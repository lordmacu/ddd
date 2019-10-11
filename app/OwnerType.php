<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OwnerType extends Model
{
    
         protected $table = 'owner_types';
         
         public function getByName($name){
             return $this->where("name",$name)->get();
         }

}