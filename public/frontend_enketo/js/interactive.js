$(document).ready(function() {
	if($("#area_seleccionada").val() == 6)  
	{
		$("#titulo").html("Técnica");
		$("#intro").css('background-color', '#dc3545');
		$(".dl-menuwrapper ul").css('background','#dc3545');
		$(".dl-menuwrapper button").css('background', 'rgba(220,53,69,.5)');
		$("#subtitulo").html("<img src='http://201.236.212.130:82/intranetcercafe/public/frontend_enketo/img/area-tecnica.png'/>");
		$(".card").removeClass("bg-success").addClass("bg-danger");
		$(".accordion-titulo").css('background', '#dc3545');
		$(".accordion-titulo").css('color', '#ffffff');
		$(".accordion-titulo.open").css('background', '#dc3545');
		$(".accordion-titulo.open").css('color', '#ffffff');
		$(".accordion-titulo:hover").css('background', '#dc3545');
		$(".accordion-titulo:hover").css('color', '#ffffff');
	}
	else if($("#area_seleccionada").val() == 9)
	{
		$("#titulo").html("Planta de Concentrados");
		$("#intro").css('background-color', '#17a2b8');
		$(".dl-menuwrapper ul").css('background','#17a2b8');
		$(".dl-menuwrapper button").css('background', 'rgba(23,162,184,.5)');
		$("#subtitulo").html("<img src='http://201.236.212.130:82/intranetcercafe/public/frontend_enketo/img/area-concentrados.png'/>");
		$(".card").removeClass("bg-success").addClass("bg-info");
		$(".accordion-titulo").css('background', '#17a2b8');
		$(".accordion-titulo").css('color', '#ffffff');
		$(".accordion-titulo.open").css('background', '#17a2b8');
		$(".accordion-titulo.open").css('color', '#ffffff');
		$(".accordion-titulo:hover").css('background', '#17a2b8');
		$(".accordion-titulo:hover").css('color', '#ffffff');
	}
	else if($("#area_seleccionada").val() == 1)
	{
		$("#titulo").html("Sistemas");
		$("#intro").css('background-color', '#007BFF');
		$(".dl-menuwrapper ul").css('background','#007BFF');
		$(".dl-menuwrapper button").css('background', 'rgba(0,123,255,.5)');
		$("#subtitulo").html("<img src='http://201.236.212.130:82/intranetcercafe/public/frontend_enketo/img/area-sistemas.png'/>");
		$(".card").removeClass("bg-success").addClass("bg-primary");
		$(".accordion-titulo").css('background', '#007BFF');
		$(".accordion-titulo").css('color', '#ffffff');
		$(".accordion-titulo.open").css('background', '#007BFF');
		$(".accordion-titulo.open").css('color', '#ffffff');
		$(".accordion-titulo:hover").css('background', '#007BFF');
		$(".accordion-titulo:hover").css('color', '#ffffff');
	}
	else if($("#area_seleccionada").val() == 4)
	{
		$("#titulo").html("Comercial");
		$("#intro").css('background-color', '#FFC107');
		$(".dl-menuwrapper ul").css('background','#FFC107');
		$(".dl-menuwrapper button").css('background', 'rgba(255,193,7,.5)');
		$("#subtitulo").html("<img src='http://201.236.212.130:82/intranetcercafe/public/frontend_enketo/img/area-comercial.png'/>");
		$(".card").removeClass("bg-success").addClass("bg-warning");
		$(".accordion-titulo").css('background', '#FFC107');
		$(".accordion-titulo").css('color', '#ffffff');
		$(".accordion-titulo.open").css('background', '#FFC107');
		$(".accordion-titulo.open").css('color', '#ffffff');
		$(".accordion-titulo:hover").css('background', '#FFC107');
		$(".accordion-titulo:hover").css('color', '#ffffff');
	}
	else if($("#area_seleccionada").val() == 7)
	{
		$("#titulo").html("Compras");
		$("#intro").css('background-color', '#dc3545');
		$(".dl-menuwrapper ul").css('background','#dc3545');
		$(".dl-menuwrapper button").css('background', 'rgba(220,53,69,.5)');
		$("#subtitulo").html("<img src='http://201.236.212.130:82/intranetcercafe/public/frontend_enketo/img/area-comercial.png'/>");
		$(".card").removeClass("bg-success").addClass("bg-danger"); 
		$(".accordion-titulo").css('background', '#dc3545');
		$(".accordion-titulo").css('color', '#ffffff');
		$(".accordion-titulo.open").css('background', '#dc3545');
		$(".accordion-titulo.open").css('color', '#ffffff');
		$(".accordion-titulo:hover").css('background', '#dc3545');
		$(".accordion-titulo:hover").css('color', '#ffffff');
	}
	else if($("#area_seleccionada").val() == 3)
	{
		$("#titulo").html("Financiera");
		$("#intro").css('background-color', '#28a745');
		$(".dl-menuwrapper ul").css('background','#28a745');
		$(".dl-menuwrapper button").css('background', 'rgba(40,167,69,.5)');
		$("#subtitulo").html("<img src='http://201.236.212.130:82/intranetcercafe/public/frontend_enketo/img/area-financiera.png'/>");
		$(".accordion-titulo").css('background', '#28a745');
		$(".accordion-titulo").css('color', '#ffffff');
		$(".accordion-titulo.open").css('background', '#28a745');
		$(".accordion-titulo.open").css('color', '#ffffff');
		$(".accordion-titulo:hover").css('background', '#28a745');
		$(".accordion-titulo:hover").css('color', '#ffffff');
	}
	else if($("#area_seleccionada").val() == 2)
	{
		$("#titulo").html("Mejoramiento Continuo");
		$("#intro").css('background-color', '#17a2b8');
		$(".dl-menuwrapper ul").css('background','#17a2b8');
		$(".dl-menuwrapper button").css('background', 'rgba(23,162,184,.5)');
		$("#subtitulo").html("<img src='http://201.236.212.130:82/intranetcercafe/public/frontend_enketo/img/area-mejoramiento.png'/>");
		$(".card").removeClass("bg-success").addClass("bg-info");
		$(".accordion-titulo").css('background', '#17a2b8');
		$(".accordion-titulo").css('color', '#ffffff');
		$(".accordion-titulo.open").css('background', '#17a2b8');
		$(".accordion-titulo.open").css('color', '#ffffff');
		$(".accordion-titulo:hover").css('background', '#17a2b8');
		$(".accordion-titulo:hover").css('color', '#ffffff');
	}
	else if($("#area_seleccionada").val() == 11)
	{
		$("#titulo").html("Calidad");
		$("#intro").css('background-color', '#28a745');
		$(".dl-menuwrapper ul").css('background','#28a745');
		$(".dl-menuwrapper button").css('background', 'rgba(40,167,69,.5)');
		$("#subtitulo").html("<img src='http://201.236.212.130:82/intranetcercafe/public/frontend_enketo/img/area-calidad.png'/>");
		$(".accordion-titulo").css('background', '#28a745');
		$(".accordion-titulo").css('color', '#ffffff');
		$(".accordion-titulo.open").css('background', '#28a745');
		$(".accordion-titulo.open").css('color', '#ffffff');
		$(".accordion-titulo:hover").css('background', '#28a745');
		$(".accordion-titulo:hover").css('color', '#ffffff');
	}
	else if($("#area_seleccionada").val() == 10)
	{
		$("#titulo").html("Talento Humano");
		$("#intro").css('background-color', '#007BFF');
		$(".dl-menuwrapper ul").css('background','#007BFF');
		$(".dl-menuwrapper button").css('background', 'rgba(0,123,255,.5)');
		$("#subtitulo").html("<img src='http://201.236.212.130:82/intranetcercafe/public/frontend_enketo/img/area-humana.png'/>");
		$(".card").removeClass("bg-success").addClass("bg-primary");
		$(".accordion-titulo").css('background', '#007BFF');
		$(".accordion-titulo").css('color', '#ffffff');
		$(".accordion-titulo.open").css('background', '#007BFF');
		$(".accordion-titulo.open").css('color', '#ffffff');
		$(".accordion-titulo:hover").css('background', '#007BFF');
		$(".accordion-titulo:hover").css('color', '#ffffff');
	}
	else if($("#area_seleccionada").val() == 8)
	{
		$("#titulo").html("Generalidades");
		$("#intro").css('background-color', '#868e96');
		$(".dl-menuwrapper ul").css('background','#868e96');
		$(".dl-menuwrapper button").css('background', 'rgba(134,142,150,.5)');
		$("#subtitulo").html("<img src='http://201.236.212.130:82/intranetcercafe/public/frontend_enketo/img/area-generalidades.png'/>");
		$(".card").removeClass("bg-success").addClass("bg-secondary");
		$(".accordion-titulo").css('background', '#868e96');
		$(".accordion-titulo").css('color', '#ffffff');
		$(".accordion-titulo.open").css('background', '#868e96');
		$(".accordion-titulo.open").css('color', '#ffffff');
		$(".accordion-titulo:hover").css('background', '#868e96');
		$(".accordion-titulo:hover").css('color', '#ffffff');
	}
	else if($("#area_seleccionada").val() == 0)
	{
		$("#titulo").html("Forms");
		$("#intro").css('background-color', '#900C3F');
		$(".dl-menuwrapper ul").css('background','#900C3F');
		$(".dl-menuwrapper button").css('background', 'rgba(144,12,63,.5)');
		$("#subtitulo").html("Agradecimientos");
		$("p").css("font-size","17px");
	}
	else
	{

	}
	$(".accordion-titulo").click(function(){
	   var contenido=$(this).next(".accordion-content");
				
	    if(contenido.css("display")=="none")
	    { //open		
	      contenido.slideDown(250);			
	      $(this).addClass("open");
	    }
	    else
	    { //close		
	      contenido.slideUp(250);
	      $(this).removeClass("open");	
	  	}						
	});
});

 