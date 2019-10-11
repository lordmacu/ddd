<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Response;
use App\PropertyType;
use App\PropertyImage;
use App\OwnerType;
use App\Operation;
use App\Owner;
use App\Service;
use App\UnitFeature;
use App\UnitService;
use App\Feature;
use App\City;
use App\Neighborhood;
use App\Symbol;
use Auth;
use App\SearchCollect;
use App\SearchCollectItem;
use App\Unit;
use Session;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Cache;
use \App\Busco;
class SearchController extends Controller {
    
    
    public function searchByNeighborhood($neighborhoodName){
        
        $neighborhood= new Neighborhood();
        
        
        
            $title= ucwords(str_replace("-"," ",$neighborhoodName));
   $barriogetByName=$neighborhood->getByNameFirst(ucfirst($title));
   
   if($barriogetByName){
       return redirect()->to("/search?sort=all&locationId=$barriogetByName->lat|$barriogetByName->lon");
   }else{
       return redirect()->to("/search?sort=all");
   }
        return $getByNameFirst;
    }
    
     public function indexSeachSeo(Request $request){

        $max = 30000;
        $min = 4000;

        
        if(Session::has('country_id')){
           dd(config('country'));
        }

        if ($request->has("from")) {
           
            $min=$request->get("from");
        }
         if ($request->has("to")) {
           
            $min=$request->get("from");
            $max=$request->get("to");
        }

        $Unit = new Unit();

        
        $getUnitsSearch = $Unit->getUnitsSearch($request, $min, $max);
        $getUnitsSearchAll=[];
        if($getUnitsSearch->count()<5){
            $getUnitsSearchAll = $Unit->getUnitsSearchAll($request, $min, $max);
            
         }   

        $neighborHoods= Neighborhood::all();
        
        $arraySelectLocation=[];
        
        foreach ($neighborHoods as $neighborHood) {
            $arraySelectLocation[]=array("value"=>$neighborHood,"name"=>$neighborHood->name,"type"=>"neighborhood","latlon"=>$neighborHood->lat."|".$neighborHood->lon);
        }
        
        
        
        $cities= City::all();
        
         foreach ($cities as $city) {
             $city->type="city";
            $arraySelectLocation[]=array("name"=>$city->name,"value"=>$city->value,"latlon"=>$city->lat."|".$city->lon);
        }
        
        $operations= Operation::all();
        $properties= PropertyType::all();
        $features= Service::all();

        return view('pages.search')
        ->with("features",$features)
        ->with("operations",$operations)
                ->with("all",$getUnitsSearchAll)
        ->with("properties",$properties)
            ->with("locationOptions",$arraySelectLocation)
                ->with("unitsProperties", $getUnitsSearch);;
    }
    
    public function indexSeach(Request $request){

        $max = config('country.'.Session::get('country_id'))["to"];
        $min = config('country.'.Session::get('country_id'))["from"];

        
        if ($request->has("from")) {
           
            $min=$request->get("from");
        }
         if ($request->has("to")) {
           
            $min=$request->get("from");
            $max=$request->get("to");
        }

        
        if($request->has("debug")){

            }
        $Unit = new Unit();

        
        $getUnitsSearch = $Unit->getUnitsSearch($request, $min, $max);
        $getUnitsSearchAll=[];
        if($getUnitsSearch->count()<5){
            $getUnitsSearchAll = $Unit->getUnitsSearchAll($request, $min, $max);
            
         }   

         if(Session::has('country_id')){
                $neighborHoods= Neighborhood::where("country_id",Session::get('country_id'))->get();
                

         }else{
                $neighborHoods= Neighborhood::all();

         }
        
        $arraySelectLocation=[];
        
        foreach ($neighborHoods as $neighborHood) {
            $arraySelectLocation[]=array("value"=>$neighborHood,"name"=>$neighborHood->name,"type"=>"neighborhood","latlon"=>$neighborHood->lat."|".$neighborHood->lon);
        }
        
        
        
        
        
        if(Session::has('country_id')){
                $cities= City::where("country_id",Session::get('country_id'))->get();

         }else{
                $cities= City::all();

         }
        
         foreach ($cities as $city) {
             $city->type="city";
            $arraySelectLocation[]=array("name"=>$city->name,"value"=>$city->value,"latlon"=>$city->lat."|".$city->lon);
        }
        
        
         if(Session::has('country_id')){
            $operations= Operation::where("country_id",Session::get('country_id'))->get();

         }else{
            $operations= Operation::all();

         }
         
          if(Session::has('country_id')){
            $properties= PropertyType::where("country_id",Session::get('country_id'))->get();

         }else{
            $properties= PropertyType::all();
         }
         
           if(Session::has('country_id')){
            $features= Service::where("country_id",Session::get('country_id'))->get();

         }else{
            $features= Service::all();
         }
         


        return view('pages.search')
        ->with("features",$features)
        ->with("operations",$operations)
                ->with("all",$getUnitsSearchAll)
        ->with("properties",$properties)
            ->with("locationOptions",$arraySelectLocation)
                ->with("unitsProperties", $getUnitsSearch);;
    }
    
    
    public function searcv(){
        
         $domain = array_first(explode('.', \Request::getHost()));

        $max = 30000;
        $min = 4000;


        if ($request->has("current-min")) {
           
            $min=$request->get("current-min");
            $max=$request->get("current-max");
        }

        $Unit = new Unit();

        if ($request->has("debug")) {
            dd(env('FACEBOOK_KEY'));
        }
        $getUnitsSearch = $Unit->getUnitsSearch($request, $min, $max);

        return view('layouts.searchv')->with("units", $getUnitsSearch);;
    }

    public function searchapiHome(Request $request) {

         $expiresAt = now()->addMinutes(200);
        $encrypted = base64_encode(json_encode($request->all()));
        return Cache::remember($encrypted."_ws111Eddd3gsddsd3ddd", $expiresAt, function () use($request) {

                    $Unit = new Unit();
                    $getUnitsSearch = $Unit->getUnitsSearchApiHome($request);

                    $datatemp = array();
                    $datatemp["total"] = $getUnitsSearch->total();

                    $searchResoults = array();

                    foreach ($getUnitsSearch as $searchUnit) {
                        if(is_numeric($searchUnit->price)){
                            
                        
                        $temp = array();
                        $temp["id"] = $searchUnit->unit_id;
                        $temp["idHome"] = $searchUnit->id;
                        $temp["price"] = $searchUnit->price;
                        $temp["title"] = str_limit(ucfirst(strtolower($searchUnit->title)), 50, '...');
                         $temp["created_at"]["date"] = $searchUnit->created_at->toString();

                        $temp["latitude"] = $searchUnit->latitude;
                        $temp["owner_type_id"] = $searchUnit->owner_type_id;
                        $temp["facebook_url"] = $searchUnit->facebook_url;
                        $temp["owned"] = $searchUnit->owned;
                        $temp["longitude"] = $searchUnit->longitude;
                        $temp["symbol_id"] = $searchUnit->symbol_id;
                        $temp["street_number"] = $searchUnit->street_number;
                        $temp["number_of_rooms"] = $searchUnit->number_of_rooms;
                        $temp["slug"] = $searchUnit->slug;
                        $temp["street_name"] = $searchUnit->street_name;
                        $temp["type_id"] = $searchUnit->type_id;
                        $temp["barrio"] = $searchUnit->barrio;
                        $temp["provincia"] = $searchUnit->provincia;
                        $temp["owner_id"] = $searchUnit->owner_id;
                        $temp["information"] = $searchUnit->information;
                        $temp["barrio"] = $searchUnit->barrio;
                        $services = array();
                        foreach ($searchUnit->services as $service) {
                            $services[] = $service->service->name;
                        }
                        $temp["services"] = $services;
                        foreach ($searchUnit->images as $image) {
                            $temp["small"] = urlencode($image->small);
                        }
                        $temp["images"] = $searchUnit->images;

                        $searchResoults[] = $temp;
                    }
                    }
                    $datatemp["data"] = $searchResoults;
                    return $datatemp;
                });
    }

    public function searchapi(Request $request) {
        $domain = array_first(explode('.', \Request::getHost()));

        $searchCollect = new SearchCollect();

        if (Auth::check()) {
            $searchCollect->user_id = Auth::id();
        }


        if (count($request->all()) > 0) {
            $searchCollect->save();
        }
        try {
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
        } catch (Exception $exc) {
            $exc->getTraceAsString();
        }




        $max = 30000;
        $min = 4000;

        if ($request->has("montooperacion_i")) {
            $prices = explode("-", $request->get("montooperacion_i"));
            if ($prices[0]) {
                $min = $prices[0];
            }
            if ($prices[1]) {
                $max = $prices[1];
            }
        }

        $Unit = new Unit();
        $getUnitsSearch = $Unit->getUnitsSearchApi($request, $min, $max);

        $datatemp = array();
        $datatemp["total"] = $getUnitsSearch->total();

        $searchResoults = array();

        foreach ($getUnitsSearch as $searchUnit) {
            $temp = array();
            $temp["unit_id"] = $searchUnit->unit_id;
            $temp["price"] = $searchUnit->price;
            $temp["symbol_id"] = $searchUnit->symbol_id;
            $temp["street_number"] = $searchUnit->street_number;
            $temp["number_of_rooms"] = $searchUnit->number_of_rooms;
            $temp["slug"] = $searchUnit->slug;
            $temp["street_name"] = $searchUnit->street_name;
            $temp["barrio"] = $searchUnit->barrio;
            $temp["provincia"] = $searchUnit->provincia;
            $temp["owner_id"] = $searchUnit->owner_id;
            $temp["information"] = $searchUnit->information;
            $temp["barrio"] = $searchUnit->barrio;
            $services = array();
            foreach ($searchUnit->services as $service) {
                $services[] = $service->service->name;
            }
            $temp["services"] = $services;
            foreach ($searchUnit->images as $image) {
                $temp["small"] = $image->small;
            }
            $temp["images"] = $searchUnit->images;

            $searchResoults[] = $temp;
        }
        $datatemp["data"] = $searchResoults;

        if ($datatemp["total"] > 0) {
            return $datatemp;
        } else {
            return Response::make('Not Found', 404);
        }
    }

    public function index(Request $request) {


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
                
                  


        return view('layouts.search')
                        ->with("cities", $getActiveCities)
                        ->with("propertyTypes", $PropertyType)
                        ->with("services", $services)
                        ->with("latest", $getLatestHomeProperties)
                        ->with("max", $max)
                        ->with("min", $min)
                        ->with("features", $arrayFeatures)
                        ->with("units", $getUnitsSearch);
    }
    
    public function buscoUnPost(Request $request){
        
        $busco= new Busco();
        $busco->ciudad=$request->get("ciudad");
        $busco->barrio=$request->get("barrio");
        $busco->tipopropiedad=$request->get("tipopropiedad");
        $busco->cantidaddormitorios=$request->get("cantidaddormitorios");
        $busco->tipooperacion=$request->get("tipooperacion");
        $busco->tipovendedor=$request->get("tipovendedor");
        $busco->barrioText=$request->get("barrioText");
        $busco->ciudadText=$request->get("ciudadText");
        $busco->minValueB=$request->get("minValueB");
        $busco->maxValueB=$request->get("maxValueB");
        
        $busco->user_id=Auth::id();
        $busco->save();
    }

    public function buscoUn(Request $request) {


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

                
       
                  

    
        return view('layouts.busco')
                        ->with("cities", $getActiveCities)
                        ->with("propertyTypes", $PropertyType)
                        ->with("services", $services)
                        ->with("max", $max)
                        ->with("min", $min)
                        ->with("features", $arrayFeatures)
                        ->with("units", $getUnitsSearch);
    }

    public function sendUsersToSlack($message) {

        $data_string = '{"text":"' . $message . '","channel":"#usr-a-d","link_names":1,"username":"alquiler-directo","icon_emoji":":casa:"}';
        $ch = curl_init('https://hooks.slack.com/services/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');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string))
        );

        $result = curl_exec($ch);
    }

    

    public function getAllBarrios() {
        return Neighborhood::with("province")->get();
    }

    public function similar(Request $request, $id) {
        $domain = array_first(explode('.', \Request::getHost()));


        $max = 30000;
        $min = 4000;
        if ($request->has("price")) {
            $prices = explode("-", $request->get("price"));
            if ($prices[0]) {
                $min = $prices[0];
            }
            if ($prices[1]) {
                $max = $prices[1];
            }
        }

        $Unit = new Unit();
        $getUnitsSearch = $Unit->getRandomUnitsSearch($request, $min, $max);

        $Neighborhood = Neighborhood::all();
        $PropertyType = PropertyType::all();
        $services = Service::all();
        $arrayFeatures = array();

        if ($request->has("features")) {
            $arrayFeatures = $request->get("features");
        }


        return view('layouts.search')
                        ->with("neighborhoods", $Neighborhood)
                        ->with("propertyTypes", $PropertyType)
                        ->with("services", $services)
                        ->with("max", $max)
                        ->with("min", $min)
                        ->with("features", $arrayFeatures)
                        ->with("units", $getUnitsSearch);
    }

    public function similardos(Request $request, $id, $dd) {

        $domain = array_first(explode('.', \Request::getHost()));


        $max = 30000;
        $min = 4000;

        if ($request->has("price")) {
            $prices = explode("-", $request->get("price"));
            if ($prices[0]) {
                $min = $prices[0];
            }
            if ($prices[1]) {
                $max = $prices[1];
            }
        }

        $Unit = new Unit();
        $getUnitsSearch = $Unit->getRandomUnitsSearch($request, $min, $max);

        $Neighborhood = Neighborhood::all();
        $PropertyType = PropertyType::all();
        $services = Service::all();
        $arrayFeatures = array();

        if ($request->has("features")) {
            $arrayFeatures = $request->get("features");
        }


        return view('layouts.search')
                        ->with("neighborhoods", $Neighborhood)
                        ->with("propertyTypes", $PropertyType)
                        ->with("services", $services)
                        ->with("max", $max)
                        ->with("min", $min)
                        ->with("features", $arrayFeatures)
                        ->with("units", $getUnitsSearch);
    }

}
