<?php

namespace App\Services;

use App\Models\Club;
use App\Models\RidePoint;
use App\Models\Ride;
use App\Models\Point;
use Illuminate\Support\Facades\Http;

class GoogleApiService
{
    const BASE_URL = "https://maps.googleapis.com/maps/";
    
    const MODE_DRIVING = "driving";
    const MODE_WALKING = "walking";
    const MODE_BICYCLING = "bicycling";
    const MODE_TRANSIT = "transit";
    
    const UNITS_METRIC = "metric";
    const UNITS_IMPERIAL = "imperial";
    
    const TRAFFIC_MODEL_BEST_GUESS = "best_guess";
    const TRAFFIC_MODEL_BEST_PESSIMISTIC = "pessimistic";
    const TRAFFIC_MODEL_BEST_OPTIMISTIC = "optimistic";
    
    /**
     * Get direction to each points
     *
     * @params $origins
     * @params $destinations
     * @params $waypoints
     * @params $mode
     */
    public function getDirection($origins, $destinations, $waypoints = null, $mode = self::MODE_DRIVING)
    {
        \Log::info('directions ' . $origins);
        \Log::info('directions ' . $destinations);
        \Log::info('directions ' . $waypoints);
        
        $data = [
            'key' => config('google.apikey'),
            'origin' => $origins,
            'destination' => $destinations,
            'mode' => $mode,
            'units' => 'metric',
        ];
        
        if($waypoints){
            $data['waypoints'] = $waypoints;
        }
        
        $url = self::BASE_URL. "api/directions/json";
        
        $response = Http::get($url . '?' . http_build_query($data));
        
        \Log::info('directions ' . $response->body());
        
        return $response->json();
    }
    
    /**
     *
     * @params Point $pointA
     * @params Point $pointB
     */
    public function getDistance(Point $pointA, Point $pointB)
    {
        $url = "https://maps.googleapis.com/maps/api/distancematrix/json";
        $data = [
            //'mode' => 'driving', // driving | walking | bicycling | transit 
            'units' => 'metric', // metric | imperial
            //'traffic_model' => 'best_guess', // best_guess | pessimistic | optimistic 
            'origins' => $pointA->lat.','.$pointA->long, //$a['results'][0]['formatted_address'],
            'destinations' => $pointB->lat.','.$pointB->long, //$b['results'][0]['formatted_address'],
            'key' => config('google.apikey'),
        ];
        $response = Http::get($url . '?' . http_build_query($data));
        
        \Log::info('distancematrix ' . $response->body());
        
        return $response->json();
    }
    
    /**
     *
     * @params Point $pointA
     * @params Point $pointB
     */
    public function geocode(Point $point)
    {
        $url = "https://maps.googleapis.com/maps/api/geocode/json";
        $data = [
            'latlng' => $point->lat.','.$point->long,
            'key' => config('google.apikey'),
        ];
        $response = Http::get($url . '?' . http_build_query($data));
        
        \Log::info('geocode ' . $response->body());
        
        return $response->json();
    }
}
