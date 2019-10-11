@extends('app')
<?php
     $nameCity=null;
        if(app('request')->input('nameN')){
            $nameCity=app('request')->input('nameN') ;
        }        
        
        foreach ($locationOptions as $location) {
            $value= $location["latlon"];
            if(app('request')->input('locationId')==$value){
                $nameCity= $location["name"];
            }
        }
        
        
    $operationName=null;
    foreach ($operations as $key=> $operation) {
        if(app('request')->input('operation')==json_decode($operation)->id){
            $operationName=$operation->name;
        }
    }
     
    ?>
@section('title') Propiedades @if($operationName)en {{$operationName}} @else en Alquiler  @endif @if($operationName)en {{$operationName}} @else en {{config('country.'.Session::get('country_id'))["name"]}} @endif | @parent @stop

@section('meta')
  <meta name="title" content="Propiedades @if($operationName) en {{$operationName}} @endif @if($operationName) en {{$operationName}} @endif" />
    <meta name="description" content="Encuentra las mejores propiedades  @if($operationName) en {{$operationName}} @endif @if($operationName) en {{$operationName}} @endif " /> 
<meta property="og:image" content="https://alquilerdirecto.com.ar/download.png"/>

@stop


@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function(){
   if(window.mobilecheck()){
        $(".filters-containers").hide();
                $(".filter-mobile-filter").show()

    }else{
        $(".filter-mobile-filter").hide()
    }
});

var actualUrl="{{Request::fullUrl()}}";
   
</script>
@endsection


@section('style')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />

<style>
    @media only screen 
and (min-device-width : 320px) 
and (max-device-width : 480px) { 
    
    .hide-mobile { display: none; }


}


@media only screen and (min-width: 960px) {
.hidedesktop{display:none;}
}


</style>

@endsection


@section('content')



@if($unitsProperties->count())
  <script type="application/ld+json">
{
  "@context":"http://schema.org",
  "@type":"ItemList",
  "itemListElement":[@foreach($unitsProperties as $unit) 
    {
      "@type": "ListItem",
      "position": "{{ $loop->iteration }}",
      "item": {
            "@type" : "Accommodation",
            "name" : "{{$unit->title }} for @if(isset($unit->price)){{$unit->price}} @endif",
            "url":"{{route('search')}}?slug={{$unit->slug}}",
            "address" : {
            "@type": "PostalAddress",
            "addressLocality": "{{config('country.'.Session::get('country_id'))["name"]}}", 
            "addressRegion": "{{config('country.'.Session::get('country_id'))["name"]}}",
            "postalCode": "7103",
            "streetAddress": "{{$unit->street_name}} {{$unit->street_number}}" },
            @if(count($unit->images)>0)"image": "https://s3-sa-east-1.amazonaws.com/alquiler/images/small/{{$unit->images[0]->medium}}"@endif

                
        }
    }@if($loop->iteration != count($unitsProperties)),@endif @endforeach
  ]
}
</script>
@endif

<div class="container">
    <div class="row">
        <div class="col-12 col-lg-4 filters-containers">

            <div class="card">
                                    <button onclick="closePopUpFilters()" class="btn btn-light">x</button>


                <div class="card-body">
                    <form method="GET" id="form-search-filter" action="">
                        <div class="no-material">
                        <h5>Ubicación</h5>
                        <input type="hidden" id="sort" name="sort" @if(app('request')->input('sort')) value="{{app('request')->input('sort')}}" @else value="all"  @endif />
                        
                        <select onchange="setLocation()" class="js-example-basic-single" id="location">
                            
                                                        <option value="">Seleccionar Barrio</option>

                            @foreach($locationOptions as $location)
                            
                            <?php $value= $location["latlon"]?>
                            @if(app('request')->input('nameN'))
                            <option value="{{app('request')->input('locationId')}}" selected>{{app('request')->input('nameN')}}</option>
                            @endif
                            <option value="{{$location["latlon"]}}" @if(app('request')->input('locationId')==$value) selected @endif >{{$location["name"]}}</option>
                            @endforeach
                        </select>
                        <input type="hidden" name="locationId" id="locationId" @if(app('request')->input('locationId')) value="app('request')->input('locationId')" @else value="0" @endif />
                        <hr/>
                    </div>

                    <div class="material">


                        <h5>Tipo de Operación</h5>

                        @foreach( $operations as $key=> $operation)
                        <div class="radio">
                            <label>
                                <input type="radio" onclick="searchFilter()" @if(app('request')->input('operation')==json_decode($operation)->id) checked @else  @if($key==0) checked @endif @endif name="operation"  value="{{$operation->id}}" >
                                {{$operation->name}}
                            </label>
                        </div>
                        @endforeach
                        <hr/>

                    </div>

                    <div class="material price-container">


                        <h5>Precio</h5>

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="from" class="bmd-label-floating">Desde</label>
                                    <input type="number" @if(app('request')->input('from')) value="{{app('request')->input('from')}}" @else value="{{config('country.'.Session::get('country_id'))["from"]}}" @endif class="form-control" name="from" id="from">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="to" class="bmd-label-floating" >Hasta</label>
                                    <input type="number" @if(app('request')->input('from')) value="{{app('request')->input('to')}}" @else value="{{config('country.'.Session::get('country_id'))["to"]}}" @endif   class="form-control" name="to" id="to">
                                </div>
                            </div>
                        </div>
                        <hr/>

                    </div>

                    <div class="material radius-button">


                        <h5>Ambientes</h5>

                        <button type="button" onclick="setNumberRooms('all')" class="btn btn-outline-danger @if(app('request')->input('rooms')=='all') selected-button-space @endif @if(app('request')->input('rooms')=="") selected-button-space @endif"   >Todos</button>
                        <button type="button" onclick="setNumberRooms('Monoambiente')" class="btn btn-outline-danger @if(app('request')->input('rooms')=='Monoambiente') selected-button-space @endif">Monoambiente</button>
                        <button type="button" onclick="setNumberRooms(1)" class="btn btn-outline-danger @if(app('request')->input('rooms')==1) selected-button-space @endif">1</button>
                        <button type="button" onclick="setNumberRooms(2)" class="btn btn-outline-danger @if(app('request')->input('rooms')==2) selected-button-space @endif"  >2</button>
                        <button type="button" onclick="setNumberRooms(3)" class="btn btn-outline-danger @if(app('request')->input('rooms')==3) selected-button-space @endif"  >3</button>
                        <button type="button" onclick="setNumberRooms(4)" class="btn btn-outline-danger @if(app('request')->input('rooms')==4) selected-button-space @endif"  >4</button>
                        <button type="button" onclick="setNumberRooms(5)" class="btn btn-outline-danger @if(app('request')->input('rooms')==5) selected-button-space @endif"  >5</button>
                        <button type="button" onclick="setNumberRooms(6)" class="btn btn-outline-danger @if(app('request')->input('rooms')==6) selected-button-space @endif"  >6</button>
                        <input name="rooms" id="rooms" type="hidden" @if(app('request')->input('rooms')) value="{{app('request')->input('rooms')}}" @else value="all" @endif/>
                        <hr/>

                    </div>

                    <div class="material">


                        <h5>Tipo de Propiedad</h5>

                        @foreach( $properties as $key=> $property)
                        <div class="radio">
                            <label>
                                <input type="radio" onclick="searchFilter()" @if(app('request')->input('property-type')==json_decode($property)->id) checked @else  @if($key==0) checked @endif @endif   value='{{json_decode($property)->id}}' name="property-type"    >
                                {{$property->name}} 
                            </label>
                        </div>
                        @endforeach
                        <hr/>

                    </div>
                        @if(count($features)>0)
                    <div class="material">

 
                        <h5>Características</h5>

                        @foreach( $features as $key=> $feature)
                        <div class="checkbox">
                            <label>
                                
                                <?php $features= explode(",", app('request')->input('features'));
                                
 //in_array($features, $haystack)
                                ?>
                                <input type="checkbox"   @if(in_array(json_decode($feature)->id,$features)) checked @else  @endif   value='{{json_decode($feature)->id}}' name="feature"    >
                                {{$feature->name}}
                            </label>
                        </div>
                        @endforeach
                        <input type="hidden" id="features" name="features" value="{{app('request')->input('features')}}"/>
                        <button type="button" class="btn btn-danger btn-raised red-button" onclick="searchFilter()">Seleccionar características</button>

                    </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-8 units">
            <div class="row container-filters">
                <div class="col-3 col-lg-6">
                    <button class="btn btn-warning btn-raised filter-mobile-filter"  onclick="showFilter()">Filtrar</button>
                </div>
                
               
                
                <div class="col-9 col-lg-6">
                 
                    
                    <div class="dropdown show">
                        <a style="    font-size: 12px;" class="btn btn-secondary dropdown-toggle btn-raised filter-button" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Ordenar por: @if(app('request')->input('sort')) @if(app('request')->input('sort')=='all') Nuevas @endif  @if(app('request')->input('sort')=='low') Menor Precio @endif  @if(app('request')->input('sort')=='high') Mayor Precio @endif  @endif
                        </a>

                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                          <a class="dropdown-item" href="#" onclick="addFilter('all')">Nuevas</a>
                          <a class="dropdown-item" href="#"  onclick="addFilter('low')">Menor Precio</a>
                          <a class="dropdown-item" href="#"  onclick="addFilter('high')">Mayor Precio</a>
                        </div>
                    </div>
                </div>
                <div class="col-12 mt-3 hide-mobile">
                    <a target="_blank" href="https://respaldar.com.ar/"> <img width="100%"   src="respaldar-search.gif"/></a>
                </div>
                
                 <div class="col-12 mt-3 hidedesktop">
                     <a target="_blank" href="https://respaldar.com.ar/"> <img width="100%"  src="respaldar-mobile-search.gif"/></a>
                </div>
            </div>
            @foreach ($unitsProperties as $key=> $unit)

            @if($key % 3)
             <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-lg-12 col-md-12 ">
                <ins class="adsbygoogle"
                     style="display:block"
                     data-ad-format="fluid"
                     data-ad-layout-key="-7i+db-2n-3m+q2"
                     data-ad-client="ca-pub-9292038676986573"
                     data-ad-slot="8389341002"></ins>
                <script>
                     (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
                            </div>
                             </div>
                         </div>
                  </div>
           
            @endif
            
            <a href="{{route("homeslash")}}/{{$unit->slug}}" class='link-place-list'>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-lg-5 col-md-5 thumb-image-list">
                                @if(count($unit->images)>0)
                                <img src="https://s3-sa-east-1.amazonaws.com/alquiler/images/small/{{$unit->images[0]->medium}}"/>
                                @endif
                                <p class='price'> @if(config('country.'.Session::get('country_id'))["currency"]!="€"){{config('country.'.Session::get('country_id'))["currency"]}}@endif {{number_format($unit->price)}} @if(config('country.'.Session::get('country_id'))["currency"]=="€"){{config('country.'.Session::get('country_id'))["currency"]}}@endif</p>
                            </div>
                            <div class="col-12 col-lg-7 col-md-7 ">
                                <div class='description-place'>
                                    <h5>{{ucfirst(strtolower($unit->title))}}</h5>
                                    <p>{{$unit->street_name}}  @if($unit->street_number!="0"){{$unit->street_number}}@endif</p>
                                    <p class="description d-none d-sm-none  d-sm-block ">{!! Str::limit(ucfirst(strtolower(strip_tags($unit->information))), 160, '...') !!}</p>
                                    <p class="description d-lg-none d-md-none  d-xl-block  ">{!! Str::limit(ucfirst(strtolower(strip_tags($unit->information))), 100, '...') !!}</p>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            @endforeach
            
            @if(count($all)>0)
            
            <p>Encontramos {{$unitsProperties->count()}} propiedades con tu búsqueda, También te mostramos las últimas propiedades agregadas en otros barrios </p>
            @endif
            @foreach ($all as $unit)

            <a href="{{route("homeslash")}}/{{$unit->slug}}" class='link-place-list'>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-lg-5 col-md-5 thumb-image-list">
                                @if(count($unit->images)>0)
                                <img src="https://s3-sa-east-1.amazonaws.com/alquiler/images/small/{{$unit->images[0]->medium}}"/>
                                @endif
                                <p class='price'>$ {{number_format($unit->price)}}</p>
                            </div>
                            <div class="col-12 col-lg-7 col-md-7 ">
                                <div class='description-place'>
                                    <h5>{{ucfirst(strtolower($unit->title))}}</h5>
                                    <p>{{$unit->street_name}}  @if($unit->street_number!="0"){{$unit->street_number}}@endif</p>
                                    <p class="description d-none d-sm-none  d-sm-block ">{!!Str::limit(ucfirst(strtolower(strip_tags($unit->information))), 160, '...') !!}</p>
                                    <p class="description d-lg-none d-md-none  d-xl-block  ">{!!Str::limit(ucfirst(strtolower(strip_tags($unit->information))), 100, '...') !!}</p>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            @endforeach
            
            @if(count($all)==0)
                {{$unitsProperties->links()}}
            @else
                {{$all->links()}}
            @endif
        </div>
    </div>
</div>
@endsection
