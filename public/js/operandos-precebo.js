 Date.prototype.getWeekNumber = function () {
    var d = new Date(+this); 
    d.setHours(0, 0, 0, 0);   
    d.setDate(d.getDate() + 4 - (d.getDay() || 7)); 
    return Math.ceil((((d - new Date(d.getFullYear(), 0, 1)) / 8.64e7) + 1) / 7);
};

function fechasDeAccion() 
{
  var d = document.getElementById("fecha_destete").value;
  var t = document.getElementById("fecha_traslado").value;
  // var dias_jaulon_calculados = (new Date(t) - new Date(d)) / (1000*60*60*24);
  // $("#dias_jlon").val(dias_jaulon_calculados);
  var elem_d = d.split('-');
  var elem_t = t.split('-');
  var mes_destete = elem_d[1] - 1;
  var anno_destete = elem_d[0];
  var semana_destete = new Date(elem_d[0], mes_destete, elem_d[2]);
  var l = semana_destete.getWeekNumber();
  document.getElementById("s_destete").value = l;
  document.getElementById("año_destete").value = anno_destete;

  var mes_traslado = elem_t[1] - 1;
  var anno_traslado = elem_t[0];
  var semana_traslado = new Date(elem_t[0], mes_traslado, elem_t[2]);
  var p = semana_traslado.getWeekNumber();
  document.getElementById("s_traslado").value = p;
  document.getElementById("año_trlado").value = anno_traslado;
  document.getElementById("mes_trlado").value = parseInt(mes_traslado) + 1;
}

function edadesCalculo()
{
  const edad_ajustada = 70;

  var inicial = document.getElementById("numero_inicial").value;
  var destete = document.getElementById("ed_destete").value;
  var dias_jau = document.getElementById("dias_jlon").value;

  var edad_inicial_to = parseFloat(destete) * parseInt(inicial);
  var dias_totales = parseFloat(dias_jau) * parseInt(inicial);
  var edad_final = parseFloat(destete) + parseFloat(dias_jau);

  document.getElementById("ed_total").value = edad_inicial_to.toFixed(2); 
  document.getElementById("dias_perm").value = dias_totales.toFixed(2); 
  document.getElementById("ed_final").value = edad_final.toFixed(3);
 
}

function pesoConsumo()
{
  const peso_esperado = 31; 
  var g = document.getElementById("gr").value;
  var p_ini = document.getElementById("p_inicial").value;
  var ini = document.getElementById("numero_inicial").value;

  var dias_j = document.getElementById("dias_jlon").value;
  var fin = document.getElementById("nu_final").value;
  var p_fin = document.getElementById("p_final").value;
  var cons_total = document.getElementById("consumo_total").value;
  var edad_final = document.getElementById("ed_final").value;
  
  var p_prom_ini = parseInt(p_ini) / parseInt(ini);
  var p_pond_ini = p_prom_ini * parseInt(ini);

  var p_prom_fin = parseInt(p_fin) / parseInt(fin);
  var p_pond_fin = p_prom_fin * parseInt(fin);
  var ind_p_final = (p_prom_fin / peso_esperado)*100; 

  document.getElementById("p_promedio_ini").value = p_prom_ini.toFixed(2);
  document.getElementById("p_ponderado_ini").value = p_pond_ini.toFixed(2);
  document.getElementById("p_promedio_fin").value = p_prom_fin.toFixed(2);
  document.getElementById("p_ponderado_fin").value = p_pond_fin.toFixed(2);
  document.getElementById("ind_p_f").value = ind_p_final.toFixed(2);

  var cons_promedio = parseInt(cons_total) / parseInt(fin);
  var cons_ponderado = cons_promedio * parseInt(fin);
  var cons_prom_dia = cons_promedio / parseInt(dias_j);

  var cons_promedio_inicial = parseInt(cons_total) / parseInt(ini);
  var cons_ponderado_inicial = cons_promedio_inicial * parseInt(fin);
  var cons_prom_dia_inicial = cons_promedio_inicial / parseInt(dias_j);

  if(g == 8 || g == 27)  
  {
    var consumo_ajust_ini = cons_promedio_inicial + (p_prom_ini - 5.91) * 1.1 + (26.93 - p_prom_fin) * 1.81;
    var consumo_ajust_fin = cons_promedio + (p_prom_ini - 5.91) * 1.1 + (26.93 - p_prom_fin) * 1.81;
    var conversion_ajust_ini = consumo_ajust_ini / (26.93 - 5.91);
    var conversion_ajust_fin = consumo_ajust_fin / (26.93 - 5.91);
  }
  else
  {
    var consumo_ajust_ini = cons_promedio_inicial + (p_prom_ini - 5.76) * 1.1 + (29.32 - p_prom_fin) * 1.5;
    var consumo_ajust_fin = cons_promedio + (p_prom_ini - 5.76) * 1.1 + (29.32 - p_prom_fin) * 1.5;
    var conversion_ajust_ini = consumo_ajust_ini / (29.32 - 5.76);
    var conversion_ajust_fin = consumo_ajust_fin / (29.32 - 5.76);
  }

  var ato_prom_ini = (p_fin - p_ini) / parseInt(ini);
  var ato_prom_fin = (p_fin - p_ini) / parseInt(fin); 

  var ato_prom_dia_ini = ato_prom_ini / dias_j;
  var ato_prom_dia_fin = ato_prom_fin / dias_j;

  var conv_ini = cons_promedio_inicial / ato_prom_ini; 
  var conv_fin = cons_promedio / ato_prom_fin;
  
  document.getElementById("consumo_promedio").value = cons_promedio.toFixed(2);
  document.getElementById("consumo_ponderado").value = cons_ponderado.toFixed(2);
  document.getElementById("consumo_promedio_dia").value = cons_prom_dia.toFixed(3);

  document.getElementById("consumo_promedio_inicial").value = cons_promedio_inicial.toFixed(2);
  document.getElementById("consumo_ponderado_inicial").value = cons_ponderado_inicial.toFixed(2);
  document.getElementById("consumo_promedio_dia_inicial").value = cons_prom_dia_inicial.toFixed(3);

  document.getElementById("consumo_ajustado_inicial").value = consumo_ajust_ini.toFixed(2);
  document.getElementById("cons_ajustado_final").value = consumo_ajust_fin.toFixed(2);
  document.getElementById("conversion_ajustada_inicial").value = conversion_ajust_ini.toFixed(2);
  document.getElementById("conversion_ajustada_final").value = conversion_ajust_fin.toFixed(2);

  document.getElementById("ato_promedio_inicial").value = ato_prom_ini.toFixed(2);
  document.getElementById("ato_promedio_final").value = ato_prom_fin.toFixed(2);

  document.getElementById("ato_promedio_dia_inicial").value = ato_prom_dia_ini.toFixed(3);
  document.getElementById("ato_promedio_dia_final").value = ato_prom_dia_fin.toFixed(3);

  document.getElementById("conversion_inicial").value = conv_ini.toFixed(2);
  document.getElementById("conversion_final").value = conv_fin.toFixed(2);

  document.getElementById("conversion_ajustada_inicial").value = conversion_ajust_ini.toFixed(2);
  document.getElementById("conversion_ajustada_final").value = conversion_ajust_fin.toFixed(2);
}

function porcentajeForm()
{
  var ini = document.getElementById("numero_inicial").value;
  var muertes = document.getElementById("n_muertes").value;
  var descartes = document.getElementById("n_descartes").value;
  var livianos = document.getElementById("n_livianos").value;

  var n_final = parseInt(ini) - (parseInt(descartes) + parseInt(muertes));
  var mortalidad_por = (parseInt(muertes) / parseInt(ini)) * 100;
  var descartes_por = (parseInt(descartes) / parseInt(ini)) * 100;
  var livianos_por = (parseInt(livianos) / parseInt(ini)) * 100; 

  document.getElementById("nu_final").value = n_final;
  document.getElementById("mortalidad").value = mortalidad_por.toFixed(2);
  document.getElementById("descartes").value = descartes_por.toFixed(2);
  document.getElementById("livianos").value = livianos_por.toFixed(2);
}



