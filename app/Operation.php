<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Operation extends Model
{
    
         protected $table = 'operations';
         
         public function getByName($name){
             return $this->where("name",$name)->get();
         }
         
            public function getByNameFirst($name){
             return $this->where("name",$name)->first();
         }

}