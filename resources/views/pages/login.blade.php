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

<script>
    var registerUserUrl = "{{route('registerUserUrl')}}";

    var checkUserUrl = "{{route('checkUserUrl')}}";


</script>
{{ Html::script('js/logincrearpropiedad.js') }}

@stop
@section('content')
<style type="text/css">
    .submit-property {
        padding: 20px 0;
    }
</style>



<div class="submit-property">
    <div class="container">

        <div class="col-md-6 offset-md-3">


            @if(!Session::has('userAuth'))
            <div class="modal-body modal-login">
                        <h4 class="text-center title-modal">Ingresa o Registrate en Alquiler Directo</h4>
                        <a class="btn-block btn btn-primary btn-raised facebook-color" href="/redirectToProviderFacebook"><i class="fab fa-facebook-f" aria-hidden="true"></i> Continuar con Facebook<div class="ripple-container"></div></a>
                        <a class=" btn-block btn btn-primary btn-raised google-color" href="/redirectToProviderGoogle"><i class="fab fa-google" aria-hidden="true"></i> Continuar con Google</a>
            </div>
            @endif
            @if(Session::has('userAuth'))

            <div class="card">
                <div class="card-body">
                    <div class="row">


                        <div class="col-12">
                            <h2 class="text-center">Confirmación de registro</h2>
                            <hr/>






                            <form method="post" action="{{route('registerUserUrl')}}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">



                                <div class="form-group">
                                    <label for="exampleInputEmail1">Correo Electrónico</label>
                                    <input type="email" name="alternativeemail" required="required" value="" class="form-control" id="email" placeholder="Ingresa tu correo electrónico">
                                    <input type="hidden" required="required" name="email" value="{{$dataregister["email"]}}"    >
                                    <input type="hidden" required="required" name="id_source" value="{{$dataregister["id"]}}"    >
                                    <input type="hidden" required="required" name="nickname" value="{{$dataregister["nickname"]}}"    >
                                    
                                    <small class="text-muted">Este es el correo que utilizarás y al que te enviaremos el contacto del dueño o de la persona que quiera {{config('country.'.Session::get('country_id'))["rent_name"]}}.</small>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Nombre y Apellido</label>
                                    <input type="text" required="required" name="name" value="{{$dataregister["name"]}}" class="form-control" id="name" placeholder="Ingresa tu nombre y apellido">
                                    <small class="text-muted">Este es el nombre que aparecerá en tu perfil.</small>
                                </div>

                               <!-- <div class="form-group">
                                    <select name="user_type" required="required" class="form-control user_type">
                                        <option value="">Mi Profesión es.</option>
                                        <option value="1">Emprendedor</option>
                                        <option value="2">Freelancer</option>
                                        <option value="3">Estudiante</option>
                                        <option value="4">Corredor Inmobiliario</option>
                                        <option value="5">Otro</option>
                                    </select>
                                </div>-->
                               <input type="hidden"  name="user_type" value="1"/>

                                <div class="checkbox">
                                    <input type="checkbox" checked="true" name="meetwork"> Quiero asociar mi cuenta con <a href="https://meetwork.co">MeetWork</a>.

                                </div>
                                <hr/>
                                <button type="submit" style='float: right;'   class="btn btn-lg pull-right button-theme btn-raised btn-success">Siguiente</button>

                            </form>

                        </div>


                    </div>
                </div>
            </div>

            @endif
        </div>
    </div>
</div>

@stop