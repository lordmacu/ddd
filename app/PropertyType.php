<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropertyType extends Model
{
    
         protected $table = 'property_types';
         
         public function getByName($name){
             return $this->where("name",$name)->get();
         }
         
           public function getByNameFirst($name){
             return $this->where("name",$name)->first();
         }

}