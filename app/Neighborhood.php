<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Neighborhood extends Model
{
    
         protected $table = 'neighborhoods';
         
         public function getByName($name){
             
             return $this->where("name","LIKE","%".$name."%")->get();
         }
                  
         public function getByNameFirst($name){
             
             return $this->where("name","LIKE","%".$name."%")->first();
         }
         
    public function province()
    {
        return $this->hasOne('App\Province',"id","province_id");
    }

}