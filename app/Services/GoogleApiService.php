<?php

namespace App\Services;

use App\Models\Point;
use Illuminate\Support\Facades\Http;

class GoogleApiService
{
    
    /**
     *
     * @params Point $pointA
     * @params Point $pointB
     */
    public function getDistance(Point $pointA, Point $pointB)
    {
        $url = "https://maps.googleapis.com/maps/api/distancematrix/json";
        $data = [
            'mode' => 'driving', // driving | walking | bicycling | transit 
            'units' => 'metric', // metric | imperial
            'traffic_model' => 'best_guess', // best_guess | pessimistic | optimistic 
            'origins' => 'Washington,DC',
            'destinations' => 'New+York+City,NY',
            'key' => env('GOOGLE_API_KEY'),
        ];
        $response = Http::get($url . '?' . http_build_query($data));
        
        return $response->json();
    }
    
    /**
     *
     * @params Point $pointA
     * @params Point $pointB
     */
    public function getDirection(Point $pointA, Point $pointB)
    {
        $url = "https://maps.googleapis.com/maps/api/directions/json";
        $data = [
            'mode' => 'driving', // driving | walking | bicycling | transit 
            'units' => 'metric', // metric | imperial
            'traffic_model' => 'best_guess', // best_guess | pessimistic | optimistic 
            'origin' => 'Disneyland',
            'destination' => 'Universal+Studios+Hollywood',
            'key' => env('GOOGLE_API_KEY'),
        ];
        $response = Http::get($url . '?' . http_build_query($data));
        
        return $response->json();
    }
}
