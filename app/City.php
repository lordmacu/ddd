<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class City extends Model
{
    
         protected $table = 'cities';
         
      
         public function  getActiveCities(){
             
             $expiresAt = now()->addMinutes(360);
        return Cache::remember('cities_', $expiresAt, function () {
                    return $this
                     ->join("unit_cities","unit_cities.city_id","cities.id")
                     ->groupBy("unit_cities.city_id")
                     ->get();
                });
             
            
         }
 
} 