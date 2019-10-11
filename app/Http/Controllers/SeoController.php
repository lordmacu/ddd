<?php

namespace App\Http\Controllers;

use App\PropertyType;
use App\PropertyImage;
use App\OwnerType;
use App\Owner;
use App\SearchCollect;
use App\SearchCollectItem;
use App\Service;
use App\UnitFeature;
use App\UnitService;
use App\Feature;
use App\Province;

use App\City;
use App\Neighborhood;

use App\Symbol;
use App\Propiedad;
use App\Operation;
use App\Unit;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Response;
use Illuminate\Support\Facades\Auth;

class SeoController extends Controller {
    
 public function keywordSearchBarrio(Request $request,$barrio){
    
   
    $url=parse_url($request->url());
            $Neighborhood= new Neighborhood();

    $title= ucwords(str_replace("-"," ",str_replace("/", "", $url["path"])));
   $barriogetByName=$Neighborhood->getByName(ucfirst(str_replace("-"," ",$barrio)));
    if(count($barriogetByName)>0){
        $request->request->add(["barrio" => $barriogetByName[0]->lat.",".$barriogetByName[0]->lon]);
    }
       
        $domain = array_first(explode('.', \Request::getHost()));

        $max = 30000;
        $min = 4000;





        $searchCollect = new SearchCollect();

        if (Auth::check()) {
            $searchCollect->user_id = Auth::id();
        }

        if (count($request->all()) > 0) {
            $searchCollect->save();
        }

        foreach ($request->all() as $key => $collectRequest) {
            if ($collectRequest != null) {
                $SearchCollectItem = new SearchCollectItem();
                $SearchCollectItem->item = $key;
                if (is_array($collectRequest)) {
                    $SearchCollectItem->value = json_encode($collectRequest);
                } else {
                    $SearchCollectItem->value = $collectRequest;
                }


                $SearchCollectItem->searchcollec_id = $searchCollect->id;
                $SearchCollectItem->save();
            }
        }



        if ($request->has("current-min")) {
           
            $min=$request->get("current-min");
            $max=$request->get("current-max");
        }

        $Unit = new Unit();

        if ($request->has("debug")) {
            dd(env('FACEBOOK_KEY'));
        }
           
        $getUnitsSearch = $Unit->getUnitsSearch($request, $min, $max);



        //$Neighborhood=Neighborhood::all();
        $PropertyType = PropertyType::all();
        $services = Service::all();
        $arrayFeatures = array();

        if ($request->has("features")) {
            $arrayFeatures = $request->get("features");
        }
        
                $City= new City();

                $getActiveCities=$City->getActiveCities();

                
        $unit = new Unit();
        $getLatestHomeProperties = $unit->getLatestHomeProperties(2);
                
                  


        return view('layouts.seosearch')
                        ->with("title",$title)
                        ->with("cities", $getActiveCities)
                        ->with("propertyTypes", $PropertyType)
                        ->with("services", $services)
                        ->with("latest", $getLatestHomeProperties)
                        ->with("max", $max)
                        ->with("min", $min)
                        ->with("features", $arrayFeatures)
                        ->with("units", $getUnitsSearch);
    
}


public function keywordSearch(Request $request){
    
    $url=parse_url($request->url());
    $title= ucwords(str_replace("-"," ",str_replace("/", "", $url["path"])));
    $domain = array_first(explode('.', \Request::getHost()));

    $max=30000;             
    $min=4000;     

    

    $Unit= new Unit();
    $getUnitsSearch=$Unit->getUnitsSearchSeo($request,$min,$max);
    
    $PropertyType= PropertyType::all();
    $services=  Service::all();
    $arrayFeatures=array();
                $City= new City();

                $getActiveCities=$City->getActiveCities();
       
        $unit = new Unit();
        $getLatestHomeProperties = $unit->getLatestHomeProperties(2);
                
    return view('layouts.seosearch')
                       // ->with("neighborhoods",$Neighborhood)
    ->with("propertyTypes",$PropertyType)
    ->with("services",$services) 
    ->with("max",$max)
    ->with("cities", $getActiveCities)
    ->with("min",$min)
        ->with("latest", $getLatestHomeProperties)

    ->with("title",$title)
    ->with("features",$arrayFeatures)
    ->with("units",$getUnitsSearch);
}
}