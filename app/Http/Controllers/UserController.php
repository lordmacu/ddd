<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Response;
use Illuminate\Support\Facades\Auth;

use App\PropertyType;
use App\PropertyImage;
use App\OwnerType;
use App\Owner;
use Session;
use App\Service;
use App\UnitFeature;
use App\UnitService;
use App\Feature;
use App\Province;
use App\Neighborhood;
use App\Symbol;
use App\Propiedad;
use App\Operation;
use App\User;
use Mail;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller {
    
    
       
    public function getGeoUser(Request $request){
        $data=$request->get("data");
        
        if(Auth::check()){
            $location= explode(",", $data["loc"]);
           $user= Auth::user() ;
           $user->lat=$location[0];
           $user->lon=$location[1];
           $user->city=$data["city"];
           $user->country=$data["country"];
           $user->region=$data["region"];
           $user->save();
           return array("success"=>true,"data"=>$data);
        } 
           return array("success"=>false);
    }

    public function checkUser(Request $request){
        $user= new User();
        $checkBySource=$user->checkBySource($request->get("id"));
        
        if($checkBySource==1){
            if (Auth::attempt(['email' => $request->get("email"), 'password' => $request->get("id") . "registerDueno"], true)) {
                return 1;
            }
        }
        return $checkBySource;
    }
    
    
    public function setGeouser(Request $request){
        
        $request->session()->put('user_lat', $request->get("lat"));
        $request->session()->put('user_lon',$request->get("lon"));


        if(Auth::check()){
            $user= User::find(Auth::id());
            $user->lat=$request->get("lat");
            $user->lon=$request->get("lon");
            $user->save();
        }
     
    }
    
    
    
    public function registerUserApi(Request $request){

        
        
                
            $userModel= new User();
            
            $checkByEmail=$userModel->checkByEmail($request->get("email"));
            
if(count($checkByEmail)==0){
    
    if($request->has("email")){
         $userCreate=$userModel->create(
                    array("name" => $request->get("name"),
                        "password" => $request->get("id"), 
                        "email" => strtolower($request->get("email"))
                        )
                    );
    }else{
          $userCreate=$userModel->create(
                    array("name" => $request->get("name"),
                        "password" => $request->get("id"), 
                        "email" => rand(1, 232323)."user@gmail.com"
                        )
                    );
    }
           
            if($request->has("email")){
                    $userCreate->alternative_mail=strtolower($request->get("email"));
            }else{
                                    $userCreate->alternative_mail=rand(1, 232323)."user@gmail.com";

                
            }
            
            
                    $userCreate->nickname=$request->get("nickname");
                    $userCreate->source=$request->get("source_type");
                    $userCreate->id_source=$request->get("source");
                    $userCreate->user_photo=$request->get("user_photo");
                    
                    if (Session::has('country_id')) {
                        $country_id = Session::get('country_id');
                    }

                    $userCreate->country_id=$country_id;

                   
                    $userCreate->save();
                    
                
                    
                    $this->sendUsersToSlack('usuario creado con appalquiler '.$userCreate->id.' email  '.$userCreate->alternative_mail);
          /*
                    $emailParams=array("preview"=>"Desde ahora eres parte de una de las comunidades que más crece, ahora puedes alquilar o vender de la forma mas fácil",
                        "subject"=>"Bienvenido ".$userCreate->name." a Alquiler Directo");
                    Mail::send('emails.downloadapp', ['user' => $userCreate,"emailParams"=>$emailParams], function ($m) use ($userCreate,$emailParams) {
                        $m->to(strtolower($userCreate->email), $userCreate->name)->subject($emailParams["subject"]);
                    });
                    
                    $this->sendToMeetwork($userCreate->name, strtolower($userCreate->email), $userCreate->alternative_mail, $request->get("source"), $request->get("source"), 1);
*/
            return $userCreate;
        }else{
            return $checkByEmail[0];
        }
            
            
          
        
    }
    
    public function registerUser(Request $request){
      

        $previousUrl =  strtok( request()->headers->get('referer'), '?');


    if($request->session()->has('backUrlpublicar')){
        $previousUrl=$request->session()->get('backUrlpublicar');
    }
         
      $user = new User();
      $validator = $user->validator($request->all());
      $request->session()->forget('name');
      $request->session()->forget('email');
      
      $sourceSocial = $request->session()->get('sourceSocial', 1);
        $registerData = session()->get('userAuth');
        $id = $registerData[0]["id"];

      if(!$id){
                return redirect($previousUrl); 
      }
      $request->session()->forget('id');

      $registerData=null;
   if (session()->has('userAuth')) {
            $registerData = session()->get('userAuth')[0];
        }

    if ($validator->fails()) {
 
        foreach ($validator->errors()->all() as $key ) {
            if($key=="The email has already been taken."){

                $userModel= new User();
                $checkByEmail=$userModel->checkByEmail($request->get("email"));
                $user= User::find($checkByEmail[0]->id);
                $user->delete();
                $emailTep=$request->get("email");
if(!$request->has("email")){
    $emailTep=$request->get("alternativeemail");
}
                
                Auth::login($user->create(array("name" => $request->get("name"), "password" => $id, "email" => strtolower($emailTep))),true);
                if(Auth::check()){
                    
                    $user=User::find(Auth::id());
                    
                     if (Session::has('country_id')) {
                        $country_id = Session::get('country_id');
                    }

                    $user->country_id=$country_id;

                    
                    $user->alternative_mail=strtolower($request->get("alternativeemail"));
                    $user->source=$sourceSocial;
                      if($request->session()->has('user_lat')){
            $user->lat=$request->session()->get('user_lat');
            $user->lon=$request->session()->get('user_lon');
        }
                   
                    $user->save();
                    
                   /*    Mail::raw('usuario creado '.$user->id, function ($message) {
                        $message->to('informacion@cristiangarcia.co');
                        $message->subject('Usuario Creado Alquiler Directo');
                     });*/
                     
                     $this->sendUsersToSlack('usuario creado '.$user->id);
                     
                    /*$this->sendToMeetwork($user->name, strtolower($user->email), $user->alternative_mail, $sourceSocial, $sourceSocial, 1);

                    $emailParams=array("preview"=>"Desde ahora eres parte de una de las comunidades que más crece, ahora puedes alquilar o vender de la forma mas fácil",
                        "subject"=>"Bienvenido ".$user->name." a Alquiler Directo");
                    Mail::send('emails.wellcome', ['user' => $user,"emailParams"=>$emailParams], function ($m) use ($user,$emailParams) {

                        $m->to(strtolower($user->email), $user->name)->subject($emailParams["subject"]);
                    });*/
                     

                   /* $emailParams=array("preview"=>"Desde ahora eres parte de una de las comunidades que más crece, ahora puedes alquilar o vender de la forma mas fácil",
                        "subject"=>"Bienvenido ".$user->name." a Alquiler Directo");
                    Mail::send('emails.downloadapp', ['user' => $user,"emailParams"=>$emailParams], function ($m) use ($user,$emailParams) {

                        $m->to(strtolower($user->email), $user->name)->subject($emailParams["subject"]);
                    });*/

                     
                    
                }
                return redirect($previousUrl); 
            }
            
        }
        
    }
    $emailTep=$registerData["email"];
    if(!isset($registerData["email"])){
        $emailTep=$request->get("alternativeemail");
    }

    Auth::login($user->create(array("name" => $registerData["name"], "password" => $registerData["id"], "email" => strtolower($emailTep))),true);
    if(Auth::check()){

       
        $user=User::find(Auth::id());
        $user->alternative_mail= strtolower($request->get("alternativeemail"));
        $user->source=$sourceSocial;
        
        if (Session::has('country_id')) {
            $country_id = Session::get('country_id');
        }

        $user->country_id=$country_id;
        
        if($request->session()->has('user_lat')){
            $user->lat=$request->session()->get('user_lat');
            $user->lon=$request->session()->get('user_lon');
        }
        
        $user->save();
        
      /*  Mail::raw('usuario creado '.$user->id, function ($message) {
            $message->to('informacion@cristiangarcia.co');
         });*/
    $this->sendUsersToSlack('usuario creado '.$user->id.' email  '.$user->alternative_mail);
      
     $emailParams=array("preview"=>"Desde ahora eres parte de una de las comunidades que más crece, ahora puedes alquilar o vender de la forma mas fácil",
                        "subject"=>"Bienvenido ".$user->name." a Alquiler Directo");
                    Mail::send('emails.downloadapp', ['user' => $user,"emailParams"=>$emailParams], function ($m) use ($user,$emailParams) {

                        $m->to(strtolower($user->email), $user->name)->subject($emailParams["subject"]);
                    });
    
    
    }
    
    //if($request->has("meetwork")){
   // }
    
    
        $this->sendToMeetwork($user->name, strtolower($user->email), $user->alternative_mail, $registerData["id"], $registerData["id"], $request->get("user_type"));
    $request->session()->forget('sourceSocial');

    return redirect($previousUrl);
    
}



public function sendToMeetwork($name,$email,$alternative_email,$password,$remote_id,$user_type){
    $post = [
    'name' => $name,
    'email' => $email,
    'alternative_email'   => $alternative_email,
    'password'   => $password,
    'remote_id'   => $remote_id,
    'user_type'   => $user_type,
];
    
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://meetwork.co/registeralquiler');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
$response = curl_exec($ch);
}

public function sendUsersToSlack($message){
    
                                                                                       
$data_string='{"text":"'.$message.'","channel":"#usr-a-d","link_names":1,"username":"alquiler-directo","icon_emoji":":casa:"}';
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



public function login(Request $request){
            $value = $request->session()->get('backUrl', 'default');
            
            
            if(!\Session::has('backUrlpublicar')){
                 \Session::put('backUrlpublicar',route("homeslash"));
                \Session::put('backUrl', route("homeslash"));
            }
       
        
            
    if(Auth::check()){
        if($value=="https://alquilerdirecto.com.ar/login"){
            return redirect()->route("homeslash");
        }else{
            return redirect()->to($value);

        }
    
    }else{
        
          $registerData = array(
            "id" => 0,
            "nickname" => "",
            "name" => "",
            "email" => "",
            "avatar" => "",
            "source" => 0
        );
        if (session()->has('userAuth')) {
            $registerData = session()->get('userAuth')[0];
            
        }
  
     
       return view('pages.login')->with("dataregister", $registerData);;
   }
   

}


public function micuenta(){
    if(Auth::check()){
        return view('layouts.profile');
    }else{
        return redirect()->route("homeslash");
    }
}


public function setprofileUser($user,$type){
    $user= User::find($user);
    dd($user);
}
public function updatePerfi(Request $request){
    if(Auth::check()){
        
        $User= User::find(Auth::id());
        $User->name=$request->get("name");
        $User->cel=$request->get("cel");
        $User->email=$request->get("email");
        $User->save();
        return redirect()->back()->with('success', __('messages.yourComment'));

    }else{
        return redirect()->route("homeslash");
    }
    

    
}
}

