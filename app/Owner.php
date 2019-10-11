<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    
         protected $table = 'owners';
         
         public function getByName($name){
             return $this->where("first_name",$name)->get();
         }
         
          public function getByNameFirst($name){
             return $this->where("first_name",$name)->first();
         }
         
           public function getByEmail($email){
             return $this->where("email",$email)->get();
         }
         
        public function getByOwnerPlatformId($name){
             return $this->where("owner_id",$name)->select(array("first_name","last_name","email","phone","type"))->get();
         }
         
            public function getByOwnerPlatformIdFirst($id){
             return $this->where("owner_id",$id)->first();
         }

}