<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
});
Route::get('/hola', function () {
    return view('home');
});
 Route::get('DescargaNuestraApp', 'HomeController@demo');
 Route::get('enviaremail', 'HomeController@enviaremail');


Route::get('/', function () {
    return view('home');
})->name("homeslash");

Route::get('/home', function () {
    return view('home');
});


Route::get('/populatePlaces', 'PropiedadController@populatePlaces')->name("populatePlaces");
Route::get('/rss', 'HomeController@rss')->name("rss");

Route::get('/getHomeMovies', 'HomeController@getHomeMovies')->name("getHomeMovies");
Route::get('/getUrl', 'HomeController@getUrl')->name("getUrl");
Route::get('/getVideoFrame', 'HomeController@getVideoFrame')->name("getVideoFrame");
Route::get('/searchMovie', 'HomeController@searchMovie')->name("searchMovie");

Route::get('/publicarPropiedades', 'PropiedadController@crearPropiedad')->name("crearPropiedades");
Route::get('/publicarPropiedad', 'PropiedadController@crearPropiedades')->name("crearPropiedad");
Route::post('/publicarPropiedad', 'PropiedadController@crearPropiedadesPost')->name("publicarPropiedadPost");

Route::post('/file-upload', 'PropiedadController@fileUpload')->name("file-upload");


Route::get('unsuscribe', 'HomeController@unsuscribe')->name("unsuscribe");
Route::get('unsuscribe/{id}', 'HomeController@unsuscribeId')->name("unsuscribeId");

Route::post('/checkUser', 'UserController@checkUser')->name("checkUserUrl");
Route::post('/registerUser', 'UserController@registerUser')->name("registerUserUrl");


/*
//// login facebook
Route::get('/callbackFacebookLogin', 'Auth\LoginController@callbackFacebookLogin')->name("callbackFacebookLogin");
Route::get('/redirectToProviderFacebook', 'Auth\LoginController@redirectToProviderFacebook')->name("redirectToProviderFacebook");
///
*/
//// login facebook
Route::get('/callbackGoogleLogin', 'Auth\LoginController@callbackGoogleLogin')->name("callbackGoogleLogin");
Route::get('/redirectToProviderGoogle', 'Auth\LoginController@redirectToProviderGoogle')->name("redirectToProviderGoogle");
///
Route::post('/file-upload', 'PropiedadController@fileUpload')->name("file-upload");
Route::post('/deletePhoto', ['as' => 'place.deletePhoto', 'uses' => 'PropiedadController@deletePhoto']);

//// login gmail
Route::get('/callbackFacebookLogin', 'Auth\LoginController@callbackFacebookLogin')->name("callbackFacebookLogin");
Route::get('/redirectToProviderFacebook', 'Auth\LoginController@redirectToProviderFacebook')->name("redirectToProviderFacebook");
///

Route::get('/alquileres-en-{slug}', 'SearchController@searchByNeighborhood');

Route::get('/search', 'SearchController@indexSeach')->name("search");
Route::get('/getGeoUser', 'UserController@getGeoUser')->name("getGeoUser");
Route::get('registerUserApi', 'UserController@registerUserApi')->name("registerUserApi");
Route::get('/searchapiHome', 'SearchController@searchapiHome')->name("searchapiHome");
Route::get('sendEmailData', 'HomeController@sendEmailData')->name("sendEmailData");;
Route::get('sendEmailUsers', 'HomeController@sendEmailUsers')->name("sendEmailUsers");;


Auth::routes();
Route::get('/login', 'UserController@login')->name("login");



Route::get('/alquiler-en-{barrio}', 'SearchController@searchByNeighborhood');
Route::get('/sitemaptwo.xml', 'HomeController@sitemapTwo')->name("sitemapTwo");

Route::get('/home/alquiler-en-{barrio}', 'SearchController@searchByNeighborhood');
Route::get('/home/alquiler-en-{barrio}', 'SearchController@searchByNeighborhood');
Route::get('/home/alquileres-{barrio}', 'SearchController@searchByNeighborhood');
Route::get('/alquileres-{barrio}', 'SearchController@searchByNeighborhood');
Route::get('/alquiler-{barrio}', 'SearchController@searchByNeighborhood');

/*
//// login facebook
Route::get('/callbackFacebookLogin', 'Auth\LoginController@callbackFacebookLogin')->name("callbackFacebookLogin");
Route::get('/redirectToProviderFacebook', 'Auth\LoginController@redirectToProviderFacebook')->name("redirectToProviderFacebook");
///
*/
//// login facebook
Route::get('/callbackGoogleLogin', 'Auth\LoginController@callbackGoogleLogin')->name("callbackGoogleLogin");
Route::get('/redirectToProviderGoogle', 'Auth\LoginController@redirectToProviderGoogle')->name("redirectToProviderGoogle");
///
Route::post('/file-upload', 'PropiedadController@fileUpload')->name("file-upload");
Route::post('/deletePhoto', ['as' => 'place.deletePhoto', 'uses' => 'PropiedadController@deletePhoto']);

//// login gmail
Route::get('/callbackFacebookLogin', 'Auth\LoginController@callbackFacebookLogin')->name("callbackFacebookLogin");
Route::get('/redirectToProviderFacebook', 'Auth\LoginController@redirectToProviderFacebook')->name("redirectToProviderFacebook");
///

///seo
Route::get('/alquiler', 'SearchController@indexSeachSeo');

Route::get('/dueno-directo', 'SearchController@indexSeachSeo');
Route::get('/inmobiliaria', 'SearchController@indexSeachSeo')->name("keywordSearch");
Route::get('/pisos-alquiler', 'SearchController@indexSeachSeo')->name("keywordSearch");
Route::get('/pisos-en-alquiler', 'SearchController@indexSeachSeo')->name("keywordSearch");
Route::get('/alquiler-pisos', 'SearchController@indexSeachSeo')->name("keywordSearch");
Route::get('/alquiler-de-departamentos', 'SearchController@indexSeachSeo')->name("keywordSearch");
Route::get('/apartamentos-en-alquiler', 'SearchController@indexSeachSeo')->name("keywordSearch");
Route::get('/pisos-en-alquiler', 'SearchController@indexSeachSeo')->name("keywordSearch");
Route::get('/alquiler-de-pisos', 'SearchController@indexSeachSeo')->name("keywordSearch");
Route::get('/habitaciones-en-alquiler', 'SearchController@indexSeachSeo')->name("keywordSearch");
Route::get('/departamentos-en-alquiler', 'SearchController@indexSeachSeo')->name("keywordSearch");
Route::get('/alquiler-de-apartamentos', 'SearchController@indexSeachSeo')->name("keywordSearch");
Route::get('/alquiler-sin-garantia', 'SearchController@indexSeachSeo')->name("keywordSearch");
Route::get('/portal-inmobiliario', 'SearchController@indexSeachSeo')->name("keywordSearch");
Route::get('/en-alquiler', 'SearchController@indexSeachSeo')->name("keywordSearch");
Route::get('/enalquiler', 'SearchController@indexSeachSeo')->name("keywordSearch");
Route::get('/alquileres-baratos', 'SearchController@indexSeachSeo')->name("keywordSearch");
Route::get('/alquiler-departamentos', 'SearchController@indexSeachSeo')->name("keywordSearch");
Route::get('/alquiler-particulares', 'SearchController@indexSeachSeo')->name("keywordSearch");
Route::get('/alquiler-vivienda-en-madrid', 'SearchController@indexSeachSeo')->name("keywordSearch");
Route::get('/alquiler-vivienda-en-buenos-aires', 'SearchController@indexSeachSeo')->name("keywordSearch");
Route::get('/alquiler-vivienda-en-capital', 'SearchController@indexSeachSeo')->name("keywordSearch");
Route::get('/alquiler-vivienda-en-capital-federal', 'SearchController@indexSeachSeo')->name("keywordSearch");
Route::get('/alquiler-vivienda-en-gran-buenos-aires', 'SearchController@indexSeachSeo')->name("keywordSearch");
Route::get('/paginas-para-buscar-casas-en-alquiler', 'SearchController@indexSeachSeo')->name("keywordSearch");
Route::get('/casas-y-apartamentos-en-alquiler', 'SearchController@indexSeachSeo')->name("keywordSearch");
Route::get('/inmobiliaria-de-alquiler', 'SearchController@indexSeachSeo')->name("keywordSearch");
Route::get('/buscador-de-alquileres-de-casas', 'SearchController@indexSeachSeo')->name("keywordSearch");
Route::get('/como-alquilar-un-piso-en-madrid', 'SearchController@indexSeachSeo')->name("keywordSearch");
Route::get('/alquiler-apartamentos-en-alquiler', 'SearchController@indexSeachSeo')->name("keywordSearch");
Route::get('/alquilar-de-apartamentos-en-alquiler', 'SearchController@indexSeachSeo')->name("keywordSearch");
Route::get('/alquilar-de-apartamentos-en-bs-as', 'SearchController@indexSeachSeo')->name("keywordSearch");
Route::get('/alquilar-apartamentos-en-bs-as', 'SearchController@indexSeachSeo')->name("keywordSearch");
Route::get('/pisos-en-alquiler-en-buenos-aires', 'SearchController@indexSeachSeo')->name("keywordSearch");
Route::get('/arriendo-de-apartamentos-en-buenos-aires', 'SearchController@indexSeachSeo')->name("keywordSearch");
Route::get('/apartaestudio-buenos-aires', 'SearchController@indexSeachSeo')->name("keywordSearch");
Route::get('/argenprop', 'SearchController@indexSeachSeo')->name("keywordSearch");
Route::get('/zonaprop-alquiler', 'SearchController@indexSeachSeo')->name("keywordSearch");
Route::get('/zonaprop', 'SearchController@indexSeachSeo')->name("keywordSearch");
Route::get('/alquileres-argentina', 'SearchController@indexSeachSeo')->name("keywordSearch");
Route::get('/buenos-aires', 'SearchController@indexSeachSeo')->name("keywordSearch");
Route::get('/departamentos-temporarios', 'SearchController@indexSeachSeo')->name("keywordSearch");
Route::get('/departamentos-alquiler', 'SearchController@indexSeachSeo')->name("keywordSearch");
Route::get('/deptos-alquiler', 'SearchController@indexSeachSeo')->name("keywordSearch");
Route::get('/deptos-en-alquiler', 'SearchController@indexSeachSeo')->name("keywordSearch");
Route::get('/propiedades-en-alquiler', 'SearchController@indexSeachSeo')->name("keywordSearch");
Route::get('/alquiler-departamentos-capital-federal', 'SearchController@indexSeachSeo')->name("keywordSearch");
Route::get('/alquiler-departamentos-caba', 'SearchController@indexSeachSeo')->name("keywordSearch");
Route::get('/alquileres-en-capital-federal', 'SearchController@indexSeachSeo')->name("keywordSearch");
Route::get('/alquileres-capital', 'SearchController@indexSeachSeo')->name("keywordSearch");
Route::get('/alquileres-en-capital', 'SearchController@indexSeachSeo')->name("keywordSearch");
Route::get('/alquileres-departamento', 'SearchController@indexSeachSeo')->name("keywordSearch");
Route::get('/alquileres-tempoprarios', 'SearchController@indexSeachSeo')->name("keywordSearch");
Route::get('/departamentos-en-alquiler-capital-federal', 'SearchController@indexSeachSeo')->name("keywordSearch");
Route::get('/rentas-buenos-aires', 'SearchController@indexSeachSeo')->name("keywordSearch");
Route::get('/alquileres-en-buenos-aires', 'SearchController@indexSeachSeo')->name("keywordSearch");
Route::get('/alquiler-temporario', 'SearchController@indexSeachSeo')->name("keywordSearch");
Route::get('/alquiler-temporario-capital-federal', 'SearchController@indexSeachSeo')->name("keywordSearch");
Route::get('/inmobiliaria-buenos-aires', 'SearchController@indexSeachSeo')->name("keywordSearch");
Route::get('/deptos-en-alquiler-buenos-aires', 'SearchController@indexSeachSeo')->name("keywordSearch");
Route::get('/deptos-en-alquiler-capital-federal', 'SearchController@indexSeachSeo')->name("keywordSearch");
Route::get('/deptos-amoblados-capital-federal', 'SearchController@indexSeachSeo')->name("keywordSearch");
Route::get('/deptos-temporarios', 'SearchController@indexSeachSeo')->name("keywordSearch");
Route::get('/apartamentos-buenos-aires', 'SearchController@indexSeachSeo')->name("keywordSearch");
Route::get('/apartamentos-en-buenos-aires', 'SearchController@indexSeachSeo')->name("keywordSearch");
Route::get('/departamentos-en-buenos-aires', 'SearchController@indexSeachSeo')->name("keywordSearch");
Route::get('/departamentos-buenos-aires', 'SearchController@indexSeachSeo')->name("keywordSearch");
Route::get('/alquiler-dueno-directo', 'SearchController@indexSeachSeo')->name("keywordSearch");
Route::get('/alquiler-dueno-directo-buenos-aires', 'SearchController@indexSeachSeo')->name("keywordSearch");
Route::get('/alquilar-en-buenos-aires', 'SearchController@indexSeachSeo')->name("keywordSearch");

Route::get('/publicar-en-buenos-aires', 'PropiedadController@crearPropiedad');
Route::get('/publicar-departamento', 'PropiedadController@crearPropiedad');
Route::get('/publicar-departamento-dueno-directo', 'PropiedadController@crearPropiedad');
 
Route::get('/inicio/{name}', 'PropiedadController@propiedadSystem')->name("propiedadSystems");
Route::get('/inicios/{name}', 'PropiedadController@propiedadSystemv')->name("propiedadSystemv");


  Route::get('/_debugbar/assets/stylesheets', [
    'as' => 'debugbar-css',
    'uses' => '\Barryvdh\Debugbar\Controllers\AssetController@css'
]);

Route::get('/_debugbar/assets/javascript', [
    'as' => 'debugbar-js',
    'uses' => '\Barryvdh\Debugbar\Controllers\AssetController@js'
]);


 Route::get('propiedad/{id}/{slug}/js/ie8-responsive-file-warning.js', function () {
    return view('layouts.empty');
});

 Route::get('setprofileUser/{user}/{type}', 'UserController@setprofileUser');


Route::get('adform/IFrameManager.html', 'HomeController@redirectToUrlFake');
Route::get('admin', 'HomeController@redirectToUrlFake');
Route::get('sendNotiicationGeneral', 'HomeController@sendNotiicationGeneral');
Route::post('setTopic', 'HomeController@setTopic');

Route::get('index.action', 'HomeController@redirectToUrlFake');
Route::get('wp-login.php', 'HomeController@redirectToUrlFake');
Route::get('user/register', 'HomeController@redirectToUrlFake');
Route::get('wp-login.php?action=register', 'HomeController@redirectToUrlFake');
Route::post('index.php/file-upload', 'HomeController@redirectToUrlFake');
Route::post('HNAP1', 'HomeController@redirectToUrlFake');
Route::post('evox/about', 'HomeController@redirectToUrlFake');
Route::post('nmaplowercheck1529440088', 'HomeController@redirectToUrlFake');
Route::post('sdk', 'HomeController@redirectToUrlFake');



Route::get('/{id}', 'PropiedadController@getBySlug');
 
