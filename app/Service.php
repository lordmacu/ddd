<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    
         protected $table = 'apartment_services';
         
         public function getByName($name){
             return $this->where("name",$name)->get();
         }
         
             public function getByNameFirst($name){
             return $this->where("name",$name)->first();
         }

}