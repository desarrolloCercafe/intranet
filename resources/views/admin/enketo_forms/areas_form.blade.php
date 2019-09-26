@extends('templates_enketo.enketo_base')
@section('contenedor')
	<title>Areas | Form</title>

	<style>
		section > .container{
			display: none !important;
		}

		section > .row{
			display: none !important;
		}

		#services{
			display: none !important;
		}
	</style>

	<section id="services" class="home-section bg-white">
	    <div class="container">
	      	<div class="row">
		        <div class="col-md-offset-2 col-md-12">
		          	<div class="section-heading">
			            <h2>Areas</h2>
			            <p>Selecciona el Area de trabajo a la que pertences para acceder a los formatos solicitados</p>
		          	</div>
		        </div>
	      	</div>
	    </div>
    	@if(Auth::user()->rol_id == 1 || Auth::user()->rol_id == 7)
    		<div class="row">
    			<div class="container">
		        	@foreach($areas as $key => $area)
		        		@if($key == 0)
							<div class="card-deck">
								<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
					    			<a href="{{ route('admin.enketoformscategories.show', $area->id) }}" style="text-decoration:none;">
					    				<div class="card border-theme mb-3" style="max-width: 30rem; background: #FA166D;">
											<div class="card-header">
												<i class="fa {{$area->descripcion_area}} fa-2x" style="color: #ffffff;"></i>
												<h5 class="card-title" style="color: #ffffff;"> {{$area->nombre_area}}</h5>
											</div>
										</div>
									</a>
						    	</div>
						@elseif($key == 3)
							</div>
							<div class="card-deck">
								<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
					    			<a href="{{ route('admin.enketoformscategories.show', $area->id) }}" style="text-decoration:none;">
					    				<div class="card border-theme mb-3" style="max-width: 30rem; background: #FA166D;">
											<div class="card-header">
												<i class="fa {{$area->descripcion_area}} fa-2x" style="color: #ffffff;"></i>
												<h5 class="card-title" style="color: #ffffff;"> {{$area->nombre_area}}</h5>
											</div>
										</div>
									</a>
						    	</div>
						@elseif($key == 12)
							</div>
							<div class="card-deck">
								<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
					    			<a href="{{ route('admin.enketoformscategories.show', $area->id) }}" style="text-decoration:none;">
					    				<div class="card border-theme mb-3" style="max-width: 30rem; background: #FA166D;">
											<div class="card-header">
												<i class="fa {{$area->descripcion_area}} fa-2x" style="color: #ffffff;"></i>
												<h5 class="card-title" style="color: #ffffff;"> {{$area->nombre_area}}</h5>
											</div>
										</div>
									</a>
						    	</div>
						    </div>
						@else
							<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
				    			<a href="{{ route('admin.enketoformscategories.show', $area->id) }}" style="text-decoration:none;">
				    				<div class="card border-theme mb-3" style="max-width: 30rem; background: #FA166D;">
										<div class="card-header">
											<i class="fa {{$area->descripcion_area}} fa-2x" style="color: #ffffff;"></i>
											<h5 class="card-title" style="color: #ffffff;"> {{$area->nombre_area}}</h5>
										</div>
									</div>
								</a>
					    	</div>
		        		@endif
		        	@endforeach
		       	</div>
			</div>
        @else
			@foreach($areas as $area)
				@if($area->id == Auth::user()->area_id || $area->id == 8)
					<div class="col-md-offset-2 col-md-12">
		    			<a href="{{ route('admin.enketoformscategories.show', $area->id) }}" style="text-decoration:none;">
		    				<div class="card border-theme mb-3" style="max-width: 30rem; background: #FA166D; margin: 0 auto; float: none; margin-bottom: 10px;">
								<div class="card-header">
									<i class="fa {{$area->descripcion_area}} fa-2x" style="color: #ffffff;"></i>
									<h5 class="card-title" style="color: #ffffff;"> {{$area->nombre_area}}</h5>
								</div>
							</div>
						</a>
			    	</div>
			    @endif
			@endforeach
        @endif
	</section>
@endsection