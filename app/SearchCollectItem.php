<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SearchCollectItem extends Model
{
    
         protected $table = 'searchcollectitem';
         
         public function getByName($name){
             return $this->where("name",$name)->get();
         }

}