@extends('template.auth')
@section('content')
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>Login</title>
    @if ($errors->has('token_error')) 
        {{ $errors->first('token_error') }} 
    @endif
    <div class="banner">
        <div class="limiter">
            <div class="container-login100">
                {{-- {!!Html::image('css_auth/images/mins/_DSC9022-HDR-1-min-min.jpg', 'fondo' ,['class' => 'img-responsive tamaño'])!!} --}}
                <div class="wrap-login100">
                    <div class="panel-heading" style="background: rgba(223, 1, 1,0.7); border-color: #DF0101;">
                        <div class="panel-title" style="color: #ffffff; float:right; position: relative; top:20px; font-size: 20px; left: -10px;">
                            <strong>Intranet</strong>
                        </div> 
                        @include('flash::message')
                        {!!Html::image('logocercafe.png', 'logo' ,['class' => 'img-responsive logo'])!!}
                     </div>
        
                    {!!Form::open(['route'=> 'log.store', 'method'=>'POST', 'class' => 'login100-form validate-form'])!!}
                        <input type="hidden" name="_token" class="form-control" value="{{ csrf_token() }}">
                        <div class="wrap-input100 validate-input m-b-26" data-validate="Usuario Requerido">
                            <span class="label-input100"><strong style="color: black;">Usuario</strong></span>
                            {!!Form::text('name', null, ['class'=>'input100', 'required','autofocus'])!!}
                            <span class="focus-input100"></span>
                        </div>
        
                        <div class="wrap-input100 validate-input m-b-18" data-validate = "Contraseña Requerida">
                            <span class="label-input100"><strong style="color: black;">Contraseña</strong></span>
                            {!!Form::password('password', ['class'=>'input100', 'required'])!!}
                            <span class="focus-input100"></span>
                        </div>
        
                        <div class="flex-sb-m w-full p-b-30">
                            <div>
                                <a href="password/email" onClick="$('#loginbox').hide(); $('#signupbox').show()" class="txt1">
                                    <strong style="color: black">¿Olvido su Contraseña?</strong>
                                </a> 
                            </div>
                        </div>
        
                        <div class="container-login100-form-btn">
                            {!!Form::submit('Ingresar', array('class'=>'login100-form-btn'))!!}
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection