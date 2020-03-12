<?php 

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use App\Models\Club;
use App\Models\Point;
use App\Models\Zone;

class ZoneRepository extends Repository
{

    public function __construct(Zone $model)
    {
        $this->model = $model;
    }
    
    /**
     * Find zone by distance
     *
     * @params int $distance
     */
    public function getByDistance($distance)
    {
        return Zone::where('distance', '>=', $distance)->orderBy('distance', 'ASC')->first();
    }
}