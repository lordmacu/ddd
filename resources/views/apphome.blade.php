<!doctype html>
<html lang="es">
    <head>

        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-104123801-1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());
            
            gtag('config', 'UA-104123801-1');
            
            var countrySearch="{{config('country.'.Session::get('searchCountry'))["from"]}}"
        </script>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Material Design for Bootstrap fonts and icons -->

        <!-- Material Design for Bootstrap CSS -->
        <link rel="stylesheet" href="https://unpkg.com/bootstrap-material-design@4.1.1/dist/css/bootstrap-material-design.min.css" integrity="sha384-wXznGJNEXNG1NFsbm0ugrLFMQPWswR3lds2VeinahP8N0zJw9VWSopbjv2x7WCvX" crossorigin="anonymous">
        <link rel="stylesheet" href="{{asset("/css/app.css")}}?rand={{rand(1,3424234234)}}" crossorigin="anonymous">
        <script src="https://kit.fontawesome.com/abd90cf694.js"></script>
          <!--[if lt IE 9]><script src="http://cdnjs.cloudflare.com/ajax/libs/es5-shim/2.0.8/es5-shim.min.js"></script><![endif]-->
            <link rel="shortcut icon" href="/images/favicon.png" type="image/x-icon"/>

        <title>@section('title') Dueño Directo - Alquiler de departamentos en {{config('country.'.Session::get('country_id'))["name"]}} @show</title>
        <meta name="csrf-token" content="{{ csrf_token() }}" />



        <meta name="msvalidate.01" content="7D65C1F7DA18A6ADF85804D7AEB18A79"/>
        <meta property="og:site_name" content="Alquiler Directo"/>
        <meta property="og:locale" content="es_ES"/>
        <meta property="fb:app_id" content="1594551287445664"/>

        <meta name="twitter:card" content="summary_large_image"/>
        <meta name="twitter:site" content="@alquilerdirecto"/>
        <meta name="twitter:image:src" content="https://alquilerdirecto.com.ar/download.png"/>
        <meta name="p:domain_verify" content="55738eecd44de90a3d281ee0ffe04a26"/>
        <meta name="msapplication-square70x70logo" content="https://www.alquilerdirecto.com.ar/logo.png"/>
        <meta name="msapplication-square150x150logo" content="https://www.alquilerdirecto.com.ar/logo.png"/>
        <meta name="msapplication-wide310x150logo" content="https://www.alquilerdirecto.com.ar/logo.png"/>
        <meta name="msapplication-square310x310logo" content="https://www.alquilerdirecto.com.ar/logo.png"/>
        <meta name="theme-color" content="#9E1820"/>
        <meta name="name" content="Habitaciones y apartamentos en alquiler: Reserve en línea | Alquiler Directo"/>
        <meta name="description" content="Alquile su próxima vivienda de mediano a largo plazo en línea. ¡Experimenta tu nuevo hogar con Alquiler Directo!"/>




        @section('meta')
        <meta property="og:url" content="https://www.alquilerdirecto.com.ar/"/>
        <meta property="og:title" content="Alquiler Directo"/>
        <meta property="og:description" content="Habitaciones y apartamentos en alquiler: Reserve en línea | Alquiler Directo"/>
        <meta property="og:type" content="website" />
        <meta property="og:image" content="https://alquilerdirecto.com.ar/download.png" />

        @show

        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({
                google_ad_client: "ca-pub-9292038676986573",
                enable_page_level_ads: true
            });
        </script>
        
        <!-- Hotjar Tracking Code for https://alquilerdirecto.com.ar/ -->
<script>
    (function(h,o,t,j,a,r){
        h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
        h._hjSettings={hjid:1385433,hjsv:6};
        a=o.getElementsByTagName('head')[0];
        r=o.createElement('script');r.async=1;
        r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
        a.appendChild(r);
    })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
</script>
        
    </head>
    <body>
 <!-- Firebase App (the core Firebase SDK) is always required and must be listed first -->
 <!-- Firebase App (the core Firebase SDK) is always required and must be listed first -->
<script src="https://www.gstatic.com/firebasejs/4.1.3/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/4.1.3/firebase-database.js"></script>
<script src="https://www.gstatic.com/firebasejs/4.1.3/firebase-messaging.js"></script>

  <script>

</script>
        @yield('content')

        <footer>
            <section class="container">
                <div class="row">
                    <div class="col-12 col-lg-12">
                        <h2>Alquiler Directo</h2>
                        <p>Alquiler Directo es la forma más fácil de buscar apartamentos en alquiler. No somos inmobiliaria y no alquilamos ni somos intermediarios en el proceso de alquiler, si tenés preguntas, escribe al dueño o llamalo al celular..</p>
                        <hr/>
                    </div>


                </div>
                <div class="row neighborhood-container">
                    <div class="col-12">
                        <h4>Barrios Populares</h4>

                    </div>
                    {!! Form::footerBarrios() !!}

                </div>
            </section>
        </footer>

        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDuNgce1nBPfJ1HzhkpGTZSvJLBFlZLD8I&libraries=places"></script>

        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.2.1.min.js"  ></script>
        <script src="https://unpkg.com/popper.js@1.12.6/dist/umd/popper.js" integrity="sha384-fA23ZRQ3G/J53mElWqVJEGJzU0sTs+SvzG8fXVWP+kJQ1lwFAOkcUOysnlKJC33U" crossorigin="anonymous"></script>
        <script src="https://unpkg.com/bootstrap-material-design@4.1.1/dist/js/bootstrap-material-design.js" integrity="sha384-CauSuKpEqAFajSpkdjv3z9t8E7RlpJ1UP0lKM/+NdtSarroVKu069AlsRPKkFBz9" crossorigin="anonymous"></script>

        <script>$(document).ready(function () {
    $('body').bootstrapMaterialDesign();

});
var urlPublic = "{{asset(" / ")}}";
        </script>
        <script src="{{asset("/js/script.js")}}?rand={{rand(1,3424234234)}}" ></script>
        <script src="/js/firebase.js?d=3"></script>

        <script type="text/javascript">
       $.ajaxSetup({
           headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           }
       });
       
   
 
 window.onload = function() {
      console.log( "ready!"+localStorage.getItem("nombredeusuario") );
};

 

        </script>
     <script type="application/ld+json">{"@context":"http://schema.org/","@type":"RealEstateAgent","name":"Alquiler Directo","description":"Rent your next mid to long-term housing online. Experience your new home with Coonga!","url":"https://www.coonga.com","logo":"https://ccon.ga/images/logo.png","image":"https://s3-sa-east-1.amazonaws.com/alquiler/map.jpg","email":"hello@coonga.com","telephone":"+1 888-950-8805","address":"C/ Vizcaya 12, 28045 Madrid - Spain","priceRange":"$-$$$","sameAs":["https://twitter.com/coonga","https://facebook.com/coonga","https://instagram.com/coonga","https://pinterest.com/coonga","https://plus.google.com/112987047080252998385"],"aggregateRating":{"@type":"AggregateRating","ratingValue":8.7,"reviewCount":1596,"bestRating":10,"worstRating":1}}</script>

    </body>
</html>