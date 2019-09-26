Date.prototype.getWeekNumber = function () {
    var d = new Date(+this); 
    d.setHours(0, 0, 0, 0);   
    d.setDate(d.getDate() + 4 - (d.getDay() || 7)); 
    return Math.ceil((((d - new Date(d.getFullYear(), 0, 1)) / 8.64e7) + 1) / 7);
};

function calcularFechas()
{
  var f1 = document.getElementById("fecha_ingreso").value;
  var f2 = document.getElementById("fecha_salida").value;
  // var dias_calculados = (new Date(f2) - new Date(f1)) / (1000*60*60*24);
  // $("#dias").val(dias_calculados);
  var elem = f2.split('-');
  var mes = elem[1] - 1;
  var anno = elem[0];
  var semana = new Date(elem[0], mes, elem[2]);
  var l = semana.getWeekNumber();
  document.getElementById("año").value = elem[0];
  document.getElementById("mes").value = parseInt(mes + 1);
  document.getElementById("semana").value = l;
}

function diasPermanencia()
{
	var e_i = document.getElementById("edad_inicial_c").value;
	var edad_inicial = parseInt(e_i);
	var inc_lote = document.getElementById("cerdos_ingresados").value;
	var cerdos_lote_inicial = parseFloat(inc_lote);

	var dias = document.getElementById("dias").value;
	var dias_granja = parseFloat(dias);
	var final_lote = document.getElementById("cerdos_finales").value;
	var cerdos_lote_final = parseFloat(final_lote);

	var edad_inicial_total = edad_inicial * cerdos_lote_inicial;
	var dias_permanecia_totales = dias_granja * cerdos_lote_final;
	var final_edad = edad_inicial + dias_granja;
	var final_edad_total = final_edad * cerdos_lote_final;

	document.getElementById("edad_total_inicial").value = edad_inicial_total;
	document.getElementById("dias_perm_granja").value = dias_permanecia_totales;
	document.getElementById("edad_final_cerdos").value = final_edad;
	document.getElementById("edad_final_cerdos_total").value = final_edad_total;
}

function totalCerdos()
{
	var ci = document.getElementById("cerdos_ingresados").value;
	var cerdos_ingresados = parseInt(ci);
	var cm = document.getElementById("muertes").value;
	var cerdos_muertos = parseInt(cm);
	var cd = document.getElementById("cerdos_descartados").value;
	var cerdos_descartados = parseInt(cd);
	var cl = document.getElementById("cerdos_livianos").value;
	var cerdos_livianos = parseInt(cl);


	var peso_ingresado_cerdos = document.getElementById("peso_ingresado").value;
	var p_i_float = parseFloat(peso_ingresado_cerdos);
	var peso_vendido_cerdos = document.getElementById("peso_vendido").value;
	var p_v_float = parseFloat(peso_vendido_cerdos);

	var cons_l = document.getElementById("lote_consumo").value;
	var consumo_lote = parseFloat(cons_l);
	var dias_g  = document.getElementById("dias").value;
	var dias = parseFloat(dias_g);


	var cerdos_fin = cerdos_ingresados - cerdos_muertos - cerdos_descartados;
	var mortalidad = (cerdos_muertos / cerdos_ingresados)*100;
	var descarte = (cerdos_descartados / cerdos_ingresados)*100;
	var livianos = (cerdos_livianos / cerdos_ingresados)*100;

	var promedio_ingresado = p_i_float / cerdos_fin;
	var promedio_vendido = p_v_float / cerdos_fin;

	var promedio_consumo = consumo_lote / cerdos_fin;
	var promedio_consumo_dias = promedio_consumo/dias;
	
 	var promedio_consumo_ini = consumo_lote / cerdos_ingresados;
	var promedio_consumo_dias_ini = promedio_consumo_ini/dias;

	var ato_prom = promedio_vendido - promedio_ingresado;
  	
  	var ato_prom_dia = ato_prom / dias;
 
  	var conv = promedio_consumo / ato_prom;

	document.getElementById("cerdos_finales").value = cerdos_fin;
	document.getElementById("por_mortalidad").value = mortalidad.toFixed(2);
	document.getElementById("por_descarte").value = descarte.toFixed(2);
	document.getElementById("por_livianos").value = livianos.toFixed(2);

	document.getElementById("peso_promedio_ingresado").value = promedio_ingresado.toFixed(2);
	document.getElementById("peso_promedio_vendido").value = promedio_vendido.toFixed(2);
	document.getElementById("promedio_consumo").value = promedio_consumo.toFixed(2);
	document.getElementById("dias_promedio_consumo").value = promedio_consumo_dias.toFixed(3);
	document.getElementById("consumo_promedio_inicial").value = promedio_consumo_ini.toFixed(2);
	document.getElementById("consumo_promedio_dia_inicial").value = promedio_consumo_dias_ini.toFixed(2);
	document.getElementById("ato_promedio").value = ato_prom.toFixed(2);
	document.getElementById("ato_promedio_dia").value = ato_prom_dia.toFixed(2);
	document.getElementById("conversion").value = conv.toFixed(2);
}

