<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use Response;
use Illuminate\Support\Facades\Auth;
use App\User;

class LoginController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | Login Controller
      |--------------------------------------------------------------------------
      |
      | This controller handles authenticating users for the application and
      | redirecting them to your home screen. The controller uses a trait
      | to conveniently provide its functionality to your applications.
      |
     */

use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest')->except('logout');
    }

    public function redirectToProviderGoogle(Request $request) {
        
        $request->session()->put('backUrl', request()->headers->get('referer'));
        return Socialite::driver('google')->redirect();
    }

    public function callbackGoogleLogin(Request $request) {



        $value = $request->session()->get("backUrl");
        try {
           
            $request->session()->put('state', $request->input('state'));
            $request->session()->put('code', $request->input('code'));

            $user = Socialite::driver('google')->stateless()->user();


            $product = [
                "id" => $user->getId(),
                "nickname" => $user->getNickname(),
                "name" => $user->getName(),
                "email" => $user->getEmail(),
                "avatar" => $user->getAvatar(),
                "source" => 2,
            ];


            $userM = new User();
            $getBySourceId = $userM->getBySourceId($user->getId());


            if ($getBySourceId) {
                Auth::login($getBySourceId, true);


                if ($request->session()->has('backUrlpublicar')) {
                    $value = $request->session()->get('backUrlpublicar');
                }

                if ($value) {
                    return redirect()->to($value);
                } else {
                    return redirect()->route("home");
                }
            }
            session()->push('userAuth', $product);

            if (!Auth::check()) {
                return redirect()->route("login");
            } else {
                if ($request->session()->has('backUrlbuscoun')) {
                    $request->session()->forget('backUrlbuscoun');

                    return redirect()->route("buscoUn");
                }

                if (is_string($value)) {
                    return redirect($value);
                } else {
                    return redirect()->route("search");
                }
            }
        } catch (\Exception $e) {

dd($e->getMessage());

            return redirect()->to("/login")->withError('Intenta iniciar sesión de nuevo');
        }

        return redirect()->route("login");
    }

    public function redirectToProviderFacebook(Request $request) {
        $request->session()->put('backUrl', request()->headers->get('referer'));
        $value = $request->session()->get('backUrl', 'default');


        return Socialite::driver('facebook')->redirect();
    }

    public function callbackFacebookLogin(Request $request) {

        $value = $request->session()->get('backUrl', 'default');

        if ($request->has("error")) {
            if ($request->get("error") == "access_denied") {
                return redirect($value);
            }
        }
        try {
            $request->session()->put('state', $request->input('state'));
            $request->session()->put('code', $request->input('code'));

            $user = Socialite::driver('facebook')->user();
            
            
            $product = [
                "id" => $user->getId(),
                "nickname" => $user->getNickname(),
                "name" => $user->getName(),
                "email" => $user->getEmail(),
                "avatar" => $user->getAvatar(),
                "source" => 2,
            ];


            $userM = new User();
            $getBySourceId = $userM->getBySourceId($user->getId());

            if ($getBySourceId) {
                Auth::login($getBySourceId, true);


                if ($request->session()->has('backUrlpublicar')) {
                    $value = $request->session()->get('backUrlpublicar');
                }
                
          

                if ($value) {
                    return redirect()->to($value);
                } else {
                    return redirect()->route("home");
                }
            }
            session()->push('userAuth', $product);

            if (!Auth::check()) {
                
                return redirect()->route("login");
            } else {
                if ($request->session()->has('backUrlbuscoun')) {
                    $request->session()->forget('backUrlbuscoun');

                    return redirect()->route("buscoUn");
                }

                if (is_string($value)) {
                    return redirect($value);
                } else {
                    return redirect()->route("search");
                }
            }
            
            
        } catch (\Exception $e) {
dd($e->getMessage());

            return redirect()->to("/login")->withError('Intenta iniciar sesión de nuevo');
        }
    }

    public function checkUser($email, $id) {
        $user = new User();
        $checkBySource = $user->checkBySource($id);

        if ($checkBySource == 1) {
            if (Auth::attempt(['email' => $email, 'password' => $id . "registerDueno"], true)) {
                return 1;
            }
        }
        return $checkBySource;
    }

}
