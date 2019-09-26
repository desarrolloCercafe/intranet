@extends('templates_enketo.enketo_base')
@section('contenedor')
	<title>Macros | Form</title>
	<input type="hidden" id="area_seleccionada" value="{{$area_select}}">
	<section id="works" class="home-section bg-gray">
		<div class="container">
			<div class="card-deck">
				@foreach($macros_seleccionados as $macro)
					<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
						<a href="{{ route('admin.enketoformscategories.edit', $macro["id_macro"]) }}"  style="text-decoration:none;">
					      	<div class="card mb-3 text-white bg-success service-box wow bounceInDown" style="max-width: 30rem;" data-wow-delay="0.1s">
								<div class="card-header">
									<i class="fa fa-archive fa-2x" style="color: #ffffff;"></i>
									<span style="display:block;"><p>{{$macro["proceso"]}}</p></span>
								</div>
							</div> 
						</a> 
				    </div> 
				@endforeach
			</div>
		</div>   
    </section>
@endsection