<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UnitService extends Model
{
    
         protected $table = 'unit_services';
         
    public function service()
    {
                return $this->hasOne('App\Service',"id","service_id");
    }
    
         
         public function getByName($name){
             return $this->where("name",$name)->get();
         }

}