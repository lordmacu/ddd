<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Propiedad extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'properties';
    
    
    public function  getApiUrl(){
        return "http://api.sosiva451.com/";
    }
    
    public function getNearbyUrl(){
        return "https://maps.googleapis.com/maps/api/place/nearbysearch/json?sensor=true&location=-34.56361,-58.442363&radius=300&types=bank|restaurant|store|bar|fast_food|college|university|hospital|pharmacy|cinema|police&key=AIzaSyAx0f60aBzSkicwQddC7ql9JmZl_GK_Q88";
    }
    

    public function getHomeProperties($arrayUrl,$method){
      // echo $this->getApiUrl().$method."?".http_build_query($arrayUrl);die();
          $result = @file_get_contents($this->getApiUrl().$method."?".http_build_query($arrayUrl));
        return $result; 
    }

    public function getIndividual($id,$method){
        $result = @file_get_contents($this->getApiUrl().$method.$id);
        return $result; 
    }
    public function getNearbyPlaces($latitude,$longitude){
        $result = @file_get_contents("https://maps.googleapis.com/maps/api/place/nearbysearch/json?sensor=true&location=".$latitude.",".$longitude."&radius=300&types=bank|restaurant|store|bar|fast_food|college|university|hospital|pharmacy|cinema|police&key=AIzaSyAx0f60aBzSkicwQddC7ql9JmZl_GK_Q88");
        return $result; 
    }
    
     public function getSimilares($id,$method){
        $result = @file_get_contents($this->getApiUrl().$method."/similares/".$id."?numAvisos=4");
        return $result; 
    }
    
         public function getAnunciante($id){
        $result = @file_get_contents($this->getApiUrl()."/Anunciantes/".$id);
        return $result; 
    }
    
    
    public function getBusqueda($q){
        $result = @file_get_contents("http://api.sosiva451.com/ubicaciones/buscar?stringBusqueda=".$q);
       
        
        return $result; 
    }
}