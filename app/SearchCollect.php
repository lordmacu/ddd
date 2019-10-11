<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SearchCollect extends Model
{
    
         protected $table = 'searchcollect';
         
         public function getByName($name){
             return $this->where("name",$name)->get();
         }

}