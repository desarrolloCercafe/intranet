@extends('template.auth')
@section('content')
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <title>Rescue Password</title>
  <div class="banner img-responsive">
    <div class="limiter">
      <div class="container-login100">
        <div class="wrap-login100">
          <div class="panel-heading" style="background: rgba(223, 1, 1,0.7); border-color: #D81819;">
            <div class="panel-title" style="color: #ffffff; float:right; position: relative; top:20px; font-size: 20px; left: -10px;">
              <strong>Recuperar</strong>
              <br>
              <strong>Contraseña</strong>
            </div>
            {!!Html::image('logocercafe.png', 'logo' ,['class' => 'img-responsive logo'])!!}
           </div>
    
            <form class="login100-form validate-form" role="form" method="POST" action="{{ url('/password/reset') }}">
                {{ csrf_field() }}
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="wrap-input100 validate-input m-b-18" data-validate = "Correo es necesario">
                    <span class="label-input100"><strong style="color: black;">Email</strong></span>
                    <input id="email" type="email" class="input100" name="email" value="{{ $email or old('email') }}">
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                    <span class="focus-input100"></span>               
                </div>

                <div class="wrap-input100 validate-input m-b-18{{ $errors->has('password') ? ' has-error' : '' }}" data-validate = "Contraseña Requerida">
                    <span class="label-input100"><strong style="color: black;">Contraseña</strong></span>
                    <input id="password" type="password" class="input100" name="password">
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                    <span class="focus-input100"></span>
                </div>

                <div class="wrap-input100 validate-input m-b-18{{ $errors->has('password_confirmation') ? ' has-error' : '' }}" data-validate = "Confirmar Contraseña">
                    <span class="label-input100"><strong style="color: black;">Confirmar Contraseña</strong></span>
                      <input id="password-confirm" type="password" class="input100" name="password_confirmation">
                      @if ($errors->has('password_confirmation'))
                          <span class="help-block">
                              <strong>{{ $errors->first('password_confirmation') }}</strong>
                          </span>
                      @endif
                    <span class="focus-input100"></span>
                </div>


                <div class="container-login100-form-btn"> 
                   {!!Form::submit('Reestablecer Contraseña', array('class'=>'login100-form-btn'))!!} 
                </div>
                <div>
                    <a href="/intranetcercafe" class="btn pull-right">
                        <strong>Cancelar</strong>
                    </a>
                </div> 
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection