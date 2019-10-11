<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InterestUnit extends Model
{
    
         protected $table = 'interes_unit';
         
         public function getByName($name){
             return $this->where("name",$name)->get();
         }
         
         
           
    public function findPropertyByuser($property,$user){
        return $this
                ->where("property_id",$property)
                ->where("user_id",$user)
                ->count();
    }

}