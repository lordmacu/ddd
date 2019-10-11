<?php

namespace App\Providers;

use App\PropertyImage;
use Form;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Cache;
use App\Unit;
use App\Neighborhood_home;
use Session;
class FormMacroServiceProvider extends ServiceProvider {

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot() {

        Form::macro('imageremote', function ($image, $size) {

            return "https://markandstorecom.ipage.com/ImageProvider/public/images/" . $size . "/" . $image;
        });



        Form::macro('simpleImage', function ($image) {
            return preg_replace("(^https?://)", "//", $image);
        });

        
          Form::macro('homeNeighborhood', function () {

            $expiresAt = now()->addMinutes(3600);
            $country_id=Session::get('country_id');

            return Cache::remember("neighboorhood_home_".$country_id, $expiresAt, function () {
                    $country_id=Session::get('country_id');

                 if(Session::has('country_id')){
                        $barios = \App\Neighborhood_home::where("country_id",$country_id)->get();

                        }else{
                        $barios = \App\Neighborhood_home::all();

                        }

                        $html = "";
                        foreach ($barios as $barrio) {

                            $html .= '<a onmouseout="activeButton()" onmouseenter="changeBackground('.$barrio->id.')" href="'.url("/").$barrio->url.'" class="button_'.$barrio->id.' btn btn-light white-button-color  btn-lg">'.$barrio->name.'</a>';
                        }
                        return $html;
                    });
        });

        

        
        Form::macro('loadLatest', function () {



            $expiresAt = now()->addMinutes(200);

            return Cache::remember("latest_footer", $expiresAt, function () {
                            $latest = "";

                        $UnitModel = new Unit();
                        $getLatestHomeProperties = $UnitModel->getLatestHomeProperties(2);
                        foreach ($getLatestHomeProperties as $unit) {

                            $image = "";
                            if ($unit->local == 2) {
                                $image = "https://s3-sa-east-1.amazonaws.com/alquiler/images/small/" . Form::principal($unit->images, 2);
                            } else {
                                $image = Form::principal($unit->images, 2);
                            }

                            $latest .= '<div class="media">
                            <div class="media-left">
                                <img style="width: 100px;" class="media-object" this.src="https://alquilerdirecto.com.ar/images/medium/1530023943-Noviembre2012017.jpg" src="' . $image . '" alt="small-properties-2">
                            </div>
                            <div class="media-body">
                                <h3 class="media-heading">
                                    <a href="' . $unit->slug . '">' . str_limit(ucfirst(strtolower($unit->title)), 50, '...') . '</a>
                                </h3>
                                <p>February 27, 2018</p>
                                <div class="price">
                                    $' . number_format($unit->price) . '
                                </div>
                            </div>
                        </div>';
                        }
                        return $latest;
                    });
        });

        Form::macro('footerBarrios', function () {

            $expiresAt = now()->addMinutes(3600);
            $country_id=Session::get('country_id');

            return Cache::remember("barrios_footerssddsd_".$country_id, $expiresAt, function () {
                    $country_id=Session::get('country_id');

                 if(Session::has('country_id')){
                        $barios = \App\Neighborhood::where("country_id",$country_id)->get();

                        }else{
                        $barios = \App\Neighborhood::all();

                        }

                        $html = "";
                        foreach ($barios as $barrio) {

                            $slug = '/alquileres-en-' . str_replace("/", " ", strtolower(str_replace(" ", "-", str_replace('"', "", str_replace(",", "", $barrio->name)))));
                            $html .= '<div class="col-6 col-md-2 col-sm-2 white-text-link"><a alt="Alquileres en '.$barrio->name.'" href="'.url("/").$slug.'">Alquileres en ' . str_replace('"', "", str_replace(",", "", $barrio->name)) . '</a></div>';
                        }
                        return $html;
                    });
        });

         Form::macro('principaldos', function ($images, $remote = 2) {
            $principal = asset("/images/noimage.png");
            foreach ($images as $key => $image) {
                if ($key == 0) {


                    if ($remote == 2) {
                        $principal = "https://s3-sa-east-1.amazonaws.com/alquiler/images/small/".$image->small;
                    } else {
                        /*
                          $url = parse_url($image->small);

                          if ($url['scheme'] == 'https') {
                          $principal = $image->small;
                          } else {
                          $b64_url = 'php://filter/read=convert.base64-encode/resource=' . $image->small;
                          $principal = "data:image/jpeg;base64," . $b64_img = file_get_contents($b64_url);
                          } */

                        $principal = "https://s3-sa-east-1.amazonaws.com/alquiler/images/small/".preg_replace("(^https?://)", "//", $image->small);
                    }
                }
            }
            return trim($principal);
        });
        
        Form::macro('principal', function ($images, $remote = 2) {
            $principal = asset("/img/noimage.png");
            foreach ($images as $key => $image) {
                if ($key == 0) {


                    if ($remote == 2) {
                        $principal = str_replace("http:","https:",$image->small);
                    } else {
                        /*
                          $url = parse_url($image->small);

                          if ($url['scheme'] == 'https') {
                          $principal = $image->small;
                          } else {
                          $b64_url = 'php://filter/read=convert.base64-encode/resource=' . $image->small;
                          $principal = "data:image/jpeg;base64," . $b64_img = file_get_contents($b64_url);
                          } */

                        $principal = preg_replace("(^https?://)", "//", $image->small);
                    }
                }
            }
            return $principal;
        });

        Form::macro('isMobile', function () {

            if (!empty($_SERVER["HTTP_USER_AGENT"])) {
                return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
            } else {
                return false;
            }
        });


        Form::macro('similarImage', function ($id) {
            $propertyImage = new PropertyImage();
            $getImagesPerUnit = $propertyImage->getImagesPerUnit($id);
            if (!$getImagesPerUnit->count()) {
                return "";
            }
            /*
              $url = parse_url($propertyImage->getImagesPerUnit($id)[0]->small);
              if ($url['scheme'] == 'https') {
              return $propertyImage->getImagesPerUnit($id)[0]->small;
              } else {
              $b64_url = 'php://filter/read=convert.base64-encode/resource=' . $propertyImage->getImagesPerUnit($id)[0]->small;
              return "data:image/jpeg;base64," . $b64_img = file_get_contents($b64_url);
              } */
            return preg_replace("(^https?://)", "//", $propertyImage->getImagesPerUnit($id)[0]->small);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        //
    }

}
