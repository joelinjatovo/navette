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
		info('RideProcessor...');
        $this->google = $google;

		// Handle job...
		$items = Item::join('orders', 'orders.id', '=', 'items.order_id')
			->where('orders.status', Order::STATUS_OK)
			->where('items.status', Item::STATUS_PING)
			->where(function($query) {
				$query->whereNull('items.ride_at');
				$query->orWhere('items.ride_at', '<=', now()->addMinutes(30));
			})
			->distinct('items.order_id')
			->get();

		foreach($items as $item){
			info('RideProcessor...' . $item->getKey());
			$this->performTask($item);
		}
		
    }
	
    /**
     * Process this item
     *
     * @return boolean
     */
    protected function performTask(Item $item)
    {
		$ride = null;
		
		if(!($order = $item->order) || !($club = $order->club)){
			return $ride;
		}
		
		// Find locked car who has rides.available_place = order_place
		if(!$ride){
			info("findPerfectPingedRide " . $item->getKey());
			$ride = $this->findPerfectPingedRide($club, $order->place);
		}
		
		// Find locked car who has rides.available_place > order_place
		if(!$ride){
			info("findBestPingedRide " . $item->getKey());
			$ride = $this->findBestPingedRide($club, $order->place);
		}
		
		// Find the available car who has place count
		$car = $this->findPerfectCar($club, $order->place);
		if($car && $car->driver){
			info("findPerfectCar " . $item->getKey());
			$ride = $this->createRide($item, $car);
		}
		
		// Find the good car who has car_place > ordered_place
		if(!$ride){
			info("findBestCar " . $item->getKey());
			$car = $this->findBestCar($club, $order->place);
			if($car && $car->driver){
				$ride = $this->createRide($item, $car);
			}
		}
		
		// Create basic car
		if(!$ride){
			info("findCar " . $item->getKey());
			$car = $this->findCar($club, $order->place);
			if($car && $car->driver){
				$ride = $this->createRide($item, $car);
			}
		}
		
		// Attach item to ride
		if($ride){
			info("attachItem " . $item->getKey());
			$ride->attachItem($item, $order->place);
			$ride->addPlace($order->place);
			$item->active();
			$order->active();
		}else{
			info("No ride for " . $item->getKey());
		}
		
		return $ride;
    }
	
	private function createRide(Item $item, Car $car){
		$ride = new Ride();
		$ride->status = Ride::STATUS_PING;
		$ride->available_place = $car->place;
		$ride->max_place = $car->place;
		$ride->driver()->associate($car->driver);
		if($ride->save()){
			$car->lock();
			return $ride;
		}
		return null;
	}
	
	private function findPerfectCar(Club $club, $place, $excludedCars = []){
		$query = $club->cars()
			->where('place', '=', $place)
			->whereHas('driver')
			->where('status', Car::STATUS_AVAILABLE);
		if(!is_array($excludedCars) && !empty($excludedCars)){
			$query->whereNotIn('cars.id', $excludedCars);
		}
		return $query->first();
	}
	
	private function findBestCar(Club $club, $place, $excludedCars = []){
		$query = $club->cars()
			->where('place', '>=', $place)
			->whereHas('driver')
			->where('status', Car::STATUS_AVAILABLE)
			->orderBy('place', 'asc');
		if(!is_array($excludedCars) && !empty($excludedCars)){
			$query->whereNotIn('cars.id', $excludedCars);
		}
		return $query->first();
	}
	
	private function findCar(Club $club, $place, $excludedCars = []){
		$query = $club->cars()
			->where('place', '>=', $place)
			->whereHas('driver')
			->whereNot('status', Car::STATUS_UNAVAILABLE)
			->orderBy('place', 'asc');
		if(!is_array($excludedCars) && !empty($excludedCars)){
			$query->whereNotIn('cars.id', $excludedCars);
		}
		return $query->first();
	}
	
	private function findPerfectPingedRide(Club $club, $place, $excludedCars = []){
		$query = $club->cars()
			->join('rides', 'rides.driver_id', '=', 'cars.driver_id')
			->where('rides.available_place', '=', $place)
			->where('rides.status', Ride::STATUS_PING);
		if(!is_array($excludedCars) && !empty($excludedCars)){
			$query->whereNotIn('cars.id', $excludedCars);
		}
		return $query->first();
	}
	
	private function findBestPingedRide(Club $club, $place, $excludedCars = []){
		$query = Ride::join('cars', 'rides.driver_id', '=', 'cars.driver_id')
			->where('rides.available_place', '>=', $place)
			->where('rides.status', Ride::STATUS_PING)
			->orderBy('rides.available_place', 'asc');
		if(!is_array($excludedCars) && !empty($excludedCars)){
			$query->whereNotIn('cars.id', $excludedCars);
		}
		return $query->first();
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
	
	
}
