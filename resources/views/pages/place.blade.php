@extends('app')

@section('title')
  {{ucfirst(strtolower($unit->title))}} -@parent
@stop

@section('meta')

<meta name="title" content=" {{$unit->title}} Barrio @if($unit->neighborhood){{$unit->neighborhood->name}}@endif " />

@foreach($unit->images as $key=>$image)


@if (strpos($image->medium, 'markandstorecom') !== false) 
<meta property="og:image" content="{!! $image->medium !!}" />
<meta property="og:image:type" content="image/jpeg" />


<meta property="og:image:width" content="640" />
<meta property="og:image:height" content="480" />
@else

<meta property="og:image" content="https://s3-sa-east-1.amazonaws.com/alquiler/images/medium/{!! $image->medium !!}" />
<meta property="og:image:type" content="image/jpeg" />


<meta property="og:image:width" content="640" />
<meta property="og:image:height" content="480" />
@endif
@endforeach

<meta name="description" content=" @if($unit->owner_type_id==2)- Dueño directo @endif  {{str_replace("\n","",wordwrap(strip_tags(str_replace("&nbsp;","",$unit->information)),160))}}" />
<meta property="og:title" content=" {{$unit->title}} Barrio @if($unit->neighborhood){{$unit->neighborhood->name}}@endif  " />
<meta property="og:site_name" content="" />
<meta property="og:description" content=" @if($unit->owner_type_id==2)- Sueño directo @endif {{str_replace("\n","",wordwrap(strip_tags(str_replace("&nbsp;","",$unit->information)),160))}} barrio @if($unit->neighborhood){{$unit->neighborhood->name}}@endif" />
@if($unit->latitude)

<meta property="og:type" content="place" />
@else
<meta property="og:type" content="article" />
@endif
<meta property="fb:app_id" content="1829688357306202" /> 
 
    <?php $titulo=$unit->title." Barrio";
    if($unit->neighborhood){
        $titulo.=" ".$unit->neighborhood->name;
    }
    if(isset($unit->number_of_rooms)){
        if($unit->number_of_rooms!="Monoambiente"){
            if($unit->number_of_rooms==1){
                $titulo.=" ".$unit->number_of_rooms." Habitaciones";
            }else{
            $titulo.=" ".$unit->number_of_rooms." Habitaciones";
            }
        }else{
            $titulo.=" ".$unit->number_of_rooms;
        } 
    }
    //$titulo.=" ".env('MONEDA')."".$unit->price;

  ?>



<meta property="og:url" content="{{url()->current()}}" />

<meta property="og:street-address" content="{{$unit->street_name}} {{$unit->street_number}} {{$unit->floor}} {{$unit->department}}" />

@if($unit->neighborhood)<meta property="og:locality" content="{{$unit->neighborhood->name}}" />@endif
<meta property="og:region" content="Argentina" />
<meta property="og:postal-code" content="1043" />
<meta property="og:country-name" content="AR" />
@if($unit->latitude)
<meta property="place:location:latitude" content="{{$unit->latitude}}" /> 
<meta property="place:location:longitude" content="{{$unit->longitude}}" />
@endif
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:site" content="@Duenodirecto" />
<meta name="twitter:creator" content="@duenodirecto" />
@if($unit->neighborhood)<meta name="twitter:title" content="{{$unit->title}} en {{$unit->neighborhood->name}}  " />@endif
<meta name="twitter:description" content="@if($unit->owner_type_id==2) @endif  {{str_replace("\n","",wordwrap(strip_tags(str_replace("&nbsp;","",$unit->information)),160))}}" />

<meta name="twitter:image" content="{{Form::principal($unit->images,2)}}" />
  
@overwrite


@section('content')



<style>
    .promoted-content{
        margin-top: 40px;
        .card-body{
            padding: 20px;
        }
    }
</style>
<div class="container property-view">
    <div class="row">
        
        <div class="col-12 " >
            <div class="card card-cotact-place  d-block d-sm-none">

                <div class="card-body price-unit-container">
                    <div class="row">
                        <div class="col-12">
                           
                            @if(Auth::check())
                            
                            @if(!$unit->owner_name)
                                @if($unit->owner)
                                    @if($unit->user_id!=12155)
                                        @if($unit->user_id!=30614)

                                            <div class="main-title-2">
                                               <h1>@if(isset($unit->owner->first_name))<span>{{$unit->owner->first_name}}@endif @if(isset($unit->owner->last_name)) {{$unit->owner->last_name}} @endif</span></h1>
                                            </div>
                                            @if($unit->owner->phone)
                                            <h4>{{$unit->owner->phone}}</h4>
                                            @endif
                                         @endif
                                    @endif
                                @endif

                                
                            @else 
                                
                                
                                 <div class="main-title-2">
                                        <h1><span>{{$unit->owner_name}}</span></h1>
                                    </div>
                                    @if($unit->phone)
                                    <h4><a href="tel:{{$unit->phone}}">{{$unit->phone}}</a></h4>
                                    @endif
                                     @if($unit->email)
                                     <h5><a href="mailto:{{$unit->email}}">{{$unit->email}}</a></h5>
                                    @endif
                                    <hr/>
                            @endif
                            
                             @if($unit->facebook_url)
                                     <button onclick="window.open('{{$unit->facebook_url}}')" class=" btn-block btn btn-raised btn-primary  facebook-color"><i class="fab fa-facebook-messenger"></i> Contactar al Dueño</button>
                                @endif
                                
                                
                                @else
                                
                                <button class="btn btn-raised btn-danger" data-toggle="modal" data-target="#modalSocialLogin">Ingresar para ver los datos del dueño</button>
                                
                            @endif
                           
                            
                        </div>
                           
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-12 col-lg-8 ">

            <div class="card">

                <div class="card-body">
                    <div class="row">
                        <div class="col-12 no-padding">
                            <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner">
                                    @foreach($unit->images as $key=> $image)
                                    <div class="carousel-item @if($key==0) active @endif">
                                        
                                        @if(strpos($image->medium,"markandstorecom") == false )
                                            <img class="d-block w-100" src="https://s3-sa-east-1.amazonaws.com/alquiler/images/large/{{$image->medium}}" alt="First slide {{$key}}">
                                        @else
                                            <img class="d-block w-100" src="{{$image->medium}}" alt="First slide {{$key}}">

                                        @endif
                                    </div>
                                    @endforeach

                                </div>
                                <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-12 ">
                            <div class="description-place">
                                <h3>{{$unit->title}}</h3> 
                                <h6>{{$unit->street_name}} @if($unit->street_number!="0") {{$unit->street_number}}@endif @if($unit->neighborhood), {{$unit->neighborhood->name}} @endif</h6>
                                <hr/>
                                <p class="description-text-place">

                                    {!!(preg_replace('/[0-9]{8}|[0-9]{4}[\-][0-9]{4}|[0-9]{2}[\-][0-9]{4}[\-][0-9]{4}|[0-9]{3}[\-][0-9]{6}|[0-9]{3}[\-][0-9]{6}|[0-9]{3}[\s][0-9]{6}|[0-9]{3}[\s][0-9]{3}[\s][0-9]{4}|[0-9]{9}|[0-9]{3}[\-][0-9]{3}[\-][0-9]{4}/', '<a href="javascript:void(0)" data-toggle="modal" data-target="#modalSocialLogin" >***-******</a>', strip_tags(nl2br($unit->information),"<p><br><ul><li><pre>")))!!}

                                </p>
                                <p>
<ins class="adsbygoogle"
     style="display:block"
     data-ad-format="fluid"
     data-ad-layout-key="-7i+db-2n-3m+q2"
     data-ad-client="ca-pub-9292038676986573"
     data-ad-slot="9242245913"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
</p>
                       @if(count($unit->services)>0)
                                <h5>Servicios</h5>
                                <ul class="list-icons">
                                    @foreach($unit->services as $service)
                                         <span class="btn-group-lg">
                                            <button type="button" class="btn btn-danger bmd-btn-fab">
                                                @if($service->service->icon) {!! $service->service->icon !!} @else {{trim($service->service->name) }} @endif
                                            </button>
                                          </span>
                                    @endforeach   
                                </ul>
                        @endif
                            @if($unit->latitude)
                            <div class="location sidebar-widget">
                                <div class="map">
                                    <div class="main-title-2">
                                        <h1><span>Location</span></h1>
                                    </div>
                                    <img style="width: 100%" src="https://maps.googleapis.com/maps/api/staticmap?center={{$unit->latitude}},{{$unit->longitude}}&size=740x400&sensor=false&zoom=15&maptype=roadmap&markers=color:0xe70000|{{$unit->latitude}},{{$unit->longitude}}&key=AIzaSyD3x9EIe6p6aoIIoGE_CXJsYovvc4-mgLQ"/>

                                </div>
                            </div>
                            @endif

                            </div>
                        </div>
                        <div class="col-lg-12">
                            
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4 ">

            <div class="card">

                <div class="card-body price-unit-container">
                    <div class="row">
                        <div class="col-6">
                            <span>{{$unit->operation->name}}</span>
                        </div>
                          <div class="col-6 align-right">
                              <span>@if(config('country.'.Session::get('country_id'))["currency"]!="€"){{config('country.'.Session::get('country_id'))["currency"]}}@endif {{number_format($unit->price)}} @if(config('country.'.Session::get('country_id'))["currency"]=="€"){{config('country.'.Session::get('country_id'))["currency"]}}@endif</span>
                        </div>
                    </div>
                </div>
            </div>
             
             <div class="card card-cotact-place">

                <div class="card-body price-unit-container">
                    <div class="row">
                        <div class="col-12">
                           
                            @if(Auth::check())
                            
                            @if(!$unit->owner_name)
                                @if($unit->owner)
                                    @if($unit->user_id!=12155)
                                    @if($unit->user_id!=30614)
                                        <div class="main-title-2">
                                           <h1>@if(isset($unit->owner->first_name))<span>{{$unit->owner->first_name}}@endif @if(isset($unit->owner->last_name)) {{$unit->owner->last_name}} @endif</span></h1>
                                        </div>
                                        @if($unit->owner->phone)
                                        <h4>{{$unit->owner->phone}}</h4>
                                        @endif
                                    @endif
                                    @endif
                                @endif
                                
                             @else   
                                  <div class="main-title-2">
                                        <h1><span>{{$unit->owner_name}}</span></h1>
                                    </div>
                                    @if($unit->phone)
                                    <h4><a href="tel:{{$unit->phone}}">{{$unit->phone}}</a></h4>
                                    @endif
                                     @if($unit->email)
                                     <h5><a href="mailto:{{$unit->email}}">{{$unit->email}}</a></h5>
                                    @endif
                                    <hr/>
                            @endif
                                 @if($unit->facebook_url)
                                     <button onclick="window.open('{{$unit->facebook_url}}')" class=" btn-block btn btn-raised btn-primary  facebook-color"><i class="fab fa-facebook-messenger"></i> Contactar al Dueño</button>
                                @endif
                                
                                @else
                                
                                <button class="btn btn-raised btn-danger" data-toggle="modal" data-target="#modalSocialLogin">Ingresar para ver los datos del dueño</button>
                                
                            @endif
                           
                            
                        </div>
                           
                    </div>
                </div>
            </div>
            
             <div class="card card-cotact-place">

                <div class="card-body price-unit-container">
                    <div class="row">
                        <div class="col-12">
                  
                            <a target="_blank" href="https://respaldar.com.ar/"> <img width="100%"  src="respaldar-individual.gif"/></a>

                <ins class="adsbygoogle"
                     style="display:block"
                     data-ad-format="autorelaxed"
                     data-ad-client="ca-pub-9292038676986573"
                     data-ad-slot="2948300309"></ins>
                <script>
                     (adsbygoogle = window.adsbygoogle || []).push({});
                </script> 
                            
                        </div>
                           
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    

</div>

<div class="container-fluid">
    <div class="row promoted-content">
        <div class="col-12">
            <div class="row">
        <div class="col-12">
            <div class="card">
                  <div class="card-body">
                      <h3>Publicaciones recomendadas</h3>
                <ins class="adsbygoogle"
                     style="display:block"
                     data-ad-format="autorelaxed"
                     data-ad-client="ca-pub-9292038676986573"
                     data-ad-slot="2948300309"></ins>
                <script>
                     (adsbygoogle = window.adsbygoogle || []).push({});
                </script> 
            </div>
                  </div>
        </div>
    </div>
        </div>
    </div>
</div>
    
<script type="application/ld+json">{"@context":"http://schema.org/","@type":"Product","name":"{{ucfirst(strtolower($unit->title))}} {{$unit->street_name}} {{$unit->number}} @if($unit->neighborhood) {{$unit->neighborhood->name}} @endif","image":"@if($unit->local==2)https://s3-sa-east-1.amazonaws.com/alquiler/images/small/{!! Form::principal($unit->images,2) !!} @else {!! Form::principal($unit->images,2) !!} @endif","description":"{{strip_tags($unit->information)}}","url":"{{url('/')}}/{{$unit->slug}}","brand":{"@type":"RealEstateAgent","name":"Alquiler Directo","image":"https://s3-sa-east-1.amazonaws.com/alquiler/map.jpg","address":"{{$unit->street_name}} {{$unit->number}} @if($unit->neighborhood) {{$unit->neighborhood->name}} @endif","telephone":"+1133221411","priceRange":"$-$$$"},"offers":{"@type":"Offer","priceCurrency":"{{config('country.'.Session::get('country_id'))["currencyName"]}}","price":{{$unit->price}},"itemOffered":{"@type":"Residence"},"seller":{"@type":"RealEstateAgent","name":"Coonga","image":"https://s3-sa-east-1.amazonaws.com/alquiler/map.jpg","address":"{{$unit->street_name}} {{$unit->number}} @if($unit->neighborhood) {{$unit->neighborhood->name}} @endif","telephone":"+1133221411","priceRange":"$-$$$"}}}</script>
<script type="application/ld+json">{"@context":"http://schema.org/","@type":"Product","name":"{{ucfirst(strtolower($unit->title))}} {{$unit->street_name}} {{$unit->number}} @if($unit->neighborhood) {{$unit->neighborhood->name}} @endif","description":"{{strip_tags($unit->information)}}","aggregateRating":{"@type":"AggregateRating","ratingValue":4,"bestRating":5,"ratingCount":123}}</script>

@endsection
