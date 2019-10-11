<?php

namespace App\Http\Controllers;

use App\PropertyType;
use App\PropertyImage;
use App\OwnerType;
use App\Owner;
use App\Service;
use App\UnitFeature;
use App\UnitService;
use App\Feature;
use MongoClient;
use App\SearchCollect;
use App\Neighborhood;
use App\Symbol;
use App\Propiedad;
use App\Unit;
use App\User;
use App\City;
use App\SMTP_Validate_Email;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Response;
use Illuminate\Support\Facades\Auth;
use Mail;
use Goutte;
use Htmldom;
use Illuminate\Support\Facades\Route;
use Crawler;
use Log;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class HomeController extends Controller {

    public function getNeighborhoodName(Request $request) {
        if ($request->has("neighborhood")) {
            $Neighborhood = new Neighborhood();
            $getByName = $Neighborhood->getByName($request->get("neighborhood"));
            if (count($getByName) > 0) {
                return redirect()->to("/search?barrio=" . $getByName[0]->lat . "," . $getByName[0]->lon);
            }
        }

        return redirect()->to("/search");
    }

    public function setTopic(Request $request) {


        $headers = array
            ('Authorization: key=AAAAJqjp1XQ:APA91bE2GXntQ3GJI7IzFH12WtXNUFOTMTR7ZxgCNnkbFEtG-GMQg_8SqaiL1kH8J94KyMlosI-YRgoqVmpCQr8qYSmFsT5E3V8Xr2jFjbofjsp0fbBKyZwRKV0HG2Egcke-ob_PX0Md',
            'Content-Type: application/json');

                $token = $request->get("token");

        if(Auth::check()){
            $User= User::find(Auth::id());
            $User->token_push=$token;
            $User->save();
        }
        $ch = curl_init();
// browser token you can get it via ajax from client side
        curl_setopt($ch, CURLOPT_URL, "https://iid.googleapis.com/iid/v1/$token/rel/topics/testIshakTopic");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, array());
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
    }

    public function sendNotiicationGeneral() {
        $curl = curl_init();
        $random= random_int(1, 20);
        $title="Agregamos $random propiedades 🏠 nuevas.";
        $url="https://alquilerdirecto.com.ar/search";
        $body="☺ Mirálas antes que alguiel las alquile.";
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://fcm.googleapis.com/fcm/send",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\n  \"to\": \"/topics/testIshakTopic\",\n  \"data\": {\n    \"body\": \"$body\",\n    \"title\": \"$title\",\n    \"url\":\"$url\"\n  }\n}",
            CURLOPT_HTTPHEADER => array(
                "authorization: key=AAAAJqjp1XQ:APA91bE2GXntQ3GJI7IzFH12WtXNUFOTMTR7ZxgCNnkbFEtG-GMQg_8SqaiL1kH8J94KyMlosI-YRgoqVmpCQr8qYSmFsT5E3V8Xr2jFjbofjsp0fbBKyZwRKV0HG2Egcke-ob_PX0Md",
                "cache-control: no-cache",
                "content-type: application/json",
                "postman-token: 4a7f45fa-4caa-f317-8db9-b7922a8e8efb"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }
    }

    public function validateProperty() {
        return "valid";
    }

    public function enviaremail(Request $request) {
        Mail::send('emails.amp', $request->all(), function ($m) use ($request) {

            $m->to("informacion@cristiangarcia.co", "cristian")->subject(" información de contacto");
        });
    }

    public function sendEmailData(Request $request) {

        $User = User::find($request->get("id_user"));
        $User->alternative_mail = $request->get("user_email");
        $User->save();
        Mail::send('emails.infoproperty', $request->all(), function ($m) use ($request) {

            $m->to($request->get("user_email"), $request->get("user_name"))->subject($request->get("user_name") . " información de contacto");
        });
    }

    public function demo() {
        return response()->view('demo');
    }

    public function rss() {

        $unit = new Unit();
        $getLatestUnits = $unit->getLatestUnits();

        echo "<rss version='2.0' xmlns:atom='http://www.w3.org/2005/Atom'>\n";
        echo "<channel>\n";

        echo "<title>Demo RSS Feed</title>\n";
        echo "<description>RSS Description</description>\n";
        echo "<link>http://www.mydomain.com</link>\n";


        foreach ($getLatestUnits as $unit) {


            echo "<item>";
            echo "<title>$unit->title</title>\n";
            echo "<description>" . strip_tags($unit->information) . "</description>\n";
            echo "<pubDate>" . date('D, d M Y H:i:s', strtotime($unit->created_at)) . " GMT</pubDate>\n";
            echo "<link>" . url("/") . "/$unit->slug</link>\n";
            echo "<guid>" . url("/") . "/$unit->slug</guid>\n";
            echo "<atom:link href='" . url("/") . "/$unit->slug' rel='self' type='application/rss+xml'/>\n";
            echo "</item>\n";
        }


        echo "</channel>\n";
        echo "</rss>\n";


        return "";
    }

    public function sitemapTwo() {
        $Unit = new Unit();
        $sitemap = $Unit->sitemap();
        $sitemapporBarrio = Neighborhood::all();

        return response()->view('layouts.sitemap', ["sitemap" => $sitemap, "barrios" => $sitemapporBarrio])
                        ->header('Cache-Control', 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0')
                        ->header('Content-Type', 'text/xml');
    }

    public function getUrl(Request $request) {
        header('Access-Control-Allow-Origin:  *');
        header('Access-Control-Allow-Methods:  POST, GET, OPTIONS, PUT, DELETE');
        header('Access-Control-Allow-Headers:  Content-Type, X-Auth-Token, Origin, Authorization');
        // Get cURL resource
        $curl = curl_init();
        // Set some options - we are passing in a useragent too here
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $request->get("url")
        ));
        // Send the request & save response to $resp
        $resp = curl_exec($curl);
        // Close request to clear up some resources

        echo $resp;
        curl_close($curl);
    }

    public function getVideoFrame(Request $request) {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $request->get("url"),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => "",
            CURLOPT_HTTPHEADER => array(
                "Postman-Token: 28872b65-6f40-4a8f-bbaa-9c5b06e869e8",
                "cache-control: no-cache"
            ),
        ));

        $response = curl_exec($curl);
        dd($response);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }
    }

    public function searchMovie() {
        dd("ss");
    }

    public function searchMovies(Request $request) {
        dd("ss");

        header('Access-Control-Allow-Origin:  *');
        header('Access-Control-Allow-Methods:  POST, GET, OPTIONS, PUT, DELETE');
        header('Access-Control-Allow-Headers:  Content-Type, X-Auth-Token, Origin, Authorization');

        // Get cURL resource
        $curl = curl_init();
// Set some options - we are passing in a useragent too here



        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => "https://www.cuevana3.co/?s=" . $request->get("search")
        ));
// Send the request & save response to $resp
        $resp = curl_exec($curl);
// Close request to clear up some resources

        echo $resp;
        curl_close($curl);
    }

    public function getHomeMovies(Request $request) {
        header('Access-Control-Allow-Origin:  *');
        header('Access-Control-Allow-Methods:  POST, GET, OPTIONS, PUT, DELETE');
        header('Access-Control-Allow-Headers:  Content-Type, X-Auth-Token, Origin, Authorization');
        // Get cURL resource
        $curl = curl_init();
// Set some options - we are passing in a useragent too here
        if ($request->get("category") != "0") {
            if ($request->get("paginator") > 1) {
                $url = 'https://www.cuevana3.co/' . $request->get("category") . '/page/' . $request->get("paginator");
            } else {
                $url = 'https://www.cuevana3.co/' . $request->get("category");
            }
        } else {


            if ($request->get("paginator") > 1) {
                $url = 'https://www.cuevana3.co/page/' . $request->get("paginator");
            } else {
                $url = 'https://www.cuevana3.co';
            }
        }

        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $url
        ));
// Send the request & save response to $resp
        $resp = curl_exec($curl);
// Close request to clear up some resources

        echo $resp;
        curl_close($curl);
    }

    public function test() {
        $value = 0 / 3;
        explode($string);
        dd("aqui" . $value);
        phpinfo();
        die();
        $user = User::find(10723);

        $emailParams = array("preview" => "Desde ahora eres parte de una de las comunidades que más crece, ahora puedes alquilar o vender de la forma mas fácil",
            "subject" => "Bienvenido " . $user->name . " a Alquiler Directo");
        Mail::send('emails.wellcome', ['user' => $user, "emailParams" => $emailParams], function ($m) use ($user, $emailParams) {

            $m->to($user->email, $user->name)->subject($emailParams["subject"]);
        });
    }

    public function botman() {
        return "hola";
    }

    public function deleteProperty($slug, $email) {

        $unit = new Unit();
        $getUnitPerSlug = $unit->getUnitPerSlug($slug);
        $owner = new Owner();
        $getByOwnerPlatformId = $owner->getByOwnerPlatformId($getUnitPerSlug->owner_id);
        if (count($getByOwnerPlatformId) > 0) {
            if ($email == $getByOwnerPlatformId[0]->email) {
                $getUnitPerSlug->publised = 0;
                $getUnitPerSlug->save();
            }
        }
        return redirect()->to("/");
    }

    public function sendEmailUsers() {




        ini_set('display_startup_errors', 1);
        ini_set('display_errors', 1);
        error_reporting(-1);

        $unit = new Unit();

        $user = new User();

        $emails = [];
        foreach ($user->getRandomUsers() as $key => $user) {
            $emails[] = $user->email;
            try {
                $user->email_send = Carbon::now();
                $user->save();

                $getLatestSix = $unit->getLatestSix($user);

                $emailParams = array("user" => $user,
                    "units" => $getLatestSix);
                if (count($getLatestSix) > 5) {

                    if ($key == 0) {
                        Mail::send('emails.ultimas', $emailParams, function ($m) use ($emailParams) {
                            $m
                                    ->to(strtolower("informacion@cristiangarcia.co"), "cristian")
                                    ->subject("Cristian - Últimas propiedades en Alquiler Directo");
                        });
                    }


                    Mail::send('emails.ultimas', $emailParams, function ($m) use ($emailParams) {

                        $m
                                ->to(strtolower($emailParams["user"]->email), $emailParams["user"]->name)
                                ->subject($emailParams["user"]->name . " - Últimas propiedades en Alquiler Directo");
                    });


                    Mail::send('emails.downloadapp', $emailParams, function ($m) use ($emailParams) {

                        $m
                                ->to(strtolower($emailParams["user"]->email), $emailParams["user"]->name)
                                ->subject($emailParams["user"]->name . " - Descarga el app de Alquiler Directo");
                    });

                    //sleep(3);
                }
            } catch (\Exception $exc) {
                //  $this->sendUsersToSlack($exc->getMessage()." ".$exc->getFile()." ".$exc->getLine());
            }
        }

        /* Mail::raw("se ha corrido  el mailing ll ". implode(",", $emails), function ($message){
          $message->to('informacion@cristiangarcia.co');
          }); */
    }

    public function sendUsersToSlack($message) {

        $data_string = '{"text":"' . $message . '","channel":"#prop-creation","link_names":1,"username":"alquiler-directo","icon_emoji":":casa:"}';
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

    public function unsuscribeId($id) {

        $user = User::find($id);
        $user->nomail = 0;
        $user->save();

        echo "unsuscribed";

        echo '<script>setTimeout(function() { 
    window.location.href = "' . url("/") . '"; 
 }, 1000);</script>';
    }

    public function unsuscribe() {


        echo "unsuscribed";

        echo '<script>setTimeout(function() { 
    window.location.href = "' . url("/") . '"; 
 }, 1000);</script>';
    }

    public function redirectToUrlFake() {
        return redirect()->to("/");
    }

    public function populateCities() {

        $Neighborhood = Neighborhood::where("lat", "")->get();
        foreach ($Neighborhood as $nei) {

            $file = file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=" . urlencode($nei->name . ", " . $nei->province->name . ", Argentina") . "&sensor=false&key=AIzaSyD3x9EIe6p6aoIIoGE_CXJsYovvc4-mgLQ");
            $result = json_decode($file, true);

            if (isset($result["results"])) {
                if (count($result["results"]) > 0) {
                    $nei->lat = $result["results"][0]["geometry"]["location"]["lat"];
                    $nei->lon = $result["results"][0]["geometry"]["location"]["lng"];
                    $nei->save();
                }
            }
        }
        dd($Neighborhood);
    }

    public function teste(Request $request) {
        $Unit = new Unit();
        $getUnitsSearch = $Unit->getUnitsSearchApiHome($request);
        return $getUnitsSearch;
    }

    public function homeProperties($request) {


        $request->request->add(['latitude' => -34.57972975760001]);
        $request->request->add(['longitude' => -58.42482089996337]);


        $request->request->add(['min_price' => 4000]);
        $request->request->add(['max_price' => 30000]);


        $expiresAt = now()->addMinutes(120);
        $encrypted = base64_encode(json_encode($request->all()));
        return Cache::remember("homes_maps" . $encrypted, $expiresAt, function () use($request) {

                    $Unit = new Unit();
                    $getUnitsSearch = $Unit->getUnitsSearchApiHome($request);

                    $datatemp = array();
                    $datatemp["total"] = $getUnitsSearch->total();

                    $searchResoults = array();

                    foreach ($getUnitsSearch as $searchUnit) {
                        $temp = array();
                        $temp["id"] = $searchUnit->unit_id;
                        $temp["local"] = $searchUnit->local;
                        $temp["idHome"] = $searchUnit->id;

                        $temp["price"] = $searchUnit->price;
                        $temp["title"] = str_limit(ucfirst(strtolower($searchUnit->title)), 50, '...');
                        $temp["created_at"] = $searchUnit->created_at;
                        $temp["latitude"] = $searchUnit->latitude;
                        $temp["owner_type_id"] = $searchUnit->owner_type_id;

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
                            $temp["small"] = $image->small;
                        }
                        $temp["images"] = $searchUnit->images;

                        $searchResoults[] = $temp;
                    }
                    $datatemp["data"] = $searchResoults;
                    return $datatemp;
                });
    }

    public function homeMap(Request $request) {
        $request->request->add(['map' => 1]);

        return $this->home($request);
    }

    public function home(Request $request) {


        $map = false;
        $homeProperties = array();
        $PropertyType = array();
        if ($request->has("map")) {
            $map = true;

            $expiresAt = now()->addMinutes(3600);

            $PropertyType = Cache::remember('PropertyType', $expiresAt, function () {

                        return PropertyType::all();
                    });



            $homeProperties = $this->homeProperties($request);
        }




        $unit = new Unit();

        $encrypted = base64_encode(json_encode($request->all()));

        $getLatestHomeProperties = $unit->getLatestHomePropertiesEncrypt(12, $encrypted);
        //dd($getHomeProperties[0]->services);
        $City = new City();
        $getActiveCities = $City->getActiveCities();

        return view('layouts.home')
                        ->with("map", $map)
                        ->with("cities", $getActiveCities)
                        ->with("homePropertiesCache", $homeProperties)
                        ->with("propertyTypes", $PropertyType)
                        ->with("getLatestHomeProperties", $getLatestHomeProperties);
    }

    public function loadBarrios() {
        $expiresAt = now()->addMinutes(1600);
        return Cache::remember('barrios_', $expiresAt, function () {

                    $barrios = $Neighborhood = Neighborhood::all();
                    $barriosarray = array();
                    foreach ($barrios as $value) {
                        $barriosarray[] = array("value" => $value->lat . "," . $value->lon, "name" => $value->name);
                    }
                    return $barriosarray;
                });
    }

    public function logout() {
        Auth::logout();
        session()->forget('backUrlpublicar');
        session()->forget('userAuth');

        return back();
    }

    public function importadorIndividual(Request $request) {
        error_reporting(E_ALL);
        ini_set('display_errors', '1');

        ini_set('memory_limit', '-1');
        ob_start();





        $unit = new Unit();
        $getUnitPerId = $unit->getCountUnitPerId($request->get("id"));





        if (count($getUnitPerId) == 0) {

            $result = @file_get_contents("http://api.sosiva451.com/Avisos/" . ($request->get("id") - 2354));
            $result = json_decode($result, true);


            $anunciante = @file_get_contents("http://api.sosiva451.com/Anunciantes/" . $result["IdAnunciante_i"]);
            $resultanunciante = json_decode($anunciante, true);
            // $result = @file_get_contents("https://markandstorecom.ipage.com/ImageProvider/public/uploadProperty?id=".$request->get("id"));

            $Owner = new Owner();
            $getByOwnerPlatformId = $Owner->getByOwnerPlatformId($resultanunciante["IdAnunciante"]);
            $ownerType = null;

            if ($getByOwnerPlatformId->count() == 0) {


                if (isset($resultanunciante["Nombre_t"])) {
                    $Owner->first_name = $resultanunciante["Nombre_t"];
                }
                if (isset($resultanunciante["RazonSocial_t"])) {
                    $Owner->first_name = $resultanunciante["RazonSocial_t"];
                }


                if (isset($resultanunciante["Apellido_t"])) {
                    $Owner->last_name = $resultanunciante["Apellido_t"];
                }

                if (isset($resultanunciante["DisponibilidadAtencionAnunciante_t"])) {
                    $Owner->info = $resultanunciante["DisponibilidadAtencionAnunciante_t"];
                }
                if (isset($resultanunciante["EmailContacto_t"])) {
                    $Owner->email = $resultanunciante["EmailContacto_t"];
                }

                if (isset($resultanunciante["TelefonoAnunciante_t"])) {
                    $Owner->phone = $resultanunciante["TelefonoAnunciante_t"];
                }

                if (isset($resultanunciante["IdTipoVendedor_i"])) {
                    $Owner->type = $resultanunciante["IdTipoVendedor_i"];
                    $ownerType = $resultanunciante["IdTipoVendedor_i"];
                    $Owner->owner_id = $resultanunciante["IdAnunciante"];

                    $Owner->save();
                }
            } else {
                $ownerType = $getByOwnerPlatformId[0]->type;
            }



            $unit->unit_id = $request->get("id");



            if (isset($result["Direccion_Latitud_d"])) {
                $unit->latitude = $result["Direccion_Latitud_d"];
            }
            if (isset($result["Direccion_Longitud_d"])) {
                $unit->longitude = $result["Direccion_Longitud_d"];
            }
            $unit->owner_id = $result["IdAnunciante_i"];
            if (isset($result["TipoPropiedad_t"])) {
                ///insert property
                $PropertyType = new PropertyType();
                $getByNameCount = $PropertyType->getByName($result["TipoPropiedad_t"]);
                if ($getByNameCount->count()) {
                    $unit->type_id = $getByNameCount[0]->id;
                } else {
                    $PropertyType->name = $result["TipoPropiedad_t"];
                    $PropertyType->save();
                    $unit->type_id = $PropertyType->id;
                }
                ///insert property
            }

            if (isset($result["MonedaSimbolo_t"])) {
                ///insert symbol
                $Symbol = new Symbol();
                $getByNameCount = $Symbol->getByName($result["MonedaSimbolo_t"]);
                if ($getByNameCount->count()) {
                    $unit->symbol_id = $getByNameCount[0]->id;
                } else {
                    $Symbol->name = $result["MonedaSimbolo_t"];
                    $Symbol->save();
                    $unit->symbol_id = $Symbol->id;
                }
                ///insert symbol   
            }


            ////
            if (isset($result["SuperficieCubierta_d"])) {
                $unit->surface = $result["SuperficieCubierta_d"];
            }
            if (isset($result["Direccion_Numero_i"])) {
                $unit->street_number = $result["Direccion_Numero_i"];
            }


            if (isset($result["TipoOperacion_t"])) {
                ///insert operation
                $Operation = new Operation();
                $getByNameCount = $Operation->getByName($result["TipoOperacion_t"]);
                if ($getByNameCount->count()) {
                    $unit->operation_id = $getByNameCount[0]->id;
                } else {
                    $Operation->name = $result["TipoOperacion_t"];
                    $Operation->save();
                    $unit->operation_id = $Operation->id;
                }
                ///insert operation
            }


            if ($ownerType) {


                $unit->owner_type_id = $ownerType;
            }


            $unit->status = $result["Visible_b"];
            if (isset($result["MontoOperacion_i"])) {
                $unit->price = $result["MontoOperacion_i"];
            }

            if (isset($result["Provincia_t"])) {
                $province_id = null;
                ///insert province
                $Province = new Province();
                $getByNameCount = $Province->getByName($result["Provincia_t"]);
                if ($getByNameCount->count()) {
                    $province_id = $getByNameCount[0]->id;
                } else {
                    $Province->name = $result["Provincia_t"];
                    $Province->save();
                    $province_id = $Province->id;
                }
                ///insert province
            }
            if (isset($result["Barrio_t"])) {
                ///insert neighborhood
                $Neighborhood = new Neighborhood();
                $getByNameCount = $Neighborhood->getByName($result["Barrio_t"]);
                if ($getByNameCount->count()) {
                    $unit->neighborhood_id = $getByNameCount[0]->id;
                } else {
                    $Neighborhood->name = $result["Barrio_t"];
                    $Neighborhood->province_id = $province_id;
                    $Neighborhood->save();
                    $unit->neighborhood_id = $Neighborhood->id;
                }
                ///insert neighborhood
            }

            ////saquyi

            if (isset($result["Titulo_t"])) {
                $unit->title = $result["Titulo_t"];
            }
            if (isset($result["Direccion_NombreCalle_t"])) {
                $unit->street_name = $result["Direccion_NombreCalle_t"];
            }
            if (isset($result["Direccion_Piso_t"])) {
                $unit->floor = $result["Direccion_Piso_t"];
            }

            if (isset($result["Direccion_Departamento_t"])) {
                $unit->department = $result["Direccion_Departamento_t"];
            }
            $unit->slug = $result["DescripcionSeo_t"];
            if (isset($result["InformacionAdicional_t"])) {
                $unit->information = $result["InformacionAdicional_t"];
            }
            ////saquyi


            if (isset($result["Multimedia_s"]) && isset($result["MontoOperacion_i"]) && $ownerType) {

                $unit->save();


                foreach ($result["Multimedia_s"] as $fea) {
                    if (isset($fea["Medium"])) {
                        if ($this->isImageFile($fea["Url"])) {
                            $PropertyImage = new PropertyImage();
                            $PropertyImage->unit_id = $unit->id;
                            $PropertyImage->small = $fea["Small"];
                            $PropertyImage->medium = $fea["Medium"];
                            $PropertyImage->large = $fea["Large"];
                            $PropertyImage->save();
                        }
                    }
                }


                $cantidadAmbientes = "Monoambiente";

                foreach ($result["DatosComunes_s"] as $fea) {
                    if ($fea["Leyenda"]) {
                        if ($fea["Valor"]) {
                            ///insert feature
                            $Feature = new Feature();
                            $getByNameCount = $Feature->getByName($fea["Leyenda"]);
                            $featureId = null;
                            if ($getByNameCount->count()) {
                                $featureId = $getByNameCount[0]->id;
                            } else {
                                $Feature->name = $fea["Leyenda"];
                                $Feature->save();
                                $featureId = $Feature->id;
                            }
                            if ($fea["Leyenda"] == "Cantidad de dormitorios") {
                                $cantidadAmbientes = $fea["Valor"];
                            }

                            if ($fea["Leyenda"] == "Cantidad de ambientes") {
                                $cantidadAmbientes = $fea["Valor"];
                            }

                            $UnitFeature = new UnitFeature();
                            $UnitFeature->unit_id = $unit->id;
                            $UnitFeature->feature_id = $featureId;
                            $UnitFeature->value = $fea["Valor"];
                            $UnitFeature->save();
                            ///insert feature
                        }
                    }
                }
///////////
                $unit->number_of_rooms = $cantidadAmbientes;
                $unit->save();
                foreach ($result["Secciones_s"]["Secciones"] as $sec) {

                    if ($sec["Nombre"] == "Servicios del departamento") {
                        foreach ($sec["Items"] as $item) {
                            $Service = new Service();
                            $getByNameCount = $Service->getByName($item["Nombre"]);
                            $serviceId = null;
                            if ($getByNameCount->count()) {
                                $serviceId = $getByNameCount[0]->id;
                            } else {
                                $Service->name = $item["Nombre"];
                                $Service->save();
                                $serviceId = $Service->id;
                            }

                            $UnitService = new UnitService();
                            $UnitService->unit_id = $unit->id;
                            $UnitService->service_id = $serviceId;
                            $UnitService->value = $item["Valor"];
                            if ($item["Valor"] == 1) {
                                $UnitService->save();
                            }
                        }
                    }
                }

                echo "no esta -> " . $unit->unit_id . " -> " . $unit->id . "<hr/>";
                ob_flush();
                flush();

                dd($unit->toArray(), "nuevo");
            }
        } else {


            $getUnitPerId = $getUnitPerId[0];

            dd($getUnitPerId->toArray(), "ya esta");
        }
    }

    public function importador() {

        error_reporting(E_ALL);
        ini_set('display_errors', '1');

        ini_set('memory_limit', '-1');
        ob_start();

        $propiedad = Propiedad::where("status", 1)->first();




        $unit = new Unit();
        $getUnitPerId = $unit->getCountUnitPerId($propiedad->id_property);


        if (count($getUnitPerId) == 0) {

            $result = @file_get_contents("http://api.sosiva451.com/Avisos/" . ($propiedad->id_property - 2354));
            $result = json_decode($result, true);


            $anunciante = @file_get_contents("http://api.sosiva451.com/Anunciantes/" . $result["IdAnunciante_i"]);
            $resultanunciante = json_decode($anunciante, true);

            $Owner = new Owner();
            $getByOwnerPlatformId = $Owner->getByOwnerPlatformId($resultanunciante["IdAnunciante"]);
            $ownerType = null;
            if ($getByOwnerPlatformId->count() == 0) {


                if (isset($resultanunciante["Nombre_t"])) {
                    $Owner->first_name = $resultanunciante["Nombre_t"];
                }
                if (isset($resultanunciante["RazonSocial_t"])) {
                    $Owner->first_name = $resultanunciante["RazonSocial_t"];
                }


                if (isset($resultanunciante["Apellido_t"])) {
                    $Owner->last_name = $resultanunciante["Apellido_t"];
                }

                if (isset($resultanunciante["DisponibilidadAtencionAnunciante_t"])) {
                    $Owner->info = $resultanunciante["DisponibilidadAtencionAnunciante_t"];
                }
                if (isset($resultanunciante["EmailContacto_t"])) {
                    $Owner->email = $resultanunciante["EmailContacto_t"];
                }

                if (isset($resultanunciante["TelefonoAnunciante_t"])) {
                    $Owner->phone = $resultanunciante["TelefonoAnunciante_t"];
                }
                if (isset($resultanunciante["IdTipoVendedor_i"])) {
                    $Owner->type = $resultanunciante["IdTipoVendedor_i"];
                    $ownerType = $resultanunciante["IdTipoVendedor_i"];
                    $Owner->owner_id = $resultanunciante["IdAnunciante"];

                    $Owner->save();
                }
            } else {
                $ownerType = $getByOwnerPlatformId[0]->type;
            }

            $unit->unit_id = $propiedad->id_property;

            if (!empty($propiedad->id_video)) {
                $unit->video = $propiedad->id_video;
            }


            if (isset($result["Direccion_Latitud_d"])) {
                $unit->latitude = $result["Direccion_Latitud_d"];
            }
            if (isset($result["Direccion_Longitud_d"])) {
                $unit->longitude = $result["Direccion_Longitud_d"];
            }
            $unit->owner_id = $result["IdAnunciante_i"];
            if (isset($result["TipoPropiedad_t"])) {
                ///insert property
                $PropertyType = new PropertyType();
                $getByNameCount = $PropertyType->getByName($result["TipoPropiedad_t"]);
                if ($getByNameCount->count()) {
                    $unit->type_id = $getByNameCount[0]->id;
                } else {
                    $PropertyType->name = $result["TipoPropiedad_t"];
                    $PropertyType->save();
                    $unit->type_id = $PropertyType->id;
                }
                ///insert property
            }

            if (isset($result["MonedaSimbolo_t"])) {
                ///insert symbol
                $Symbol = new Symbol();
                $getByNameCount = $Symbol->getByName($result["MonedaSimbolo_t"]);
                if ($getByNameCount->count()) {
                    $unit->symbol_id = $getByNameCount[0]->id;
                } else {
                    $Symbol->name = $result["MonedaSimbolo_t"];
                    $Symbol->save();
                    $unit->symbol_id = $Symbol->id;
                }
                ///insert symbol   
            }
            if (isset($result["SuperficieCubierta_d"])) {
                $unit->surface = $result["SuperficieCubierta_d"];
            }
            if (isset($result["Direccion_Numero_i"])) {
                $unit->street_number = $result["Direccion_Numero_i"];
            }


            if (isset($result["TipoOperacion_t"])) {
                ///insert operation
                $Operation = new Operation();
                $getByNameCount = $Operation->getByName($result["TipoOperacion_t"]);
                if ($getByNameCount->count()) {
                    $unit->operation_id = $getByNameCount[0]->id;
                } else {
                    $Operation->name = $result["TipoOperacion_t"];
                    $Operation->save();
                    $unit->operation_id = $Operation->id;
                }
                ///insert operation
            }
            if ($ownerType) {


                $unit->owner_type_id = $ownerType;
            }


            $unit->status = $result["Visible_b"];
            if (isset($result["MontoOperacion_i"])) {
                $unit->price = $result["MontoOperacion_i"];
            }

            if (isset($result["Provincia_t"])) {
                $province_id = null;
                ///insert province
                $Province = new Province();
                $getByNameCount = $Province->getByName($result["Provincia_t"]);
                if ($getByNameCount->count()) {
                    $province_id = $getByNameCount[0]->id;
                } else {
                    $Province->name = $result["Provincia_t"];
                    $Province->save();
                    $province_id = $Province->id;
                }
                ///insert province
            }
            if (isset($result["Barrio_t"])) {
                ///insert neighborhood
                $Neighborhood = new Neighborhood();
                $getByNameCount = $Neighborhood->getByName($result["Barrio_t"]);
                if ($getByNameCount->count()) {
                    $unit->neighborhood_id = $getByNameCount[0]->id;
                } else {
                    $Neighborhood->name = $result["Barrio_t"];
                    $Neighborhood->province_id = $province_id;
                    $Neighborhood->save();
                    $unit->neighborhood_id = $Neighborhood->id;
                }
                ///insert neighborhood
            }


            if (isset($result["Titulo_t"])) {
                $unit->title = $result["Titulo_t"];
            }
            if (isset($result["Direccion_NombreCalle_t"])) {
                $unit->street_name = $result["Direccion_NombreCalle_t"];
            }
            if (isset($result["Direccion_Piso_t"])) {
                $unit->floor = $result["Direccion_Piso_t"];
            }

            if (isset($result["Direccion_Departamento_t"])) {
                $unit->department = $result["Direccion_Departamento_t"];
            }
            $unit->slug = $result["DescripcionSeo_t"];
            if (isset($result["InformacionAdicional_t"])) {
                $unit->information = $result["InformacionAdicional_t"];
            }


            if (isset($result["Multimedia_s"]) && isset($result["MontoOperacion_i"]) && $ownerType) {

                $unit->save();


                foreach ($result["Multimedia_s"] as $fea) {
                    if (isset($fea["Medium"])) {
                        if ($this->isImageFile($fea["Url"])) {
                            $PropertyImage = new PropertyImage();
                            $PropertyImage->unit_id = $unit->id;
                            $PropertyImage->small = $fea["Small"];
                            $PropertyImage->medium = $fea["Medium"];
                            $PropertyImage->large = $fea["Large"];
                            $PropertyImage->save();
                        }
                    }
                }


                $cantidadAmbientes = "Monoambiente";

                foreach ($result["DatosComunes_s"] as $fea) {
                    if ($fea["Leyenda"]) {
                        if ($fea["Valor"]) {
                            ///insert feature
                            $Feature = new Feature();
                            $getByNameCount = $Feature->getByName($fea["Leyenda"]);
                            $featureId = null;
                            if ($getByNameCount->count()) {
                                $featureId = $getByNameCount[0]->id;
                            } else {
                                $Feature->name = $fea["Leyenda"];
                                $Feature->save();
                                $featureId = $Feature->id;
                            }
                            if ($fea["Leyenda"] == "Cantidad de dormitorios") {
                                $cantidadAmbientes = $fea["Valor"];
                            }

                            if ($fea["Leyenda"] == "Cantidad de ambientes") {
                                $cantidadAmbientes = $fea["Valor"];
                            }

                            $UnitFeature = new UnitFeature();
                            $UnitFeature->unit_id = $unit->id;
                            $UnitFeature->feature_id = $featureId;
                            $UnitFeature->value = $fea["Valor"];
                            $UnitFeature->save();
                            ///insert feature
                        }
                    }
                }

                $unit->number_of_rooms = $cantidadAmbientes;
                $unit->save();
                foreach ($result["Secciones_s"]["Secciones"] as $sec) {

                    if ($sec["Nombre"] == "Servicios del departamento") {
                        foreach ($sec["Items"] as $item) {
                            $Service = new Service();
                            $getByNameCount = $Service->getByName($item["Nombre"]);
                            $serviceId = null;
                            if ($getByNameCount->count()) {
                                $serviceId = $getByNameCount[0]->id;
                            } else {
                                $Service->name = $item["Nombre"];
                                $Service->save();
                                $serviceId = $Service->id;
                            }

                            $UnitService = new UnitService();
                            $UnitService->unit_id = $unit->id;
                            $UnitService->service_id = $serviceId;
                            $UnitService->value = $item["Valor"];
                            $UnitService->save();
                        }
                    }
                }

                echo "no esta -> " . $unit->unit_id . " -> " . $unit->id . "<hr/>";
                sleep(1);
                ob_flush();
                flush();
            }
            $PropiedadModel = Propiedad::find($propiedad->id);
            $PropiedadModel->status = 2;
            $PropiedadModel->save();
            dd($PropiedadModel->id_property);
        } else {


            $getUnitPerId = $getUnitPerId[0];

            echo "ya esta ->" . count($getUnitPerId) . " propiedad id-> " . $propiedad->id_property . " unit ->" . $getUnitPerId->unit_id . "  id->" . $propiedad->id . "<br>";

            $PropiedadModel = Propiedad::find($propiedad->id);

            $PropiedadModel->status = 2;
            $PropiedadModel->save();
        }
    }

}
