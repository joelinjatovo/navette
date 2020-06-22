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

		// Handle job...
		$items = Item::where('items.status', Item::STATUS_OK)
			->whereNotNull('items.ride_at');
			->distinct('items.order_id')
			->orderBy('items.ride_at', 'asc') // First In First Served
			->get();

		$rides = [];
		foreach($items as $item){
            if(!($order = $item->order) || !($club = $order->club)){
                continue;
            }
            
			$rides = $this->getOptimizedRides($club, $item);
            $ride = $this->getSolution($rides);
            if($ride){
                $this->attachItem($ride, $item, $order->place);
                continue;
            }
            
            $car = $this->getCar($club, $item);
            if($car){
                $ride = $this->createRide($club, $car, $item);
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
		info($exception);
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
    protected function getOptimizedRides(Club $club, Item $item, $excludedRides = [])
    {
        $solutions = [];
		
        $max_car_place = $club->getMaxCarPlace();
		$max_ride_duration = 60; // 60 minutes par course
		$date = $this->getStartDate($item);
		
		$rides = $this->getActivedRide($club, $item->ride_at, $order->place);
		foreach($rides as $ride){
            $items = $ride->rideitems;
            if(!$this->hasNotServed($items)){
                continue;
            }
            $items[] = $item;
            $items = $this->getDirection($items);
            if(!$this->isChargeValid($items, $max_car_place)){
                continue;
            }
            if(!$this->isDurationValid($items, $max_ride_duration)){
                continue;
            }
            $solutions[$ride->getKey()] = $ride;
		}
        
        $rides = $this->getPingedRide($club, $item->ride_at, $order->place);
        foreach($rides as $ride){
            $items = $ride->rideitems;
            $items[] = $item;
            $items = $this->getDirection($items);
            if(!$this->isChargeValid($items, $max_car_place)){
                continue;
            }
            if(!$this->isDurationValid($items, $max_ride_duration)){
                continue;
            }
            $solutions[$ride->getKey()] = $ride;
        }
        
        return $solutions;
    }
	
    /**
     *
     * @return Car $car
     */
    protected function getCar(Club $club, Item $item, $excludedRides = [])
    {
        $car = $this->findPerfectCar($club, $item->ride_at, $order->place);
        if($car && $car->driver){
            return $car;
        }
		
        $car = $this->findBestCar($club, $item->ride_at, $order->place);
        if($car && $car->driver){
            return $car;
        }
        
        $car = $this->findCar($club, $item->ride_at, $order->place);
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
        $order->active();
    }
	
    /**
    * 
    */
	private function isChargeValid(RideItem $items, $max)
    {
        $currentCharge = 0;
        foreach($items as $order => $item){
            if(RideItem::TYPE_DROP == $item->type){
                $currentCharge += $item->place;
            }
        }
        
        foreach($items as $item){
            $currentCharge += $item->getCharge();
            if($currentCharge>$max) return false;
        }
        return true;
    }
	
    /**
    * 
    */
	private function isDurationValid(RideItem $items, $max){
        $currentItems = [];
        foreach($items as $order => $item){
            if(RideItem::TYPE_DROP == $item->type){
                $currentItems[$order] = $item;
            }
        }
        
        $preds = [];
        $from = 0;
        foreach($items as $order => $item){
            $duration = $this->getDuration($preds, $from) + $item->getMaxDuration();
            if($duration>$max) return false;
            
            $preds[$order] = $item;
            if(RideItem::TYPE_DROP == $item->type){
                unset($currentItems[$order]);
                if(!$this->containsDropOff($currentItems)){
                    $from = $this->getFirstPickupOrder($preds);
                }
            }else{
                $currentItems[$order] = $item;
            }
        }
        
        return true;
    }
	
    /**
    * 
    */
	private function getDuration(RideItem $items, $from = 0){
        $duration = 0;
        if(($from == 0) && $this->containsDropOff($items)){
            $duration = 5 * 60;
        }
        
        for($i = $from; $i < count($items); $i++){
            $duration += $items[$i]->getMaxDuration();
        }
        return $duration;
    }
	
    /**
    * 
    */
	private function getFirstPickupOrder(RideItem $items){
        foreach($items as $order => $item){
            if(RideItem::TYPE_PICKUP == $item->type){
                return $order;
            }
        }
        return 0;
    }
	
    /**
    * 
    */
	private function containsDropOff(RideItem $items){
        foreach($items as $key => $item){
            if(RideItem::TYPE_DROP == $item->type){
                return true;
            }
        }
        return false;
    }
	
    /**
    * 
    */
	private function hasNotServed(RideItem $items){
        foreach($items as $key => $item) {
            if(in_array($item->status, [RideItem::TYPE_PING, RideItem::TYPE_ACTIVE, RideItem::TYPE_NEXT])) {
                return true;
            }
        }
        return false;
    }
    
	private function createRide(Club $club, Car $car, Item $item){
		$ride = new Ride();
		$ride->status = Ride::STATUS_PING;
		$ride->available_place = $car->place;
		$ride->max_place = $car->place;
		$ride->club()->associate($car->club);
		$ride->driver()->associate($car->driver);
		
        $start_date = $this->getStartDate($item);
        $end_date = $this->getEndDate($item);
        $active = $club->rides()->where('status', Ride::STATUS_ACTIVE)->first();
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
        
		if($ride->save()){
			$car->lock();
		}else{
			$ride = null;
		}
		
		return $ride;
	}
	
	private function getActivedRide(Club $club, $date, $excludedRides = []){
		$query = $club->rides()
			->where('rides.started_at', '<=', $date)
			->where('rides.complete_at', '>=', $date)
			->where('TIMEDIFF(rides.started_at, rides.complete_at)', '<=', 3600)
			->where('rides.status', Ride::STATUS_ACTIVE);
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
                    $subquery->where('ADDTIME(rides.start_at, 3600)', '>=', $date);
                });
            })
			->where('TIMEDIFF(rides.start_at, rides.complete_at)', '<=', 3600)
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
