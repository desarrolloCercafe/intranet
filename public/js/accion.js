$(document).ready(iniciar)
 
function iniciar (){
	$("#accion").on("click",mostrar);
	$("#accion2").on("click",mostrar2);
	$("#accion3").on("click",mostrar3);
	$("#accion4").on("click",mostrar4);
	$("#accion5").on("click",mostrar5);
  $("#esconder1").hide();
  $("#esconder2").hide();
  $("#esconder3").hide();
  $("#esconder4").hide();
  $("#esconder5").hide();
  $("#text").hide();
  $("#text2").hide();
  $("#text3").hide();
  $("#text4").hide();
  $("#text5").hide();
  $("#esconder1").on("click",esconder1);
  $("#esconder2").on("click",esconder2);
  $("#esconder3").on("click",esconder3);
  $("#esconder4").on("click",esconder4);
  $("#esconder5").on("click",esconder5);
}

function mostrar(){
	$("#text").slideDown("slow");
  $("#accion").hide();
  $("#esconder1").show();
}

function mostrar2(){
  $("#text2").slideDown("slow");
  $("#accion2").hide();
  $("#esconder2").show();  
}

function mostrar3(){
  $("#text3").slideDown("slow");
  $("#accion3").hide();
  $("#esconder3").show();
}
function mostrar4(){
  $("#text4").slideDown("slow");
  $("#accion4").hide();
  $("#esconder4").show();
}
function mostrar5(){
  $("#text5").slideDown("slow");
  $("#accion5").hide();
  $("#esconder5").show();
}

function esconder1(){
  $("#text").slideUp("slow");
  $("#esconder1").hide();
  $("#accion").show();
}

function esconder2(){
  $("#text2").slideUp("slow");
  $("#esconder2").hide();
  $("#accion2").show();
}

function esconder3(){
  $("#text3").slideUp("slow");
  $("#esconder3").hide();
  $("#accion3").show();
}

function esconder4(){
  $("#text4").slideUp("slow");
  $("#esconder4").hide();
  $("#accion4").show();
}

function esconder5(){
  $("#text5").slideUp("slow");
  $("#esconder5").hide();
  $("#accion5").show();
}