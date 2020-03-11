<?php 

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use App\Models\Club;
use App\Models\Point;
use App\Models\Zone;

class OrderRepository extends Repository
{

    protected $google;
    
    public function __construct(Order $model)
    {
        $this->model = $model;
        //$this->google = $google;
    }
    
    /**
     * Calculate the order
     *
     * @params Order $order
     * @params Club $club
     */
    public function calculate(Order $order, Club $club, Point $point_a, ?Point $point_b = null)
    {
        $zone = $this->getZone($club, $point_a);
        $order->vat = 0;
        $order->amount = $zone->price;
        $order->currency = $zone->currency;
        $order->subtotal = $order->place * $zone->price;
        $order->total = $order->subtotal + $order->subtotal * $order->vat;
        
        return $order;
    }
    
    /**
     * Find zone
     *
     * @params Order $order
     * @params Club $club
     */
    public function getZone(Club $club, Point $point)
    {
        $distance =  10;
        return Zone::where('distance', '>=', $distance)->order('distance', 'ASC')->first();
    }
}