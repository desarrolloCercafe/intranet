@extends('template.auth')
@section('content')
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <title>Solicitar Contraseña</title>
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
    
          {!!Form::open(['route'=> '/intranetcercafe/public/password/email', 'method'=>'POST', 'class' => 'login100-form validate-form'])!!}
            <div class="wrap-input100 validate-input m-b-18" data-validate = "Correo es necesario">
              <span class="label-input100">Email</span>
                {!!Form::email('correo_emisor',null, ['class'=>'input100', 'required'])!!} 
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
          {!! Form::close() !!} 
          <div class="container">
            <strong><p>El lapso de tiempo para dar respuesta a su solicitud: 24Hrs.en caso de NO recibir respuesta, comuniquese a la extensión 117 de la Sede Administrativa o contactar con personal del area de Sistemas...</p></strong>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection