@extends('template.plantilla')
@section('content')
	<title> Ingresar Procesos | Cercafe</title> 
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
	<div class="container-fluid col-md-12">
		<h2><i class="lnr lnr-calendar-full"></i> <strong style=" color: #df0101;">Procesos Registrables:</strong></h2>
        <p>Los siguientes botones permiten registrar la informacion correspondiente para controller de todos los procesos realizados semanalmente en sus granjas. <strong>Ingrese los datos correspondientes: </strong></p>

		<div class="col-xs-12 col-md-4 ">
			<div class="thumbnail">
				<a href="{{ route('admin.precebos.create') }}" data-toggle="tooltip" data-placement="top" title="Precebo">{{Html::image('media/img/precebo2.0.jpg', 'im_precebo')}}</a>
				<div class="caption">
					<center>
						<button id="accion" class="btn btn-success"><i class="fa fa-plus"></i></button>
						<button id="esconder1" class="btn btn-danger" > <i class="fa fa-minus"></i></button>
					</center> 
					<div id="text" align="center"> 
						Esta etapa va desde el destete con un peso de 6 a 7 kg, hasta alcanzar los 30 kg de peso promedio.
						<br><br>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xs-12 col-md-4 ">
			<div class="thumbnail">
				<a href="{{ route('admin.cebas.create') }}" data-toggle="tooltip" data-placement="top" title="Ceba">{{Html::image('media/img/ceba2.0.jpg', 'im_ceba')}}</a>
				<div class="caption">
					<center>
						<button id="accion2" class="btn btn-success btn-group btn-group-xs"><i class="fa fa-plus"></i></button>
						<button id="esconder2" class="btn btn-danger btn-group btn-group-xs" aria-hidden="true"> <i class="fa fa-minus"></i></button>
					</center> 
					<div id="text2" align="center">
						Los cerdos inician esta etapa con 30 kg de peso promedio y termina con un peso aproximado de 110 kg con 150 dias de edad. 
						<br><br>
					</div>
				</div>
			</div>
		</div>
		<div class=" col-xs-12 col-md-4 ">
			<div class="thumbnail">
				<a href="{{ route('admin.desteteFinalizacion.create') }}" data-toggle="tooltip" data-placement="top" title="Destete Finalizacion">{{Html::image('media/img/destete2.0.jpg', 'im_destete_finalizacion')}}</a>
				<div class="caption">
					<center>
						<button id="accion3" class="btn btn-success"><i class="fa fa-plus"></i></button>
						<button id="esconder3" class="btn btn-danger" aria-hidden="true"> <i class="fa fa-minus"></i></button>
					</center> 
					<div id="text3" align="center">
						Es el periodo comprendido entre los 21 o 28 dias y los 150 dias de edad. Abarca todo el proceso de engorde a partir del destete. 
						<br><br>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="container-fluid col-md-12">
		<div class="col-xs-12 col-md-6">
			<div class="thumbnail">
				<a href="{{ route('admin.reporteMortalidad.create') }}" data-toggle="tooltip" data-placement="top" title="Mortalidad Precebo Ceba">{{Html::image('media/img/mortalidad2.0.jpg', 'im_mortalidad')}}</a>
				<div class="caption">
					<center>
						<button id="accion4" class="btn btn-success"><i class="fa fa-plus"></i></button>
						<button id="esconder4" class="btn btn-danger" aria-hidden="true"><i class="fa fa-minus"></i></button>
					</center> 
					<div id="text4" align="center">
						Contabilización de cerdos muertos en las etapas de precebo y ceba, indicando la causa de muerte
						<br><br>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xs-12 col-md-6">
			<div class="thumbnail">
				<a href="{{ route('admin.destetosSemana.create') }}" data-toggle="tooltip" data-placement="top" title="Destete Semana">{{Html::image('media/img/semana2.0.jpg', 'im_destete')}}</a>
				<div class="caption">
					<center>
						<button id="accion5" class="btn btn-success"><i class="fa fa-plus"></i> </button>
						<button id="esconder5" class="btn btn-danger" aria-hidden="true"><i class="fa fa-minus"></i> </button>
					</center> 
					<div id="text5" align="center">
						El destete es el período en el que los lechones dejan definitivamente la alimentación basada en la leche materna. Los lechones se retiran al mismo tiempo entre 21 días y 28 días de edad. 
						<br><br>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection