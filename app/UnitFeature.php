<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UnitFeature extends Model
{
    
         protected $table = 'unit_features';
         
         public function getByName($name){
             return $this->where("name",$name)->get();
         }
         
          public function feature()
    {
                return $this->hasOne('App\Feature',"id","feature_id")->select(array("name"));
    }
    

}