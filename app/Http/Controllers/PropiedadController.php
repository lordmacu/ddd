<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Response;
use App\PropertyType;
use App\PropertyImage;
use App\OwnerType;
use App\Owner;
use App\Service;
use App\UnitFeature;
use App\UnitService;
use App\UnitFavorite;
use App\Feature;
use App\Province;
use App\Neighborhood;
use App\Symbol;
use App\Propiedad;
use App\InterestUnit;
use App\Operation;
use App\User;
use App\Unit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Image;
use Session;
use Mail;
use Illuminate\Support\Facades\Cache;

class PropiedadController extends Controller {

    public function getBySlug(Request $request, $slug) {
        $unit = new Unit();

        $getUnitPerSlug = $unit->getUnitPerSlug($slug);


        $owner = new Owner();

        if (!$getUnitPerSlug) {
            $getUnitPerSlug = $unit->getRandomUnit($slug);
        }

        $getByOwnerPlatformIdFirst = $owner->getByOwnerPlatformIdFirst($getUnitPerSlug->user_id);
        if ($getByOwnerPlatformIdFirst) {
            $getUnitPerSlug->owner = $getByOwnerPlatformIdFirst;
        }



        return view('pages.place')->with("unit", $getUnitPerSlug);
    }

    public function populatePlaces() {


        $places = file_get_contents("https://api.fotocasa.es/PropertySearch/Search?combinedLocationIds=724,9,8,232,376,8019,0,0,0&culture=es-ES&hrefLangCultures=ca-ES%3Bes-ES%3Bde-DE%3Ben-GB&isMap=false&isNewConstruction=false&latitude=41.3854&longitude=2.17754&pageNumber=2&platformId=1&propertySubtypeIds=2%3B6%3B7%3B8%3B52%3B1%3B54&sortOrderDesc=true&sortType=bumpdate&transactionTypeId=1&propertyTypeId=2");

        $placesJson = json_decode($places, true);
        foreach ($placesJson["realEstates"] as $value) {


            $rooms = 0;
            $price = 0;
            foreach ($value["features"] as $key => $feature) {
                if ($feature["key"] == "rooms") {
                    $rooms = $feature["value"][0];
                }
            }
            $price = $value["transactions"][0]["value"][0];
            $ownerName = ucwords(implode(" ", explode("-", $value["advertiser"]["urlAlias"])));

            $ownerPhone = $value["advertiser"]["phone"];
            $totalAddress = explode(",", $value["address"]["ubication"]);
            $address = "";
            $neigborhood = "";
            $lat = $value["address"]["coordinates"]["latitude"];
            $lon = $value["address"]["coordinates"]["longitude"];
            if (count($totalAddress) == 2) {
                $address = $totalAddress[0];
                $neigborhood = $totalAddress[1];
            } else {
                $address = $totalAddress[0];
                $neigborhood = $totalAddress[0];
            }

            $type = "";
            if ($value["subtypeId"] == 1) {
                $type = "Plantas intermedias";
            } else if ($value["subtypeId"] == 2) {
                $type = "Apartamento";
            } else if ($value["subtypeId"] == 6) {
                $type = "Ático";
            } else if ($value["subtypeId"] == 7) {
                $type = "Dúplex";
            } else if ($value["subtypeId"] == 8) {
                $type = "Loft";
            } else if ($value["subtypeId"] == 52) {
                $type = "Planta baja";
            } else if ($value["subtypeId"] == 8) {
                $type = "Loft";
            } else if ($value["subtypeId"] == 54) {
                $type = "Estudio";
            } else if ($value["subtypeId"] == 3) {
                $type = "Chalet";
            } else if ($value["subtypeId"] == 5) {
                $type = "Casa adosada";
            } else if ($value["subtypeId"] == 9) {
                $type = "Finca rústica";
            }
            try {




                $unit = new Unit();

                $getUnitByUnitId = $unit->getUnitByUnitId($value["id"]);

                if (!$getUnitByUnitId) {


                    $unit->unit_id = $value["id"];

                    $unit->latitude = $lat;
                    $unit->longitude = $lon;

                    $unit->video = "";


                    $Owner = new Owner();
                    $getByEmail = $Owner->getByNameFirst($ownerName);
                    if (!$getByEmail) {
                        $Owner->first_name = $ownerName;
                        $Owner->email = $value["advertiser"]["urlAlias"] . "@gmail.com";
                        $Owner->phone = strip_tags($ownerPhone);
                        $Owner->type = 1;
                        $Owner->owner_id = 0;
                        $Owner->save();
                        $getByEmail = $Owner;
                    } else {
                        $getByEmail = $Owner;
                    }

                    $unit->owner_id = $getByEmail->id;
                    $unit->country_id = 3;

                    $unit->user_id = Auth::id();
                    $unit->owner_type_id = 1;


                    $unit->owner_name = $ownerName;
                    $unit->email = $value["advertiser"]["urlAlias"] . "@gmail.com";
                    $unit->phone = strip_tags($ownerPhone);



                    $propertyTYpe = new PropertyType();
                    $propertyType = $propertyTYpe->getByNameFirst($type);
                    if (!$propertyType) {
                        $propertyTYpeModel = new PropertyType();
                        $propertyTYpeModel->name = $type;
                        $propertyTYpeModel->country_id = 3;
                        $propertyTYpeModel->save();

                        $propertyType = $propertyTYpeModel;
                    }

                    $operationText = "";
                    $operationText = "Alquiler de";

                    $slug = $operationText . " de " . $propertyType->name . " en ";

                    $unit->type_id = $propertyType->id;




                    $unit->symbol_id = 5;

                    $unit->surface = 0;


                    $unit->street_name = $address;


                    $unit->street_number = 0;
                    $unit->floor = 0;
                    $unit->department = 0;
                    $unit->zip = 0;






                    $neibourhoodModel = new Neighborhood();
                    $Neighborhood = $neibourhoodModel->getByNameFirst($neigborhood);

                    if ($Neighborhood == null) {

                        $neibourhoodModel->country_id = 3;


                        $neibourhoodModel->name = $neigborhood;
                        $neibourhoodModel->lat = $lat;
                        $neibourhoodModel->lon = $lon;

                        $neibourhoodModel->save();
                        $Neighborhood = $neibourhoodModel;
                        $unit->neighborhood_id = $Neighborhood->id;
                    } else {
                        $unit->neighborhood_id = $Neighborhood->id;
                    }

                    $slug .= $Neighborhood->name;




                    $unit->operation_id = 2;

                    $unit->price = $price;
                    $unit->title = $slug;
                    $unit->number_of_rooms = $rooms;
                    $unit->slug = "s";
                    $unit->information = $value["description"];
                    $unit->system = 1;
                    $unit->unit_status = 1;
                    $unit->status = 1;
                    $unit->autorized = 1;
                    $unit->local = 2;
                    $unit->publised = 1;



                    $unit->save();
                    $unit->slug = $this->sluglify($unit->id . " " . $slug);

                    $unit->save();

                    $count = 0;
                    foreach ($value["multimedias"] as $multimedia) {
                        if ($count < 6) {
                            $response = $this->fileUploadUrl($multimedia["url"]);

                            $propertyImage = new PropertyImage();
                            $propertyImage->unit_id = $unit->id;
                            $propertyImage->small = $response;
                            $propertyImage->medium = $response;
                            $propertyImage->large = $response;
                            $propertyImage->save();
                            $count++;
                        }
                    }



                    /*  foreach ($value["services"] as $service) {


                      $apartmentService = new Service();
                      $getByNameFirst = $apartmentService->getByNameFirst($service);

                      if (!$getByNameFirst) {
                      $apartmentServiceModel = new Service();
                      $apartmentServiceModel->name = $service;
                      $apartmentServiceModel->country_id = 2;
                      $apartmentServiceModel->save();
                      $getByNameFirst = $apartmentServiceModel;
                      }
                      $UnitService = new UnitService();
                      $UnitService->unit_id = $unit->id;
                      $UnitService->service_id = $getByNameFirst->id;
                      $UnitService->save();
                      } */




                    dump($unit->slug);
                }
            } catch (\Exception $ex) {
                dd($ex->getMessage() . " " . $ex->getLine());
            }
        }
    }

    public function vinculationPost(Request $request) {

        $unitModel = new Unit();
        $unit = $unitModel->getUnitByCode($request->get("code"));
        if ($unit) {
            $Owner = new Owner();
            $getByOwnerPlatformIdFirst = $Owner->getByOwnerPlatformIdFirst(Auth::id());
            if (!$getByOwnerPlatformIdFirst) {
                $Owner->first_name = $request->get("name_owner");
                $Owner->email = $request->get("email");
                $Owner->phone = $request->get("phone_owner");
                $Owner->type = $request->get("tipovendedor");
                $Owner->owner_id = Auth::id();
                $Owner->save();
                $unit->owner_id = $Owner->id;
                $unit->user_id = Auth::id();
            } else {
                $unit->owner_id = $getByOwnerPlatformIdFirst->id;
                $unit->user_id = Auth::id();
            }
            $unit->unit_status = 1;
            $unit->owned = 1;

            $unit->save();
            return redirect("https://alquilerdirecto.com.ar/unit/" . $unit->id . "/edit");
        } else {
            return redirect()->back();
        }
    }

    public function vincularPropiedad(Request $request) {

        \Session::put('backUrlpublicar', url()->full());
        \Session::put('backUrl', url()->full());

        if (Auth::check()) {

            $unit = new Unit();
            $getUnitByCode = $unit->getUnitByCode($request->get("code"));

            return view('layouts.vincular')
                            ->with("unit", $getUnitByCode);
        } else {
            return redirect("https://alquilerdirecto.com.ar/login");
        }
    }

    public function contactOwnerApi($request) {
        $Unit = new Unit();

        $getCountUnitPerId = $Unit->getUnitPerId($request->get("place"));
        // dd($getCountUnitPerId);

        if (!$getCountUnitPerId->owner) {

            $Owner = new Owner();
            $getCountUnitPerId->owner = $Owner->getByOwnerPlatformId($getCountUnitPerId->owner_id);
        } else {
            return array("error" => "no owner");
        }
    }

    public function contactOwner($id, Request $request) {
        $Unit = new Unit();

        $getCountUnitPerId = $Unit->getUnitPerId($id);
        // dd($getCountUnitPerId);

        if (!$getCountUnitPerId->owner) {

            $Owner = new Owner();
            $getCountUnitPerId->owner = $Owner->getByOwnerPlatformId($getCountUnitPerId->owner_id);
        }
        if ($request->has("debug")) {
            dd($getCountUnitPerId->owner);
        }


        return view('layouts.contactowner')
                        ->with("unit", $getCountUnitPerId);
    }

    public function generateImage(Request $request) {



        return "image";
        if (!$request->has("debug")) {
            ini_set("zlib.output_compression", "Off");
            header('Content-type: image/jpeg');
        }


        $urlImage = $request->get("img");

        $ext = pathinfo($urlImage, PATHINFO_EXTENSION);


        $imageOverlapUrl = "https://s3.amazonaws.com/meetworks/gradient_header.png";
        $imageOverlaps = imagecreatefrompng($imageOverlapUrl);


        // Create Image From Existing File
        if ($request->has("img")) {
            $mime = @getimagesize($urlImage);
            if ($request->has("debug")) {
                dd($urlImage);
            }
            if ($mime) {
                if ($mime["mime"] != "image/gif" && $ext == "jpg") {
                    $jpg_imagebacks = imagecreatefromjpeg($urlImage);
                } else {
                    $jpg_imagebacks = imagecreatefromjpeg(realpath(public_path("wall.jpg")));
                }
            } else {
                $jpg_imagebacks = imagecreatefromjpeg(realpath(public_path("wall.jpg")));
            }
        } else {
            $jpg_imagebacks = imagecreatefromjpeg(realpath(public_path("wall.jpg")));
        }
        // $jpg_images = imagecreatefromjpeg(realpath(public_path("wall.jpg")));
        // list($width, $height) = getimagesize(realpath(public_path("wall.jpg")));

        $jpg_image = imagecreatetruecolor(600, 314);
        //  imagecopyresized($jpg_image, $jpg_images, 0, 0, 0, 0, 600, 314, $width, $height);

        if ($request->has("img")) {
            $mime = @getimagesize($urlImage);
            if ($mime) {
                list($width1, $height1) = $mime;
            } else {
                $width1 = 600;
                $height1 = 314;
            }
        } else {
            $width1 = 600;
            $height1 = 314;
        }
        $jpg_imageback = imagecreatetruecolor(600, 314);
        imagecopyresized($jpg_imageback, $jpg_imagebacks, 0, 0, 0, 0, 600, 314, $width1, $height1);

        // Allocate A Color For The Text
        $white = imagecolorallocate($jpg_image, 255, 255, 255);

        // Set Path to Font File
        $font_path = realpath(public_path("font.ttf"));

        // Set Text to Be Printed On Image
        $text = $request->get("text");
        imagecopy($jpg_image, $jpg_imageback, (imagesx($jpg_image) / 2) - (imagesx($jpg_imageback) / 2), (imagesy($jpg_image) / 2) - (imagesy($jpg_imageback) / 2), 0, 0, imagesx($jpg_imageback), imagesy($jpg_imageback));

        // Print Text On Image
        $rotate = imagerotate($imageOverlaps, 180, 0);


        imagettftext($rotate, 18, 0, 10, 30, $white, $font_path, wordwrap($text, 50, "\n"));

        imagecopyresized($jpg_image, $rotate, 0, 230, 0, 0, 600, 80, 600, 80);




        // Send Image to Browser
        imagejpeg($jpg_image);

        // Clear Memory
        imagedestroy($jpg_image);
    }

    public function randompropiedad() {

        $Unit = new Unit();


        $getCountUnitPerId = $Unit->getRandomUnit();

        $nearUnits = null;
        $getNearbyPlaces = null;

        if ($getCountUnitPerId->latitude) {
            $nearUnits = $Unit->getNearUnits($getCountUnitPerId->latitude, $getCountUnitPerId->longitude, $getCountUnitPerId->id);

            $getNearbyPlaces = json_decode($Unit->getNearbyPlaces($getCountUnitPerId->latitude, $getCountUnitPerId->longitude), true)["results"];
            $getNearbyPlaces = array_slice($getNearbyPlaces, 0, 5);
        }

        if (!$getCountUnitPerId->owner) {

            $Owner = new Owner();
            $getCountUnitPerId->owner = $Owner->getByOwnerPlatformId($getCountUnitPerId->owner_id);
        }




        return view('layouts.propiedadv2')
                        ->with("near", $nearUnits)
                        ->with("nearPlaces", $getNearbyPlaces)
                        ->with("unit", $getCountUnitPerId);
    }

    public function index(Request $request, $id, $name) {


        $Unit = new Unit();


        $getCountUnitPerId = $Unit->getUnitPerId($id);

        if ($request->has("debug")) {

            dd("aqui");
            return $getCountUnitPerId;
        }

        try {
            if (!$getCountUnitPerId) {
                $openstreet = file_get_contents("https://alquilerdirecto.com.ar/importadorIndividual?id=" . ($id));


                $getCountUnitPerId = $Unit->getUnitPerId($id);
            }
        } catch (\Exception $exc) {
            $getCountUnitPerId = null;
        }



        if ($getCountUnitPerId == null) {
            $getCountUnitPerId = $Unit->getRandomUnit();
        }

        if ($request->has("debug")) {
            dd($getCountUnitPerId);
        }
        $nearUnits = null;
        $getNearbyPlaces = null;

        $expiresAt = now()->addMinutes(3600);

        if ($getCountUnitPerId->latitude) {

            $nearUnits = $Unit->getNearUnits($getCountUnitPerId->latitude, $getCountUnitPerId->longitude, $getCountUnitPerId->id);



            $getNearbyPlaces = Cache::rememberForever("near_places_" . $getCountUnitPerId->id, function () use($Unit, $getCountUnitPerId) {
                        return json_decode($Unit->getNearbyPlaces($getCountUnitPerId->latitude, $getCountUnitPerId->longitude), true)["results"];
                    });
            if (is_array($getNearbyPlaces)) {
                $getNearbyPlaces = array_slice($getNearbyPlaces, 0, 5);
            }
        }

        if (!$getCountUnitPerId->owner) {

            $getCountUnitPerId->owner = $getCountUnitPerId->ownerExt;
        }



        return view('layouts.propiedadv2')
                        ->with("near", $nearUnits)
                        ->with("nearPlaces", $getNearbyPlaces)
                        ->with("unit", $getCountUnitPerId);
    }

    public function propiedadSystemv(Request $request, $name) {


        try {

            $expiresAt = now()->addMinutes(3600);

            $Unit = new Unit();
            $getCountUnitPerId = $Unit->getUnitPerSlug($name);

            if ($request->has("debug")) {

                //  return $getCountUnitPerId;
            }

            if ($getCountUnitPerId) {


                $nearUnits = null;
                $getNearbyPlaces = null;

                if ($getCountUnitPerId->latitude) {
                    $nearUnits = Cache::remember("near_unitsf_" . $getCountUnitPerId->id, $expiresAt, function () use($Unit, $getCountUnitPerId) {
                                return $Unit->getNearUnits($getCountUnitPerId->latitude, $getCountUnitPerId->longitude, $getCountUnitPerId->id);
                            });

                    $getNearbyPlaces = Cache::rememberForever("near_places_sd" . $getCountUnitPerId->id, function () use($Unit, $getCountUnitPerId) {
                                return json_decode($Unit->getNearbyPlaces($getCountUnitPerId->latitude, $getCountUnitPerId->longitude), true)["results"];
                            });
                    if ($getNearbyPlaces) {
                        shuffle($getNearbyPlaces);
                        $getNearbyPlaces = array_slice($getNearbyPlaces, 0, 10);
                    }
                }

                if (!$getCountUnitPerId->owner) {

                    $getCountUnitPerId->owner = $getCountUnitPerId->ownerExt;
                }

                return view('layouts.propiedadv2')
                                ->with("near", $nearUnits)
                                ->with("nearPlaces", $getNearbyPlaces)
                                ->with("unit", $getCountUnitPerId);
            } else {
                return redirect()->route("search");
            }
        } catch (Exception $e) {
            return redirect()->route("search");
        }
    }

    public function propiedadSystem(Request $request, $name) {



        if ($request->has("autolog")) {
            $user = new User();
            $getBySourceId = $user->getBySourceId($request->get("autolog"));
            if ($getBySourceId) {
                Auth::login($getBySourceId, true);
            }
        }

        try {

            $expiresAt = now()->addMinutes(3600);

            $Unit = new Unit();
            $getCountUnitPerId = $Unit->getUnitPerSlug($name);

            if ($request->has("debug")) {

                //  return $getCountUnitPerId;
            }

            if ($getCountUnitPerId) {


                $nearUnits = null;
                $getNearbyPlaces = null;

                if ($getCountUnitPerId->latitude) {
                    $nearUnits = Cache::remember("near_unitsdd_d" . $getCountUnitPerId->id, $expiresAt, function () use($Unit, $getCountUnitPerId) {
                                return $Unit->getNearUnits($getCountUnitPerId->latitude, $getCountUnitPerId->longitude, $getCountUnitPerId->id);
                            });

                    $getNearbyPlaces = Cache::rememberForever("near_places_sd" . $getCountUnitPerId->id, function () use($Unit, $getCountUnitPerId) {
                                return json_decode($Unit->getNearbyPlaces($getCountUnitPerId->latitude, $getCountUnitPerId->longitude), true)["results"];
                            });
                    if ($getNearbyPlaces) {
                        shuffle($getNearbyPlaces);
                        $getNearbyPlaces = array_slice($getNearbyPlaces, 0, 10);
                    }
                }

                if (!$getCountUnitPerId->owner) {

                    $getCountUnitPerId->owner = $getCountUnitPerId->ownerExt;
                }

                return view('layouts.propiedadv2')
                                ->with("near", $nearUnits)
                                ->with("nearPlaces", $getNearbyPlaces)
                                ->with("unit", $getCountUnitPerId);
            } else {
                return redirect()->route("search");
            }
        } catch (Exception $e) {
            return redirect()->route("search");
        }
    }

    public function sendInteres(Request $request) {
        // return ["result"=>true,"success"=>"Enviaste tus datos al propietario, en unos momentos te contactará"];


        set_time_limit(0);



        if (Auth::check()) {


            try {
                $property = new Unit();
                $InteresProperty = new InterestUnit();
                $findPropertyId = Unit::find($request->get("id"));
                if ($findPropertyId) {
                    $this->sendInteresGetMessage(Auth::id(), $findPropertyId->slug, $request->get("comentariocontact"));


                    $findPropertyByuser = $InteresProperty->findPropertyByuser($request->get("unit_id"), Auth::id());
                    if ($findPropertyByuser == 0) {
                        $user = User::find(Auth::id());
                        $user->alternative_mail = $request->get("email");
                        $user->cel = $request->get("cel");
                        $user->save();

                        $InteresProperty->property_id = $request->get("id");
                        $InteresProperty->user_id = Auth::id();
                        $InteresProperty->comment = $request->get("comentariocontact");
                        $InteresProperty->save();
                        return redirect()->back()->with('success', __('messages.yourComment'));
                    } else {
                        return redirect()->back()->with('success', __('messages.yourComment'));
                    }
                } else {
                    return redirect()->back()->with('error', __('messages.PropertyNoExist'));
                }
            } catch (Exception $exc) {
                return redirect()->back()->with('error', __('messages.PropertyError'));
            }
        } else {
            return ["result" => true, "success" => __('messages.sendDataProperty')];
        }
    }

    public function crearPropiedadesPost(Request $request) {
        if (!Auth::check()) {
            return redirect()->route("homeslash");
        }

        $unit = new Unit();

        $getUnitByTitle = $unit->getUnitByTitle($request->get("title"));

        if (count($getUnitByTitle) == 0) {
            $unit->unit_id = uniqid();

            if ($request->has("latitude")) {
                $unit->latitude = $request->get("latitude");
            }

            if ($request->has("longitude")) {
                $unit->longitude = $request->get("longitude");
            }
            $unit->video = "";



            $Owner = new Owner();
            $getByEmail = $Owner->getByEmail($request->get("email"));
            if ($getByEmail->count() == 0) {
                $Owner->first_name = Auth::user()->name;
                $Owner->email = $request->get("email");
                $Owner->phone = $request->get("phone");
                $Owner->type = $request->get("ownerType");
                $Owner->owner_id = Auth::id();
                $Owner->save();
            }


            $unit->owner_id = $Owner->id;
            if (Session::has('country_id')) {
                $unit->country_id = Session::get('country_id');
            }
            $unit->user_id = Auth::id();
            $unit->owner_type_id = $request->get("ownerType");

            if ($request->has("ownername")) {
                $unit->owner_name = $request->get("ownername");
            }
            if ($request->get("email") != "0") {

                $unit->email = $request->get("email");
                $unit->phone = $request->get("phone");
            }




            $propertyType = PropertyType::find($request->get("propertyType"));

            $operationText = "";
            if ($request->get("operation") == 1) {
                $operationText = "Alquiler de";
            } else if ($request->get("operation") == 2) {
                $operationText = "Venta de";
            }
            $slug = $operationText . " de " . $propertyType->name . " en ";

            $unit->type_id = $request->get("propertyType");

            if ($request->get("currency") == "peso") {
                $unit->symbol_id = 3;
            }
            if ($request->get("currency") == "dolar") {
                $unit->symbol_id = 2;
            }
            $unit->surface = 0;

            $unit->street_name = $request->get("streetName");
            $unit->street_number = $request->get("streetNumber");
            $unit->floor = 0;
            $unit->department = 0;
            $unit->zip = 0;

            $unit->operation_id = $request->get("operation");
            $unit->price = str_replace(',', '', str_replace(".", "", $request->get("price")));
            $unit->title = $request->get("title");
            $unit->number_of_rooms = $request->get("number_of_rooms");
            $unit->slug = $request->get("slug");
            $unit->information = $request->get("description");
            $unit->system = 1;
            $unit->unit_status = 1;
            $unit->status = 1;
            $unit->autorized = 1;
            $unit->local = 2;
            $unit->publised = 1;


            if ($request->has("facebook_url")) {
                $unit->facebook_url = $request->get("facebook_url");
            } else {
                if (Auth::user()->source == 1) {
                    $unit->facebook_url = "https://www.facebook.com/messages/t/" . Auth::user()->id_source . "/";
                }
            }



            if ($request->has("neighborhood")) {

                $neibourhoodModel = new Neighborhood();
                $Neighborhood = $neibourhoodModel->getByNameFirst($request->get("neighborhood"));

                if ($Neighborhood == null) {

                    if (Session::has('country_id')) {
                        $neibourhoodModel->country_id = Session::get('country_id');
                    }

                    $neibourhoodModel->name = $request->get("neighborhood");
                    $neibourhoodModel->lat = $request->get("latitude");
                    $neibourhoodModel->lon = $request->get("longitude");
                    $neibourhoodModel->save();
                    $Neighborhood = $neibourhoodModel;
                    $unit->neighborhood_id = $Neighborhood->id;
                } else {
                    $unit->neighborhood_id = $Neighborhood->id;
                }

                $slug .= $Neighborhood->name;
            }

            $unit->save();
            $unit->slug = $this->sluglify($unit->id . " " . $slug);

            $unit->save();


            foreach ($request->get("images") as $image) {
                $propertyImage = new PropertyImage();
                $propertyImage->unit_id = $unit->id;
                $propertyImage->small = $image;
                $propertyImage->medium = $image;
                $propertyImage->large = $image;
                $propertyImage->save();
            }

            foreach ($request->get("favorite") as $image) {
                $UnitService = new UnitService();
                $UnitService->unit_id = $unit->id;
                $UnitService->service_id = $image;
                $UnitService->save();
            }



            $this->sendUsersToSlack('Nueva propiedad creada https://alquilerdirecto.com.ar/' . $unit->slug);

            return $unit->slug;

        }else{
            return $getUnitByTitle[0]->slug;
        }
    }

    public function crearPropiedad(Request $request) {


        if (!Auth::check()) {

            \Session::put('backUrlpublicar', route("crearPropiedad"));
            \Session::put('backUrl', route("crearPropiedad"));
            return redirect()->route("login");
        }

        Session::put('tempId', rand(999990900, 999999999));


        if (Session::has('country_id')) {
            $PropertyType = PropertyType::where("country_id", Session::get('country_id'))->get();
        } else {
            $PropertyType = PropertyType::all();
        }

        if (Session::has('country_id')) {
            $services = Service::where("country_id", Session::get('country_id'))->get();
        } else {
            $services = Service::all();
        }



        return view('layouts.crearpropiedad')
                        ->with("id", Session::get('tempId'))
                        ->with("propertyTypes", $PropertyType)
                        ->with("services", $services);
    }

    public function crearPropiedades(Request $request) {

        if (!Auth::check()) {

            \Session::put('backUrlpublicar', route("crearPropiedad"));
            \Session::put('backUrl', route("crearPropiedad"));
            return redirect()->route("login");
        }


        Session::put('tempId', rand(999990900, 999999999));

        if (Session::has('country_id')) {
            $PropertyType = PropertyType::where("country_id", Session::get('country_id'))->get();
        } else {
            $PropertyType = PropertyType::all();
        }

        if (Session::has('country_id')) {
            $services = Service::where("country_id", Session::get('country_id'))->get();
        } else {
            $services = Service::all();
        }

        return view('pages.crearpropiedades')
                        ->with("id", Session::get('tempId'))
                        ->with("propertyTypes", $PropertyType)
                        ->with("services", $services);
    }

    public function publicarPropiedadFacebook() {



        Session::put('tempId', rand(999990900, 999999999));
        $Neighborhood = Neighborhood::all();
        $PropertyType = PropertyType::all();
        $services = Service::all();

        return view('layouts.crearpropiedadesFacebook')
                        ->with("id", Session::get('tempId'))
                        ->with("neighborhoods", $Neighborhood)
                        ->with("propertyTypes", $PropertyType)
                        ->with("services", $services);
    }

    public function sendInteresGetMessage($userId, $slug, $message) {

        $user = User::find($userId);

        $unit = new Unit();
        $getUnitPerSlug = $unit->getUnitPerSlug($slug);

        if ($getUnitPerSlug) {

            if ($getUnitPerSlug->owner) {
                $emailParams = array("user" => $user,
                    "message" => $message,
                    "unit" => $getUnitPerSlug);

                Mail::send('emails.interes', $emailParams, function ($m) use ($emailParams) {

                    $m
                            ->to(strtolower($emailParams["unit"]->owner->email), $emailParams["unit"]->owner->first_name)
                            ->subject($emailParams["user"]->name . " esta interesado en tu propiedad ");
                });
            }
        }
    }

    public function sendInteresGet(Request $request) {

        try {


            $user = User::find($request->get("user_id"));

            $unit = new Unit();
            $getUnitPerSlug = $unit->getUnitPerSlug($request->get("slug"));

            if ($getUnitPerSlug) {

                if ($getUnitPerSlug->owner) {
                    $emailParams = array("user" => $user,
                        "message" => null,
                        "unit" => $getUnitPerSlug);
                    Mail::send('emails.interes', $emailParams, function ($m) use ($emailParams) {

                        $m
                                ->to(strtolower($emailParams["unit"]->owner->email), $emailParams["unit"]->owner->first_name)
                                // ->to(strtolower("informacion@cristiangarcia.co"), $emailParams["unit"]->owner->first_name)
                                ->subject($emailParams["user"]->name . " esta interesado en tu propiedad ");
                    });

                    return array("response" => true, "data" => $getUnitPerSlug->owner);
                }
            }
        } catch (\Exception $exc) {
            return array("response" => false);
        }
    }

    public function fileUploadUrl($url) {






        $filename = time() . ".jpg";
        $arrayImages = array();

        $s3 = \Storage::disk('s3');


        $small = Image::make($url)->fit(300, 171)->encode("jpg", 75);
        $thumbImage = $small->stream();

        $upload = $s3->put("/images/small/" . $filename, $thumbImage->__toString());


        $small = Image::make($url)->fit(700, 400)->encode("jpg", 75);
        $thumbImage = $small->stream();

        $upload = $s3->put("/images/medium/" . $filename, $thumbImage->__toString());

        $small = Image::make($url)->encode("jpg", 75);
        $thumbImage = $small->stream();

        $upload = $s3->put("/images/large/" . $filename, $thumbImage->__toString());

        return $filename;
    }

    public function fileUpload(Request $request) {



        $rules = [
            'qqfile' => 'required|image|mimes:jpeg,png,jpg',
        ];

        $input = $request->all();

        $validator = Validator::make($input, $rules);



        if ($validator->fails()) {
            return $validator->errors();
        }

        $image = $request->file('qqfile');
        $string = preg_replace('/\s+/', '', $image->getClientOriginalName());

        $filename = time() . "-" . $string;
        $arrayImages = array();

        $s3 = \Storage::disk('s3');


        $small = Image::make($image->getRealPath())->fit(300, 171)->encode($image->extension(), 75);
        $thumbImage = $small->stream();

        $upload = $s3->put("/images/small/" . $filename, $thumbImage->__toString());


        $small = Image::make($image->getRealPath())->fit(700, 400)->encode($image->extension(), 75);
        $thumbImage = $small->stream();

        $upload = $s3->put("/images/medium/" . $filename, $thumbImage->__toString());

        $small = Image::make($image->getRealPath())->encode($image->extension(), 75);
        $thumbImage = $small->stream();

        $upload = $s3->put("/images/large/" . $filename, $thumbImage->__toString());

        return '{"success":true,"newUuid":"' . $filename . '"}';
    }

    public function deletePhoto(Request $request) {
        $key = $request->get("key");
        $data = explode("|", $key);
        $PropertyImage = PropertyImage::find($data[1]);
        return "" . $PropertyImage->delete();
    }

    public function get_remote_data($url, $post_paramtrs = false) {
        $c = curl_init();
        curl_setopt($c, CURLOPT_URL, $url);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        if ($post_paramtrs) {
            curl_setopt($c, CURLOPT_POST, TRUE);
            curl_setopt($c, CURLOPT_POSTFIELDS, "var1=bla&" . $post_paramtrs);
        } curl_setopt($c, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($c, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; rv:33.0) Gecko/20100101 Firefox/33.0");
        curl_setopt($c, CURLOPT_COOKIE, 'CookieName1=Value;');
        curl_setopt($c, CURLOPT_MAXREDIRS, 10);
        $follow_allowed = ( ini_get('open_basedir') || ini_get('safe_mode')) ? false : true;
        if ($follow_allowed) {
            curl_setopt($c, CURLOPT_FOLLOWLOCATION, 1);
        }curl_setopt($c, CURLOPT_CONNECTTIMEOUT, 9);
        curl_setopt($c, CURLOPT_REFERER, $url);
        curl_setopt($c, CURLOPT_TIMEOUT, 60);
        curl_setopt($c, CURLOPT_AUTOREFERER, true);
        curl_setopt($c, CURLOPT_ENCODING, 'gzip,deflate');
        $data = curl_exec($c);
        $status = curl_getinfo($c);
        curl_close($c);
        preg_match('/(http(|s)):\/\/(.*?)\/(.*\/|)/si', $status['url'], $link);
        $data = preg_replace('/(src|href|action)=(\'|\")((?!(http|https|javascript:|\/\/|\/)).*?)(\'|\")/si', '$1=$2' . $link[0] . '$3$4$5', $data);
        $data = preg_replace('/(src|href|action)=(\'|\")((?!(http|https|javascript:|\/\/)).*?)(\'|\")/si', '$1=$2' . $link[1] . '://' . $link[3] . '$3$4$5', $data);
        if ($status['http_code'] == 200) {
            return $data;
        } elseif ($status['http_code'] == 301 || $status['http_code'] == 302) {
            if (!$follow_allowed) {
                if (empty($redirURL)) {
                    if (!empty($status['redirect_url'])) {
                        $redirURL = $status['redirect_url'];
                    }
                } if (empty($redirURL)) {
                    preg_match('/(Location:|URI:)(.*?)(\r|\n)/si', $data, $m);
                    if (!empty($m[2])) {
                        $redirURL = $m[2];
                    }
                } if (empty($redirURL)) {
                    preg_match('/href\=\"(.*?)\"(.*?)here\<\/a\>/si', $data, $m);
                    if (!empty($m[1])) {
                        $redirURL = $m[1];
                    }
                } if (!empty($redirURL)) {
                    $t = debug_backtrace();
                    return call_user_func($t[0]["function"], trim($redirURL), $post_paramtrs);
                }
            }
        } return "ERRORCODE22 with $url!!<br/>Last status codes<b/>:" . json_encode($status) . "<br/><br/>Last data got<br/>:$data";
    }

    public function sanitize(Request $request) {
        $input = $request->all();


        $input['idTemp'] = filter_var($input['idTemp'], FILTER_SANITIZE_STRING);
        $input['title'] = filter_var($input['title'], FILTER_SANITIZE_STRING);
        $input['tipooperacion'] = filter_var($input['tipooperacion'], FILTER_SANITIZE_STRING);
        $input['tipopropiedad'] = filter_var($input['tipopropiedad'], FILTER_SANITIZE_STRING);
        $input['price'] = filter_var($input['price'], FILTER_SANITIZE_STRING);
        $input['surface'] = filter_var($input['surface'], FILTER_SANITIZE_STRING);
        $input['cantidaddormitorios'] = filter_var($input['cantidaddormitorios'], FILTER_SANITIZE_STRING);
        $input['tipovendedor'] = filter_var($input['tipovendedor'], FILTER_SANITIZE_STRING);
        $input['street_name'] = filter_var($input['route'], FILTER_SANITIZE_STRING);
        $input['street_number'] = filter_var($input['street_number'], FILTER_SANITIZE_STRING);
        $input['floor_prop'] = filter_var($input['floor_prop'], FILTER_SANITIZE_STRING);
        $input['department'] = filter_var($input['department'], FILTER_SANITIZE_STRING);
        $input['neighborhood_id'] = filter_var($input['sublocality'], FILTER_SANITIZE_STRING);
        $input['name'] = filter_var($input['name_owner'], FILTER_SANITIZE_STRING);
        $input['email'] = filter_var($input['email'], FILTER_SANITIZE_STRING);
        $input['phone'] = filter_var($input['phone_owner'], FILTER_SANITIZE_STRING);
        $input['description'] = filter_var($input['description'], FILTER_SANITIZE_STRING);

        $request->replace($input);
    }

    public function previewPropiedad(Request $request) {



        \Session::put('backUrlpublicar', route("publishPropiedad"));
        \Session::put('backUrl', route("publishPropiedad"));



        $value = $request->session()->get('backUrl', 'default');


        if ($request->has("idTemp")) {
            $this->sanitize($request);
        } else {
            return redirect()->back()
                            ->withInput();
        }
        $messages = [
            'neighborhood_id.exists' => __('messages.neightboorhoodNoExist'),
            'tipopropiedad.exists' => __('messages.typePropertyNoExist'),
            'tipovendedor.exists' => __('messages.TypeOwnerNoExist'),
            'tipooperacion.exists' => __('messages.TypeOperationNoExist')
        ];

        $validator = Validator::make($request->all(), [
                    'tipopropiedad' => 'required|exists:property_types,id|integer',
                    'tipooperacion' => 'required|exists:operations,id|integer',
                    'price' => 'required',
                    'cantidaddormitorios' => 'required',
                    'tipovendedor' => 'required',
                    'name' => 'required',
                    'email' => 'required',
                        //  'g-recaptcha-response' => 'required|captcha'
                        ], $messages);



        if ($validator->fails()) {

            return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
        }




        if (!$request->has("latitude")) {
            $stringbusqueda = $request->get("neighborhood_id")
                    . $request->get("street_name") . " "
                    . $request->get("street_number");
            $url = "http://nominatim.openstreetmap.org/search?format=json&q=" . urlencode($stringbusqueda);
            $openstreet = $this->get_remote_data($url);
            $latitude = json_decode($openstreet, true);


            if (is_array($latitude) && count($latitude) > 0) {
                $request->request->add(["latitude" => $latitude[0]["lat"]]);
                $request->request->add(["longitude" => $latitude[0]["lon"]]);
            }
        }


        \Session::put('unit', $request->all());


        //dd( \Session::get('unit'));

        $getNearbyPlaces = null;


        if ($request->has("features")) {
            $featuresPreview = array();
            foreach ($request->get("features") as $feature) {
                $feature = Service::find($feature);

                $featuresPreview[] = $feature->name;
            }
        }

        if (Auth::check()) {
            return redirect()->route("publishPropiedad");
        } else {
            return view('layouts.logincrearpropiedad');
        }
        return view('layouts.propiedadpreview')
                        ->with("features", $featuresPreview)
                        ->with("nearPlaces", $getNearbyPlaces)
                        ->with("unit", $request->all());
    }

    public function misPropiedades(Request $request) {
        if (Auth::check()) {
            $units = new Unit();

            $getUnitsPerOwner = $units->getUnitsPerOwner($request, Auth::id());


            return view('layouts.mispropiedades')
                            ->with("units", $getUnitsPerOwner);
        } else {
            return redirect()->route("homeslash");
        }
    }

    public function favoritas(Request $request) {





        return view('layouts.favoritas');
    }

    public function convertImages() {
        $unit = new PropertyImage();
        $getimages = $unit->getimages();

        foreach ($getimages as $value) {
            $value->small = "https://alquilerdirecto.com.ar" . $value->small;
            $value->medium = "https://alquilerdirecto.com.ar" . $value->medium;
            $value->large = "https://alquilerdirecto.com.ar" . $value->large;
            $value->save();
        }
    }

    public function editPropiedad($id) {

        $unit = Unit::find($id);

        if ($unit) {



            if ($unit->user_id != Auth::id()) {
                return redirect()->route("misPropiedades")->with('error', __('messages.CantSeeProperty'));
            }

            $Neighborhood = Neighborhood::all();
            $PropertyType = PropertyType::all();
            $services = Service::all();

            $features = array();

            foreach ($unit->services as $service) {
                $features[] = $service->service_id;
            }
            $resultImage = array();

            foreach ($unit->images as $file) { //get an array which has the names of all the files and loop through it 
                $obj = array();
                $obj['name'] = $file->small . "|" . $file->id;
                $obj['size'] = 12551;
                $obj['id'] = $file->id;
                $resultImage[] = $obj;
            }

            $unit->neighborhood_id = $unit->neighborhood->name;

            return view('layouts.editpropiedad')
                            ->with("neighborhoods", $Neighborhood)
                            ->with("unit", $unit)
                            ->with("features", $features)
                            ->with("images", $resultImage)
                            ->with("propertyTypes", $PropertyType)
                            ->with("services", $services);
        } else {
            return redirect()->route("misPropiedades")->with('error', __('messages.CantSeeProperty'));
        }
    }

    public function editPostPropiedad(Request $request) {

        try {




            $this->sanitize($request);



            $messages = [
                'neighborhood_id.exists' => __('messages.neightboorhoodNoExist'),
                'tipopropiedad.exists' => __('messages.typePropertyNoExist'),
                'tipovendedor.exists' => __('messages.TypeOwnerNoExist'),
                'tipooperacion.exists' => __('messages.TypeOperationNoExist')
            ];

            $validator = Validator::make($request->all(), [
                        'neighborhood_id' => 'required',
                        'tipopropiedad' => 'required|exists:property_types,id|integer',
                        'tipooperacion' => 'required|exists:operations,id|integer',
                        'price' => 'required',
                        'cantidaddormitorios' => 'required',
                        'tipovendedor' => 'required',
                        'street_name' => 'required',
                        'street_number' => 'required',
                        'name' => 'required',
                        'email' => 'required',
                            ], $messages);



            if ($validator->fails()) {
                return redirect()->back()
                                ->withErrors($validator)
                                ->withInput();
            }





            $Unit = Unit::find($request->get("unit_id"));
            Cache::forget("unit_slug_" . $Unit->slug);



            if ($Unit->user_id != Auth::id()) {
                return redirect()->route("misPropiedades")->with('error', __('messages.CantSeeProperty'));
            }


            $images = $request->get("images");
            $imagesStored = array();
            $imagesNews = array();
            if ($request->has("images")) {
                foreach ($images as $image) {
                    $explodeImages = explode("|", $image);
                    if (count($explodeImages) == 2) {
                        $imagesStored[] = $explodeImages[1];
                    } else {
                        $imagesNews[] = $image;
                    }
                }
            }



            $features = $request->get("features");
            $arrayFeatures = array();
            foreach ($Unit->services as $value) {

                if (!in_array($value->service_id, $features)) {
                    $unitService = UnitService::find($value->id);
                    $unitService->delete();
                } else {
                    $arrayFeatures[] = $value->service_id;
                }
            }

            if ($request->has("features")) {


                foreach ($features as $feature) {

                    if (!in_array($feature, $arrayFeatures)) {
                        $UnitService = new UnitService();
                        $UnitService->unit_id = $Unit->id;
                        $UnitService->service_id = $feature;
                        $UnitService->save();
                    }
                }
            }
            if ($request->has("title")) {
                $Unit->title = $request->get("title");
            }

            if ($request->has("tipooperacion")) {
                $Unit->operation_id = $request->get("tipooperacion");
            }
            if ($request->has("tipopropiedad")) {
                $Unit->type_id = $request->get("tipopropiedad");
            }

            if ($request->has("price")) {

                $Unit->price = str_replace("$", "", $request->get("price"));
                $Unit->price = str_replace(".", "", $Unit->price);
            }

            if ($request->has("surface")) {
                $Unit->surface = $request->get("surface");
            }

            if ($request->has("cantidaddormitorios")) {
                $Unit->number_of_rooms = $request->get("cantidaddormitorios");
            }
            if ($request->has("tipovendedor")) {
                $Unit->owner_type_id = $request->get("tipovendedor");
            }

            if ($request->has("street_name")) {
                $Unit->street_name = $request->get("street_name");
            }


            if ($request->has("street_number")) {
                $Unit->street_number = $request->get("street_number");
            }

            if ($request->has("floor_prop")) {
                $Unit->floor = $request->get("floor_prop");
            }
            if ($request->has("department")) {
                $Unit->department = $request->get("department");
            }

            if ($request->has("neighborhood_id")) {

                $neibourhoodModel = new Neighborhood();
                $Neighborhood = $neibourhoodModel->getByNameFirst($request->get("neighborhood_id"));

                if ($Neighborhood == null) {

                    $neibourhoodModel->name = $request->get("neighborhood_id");
                    $neibourhoodModel->save();
                    $Unit->neighborhood_id = $neibourhoodModel->id;
                } else {
                    $Unit->neighborhood_id = $Neighborhood->id;
                }
            }



            if ($request->has("zip")) {
                $Unit->zip = $request->get("zip");
            }

            if ($request->has("description")) {
                $Unit->information = $request->get("description");
            }

            $Owner = Owner::find($Unit->owner->id);


            if ($request->has("name_owner")) {
                $Owner->first_name = $request->get("name_owner");
            }

            if ($request->has("email")) {
                $Owner->email = $request->get("email");
            }

            if ($request->has("phone_owner")) {
                $Owner->phone = $request->get("phone_owner");
            }

            $Owner->save();
            $Unit->save();
            return redirect()->route("propiedadSystem", array($Unit->slug))->with('creation', __('messages.CantCreateProperty'));
        } catch (\Exception $exc) {
            echo $exc->getMessage() . " " . $exc->getLine();
        }
    }

    public function generateRandomString($length) {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function draftUnit($id, $status) {
        $unit = Unit::find($id);

        if ($unit->user_id != Auth::id()) {
            return redirect()->route("misPropiedades")->with('error', __('messages.CantSeeProperty'));
        }
        $unit->unit_status = $status;

        $unit->save();

        return redirect()->route("misPropiedades")->with('success', __('messages.noPublishProperty'));
    }

    public function publishPropiedad(Request $request) {
        if (Session::has('unit')) {
            $slug = "";
            $unitSession = Session::get('unit');

            $Unit = new Unit();
            if (isset($unitSession["title"])) {
                $Unit->title = $unitSession["title"];
            }
            $Unit->unit_id = 0;
            $Unit->code = $this->generateRandomString(7);

            $Unit->unit_status = 1;



            if (isset($unitSession["facebook_url"])) {
                $Unit->facebook_url = $unitSession["facebook_url"];
                $Unit->unit_status = 1;
                $Unit->owned = 0;
            } else {
                $Unit->unit_status = 1;
            }

            if (isset($unitSession["tipooperacion"])) {
                $Unit->operation_id = $unitSession["tipooperacion"];
                $Operation = Operation::find($unitSession["tipooperacion"]);
                $slug .= $Operation->name;
            }
            if (isset($unitSession["tipopropiedad"])) {
                $Unit->type_id = $unitSession["tipopropiedad"];
                $PropertyType = PropertyType::find($unitSession["tipopropiedad"]);
                $slug .= " " . $PropertyType->name;
            }

            if (isset($unitSession["neighborhood_id"])) {
                $neibourhoodModel = new Neighborhood();
                $Neighborhood = $neibourhoodModel->getByNameFirst($unitSession["neighborhood_id"]);
                if (!$Neighborhood) {
                    $Neighborhood = new Neighborhood();
                    $Neighborhood->name = $unitSession["neighborhood_id"];
                    $Neighborhood->save();
                }

                $Unit->neighborhood_id = $Neighborhood->id;

                $slug .= " en " . $Neighborhood->name;
            }

            if (isset($unitSession["price"])) {


                $Unit->price = str_replace("$", "", $unitSession["price"]);
                $Unit->price = str_replace(".", "", $Unit->price);
            }

            if (isset($unitSession["surface"])) {
                $Unit->surface = $unitSession["surface"];
            }

            if (isset($unitSession["tipovendedor"])) {
                $Unit->owner_type_id = $unitSession["tipovendedor"];
            }
            if (isset($unitSession["street_name"])) {
                $Unit->street_name = $unitSession["street_name"];
            }
            $Unit->autorized = 1;
            if (isset($unitSession["latitude"])) {
                $Unit->latitude = $unitSession["latitude"];
            }

            if (isset($unitSession["longitude"])) {
                $Unit->longitude = $unitSession["longitude"];
            }

            $Unit->user_id = Auth::id();

            if (isset($unitSession["street_number"])) {
                $Unit->street_number = $unitSession["street_number"];
            }
            if (isset($unitSession["floor_prop"])) {
                $Unit->floor = $unitSession["floor_prop"];
            }
            if (isset($unitSession["department"])) {
                $Unit->department = $unitSession["department"];
            }

            if (isset($unitSession["zip"])) {
                $Unit->zip = $unitSession["zip"];
            }

            if (isset($unitSession["cantidaddormitorios"])) {
                $Unit->number_of_rooms = $unitSession["cantidaddormitorios"];
            }


            if (isset($unitSession["description"])) {
                $Unit->information = $unitSession["description"];
            }
            $Unit->system = 1;
            $Unit->local = 2;
            $Unit->save();

            if ($Unit->unit_id == 0) {
                $Unit->slug = $this->sluglify($Unit->id . " " . $slug);
            } else {
                $Unit->slug = $this->sluglify($slug);
            }


            $Unit->save();

            $PropertyImage = new PropertyImage();
            $getImagesPerUnit = $PropertyImage->getImagesPerUnit($unitSession["idTemp"]);
            foreach ($getImagesPerUnit as $imageIndi) {

                $imageProp = PropertyImage::find($imageIndi->id);
                $imageProp->unit_id = $Unit->id;
                $imageProp->save();
            }



            $Owner = new Owner();
            $Owner->first_name = $unitSession["name"];
            $Owner->email = $unitSession["email"];
            $Owner->phone = $unitSession["phone"];
            $Owner->type = $unitSession["tipovendedor"];
            $Owner->owner_id = Auth::id();
            $Owner->save();
            $Unit->owner_id = $Owner->id;





            $Unit->save();
            if (count($unitSession) > 0) {
                if (isset($unitSession["features"])) {
                    foreach ($unitSession["features"] as $feature) {
                        $UnitService = new UnitService();
                        $UnitService->unit_id = $Unit->id;
                        $UnitService->service_id = $feature;
                        $UnitService->save();
                    }
                }
            }

            $request->session()->forget('unit');

            $this->sendUsersToSlack('Nueva propiedad creada https://alquilerdirecto.com.ar/' . $Unit->slug);






            return redirect()->route("propiedadSystem", array($Unit->slug))->with('creation', __('messages.CantCreateProperty'));
        } else {
            return redirect()->route("misPropiedades")->with('error', __('messages.CanCreatePropertyPlease'));
        }
    }

    public function sendUsersToSlack($message) {
        
      
         Mail::raw($message, function ($message){
            $message->to('anamariagarcia9709@gmail.com');
         });
/*
        $data_string = '{"text":"' . $message . '","channel":"#prop-creation","link_names":1,"username":"alquiler-directo","icon_emoji":":casa:"}';
        $ch = curl_init('https://hooks.slack.com/services/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');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string))
        );

        $result = curl_exec($ch);*/
    }

    public function sluglify($text) {
        // replace non letter or digits by -
        $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
        // trim
        $text = trim($text, '-');
        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        // lowercase
        $text = strtolower($text);
        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        if (empty($text)) {
            return 'n-a';
        }
        return $text;
    }

    public function similar(Request $request) {
        dd("aqui");
    }

    public function agregarFavoritos(Request $request) {
        $UnitFavorite = new UnitFavorite();
        $UnitFavorite->unit_id = $request->get("favoriteId");
        $UnitFavorite->user_id = Auth::id();
        $UnitFavorite->save();
        return redirect()->back()->with('success', __('messages.AddSuccessPropertyFavorites'));
    }

}
