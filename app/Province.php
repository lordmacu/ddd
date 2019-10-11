<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    
         protected $table = 'provinces';
         
         public function getByName($name){
             return $this->where("name",$name)->get();
         }
               
    public function country()
    {
        return $this->hasOne('App\Country',"id","country_id");
    }

}