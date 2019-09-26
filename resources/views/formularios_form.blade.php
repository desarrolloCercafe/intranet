<!DOCTYPE html>
<html manifest="http://201.236.212.130:82/intranetcercafe/public/page_manifest.appcache">
	<head>
		<title>Forms - {{$macro->proceso}}</title>
		<meta charset="utf-8"/>
  		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  		{!!Html::style('frontend_enketo/css/bootstrap4.min.css')!!}
  		{!!Html::style('frontend_enketo/css/style.css')!!}
	</head>
	<body style="background: #FA166D">
		<div class="menu-area">
		    <a href="javascript:history.go(-1);" class="btn btn-link"><i class="fa fa-arrow-left fa-2x" style="color: #ffffff;"></i></a>
		</div>
		<div id="intro-offline">
		    <div class="intro-text">
		      	<div class="container">
			        <div class="row">
			          	<div class="col-md-12">
			                <h1><a href="#">{{$macro->proceso}}</a></h1>
			              	<div class="line-spacer"></div>
			          	</div>
			        </div>
		      	</div>
		    </div> 
		</div>
      	<div class="container">
      		<div class="card-deck">
		        @foreach($ruta_micros as $micro)
		    		<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
		    			<a href="{{$micro["enlace"]}}" target="_blank" style="text-decoration:none;">
		    				<div class="card border-light mb-3" style="max-width: 30rem; background: #FA166D;">
								<div class="card-header text-white">
									<p class="card-title">{{$micro["nombre_documento"]}}</p>
								</div>
							</div>
						</a>
			    	</div>
		    	@endforeach
		    </div>
      	</div>
      	<footer>
		    <div class="container">
		      	<div class="row">
			        <div class="col-md-12">
			          	<p>Página diseñada para uso offline</p>
			          	<div class="credits">
			            	Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
			          	</div>
			        </div>
		      	</div>
		    </div>
		</footer>
		{!!Html::script('frontend_enketo/js/jquery.js')!!}
		{!!html::script('frontend_enketo/js/bootstrap.min.js')!!}
		{!!Html::script('frontend_enketo/js/jquery.smooth-scroll.min.js')!!}
	</body>
</html>