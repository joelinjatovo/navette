<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Point extends Model
{
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;
    
    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'lng', 
        'lat', 
        'alt',
    ];

    /**
     * Bootstrap the model and its traits.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if ( empty( $model->{$model->getKeyName()} ) ) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
            if( empty( $model->user_id ) && auth()->check() ) {
                $model->user_id = auth()->user()->id;
            }
        });
    }

    /**
     * Get the clubs what owns the point.
     */
    public function club()
    {
        return $this->hasOne(Club::class);
    }
	
	/**
    * Titre : Calcul la distance entre 2 points en km                                                                                         
	*/
	function distance(Point $point, $unit = 'km', $decimals = 2) {
		// Calcul de la distance en degrés
		$point1_lat = $this->lat;
		$point1_lng = $this->lng;
		$point2_lat = $point->lat;
		$point2_lng = $point->lng;
		
		$degrees = rad2deg(acos((sin(deg2rad($point1_lat))*sin(deg2rad($point2_lat))) + (cos(deg2rad($point1_lat))*cos(deg2rad($point2_lat))*cos(deg2rad($point1_lng-$point2_lng)))));

		// Conversion de la distance en degrés à l'unité choisie (kilomètres, milles ou milles nautiques)
		switch($unit) {
			case 'km':
				$distance = $degrees * 111.13384; // 1 degré = 111,13384 km, sur base du diamètre moyen de la Terre (12735 km)
				break;
			case 'mi':
				$distance = $degrees * 69.05482; // 1 degré = 69,05482 milles, sur base du diamètre moyen de la Terre (7913,1 milles)
				break;
			case 'nmi':
				$distance =  $degrees * 59.97662; // 1 degré = 59.97662 milles nautiques, sur base du diamètre moyen de la Terre (6,876.3 milles nautiques)
		}
		return round($distance, $decimals);
	}
    
    /**
     * The item that belong to the point.
     */
    public function item()
    {
        return $this->hasOne(Item::class, 'point_id');
    }

    /**
     * Get the user what creates the point.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * The users that belong to the point.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_point')->using(UserPoint::class);
    }
}
