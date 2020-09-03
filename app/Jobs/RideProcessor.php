<?php

namespace App\Jobs;

use App\Models\Car;
use App\Models\Club;
use App\Models\Item;
use App\Models\Order;
use App\Models\Ride;
use App\Models\RideItem;
use App\Models\User;
use App\Services\GoogleApiService;
use Carbon\Carbon;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RideProcessor implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $google;
	
    /**
     * Create a new job instance.
     *
     * @param  Ride $ride
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(GoogleApiService $google)
    {
        $this->google = $google;
        
        info('Handle job...');

		// Handle job...
		$items = Item::where('items.status', Item::STATUS_OK)
			->whereNotNull('items.ride_at')
			->distinct('items.order_id')
			->orderBy('items.ride_at', 'asc') // First In First Served
			->get();
        
		$rides = [];
		foreach($items as $item){
            if(!($order = $item->order) || !($club = $order->club)){
                continue;
            }
            
			$rides = $this->getOptimizedRides($club, $item, $order->place);
            $ride = $this->getSolution($rides);
            if($ride){
                $this->attachItem($ride, $item, $order->place);
                continue;
            }
            
            $car = $this->getCar($club, $item, $order->place);
            if($car){
                $ride = $this->createRide($club, $car, $item);
            }
            
            if($ride){
                $this->attachItem($ride, $item, $order->place);
                continue;
            }
		}
    }

    /**
     * The job failed to process.
     *
     * @param  Exception  $exception
     * @return void
     */
    public function failed($exception)
    {
        // Send user notification of failure, etc...
		info('Send user notification of failure...' . $exception->getMessage());
    }
	
    /**
     * Process this item
     *
     * @return boolean
     */
    protected function getSolution($rides = [])
    {
        $ride = null;
        foreach($rides as $ride){
            break;
        }
        return $ride;
    }
	
    /**
     * Process this item
     *
     * @return array
     */
    protected function getOptimizedRides(Club $club, Item $item, $place, $excludedRides = [])
    {
        $solutions = [];
		
        $max_car_place = $club->getMaxCarPlace();
		$max_ride_duration = 60 * 60; // 60 minutes par course
		$date = $this->getStartDate($item);
		
		$rides = $this->getActivedRide($club, $item->ride_at, $place);
		foreach($rides as $ride){
            $rideitems = $ride->rideitems;
            if(!$this->hasNotServed($rideitems)){
                continue;
            }
            $next = $this->getNextRideItem($rideitems);
            $rideitem = new RideItem();
            $rideitem->item = $item;
            $rideitem->place = $place;
            $rideitem->type = ($item->type == Item::TYPE_BACK ? RideItem::TYPE_DROP : RideItem::TYPE_PICKUP);
            $rideitems[] = $rideitem;
            $rideitems = $this->getDirection($rideitems, $club, $next);
            if(!$this->isChargeValid($rideitems, $max_car_place)){
                info('!$this->isChargeValid 1');
                continue;
            }
            if(!$this->isDurationValid($rideitems, $max_ride_duration)){
                info('!$this->isDurationValid 1');
                continue;
            }
            $solutions[$ride->getKey()] = $ride;
		}
        
        $rides = $this->getPingedRide($club, $item->ride_at, $place);
        foreach($rides as $ride){
            $rideitems = $ride->rideitems;
            $rideitem = new RideItem();
            $rideitem->item = $item;
            $rideitem->place = $place;
            $rideitem->type = ($item->type == Item::TYPE_BACK ? RideItem::TYPE_DROP : RideItem::TYPE_PICKUP);
            $rideitems[] = $rideitem;
            $rideitems = $this->getDirection($rideitems, $club, null);
            if(!$this->isChargeValid($rideitems, $max_car_place)){
                info('!$this->isChargeValid 2');
                continue;
            }
            if(!$this->isDurationValid($rideitems, $max_ride_duration)){
                info('!$this->isDurationValid 2');
                continue;
            }
            $solutions[$ride->getKey()] = $ride;
        }
        
        return $solutions;
    }
	
    /**
     *
     * @return Array $items
     */
    protected function getDirection($rideitems, Club $club, ?RideItem $next = null)
    {
        $output = [];
        
        if($next && $next->item && $next->item->point){
            $origin = sprintf("%s,%s", $next->item->point->lat, $next->item->point->lng);
        }else{
            $origin = sprintf("%s,%s", $club->point->lat, $club->point->lng);
        }
        
        $destination = sprintf("%s,%s", $club->point->lat, $club->point->lng);
        $array_waypoints = ['optimize:true'];
        $_rideitems = [];
        foreach($rideitems as $rideitem){
			if($rideitem->item && $rideitem->item->point && (!$next || !$next->item || !$next->item->point || ($rideitem->getKey()!=$next->getKey()))){
				$array_waypoints[] = sprintf("%s,%s", $rideitem->item->point->lat, $rideitem->item->point->lng);
				$_rideitems[] = $rideitem;
			}
        }

        $waypoints = null;
        if(count($array_waypoints)>0){
            $waypoints = implode("|", $array_waypoints);
        }

        $direction = $this->google->getDirection($origin, $destination, $waypoints);
        
        if($direction && isset($direction['status']) && $direction['status'] == "OK"){
            if(isset($direction['routes'])){
                $routes = $direction['routes'];
                if(is_array($routes) && !empty($routes)){
                    $route = $routes[0];
                    
					/**
					* Set RideItem order
					*/
                    $orders = [];
                    if(isset($route['waypoint_order'])){
                        $orders = $route['waypoint_order'];
                        foreach($orders as $key => $order){
                            if(isset($_rideitems[$order])){
								$_rideitems[$order]->order = $key + 1;
                            }
                        }
                    }
                    
					/**
					* Set RideItem course info
					*/
                    if(isset($route['legs'])){
                        $distance = 0;
                        $duration = 0;
                        $legs = $route['legs'];
                        foreach($legs as $key => $leg){
                            $leg_distance = 0;
                            if(isset($leg['distance']) && isset($leg['distance']['value'])){
                                $leg_distance = $leg['distance']['value'];
                                $distance += $leg_distance; // Calculate ride distance
                            }
							
                            $leg_distance_text = null;
                            if(isset($leg['distance']) && isset($leg['distance']['text'])){
                                $leg_distance_text = $leg['distance']['text'];
                            }
                            
                            $leg_duration = 0;
                            if(isset($leg['duration']) && isset($leg['duration']['value'])){
                                $leg_duration = $leg['duration']['value'];
                                $duration += $leg_duration; // Calculate ride duration
                            }
                            
							$leg_duration_text = null;
                            if(isset($leg['duration']) && isset($leg['duration']['text'])){
                                $leg_duration_text = $leg['duration']['text'];
                            }
                            
                            // Polyline
							$positions = [];
                            if(isset($leg['steps'])){
                                $steps = $leg['steps'];
                                foreach($steps as $step){
                                    if(isset($step['polyline']) && isset($step['polyline']['points'])){
										$decoded = \App\Services\Polyline::decode($step['polyline']['points']);
                                        $positions = array_merge($positions, $decoded);
                                    }
                                }
                            }
                            $polyline = \App\Services\Polyline::encode($positions);
                            
                            /**
							* Set RideItem info
							*/
                            if( is_array($orders) && isset($orders[$key]) && isset($_rideitems[$orders[$key]]) ) {
								$_rideitems[$orders[$key]]->direction = $polyline;
								$_rideitems[$orders[$key]]->distance = $leg_distance_text;
								$_rideitems[$orders[$key]]->distance_value = $leg_distance;
								$_rideitems[$orders[$key]]->duration_value = $leg_duration;
								$_rideitems[$orders[$key]]->duration = $leg_duration_text;
                                $_rideitems[$orders[$key]]->leg = $leg;
                            }
                        }
                    }
                    
                }
            }
        }
        
        foreach($_rideitems as $_rideitem){
            if(($_rideitem->order > 0) && !isset($output[$_rideitem->order - 1])){
                $output[$_rideitem->order - 1] = $_rideitem;
            }else{
                $output[] = $_rideitem;
            }
        }
        
		return $output;
    }
	
    /**
     *
     * @return Car $car
     */
    protected function getCar(Club $club, Item $item, $place, $excludedRides = [])
    {
        $car = $this->findPerfectCar($club, $item->ride_at, $place);
        if($car && $car->driver){
            return $car;
        }
		
        $car = $this->findBestCar($club, $item->ride_at, $place);
        if($car && $car->driver){
            return $car;
        }
        
        $car = $this->findCar($club, $item->ride_at, $place);
        if($car && $car->driver){
             return $car;
        }
		
		return null;
    }
	
    /**
    * 
    */
	private function attachItem(Ride $ride, Item $item, $place)
    {
        $ride->attachItem($item, $place);
        $ride->addPlace($place);
        $item->active();
        $order = $item->order;
        if($order){
            $order->active();
        }
    }
	
    /**
    * 
    */
	private function isChargeValid($rideitems, $max)
    {
        $currentCharge = 0;
        foreach($rideitems as $order => $rideitem){
            if(RideItem::TYPE_DROP == $rideitem->type){
                $currentCharge += $rideitem->place;
            }
        }
        
        foreach($rideitems as $rideitem){
            $currentCharge += $rideitem->getCharge();
            if($currentCharge>$max) return false;
        }
        
        return true;
    }
	
    /**
    * Verifier si la duree du trajet est valide en inserant ce nouvel Item
    */
	private function isDurationValid($rideitems, $max){
        // Tous les "Retours" sont à ajouter dans le car
        $currentItems = [];
        foreach($rideitems as $order => $rideitem){
            if(RideItem::TYPE_DROP == $rideitem->type){
                $currentItems[$order] = $rideitem;
            }
        }
        
        $preds = [];
        $from = 0;
        foreach($rideitems as $order => $rideitem){
            // Calculer la duree de tous les points
            $duration = $this->getDuration($preds, $from) + $rideitem->getMaxDuration();
            if($duration>$max) return false;
            
            // Ajouter au predecesseur
            $preds[$order] = $rideitem;
            
            if(RideItem::TYPE_DROP == $rideitem->type){
                // Enlever ce point du car si c'est un "Retours"
                unset($currentItems[$order]);
                
                // Calcul de duree max a partir du premier client "Aller" si tous les "Retours" sont OK
                if(!$this->containsDropOff($currentItems)){
                    $from = $this->getFirstPickupOrder($preds);
                }
            }else{
                // Ajouter ce point si c'est un "Aller"
                $currentItems[$order] = $rideitem;
            }
            
            $preds[] = $rideitem;
        }
        
        return true;
    }
	
    /**
    * Permet de calculer la duree d'une course
    */
	private function getDuration($preds, $from = 0){
        info(count($preds));
        
        $duration = 0;
        
        if(($from == 0) && $this->containsDropOff($preds)){
            // Ajouter la duree d'attente de tous les "Retours"
            $duration = 5 * 60;
        }
        
        for($i = $from; $i < count($preds); $i++){
            // Ajouter la duree d'attente des "Aller"
            $duration += (isset($preds[$i]) ? $preds[$i]->getMaxDuration() : 0);
        }
        
        return $duration;
    }
	
    /**
    * Permet d'obtenir l'ordre du premier voyage "Aller"
    */
	private function getFirstPickupOrder($rideitems){
        foreach($rideitems as $order => $rideitem){
            if(RideItem::TYPE_PICKUP == $rideitem->type){
                return $order;
            }
        }
        return 0;
    }
	
    /**
    * Permet de verigier s'il y a encore un "Retours"
    */
	private function containsDropOff($rideitems){
        foreach($rideitems as $key => $rideitem){
            if(RideItem::TYPE_DROP == $rideitem->type){
                return true;
            }
        }
        return false;
    }
	
    /**
    * @return bool
    * @params Array RideItem
    */
	private function hasNotServed($rideitems){
        foreach($rideitems as $key => $rideitem) {
            if($rideitem && in_array($rideitem->status, [RideItem::TYPE_PING, RideItem::TYPE_ACTIVE, RideItem::TYPE_NEXT])) {
                return true;
            }
        }
        return false;
    }
	
    /**
    * @params Array RideItem
    * @return Item
    */
	private function getNextRideItem($rideitems){
        foreach($rideitems as $key => $rideitem) {
            if($rideitem && in_array($rideitem->status, [RideItem::TYPE_NEXT])) {
                return $rideitems;
            }
        }
        return null;
    }
    
	private function createRide(Club $club, Car $car, Item $item){
		$ride = new Ride();
		$ride->status = Ride::STATUS_PING;
		$ride->available_place = $car->place;
		$ride->max_place = $car->place;
		$ride->car()->associate($car);
		$ride->club()->associate($club);
		$ride->driver()->associate($car->driver);
		
        $start_date = $this->getStartDate($item);
        $end_date = $this->getEndDate($item);
        $active = $club->rides()->where('status', Ride::STATUS_STARTED)->first();
        $ping = $club->rides()->where('status', Ride::STATUS_PING)->orderby('start_at', 'asc')->first();
        if($active && $start_date->greaterThan($active->complete_at))
        {
            $start_date = $active->complete_at->addMinutes(5);
            $end_date = $start_date->addSeconds((2 * $item->duration_value) + (5 * 60));
        }

        $ride->setStartDate($start_date);
        $ride->setEndDate($end_date);

        if($ping && $ping->start_at->greaterThan($end_date))
        {
            $date = $item->complete_at->addMinutes(5);
            $ping->delayAfter($ride, $date);
        }
        
		if(!$ride->save()){
			$ride = null;
		}
		
		return $ride;
	}
	
	private function getActivedRide(Club $club, $date, $excludedRides = []){
		$query = $club->rides()
			->where('rides.started_at', '<=', $date)
			->where('rides.complete_at', '>=', $date)
			//->where('TIMEDIFF(rides.started_at, rides.complete_at)', '<=', 3600)
			->where('rides.status', Ride::STATUS_STARTED);
		if(is_array($excludedRides) && !empty($excludedRides)){
			$query->whereNotIn('rides.id', $excludedRides);
		}
		return $query->get();
	}
	
	private function getPingedRide(Club $club, $date, $place, $excludedRides = []){
		$query = $club->rides()
			->where(function($query) use($date){
                $query->orWhere(function($subquery) use($date){
                    $subquery->where('rides.start_at', '<=', $date);
                    $subquery->where('rides.complete_at', '>=', $date);
                });
                $query->orWhere(function($subquery) use($date){
                    $subquery->where('rides.start_at', '<=', $date);
                    //$subquery->where('ADDTIME(rides.start_at, 3600)', '>=', $date);
                });
            })
			//->where('TIMEDIFF(rides.start_at, rides.complete_at)', '<=', 3600)
			->where('rides.status', Ride::STATUS_PING)
			->orderBy('rides.available_place', 'asc');
		if(is_array($excludedRides) && !empty($excludedRides)){
			$query->whereNotIn('rides.id', $excludedRides);
		}
		return $query->get();
	}
	
	private function findPerfectCar(Club $club, $date, $place, $excludedCars = []){
		$query = $club->cars()
			->where('place', '=', $place)
			->whereHas('driver')
			->where('status', Car::STATUS_AVAILABLE);
		if(is_array($excludedCars) && !empty($excludedCars)){
			$query->whereNotIn('cars.id', $excludedCars);
		}
		return $query->first();
	}
	
	private function findBestCar(Club $club, $date, $place, $excludedCars = []){
		$query = $club->cars()
			->where('place', '>=', $place)
			->whereHas('driver')
			->where('status', Car::STATUS_AVAILABLE)
			->orderBy('place', 'asc');
		if(is_array($excludedCars) && !empty($excludedCars)){
			$query->whereNotIn('cars.id', $excludedCars);
		}
		return $query->first();
	}
	
	private function findCar(Club $club, $date, $place, $excludedCars = []){
		$query = $club->cars()
			->where('place', '>=', $place)
			->whereHas('driver')
			->where('status', '!=', Car::STATUS_UNAVAILABLE)
			->orderBy('place', 'asc');
		if(is_array($excludedCars) && !empty($excludedCars)){
			$query->whereNotIn('cars.id', $excludedCars);
		}
		return $query->first();
	}
	
    private function getEndDate(Item $item)
    {
		$waiting_delay = $item->type == Item::TYPE_GO ?  5 * 60 : 0;
		return $item->ride_at
			->addSeconds($item->duration_value)
			->addSeconds($waiting_delay);
	}
	
    private function getStartDate(Item $item)
    {
		$notification_delay = $item->type == Item::TYPE_GO ?  ( 7 + 5 ) * 60 : ( 15 + 5 ) * 60;
		$date = $item->ride_at
			->subSeconds($item->duration_value)
			->subSeconds($notification_delay);
		if($date->greaterThan(now())){
			$date = $item->ride_at
				->subSeconds($item->duration_value);
		}
		if($date->greaterThan(now())){
			$date = $item->ride_at;
		}
		if($date->greaterThan(now())){
			$date = now();
		}
		
		return $date;
	}
	
	
}
