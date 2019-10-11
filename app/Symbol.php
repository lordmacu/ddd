<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Symbol extends Model
{
    
         protected $table = 'symbols';
         
         public function getByName($name){
             return $this->where("name",$name)->get();
         }

}