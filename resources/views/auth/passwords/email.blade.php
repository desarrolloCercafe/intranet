@extends('template.auth')
@section('content')
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <title>Reestablecer Contraseña</title>
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
    
           <form class="login100-form validate-form" role="form" method="POST" action="{{ url('/password/email') }}">
                {{ csrf_field() }} 
                <div class="wrap-input100 validate-input m-b-18" data-validate = "Correo es necesario">
                      <span class="label-input100">Email</span>
                        <input id="email" type="email" class="input100" name="email" value="{{ old('email') }}">
                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif 
                      <span class="focus-input100"></span>
                </div>
                <div class="container-login100-form-btn">
                    {!!Form::submit('Enviar Link', array('class'=>'login100-form-btn'))!!} 
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