<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    
         protected $table = 'countries';
         
         public function getByName($name){
             return $this->where("name",$name)->get();
         }
    

}