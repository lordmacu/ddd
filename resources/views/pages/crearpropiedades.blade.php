@extends('app')

@section('title')
Ingresar a Alquiler Directo| @parent
@stop
@section('meta')
<meta name="description" content="Con mas de 300.000 visitas mensuales y un grupo de Facebook de mas de 20 mil usuarios, Alquiler Directo es la mejor opción para publicar tu propiedad ." />
<meta property="og:description"        content="Con mas de 300.000 visitas mensuales y un grupo de Facebook de mas de 20 mil usuarios, Alquiler Directo es la mejor opción para publicar tu propiedad ." />
<meta property="og:image" content="https://s3.amazonaws.com/meetworks/crear.png" />

@stop


@section('scripts')
<link href="fine-uploader/fine-uploader-new.css" rel="stylesheet">
<script src="fine-uploader/jquery.fine-uploader.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.18.0/trumbowyg.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.18.0/ui/trumbowyg.min.css">

<script type="text/template" id="qq-template-gallery">
    <div class="qq-uploader-selector qq-uploader qq-gallery" qq-drop-area-text="Arrastra las imágenes aquí">
    <div class="qq-total-progress-bar-container-selector qq-total-progress-bar-container">
    <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-total-progress-bar-selector qq-progress-bar qq-total-progress-bar"></div>
    </div>
    <div class="qq-upload-drop-area-selector qq-upload-drop-area" qq-hide-dropzone>
    <span class="qq-upload-drop-area-text-selector"></span>
    </div>
    <div class="qq-upload-button-selector qq-upload-button">
    <div>Seleccionar las imágenes</div>
    </div>
    <span class="qq-drop-processing-selector qq-drop-processing">
    <span>Procesando las imágenes</span>
    <span class="qq-drop-processing-spinner-selector qq-drop-processing-spinner"></span>
    </span>
    <ul class="qq-upload-list-selector qq-upload-list row" role="region" aria-live="polite" aria-relevant="additions removals">
    <li class="col-12 col-lg-4 col-md-4 col-sm-4">
    <span role="status" class="qq-upload-status-text-selector qq-upload-status-text"></span>
    <div class="qq-progress-bar-container-selector qq-progress-bar-container">
    <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-progress-bar-selector qq-progress-bar"></div>
    </div>
    <span class="qq-upload-spinner-selector qq-upload-spinner"></span>
    <div class="qq-thumbnail-wrapper">
    <img class="qq-thumbnail-selector" qq-max-size="120" qq-server-scale>
    </div>
    <button type="button" class="qq-upload-cancel-selector qq-upload-cancel btn btn-danger btn-raised btn-sm">X</button>
    <button type="button" class="qq-upload-retry-selector qq-upload-retry  btn btn-warning btn-raised btn-sm">
    <i class="fas fa-redo-alt"></i>
    Reintentar
    </button>

    <div class="qq-file-info">
    <div class="qq-file-name">
    <span class="qq-upload-file-selector qq-upload-file"></span>
    <span class="qq-edit-filename-icon-selector qq-edit-filename-icon" aria-label="Edit filename"></span>
    </div>
    <input class="qq-edit-filename-selector qq-edit-filename" tabindex="0" type="text">
    <span class="qq-upload-size-selector qq-upload-size"></span>
    <button type="button" class="qq-btn qq-upload-delete-selector qq-upload-delete">
    <span class="qq-btn qq-delete-icon" aria-label="Delete"></span>
    </button>
    <button type="button" class="qq-btn qq-upload-pause-selector qq-upload-pause">
    <span class="qq-btn qq-pause-icon" aria-label="Pause"></span>
    </button>
    <button type="button" class="qq-btn qq-upload-continue-selector qq-upload-continue">
    <span class="qq-btn qq-continue-icon" aria-label="Continue"></span>
    </button>
    </div>
    </li>
    </ul>

    <dialog class="qq-alert-dialog-selector">
    <div class="qq-dialog-message-selector"></div>
    <div class="qq-dialog-buttons">
    <button type="button" class="qq-cancel-button-selector">Cerrar</button>
    </div>
    </dialog>

    <dialog class="qq-confirm-dialog-selector">
    <div class="qq-dialog-message-selector"></div>
    <div class="qq-dialog-buttons">
    <button type="button" class="qq-cancel-button-selector">No</button>
    <button type="button" class="qq-ok-button-selector">Si</button>
    </div>
    </dialog>

    <dialog class="qq-prompt-dialog-selector">
    <div class="qq-dialog-message-selector"></div>
    <input type="text">
    <div class="qq-dialog-buttons">
    <button type="button" class="qq-cancel-button-selector">Cancelar</button>
    <button type="button" class="qq-ok-button-selector">Ok</button>
    </div>
    </dialog>
    </div>
</script>

<script>

    var imagesProperty = [];
    $('#fine-uploader-gallery').fineUploader({
        template: 'qq-template-gallery',
        request: {
            endpoint: '{{route("file-upload")}}',
            customHeaders: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        },
        callbacks: {

            onComplete: function (id, text, response, xhr) {
                imagesProperty.push(response.newUuid);
            }
        },
        thumbnails: {
            placeholders: {
                waitingPath: 'fine-uploader/placeholders/waiting-generic.png',
                notAvailablePath: 'fine-uploader/placeholders/not_available-generic.png'
            }
        },
        validation: {
            allowedExtensions: ['jpeg', 'jpg', 'gif', 'png']
        }
    });
    
    $('.trumbowyg-demo').trumbowyg({
     tagsToRemove: ['script', 'link'],
    btns: [
        ['strong', 'em',],
        ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],['unorderedList', 'orderedList']
    ],
        autogrow: true
    });

function finishcreationPost(data){
    
    $.ajax({
          url: '{{route("publicarPropiedadPost")}}',
          type: 'POST',
          data:data, 
          success: function(data) {
              window.location='{{route("homeslash")}}/'+data;
          },
          
          error: function(e) {
                //called when there is an error
                //console.log(e.message);
                
          }
        });
}



</script>

@stop
@section('content')
<style>
    .qq-upload-cancel-selector{
        font-size: 9px !important;
        margin: 0px !important;
        padding-left: 10px !important;
        padding-right: 10px !important;
        padding-bottom: 5px !important;
        padding-top: 5px !important;
    }
    
    
     .qq-thumbnail-selector{
        margin: 0px;
                width: 100% !important

    }
    .qq-upload-retry-selector{
        font-size: 9px !important;
        margin: 0px !important;
        padding-left: 10px !important;
        padding-right: 10px !important;
        padding-bottom: 5px !important;
        padding-top: 5px !important;
    }
   

    .qq-upload-file{
        margin-top: 5px;
        width: auto !important
    }
    .qq-upload-size{
        font-size: 11px;
        color: gray;
    }
    .fa-search{
     margin-right: 10px   
    }
    
    .pull-right{
        float: right
    }
    
    .title-creator{
        margin-bottom: 30px;
        margin-top: 30px
    }
</style>


<div class="container">
    <div class="row">
        <div class="col-12 title-creator">
            <h3>Publica tu propiedad</h3>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row step-one">
                <div class="col-12 col-lg-7">
                    <div class="row">
                        <div class="col-6">
                             <div class="form-group">
                        <label for="property-type" class="bmd-label-floating">¿Que tipo de propiedad quieres publicar?</label>
                        <select class="form-control" id="property-type">
                            @foreach($propertyTypes as $types)
                            <option value="{{$types->id}}">{{$types->name}}</option>
                            @endforeach

                        </select>
                    </div>
                        </div>
                        <div class="col-3">
                             <div class="form-group">
                        <label for="operation" class="bmd-label-floating">¿Vender o {{config('country.'.Session::get('country_id'))["rent_name"]}}?</label>
                        <select class="form-control" id="operation">
                            <option value="1" >{{config('country.'.Session::get('country_id'))["rent_name"]}}</option>
                            <option value="2" >Vender</option>
                        </select>
                        <input type="hidden" id="latitude"/>
                        <input type="hidden" id="longitude"/>
                    </div>
                        </div>
                        <div class="col-3">
                             <div class="form-group">
                        <label for="operation" class="bmd-label-floating">Anunciante</label>
                        <select class="form-control" id="owner-type">
                            <option value="2" >Dueño Directo</option>
                            <option value="1" >Inmobiliaria</option>
                        </select>
                    </div>
                        </div>
                    </div>
                     


                    <div class="form-group" id="complete-direction">
                        <label for="input-address-create" >¿En que dirección esta tu propiedad?</label>
                        <div class="input-group search-navbar">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
                            </div>
                            <input type="text" id="input-address-create" onfocusout="hideAutocomplete()" onfocus="showAutocomplete()" class="form-control white-input" placeholder="Escribe la dirección de la proiedad" aria-label="Escribe la dirección de la proiedad" aria-describedby="basic-addon2">
                        </div>
                        <br/>
                        <button onclick="nextStepAddress()" class="btn btn-success  btn-raised">Siguiente</button>
                        <div id="error-location-message" style="display:none">

                            <br/>

                            <div class="alert alert-danger" role="alert">
                                <p >No encontramos la dirección automaticamente por favor:</p>
                                <a class="btn btn-raised btn-danger" href="javascript:showFormLocation()" >Ingresar Manualmente</a>

                            </div>
                            <hr/>
                        </div>


                    </div>



                    <div class="complete-information-direction"  style="display:none">
                        <div class="form-group">
                            <label for="input-address-create" >¿En que barrio esta tu propiedad?</label>
                            <div class="input-group search-navbar">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
                                </div>
                                <input type="text" id="input-address-create-neighborhood" onfocusout="hideAutocomplete()" onfocus="showAutocomplete()" class="form-control white-input" placeholder="Escribe el nombre del barrio" aria-label="Escribe el nombre del barrio" aria-describedby="basic-addon2">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-8">
                                <div class="form-group">
                                    <label for="street_name" class="bmd-label-floating">¿Cual es el nombre de la calle?</label>
                                    <input type="text" id="street_name" class='form-control' />
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="street_number" class="bmd-label-floating">¿Cual es el número?</label>
                                    <input id="street_number" type="text" class='form-control' />
                                    <input id="neighborhood" type="hidden" class='form-control' />
                                    <input id="city" type="hidden" class='form-control' />
                                </div>
                            </div>
                        </div>
                        <button onclick="nextStepAddressManually()" class="btn btn-success  btn-raised pull-right">Siguiente</button>

                    </div>








                </div>  
                <div class="col-12 col-lg-5">
                    <div class="alert alert-danger " id="step-one-helper-error" role="alert" style="display:none">

                    </div>
                    <div class="alert alert-secondary" id="step-one-helper" role="alert">
                        <i class="fas fa-info-circle"></i>  La <b>dirección</b> es un paso muy importante para <b>nosotros</b>, por favor escribirla lo mas <b>completa</b> posible, 
                        las personas que ven tu propiedad quieren saber en <b>donde esta tu propiedad</b>.
                    </div>


                </div>
            </div>
            <div class="row step-two" style="display:none">
                <div class="col-8">
                    <div id="fine-uploader-gallery"></div>

                    <hr/>
                    <div class="row">
                        <div class="col-6">
                            <button onclick="prevValidationImage()" class="btn btn-success  btn-raised">Atras</button>
                        </div> 
                        <div class="col-6">
                            <button onclick="nextValidationImage()" class="btn btn-success  btn-raised pull-right">Siguiente</button>
                        </div> 
                        </div>
                </div>
                <div class="col-4">

                    <div class="alert alert-danger " id="step-two-helper-error" role="alert" style="display:none">

                    </div>
                    <div class="alert alert-secondary" id="step-one-helper" role="alert">
                        <i class="fas fa-info-circle"></i> Todo entra por los ojos... <br/> 
                        <ul>
                            <li>Tratá de que tu propiedad se vea por dentro y por fuera: desde dormitorios hasta jardines.</li>
                            <li>Sacá tus fotos derechas así son más fáciles de ver.</li>
                            <li>Aprovechá la luz natural, ¡las fotos salen mucho mejor!</li>
                        </ul>







                    </div>


                </div>
            </div>

            <div class="row step-three" style="display:none">
                <div class="col-8">
                    <div class="form-group">
                        <label for="title" class="bmd-label-floating">Escribe un buen título para tu publicación</label>
                        <input type="text" id="title" class='form-control' />
                    </div>
                    @if(Auth::user()->id==12155 || Auth::user()->id==27023 || Auth::user()->id==30614 || Auth::user()->id==32330 || Auth::user()->id==37884 || Auth::user()->id==38014    )
                    <div class="form-group">
                        <label for="title" class="bmd-label-floating">Url de Facebook</label>
                        <input type="text" id="facebook_url" class='form-control' value="http://m.me/usuario" />
                    </div>
                    @endif
                    
                    <div class="form-group">
                        <label for="description"  >Escribe una descripción clara de tu propiedad</label>
                        <textarea  class='form-control' rows="10" id="description"></textarea>
                    </div>

                    <div class="row">
                        <div class="col-2">
                            <div class="form-group">
                                <select class="form-control" id="currency">
                                    <option value="peso">$</option>
                                    <option value="dolar">Usd</option>
                                </select>
                            </div>   
                        </div>  
                        <div class="col-5">
                            <div class="form-group">
                                <label for="price" class="bmd-label-floating">Escribe el precio</label>
                                <input type="number" id="price" class='form-control' />
                            </div>   
                        </div> 
                        <div class="col-5">
                            <div class="form-group">
                                <label for="number_of_rooms" class="bmd-label-floating">Cantidad de Habitaciones</label>
                                <select class="form-control" id="number_of_rooms">
                                    <option value="Monoambiente">Monoambiente</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                </select>
                            </div>   
                        </div> 
                        
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <hr/>
                            <h5>Servicios</h5>
                            <br/>
                        </div>
                            
                        @foreach( $services as $key=> $feature)
                        <div class="col-6 col-lg-3  col-md-3 col-sm-6">
                        <div class="checkbox">
                            <label>
                                
                                
                                <input type="checkbox"  value='{{$feature->id}}' name="feature"    >
                                {{$feature->name}}
                            </label>
                        </div>
                         </div>
                        @endforeach
                        <input type="hidden" id="features" name="features" value="{{app('request')->input('features')}}"/>
                       
                    </div>
                     <hr/>
                        <div class="row">
                            <div class="col-6">
                                <button onclick="prevValidationDescription()" class="btn btn-success  btn-raised">Atras</button>
                            </div> 
                            <div class="col-6">
                                <button onclick="nextValidationDescription()" class="btn btn-success  btn-raised pull-right">Siguiente</button>
                            </div> 
                        </div>
                </div>
                <div class="col-4">

                    <div class="alert alert-danger " id="step-three-helper-error" role="alert" style="display:none">

                    </div>
                    <div class="alert alert-secondary" id="step-one-helper" role="alert">
                        <i class="fas fa-info-circle"></i> 

                        <p>Un título llamativo atraerá más visitas</p>
                        <p>Los usuarios van a interesarse más por tu propiedad si destacás sus características principales en el título.</p>

                        <p>Ideas breves pero fuertes</p>
                        <p>Elegí las características principales que la destaquen del resto.</p>

                    </div>


                </div>
            </div>
            
            <div class="row step-four" style="display:none">
                <div class="col-8">
                    <div class="form-group">
                        <label for="email" class="bmd-label-floating">Email de contacto</label>
                        <input type="text" id="owner-name" class='form-control' value="{{Auth::user()->name}}" />
                    </div>
                    <div class="form-group">
                        <label for="email" class="bmd-label-floating">Email de contacto</label>
                        <input type="text" id="email" class='form-control' value="{{Auth::user()->alternative_mail}}" />
                    </div>
                    <div class="form-group">
                        <label for="title" class="bmd-label-floating">Celular / Teléfono de contacto</label>
                        <input type="text" id="phone" class='form-control' />
                    </div>

                    
                     <hr/>
                        <div class="row">
                            <div class="col-6">
                                <button onclick="prevfinishcreation()" class="btn btn-success  btn-raised">Atras</button>
                            </div> 
                            <div class="col-6">
                                <button onclick="finishcreation()" class="btn btn-success  btn-raised pull-right">Siguiente</button>
                            </div> 
                        </div>
                </div>
                <div class="col-4">

                    <div class="alert alert-danger " id="step-three-helper-error" role="alert" style="display:none">

                    </div>
                    <div class="alert alert-secondary" id="step-one-helper" role="alert">
                        <h3>Datos de contacto</h3>
                        <p><b>Ahora vamos con el último paso:</b></p>
                        <p>Escribe el correo electrónico en donde las personas te contactarán</p>
                        <p>Intenta poner un número de celular</p>


                    </div>


                </div>
            </div>
        </div>
    </div>
</div>
@stop