<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="content-type" charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
    {{-- {!!Html::style('tabla/bootstrap.min.css')!!} --}}
    <title>Informe DE precebo</title>
  </head>
  <body>

    <div class="container-fluid">
      <div class="row">
        @yield('contenido')
      </div>
    </div>
  </body>
</html>
