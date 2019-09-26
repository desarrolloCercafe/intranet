@extends('template.plantilla')
@section('content')
    <title>Perfil | Cercafe</title> 
    <div class="row">
      <div class="col-lg-15" align="center">
        <h1>Informacion del Usuario</h1>
      </div>
      <div class="panel-body">
        <div class="row">
          <div class="col-lg-6 col-md-6 col-xs-12" align="center">
            {{Html::image('media/img/user.png', 'perfil', array('class' => 'lo', 'width' => '256px', 'height' => '256px'))}}
            <br>
            <br>
          </div>
          <div class="col-lg-5 col-md-5 col-xs-12">
            <table class="table table-responsive">
              <tbody>
                <tr>
                  <td><strong>Nombres:</strong></td>
                  <td>{{Auth::User()->nombre_completo}}</td>
                </tr>
                <tr>
                  <td><strong>Documento:</strong></td>
                  <td>{{Auth::User()->documento}}</td>
                </tr>
                <tr>
                  <td><strong>Telefono:</strong></td>
                  <td>{{Auth::User()->telefono}}</td>
                </tr>
                <tr>
                  <td><strong>Email:</strong></td>
                  <td><a href="mailto:info@support.com">{{Auth::User()->email}}</a></td>
                </tr>
              </tbody>
            </table>
            <a href="javascript:history.go(-1);" type="button" class="btn btn-primary btn-md">Regresar</a>
          </div>
        </div>
      </div>
  </div>	
@endsection