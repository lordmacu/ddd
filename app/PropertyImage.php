<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropertyImage extends Model
{
    
         protected $table = 'property_images';
         
         public function getByName($name){
             return $this->where("name",$name)->get();
         }
         
         public function getimages(){
             return $this
                     ->where('small', 'NOT LIKE', '%http%')
                     ->paginate(10000);
         }
         
         
         
         public function getImagesPerUnit($id){
             return $this->where("unit_id",$id)->select("id","small","medium","unit_id")->get();
         }
         
        public function deleteImagesPerUnit($id){
             return $this->where("unit_id",$id)->delete();
         }

}