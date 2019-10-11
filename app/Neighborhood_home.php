<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Neighborhood_home extends Model
{
    
         protected $table = 'neighborhood_home';
         
      

         public function getNeighborHoodsHomeByCountry($country){
             return $this->where("country_id",$country)->get();
         }
}