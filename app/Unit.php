<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\PropertyType;
use App\PropertyImage;
use App\OwnerType;
use App\Owner;
use App\Service;
use App\UnitFeature;
use App\UnitService;
use App\Feature;
use App\Province;
use App\Neighborhood;
use App\Symbol;
use App\Propiedad;
use App\Operation;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use Session;

class Unit extends Model {

    public function findBYLat($lat) {
        return $this->where("latitude", $lat)->get();
    }

    public function getUnitByCode($code) {
        return $this->where("code", $code)->first();
    }
    
     public function getUnitByUnitId($code) {
        return $this->where("unit_id", $code)->first();
    }
    
    public function getUnitByTitle($title){
        return $this->where("title",$title)->get();
    }
    
    
    

    public function getUnitsPerOwner($request, $owner) {
        $query = Unit::query();

        if ($request->has("sort")) {

            if ($request->get("sort") == "low") {
                $query->orderBy("price", "desc");
            } else if ($request->get("sort") == "high") {
                $query->orderBy("price", "asc");
            } else {
                $query->orderBy("created_at", "desc");
            }
        } else {
            $query->orderBy("created_at", "desc");
        }
        $query->where("user_id", $owner);

        return $query->paginate(10);
    }

    public function getUnitsSearchAll($request, $min, $max) {

        $expiresAt = now()->addMinutes(360);
        $encrypted = base64_encode(json_encode($request->all()));

        // dd($request->all());
        $country_id = 1;
        if (Session::has('country_id')) {
            $country_id = Session::get('country_id');
        }


        return Cache::remember("search_home_coongadall" . "_" . $country_id . "_" . $encrypted, $expiresAt, function () use($request, $min, $max) {
                    $query = Unit::query();



                    if ($request->has("property-type")) {
                        $query->where("type_id", $request->get("property-type"));
                    }


                    if ($request->has("tipovendedor") && $request->get("tipovendedor") != "Tipo Vendedor") {
                        if ($request->get("tipovendedor") != null) {
                            $tipovendedor = $request->get("tipovendedor");
                            $tipov = 1;
                            if (strpos(strtolower($tipovendedor), "directo")) {
                                $tipov = 2;
                            }

                            $query->where("owner_type_id", $tipov);
                        }
                    }

                    if ($request->has("rooms")) {
                        if ($request->get("rooms") != "all") {
                            $query->where("number_of_rooms", $request->get("rooms"));
                        }
                    }



                    $query->whereBetween('price', array((int) $min, (int) $max));

                    if ($request->has("operation")) {
                        $query->where("operation_id", $request->get("operation"));
                    }
                    // $query->where("operation_id", $operationName[0]->id);

                    if ($request->has("features")) {
                        if ($request->get("features") != "") {
                            $features = explode(",", $request->get("features"));

                            $query->whereHas('services', function($query) use($features) {
                                $query->whereIn('service_id', $features);
                            });
                        }
                    }



                    if ($request->has("sort")) {

                        if ($request->get("sort") == "low") {
                            $query->orderBy("price", "desc");
                        } else if ($request->get("sort") == "high") {
                            $query->orderBy("price", "asc");
                        } else {
                            $query->orderBy("created_at", "desc");
                        }
                    } else {
                        $query->orderBy("id", "desc");
                    }

                    if (Session::has('country_id')) {
                        $query->where("units.country_id", Session::get('country_id'));
                    }


                    $query->where("unit_status", 1);
                    $query->where("publised", 1);
                    $query->where("units.created_at", ">", Carbon::now()->subMonths(8));


                    return $query
                                    ->paginate(10);
                });
    }

    public function getLatestSix($user) {
        $query = Unit::query();

        $query->take(6);
        
        
        $query->whereBetween('price', array((int) config('country.'.Session::get('country_id'))["from"], (int) config('country.'.Session::get('country_id'))["to"]));

        $query->where("publised", 1);

        $query->orderBy("created_at", "desc");
        $query->where("country_id",$user->country_id);
        


        return $query->get();
    }
    
    
    
      public function getLatestUnits() {
        $query = Unit::query();

        $query->take(6);
        
        

        $query->where("publised", 1);

        $query->orderBy("created_at", "desc");
        if (Session::has('country_id')) {
            $country_id = Session::get('country_id');
        }
        
        $query->where("country_id",$country_id);
        


        return $query->get();
    }

    public function sitemap() {


        $expiresAt = now()->addMinutes(180);

        return Cache::remember("sitemap", $expiresAt, function () {
                    return $this->where("id", ">", "5972")->get();
                });
    }

    public function getCountUnitPerId($unit) {
        return $this->where("unit_id", $unit)->get();
    }

    public function getUnitPerId($unit) {

        $expiresAt = now()->addMinutes(3600);
        return $this->where("unit_id", $unit)
                        ->with("images")
                        ->first();
    }

    public function getUnitPerSlug($slug) {

        $expiresAt = now()->addMinutes(3600);

        return $this->where("slug", $slug)
                        ->with("images")
                        ->first();
    }

    public function getLastestUnits() {
        return $this->orderBy("created_at", "desc")
                        //  ->where("unit_status", 1)
                        //->where("owner_type_id",2)
                        ->take(30)->get();
    }

    public function images() {
        return $this->hasMany('App\PropertyImage', "unit_id", "id")->select(array("small", "medium", "unit_id", "id"))->take(10);
    }

    public function services() {
        return $this->hasMany('App\UnitService');
    }

    public function features() {
        return $this->hasMany('App\UnitFeature');
    }

    public function owner() {
        return $this->hasOne('App\Owner', 'owner_id', 'user_id');
    }

    public function ownerExt() {
        return $this->hasOne('App\Owner', 'owner_id', 'owner_id');
    }

    public function favorite() {
        return $this->hasOne('App\UnitFavorite', 'unit_id', 'id');
    }

    public function symbol() {
        return $this->hasOne('App\Symbol', 'id', 'symbol_id');
    }

    public function ownerType() {
        return $this->hasOne('App\OwnerType', 'id', 'owner_type_id');
    }

    public function propertyType() {
        return $this->hasOne('App\PropertyType', 'id', 'type_id');
    }

    public function operation() {
        return $this->hasOne('App\Operation', 'id', 'operation_id');
    }

    public function neighborhood() {
        return $this->hasOne('App\Neighborhood', 'id', 'neighborhood_id')->select(array("name"));
    }

    public function getNearbyPlaces($latitude, $longitude) {
        $result = @file_get_contents("https://maps.googleapis.com/maps/api/place/nearbysearch/json?sensor=true&location=" . $latitude . "," . $longitude . "&radius=300&types=bank|restaurant|store|bar|fast_food|college|university|hospital|pharmacy|cinema|police&key=AIzaSyAx0f60aBzSkicwQddC7ql9JmZl_GK_Q88");
        return $result;
    }

    public function imagesPerProperty($id) {
        return $this->select(array("small", "medium"))->join("property_images", "property_images.unit_id", "=", $id)->get();
    }

    public function getRandomUnit() {
        return $this->inRandomOrder()->first();
    }

    public function getNearUnits($lat, $lng, $id) {
        $circle_radius = 3959;
        $max_distance = 20;

        return $this
                        ->select(array("owner_type_id", 'unit_id', 'slug', 'system', 'id', 'title', 'price', 'street_name', 'street_number', 'floor', 'department', 'distance', 'video'))
                        ->from(DB::raw('(SELECT unit_id,owner_type_id,slug,system,title,id,price,street_name,street_number,floor,department,video, SQRT(POW(69.1 * (`latitude` - ' . $lat . '), 2) + POW(69.1 * (73.8432228 - ' . $lng . ') * COS(`latitude` / 57.3), 2)) AS distance FROM units ORDER BY distance ASC ) as NEAR_BY_TABLE'))
                        ->where("id", "<>", $id)
                        ->take(4)
                        ->get()
        ;
    }

    public function getHomeProperties() {

        $query = Unit::query();
        $query->whereNotNull("latitude");
        $query->orderBy("created_at", "desc");
        $query->where("publised", 1);

        return $query->paginate(4);
    }

    public function getLatestHomePropertiesEncrypt($size, $encripted) {
        $expiresAt = now()->addMinutes(120);

        return Cache::remember("latest_search_index_s" . $size . $encripted, $expiresAt, function () use($size) {

                    $query = Unit::query();
                    $query->where("publised", 1);

                    $query->orderBy("created_at", "desc");
                    $query->where("units.created_at", ">", Carbon::now()->subMonths(8));

                    return $query->paginate($size);
                });
    }

    public function getLatestHomeProperties($size) {
        $expiresAt = now()->addMinutes(120);

        return Cache::remember("latest_search_index_s" . $size, $expiresAt, function () use($size) {

                    $query = Unit::query();
                    $query->where("publised", 1);

                    $query->orderBy("created_at", "desc");
                    $query->where("units.created_at", ">", Carbon::now()->subMonths(8));

                    return $query->paginate($size);
                });
    }

    public function getUnitsSearch($request, $min, $max) {

        $expiresAt = now()->addMinutes(360);
        $encrypted = base64_encode(json_encode($request->all()));

        // dd($request->all());


        $country_id = 1;
        if (Session::has('country_id')) {
            $country_id = Session::get('country_id');
        }

        $query = Unit::query();
      if ($request->has("locationId")) {
            if ($request->get("locationId") != null) {


                $barrio = explode("|", $request->get("locationId"));

                $latitude = $barrio[0];
                $longitude = $barrio[1];

                $distance = 1.5;
                if ($latitude != "" && $longitude != "") {
                    $query->whereRaw(DB::raw("(3959 * acos( cos( radians($latitude) ) * cos( radians( latitude ) )  * 
                             cos( radians( longitude ) - radians($longitude) ) + sin( radians($latitude) ) * sin( 
                             radians( latitude ) ) ) ) < $distance "));
                }

                $query->join('neighborhoods', 'neighborhoods.id', '=', 'units.neighborhood_id');

                $query->select("units.*", "neighborhoods.name as barrio");
            }
        }

 
        if ($request->has("property-type")) {
            //dd("aqui",$request->get("property-type"));
            $query->where("type_id", $request->get("property-type"));
        }

 
        
                  

        if ($request->has("tipovendedor") && $request->get("tipovendedor") != "Tipo Vendedor") {
            if ($request->get("tipovendedor") != null) {
                $tipovendedor = $request->get("tipovendedor");
                $tipov = 1;
                if (strpos(strtolower($tipovendedor), "directo")) {
                    $tipov = 2;
                }

                $query->where("owner_type_id", $tipov);
            }
        }

        if ($request->has("rooms")) {
            if ($request->get("rooms") != "all") {
                $query->where("number_of_rooms", $request->get("rooms"));
            }
        }



        $query->whereBetween('price', array((int) $min, (int) $max));

        if ($request->has("operation")) {
            $query->where("operation_id", $request->get("operation"));
        }
        // $query->where("operation_id", $operationName[0]->id);

        if ($request->has("features")) {
            if ($request->get("features") != "") {
                $features = explode(",", $request->get("features"));

                $query->whereHas('services', function($query) use($features) {
                    $query->whereIn('service_id', $features);
                });
            }
        }



        if ($request->has("sort")) {

            if ($request->get("sort") == "low") {
                $query->orderBy("price", "asc");
            } else if ($request->get("sort") == "high") {
                $query->orderBy("price", "desc");
            } else {
                $query->orderBy("id", "desc");
            }
        } else {
            $query->orderBy("id", "desc");
        }


        $query->where("unit_status", 1);
        $query->where("publised", 1);
        if (Session::has('country_id')) {
            $query->where("units.country_id", $country_id);
        }
        $query->where("units.created_at", ">", Carbon::now()->subMonths(8));


        return $query
                        ->paginate(10);
        return Cache::remember("search_home_coongade" . $encrypted, $expiresAt, function () use($request, $min, $max) {
                    
                });
    }

    public function getUnitsSearchApiHome($request) {

        $latitude = $request->get("latitude");
        $longitude = $request->get("longitude");






        $query = Unit::query();

        if ($request->has("nombre_barrio")) {
            $Neighborhood = new Neighborhood();

            $neighborhoodName = $Neighborhood->getByName(str_replace("-", " ", $request->get("nombre_barrio")));



            if (count($neighborhoodName) > 0) {
                $query->where("neighborhood_id", $neighborhoodName[0]->id);
            }
        }

        if ($request->has("tipopropiedad") && $request->get("tipopropiedad") != "Tipo Propiedad") {
            $PropertyType = new PropertyType();
            $propertyTypeName = $PropertyType->getByNameFirst($request->get("tipopropiedad"));
            $query->where("type_id", $propertyTypeName->id);
        }

        if ($request->has("tipovendedor") && $request->get("tipovendedor") != "Tipo Vendedor") {
            $tipovendedor = $request->get("tipovendedor");
            $tipov = 1;
            if (strpos(strtolower($tipovendedor), "directo")) {
                $tipov = 2;
            }

            $query->where("owner_type_id", $tipov);
        }

        if ($request->has("cantidaddormitorios") && $request->get("cantidaddormitorios") != "Cantidad de Ambientes") {
            $query->where("number_of_rooms", explode("-", $request->get("cantidaddormitorios"))[0]);
        }

        // dd($min, $max);

        $min = $request->get("min_price");
        $max = $request->get("max_price");

        if ($request->has("min_price")) {
            $query->whereBetween('price', array((int) $min, (int) $max));
        }



        if ($request->has("features")) {
            $features = $request->get("features");
            $query->whereHas('services', function($query) use($features) {
                $query->whereIn('service_id', $features);
            });
        }
        if ($request->has("sort")) {

            if ($request->get("sort") == "low") {
                $query->orderBy("price", "desc");
            } else if ($request->get("sort") == "high") {
                $query->orderBy("price", "asc");
            } else {
                $query->orderBy("units.created_at", "desc");
            }
        } else {
            $query->orderBy("units.created_at", "desc");
        }

        $query->with("propertyType");
        $query->where("unit_status", 1);
        $query->whereNotNull("latitude");
        $query->where("longitude", "<>", 0);
        $query->where("units.created_at", ">", Carbon::now()->subMonths(8));

         $country_id = 1;
        if (Session::has('country_id')) {
            $country_id = Session::get('country_id');
        }
        $query->where("units.country_id", $country_id);

        
        
        /* $query->select("posts.id"
          ,DB::raw("6371 * acos(cos(radians(" . $latitude . "))
         * cos(radians(latitude)) 
         * cos(radians(longitude) - radians(" . $longitude . ")) 
          + sin(radians(" .$latitude. "))
         * sin(radians(latitude))) AS distance")); */
        $distance = 10;

        if ($request->has("radius")) {
            $distance = $request->get("radius");
        }


        if ($latitude != null) {
            $query->whereRaw(DB::raw("(3959 * acos( cos( radians($latitude) ) * cos( radians( latitude ) )  * 
                          cos( radians( longitude ) - radians($longitude) ) + sin( radians($latitude) ) * sin( 
                          radians( latitude ) ) ) ) < $distance "));
        }

        $query->join('neighborhoods', 'neighborhoods.id', '=', 'units.neighborhood_id');
        $query->where("publised", 1);

        $query->select("units.*", "neighborhoods.name as barrio");
        return $query
                        ->paginate(200);
    }

    public function getUnitsSearchApi($request, $min, $max) {


        $query = Unit::query();
        //$query->select(array('unit_id','slug','system','id','title','price','street_name','street_number','floor','department'));


        if ($request->has("nombre_barrio")) {
            $Neighborhood = new Neighborhood();

            $neighborhoodName = $Neighborhood->getByName(str_replace("-", " ", $request->get("nombre_barrio")));



            if (count($neighborhoodName) > 0) {
                $query->where("neighborhood_id", $neighborhoodName[0]->id);
            }
        }

        /*        if ($request->has("tipopropiedad") && $request->get("tipopropiedad") != "Tipo Propiedad") {
          $PropertyType = new PropertyType();
          $propertyTypeName = $PropertyType->getByName($request->get("tipopropiedad"));
          $query->where("type_id", $propertyTypeName[0]->id);
          } */

        if ($request->has("tipovendedor") && $request->get("tipovendedor") != "Tipo Vendedor") {
            $tipovendedor = $request->get("tipovendedor");
            $tipov = 1;
            if (strpos(strtolower($tipovendedor), "directo")) {
                $tipov = 2;
            }

            $query->where("owner_type_id", $tipov);
        }
        if ($request->has("cantidaddormitorios") && $request->get("cantidaddormitorios") != "Cantidad Dormitorios") {
            $query->where("number_of_rooms", explode("-", $request->get("cantidaddormitorios"))[0]);
        }

        // dd($min, $max);


        $query->whereBetween('price', array((int) $min, (int) $max));



        if ($request->has("features")) {
            $features = $request->get("features");
            $query->whereHas('services', function($query) use($features) {
                $query->whereIn('service_id', $features);
            });
        }
        if ($request->has("sort")) {

            if ($request->get("sort") == "low") {
                $query->orderBy("price", "desc");
            } else if ($request->get("sort") == "high") {
                $query->orderBy("price", "asc");
            } else {
                $query->orderBy("units.created_at", "desc");
            }
        } else {
            $query->orderBy("units.created_at", "desc");
        }

        $query->where("unit_status", 1);
        $query->where("publised", 1);

        $query->join('neighborhoods', 'neighborhoods.id', '=', 'units.neighborhood_id');

        $query->select("units.*", "neighborhoods.name as barrio");
        return $query
                        ->paginate(9);
    }

    public function getUnitsByLatLon($latitude, $longitude) {
        $query = Unit::query();
        $distance = 4;
        $query->where("publised", 1);

        $query->whereRaw(DB::raw("(3959 * acos( cos( radians($latitude) ) * cos( radians( latitude ) )  * 
                          cos( radians( longitude ) - radians($longitude) ) + sin( radians($latitude) ) * sin( 
                          radians( latitude ) ) ) ) < $distance "));
        return $query
                        ->get();
    }

    public function getUnitsSearchSeo($request, $min, $max) {

        $expiresAt = now()->addMinutes(360);
        $encrypted = base64_encode(json_encode($request->all()));

        return Cache::remember("search_home_seo_" . $encrypted, $expiresAt, function () use($request, $min, $max) {


                    $query = Unit::query();


                    $query->whereBetween('price', array((int) $min, (int) $max));
                    $query->inRandomOrder();
                    $query->where("unit_status", 1);
                    $query->where("publised", 1);

                    return $query->paginate(7);
                });
    }

    public function getUnitsSearchSeoBarrio($request, $min, $max, $barrio = 0) {

        // dd(parse_url($request->url()));

        $query = Unit::query();

        if ($barrio != 0) {
            $query->where("neighborhood_id", $barrio);
        }
        $query->whereBetween('price', array((int) $min, (int) $max));
        $query->inRandomOrder();
        $query->where("publised", 1);

        $query->where("unit_status", 1);
        return $query->paginate(7);
    }

    public function getRandomUnitsSearch($request, $min, $max) {


        $query = Unit::query();
        //$query->select(array('unit_id','slug','system','id','title','price','street_name','street_number','floor','department'));


        if ($request->has("nombre_barrio")) {
            $Neighborhood = new Neighborhood();

            $neighborhoodName = $Neighborhood->getByName(str_replace("-", " ", $request->get("nombre_barrio")));

            if ($neighborhoodName->count()) {
                $query->where("neighborhood_id", $neighborhoodName[0]->id);
            }
        }

        if ($request->has("tipopropiedad") && $request->get("tipopropiedad") != "Tipo Propiedad") {
            $PropertyType = new PropertyType();
            $propertyTypeName = $PropertyType->getByName($request->get("tipopropiedad"));
            if ($propertyTypeName->count()) {
                $query->where("type_id", $propertyTypeName[0]->id);
            }
        }

        if ($request->has("tipovendedor") && $request->get("tipovendedor") != "Tipo Vendedor") {
            $tipovendedor = $request->get("tipovendedor");
            $tipov = 1;
            if (strpos(strtolower($tipovendedor), "directo")) {
                $tipov = 2;
            }

            $query->where("owner_type_id", $tipov);
        }
        if ($request->has("cantidaddormitorios") && $request->get("cantidaddormitorios") != "Cantidad Dormitorios") {
            $query->where("number_of_rooms", explode("-", $request->get("cantidaddormitorios"))[0]);
        }

        // dd($min, $max);
        $query->whereBetween('price', array((int) $min, (int) $max));


        if ($request->has("tipooperacion") && $request->get("tipooperacion") != "Tipo Operación") {
            $Operation = new Operation();
            $operationName = $Operation->getByName($request->get("tipooperacion"));
            if ($operationName->count()) {
                $query->where("operation_id", $operationName[0]->id);
            }
        }
        if ($request->has("features")) {
            $features = $request->get("features");
            $query->whereHas('services', function($query) use($features) {
                $query->whereIn('service_id', $features);
            });
        }
        if ($request->has("sort")) {

            if ($request->get("sort") == "low") {
                $query->orderBy("price", "desc");
            } else if ($request->get("sort") == "high") {
                $query->orderBy("price", "asc");
            } else {
                $query->orderBy("created_at", "desc");
            }
        } else {
            $query->orderBy("created_at", "desc");
        }

        $query->where("unit_status", 1);
        $query->where("publised", 1);

        $query->inRandomOrder();
        return $query
                        ->paginate(7);
    }

}
