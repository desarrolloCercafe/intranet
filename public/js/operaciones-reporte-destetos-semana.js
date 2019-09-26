function cebaDates()
{
	var a_d = document.getElementById("a_destete").value;
	var s_d = document.getElementById("s_destete").value;
  var destetos = document.getElementById('n_destetos').value;

	var anno_venta = parseInt(a_d) + 1;
	var tra_ceba = parseInt(s_d) + 7;
  var semana_venta = tra_ceba + 12;
  var semana_1_fase_1 = parseInt(s_d) + 1;
  if (semana_1_fase_1 > 52)
  {
    semana_1_fase_1 = 1;
  }
  var semana_2_fase_1 = semana_1_fase_1 + 1;
  if (semana_2_fase_1 > 52) 
  {
    semana_2_fase_1 = 1;
  }
  var semana_1_fase_2 = semana_2_fase_1 + 1;
  if (semana_1_fase_2 > 52) 
  {
    semana_1_fase_2 = 1;
  }
  var semana_2_fase_2 = semana_1_fase_2 + 1;
  if (semana_2_fase_2 > 52) 
  {
    semana_2_fase_2 = 1;
  }
  var semana_1_fase_3 = semana_2_fase_2 + 1;
  if (semana_1_fase_3 > 52) 
  {
    semana_1_fase_3 = 1;
  }
  var semana_2_fase_3 = semana_1_fase_3 + 1;
  if (semana_2_fase_3 > 52) 
  {
    semana_2_fase_3 = 1;
  }
  var semana_3_fase_3 = semana_2_fase_3 + 1;
  if (semana_3_fase_3 > 52) 
  {
    semana_3_fase_3 = 1;
  }

  var cons_sem_1_fas_1 = (200 * parseInt(destetos) * 7)/1000;
  var cons_sem_2_fas_1 = (350 * parseInt(destetos) * 7)/1000;

  var cons_sem_1_fas_2 = (450 * parseInt(destetos) * 7)/1000;
  var cons_sem_2_fas_2 = (600 * parseInt(destetos) * 7)/1000;

  var cons_sem_1_fas_3 = (800 * parseInt(destetos) * 7)/1000;
  var cons_sem_2_fas_3 = (950 * parseInt(destetos) * 7)/1000;
  var cons_sem_3_fas_3 = (1150 * parseInt(destetos) * 7)/1000;

  document.getElementById("a_venta").value = anno_venta;
  document.getElementById("t_ceba").value = tra_ceba;
  document.getElementById("s_venta").value = semana_venta;

  document.getElementById("sem_1_f_1").value = semana_1_fase_1;
  document.getElementById("cons_s_1_f_1").value = cons_sem_1_fas_1.toFixed(0);

  document.getElementById("sem_2_f_1").value = semana_2_fase_1;
  document.getElementById("cons_s_2_f_1").value = cons_sem_2_fas_1.toFixed(0);

  document.getElementById("sem_1_f_2").value = semana_1_fase_2;
  document.getElementById("cons_s_1_f_2").value = cons_sem_1_fas_2.toFixed(0);

  document.getElementById("sem_2_f_2").value = semana_2_fase_2;
  document.getElementById("cons_s_2_f_2").value = cons_sem_2_fas_2.toFixed(0);

  document.getElementById("sem_1_f_3").value = semana_1_fase_3;
  document.getElementById("cons_s_1_f_3").value = cons_sem_1_fas_3.toFixed(0);

  document.getElementById("sem_2_f_3").value = semana_2_fase_3;
  document.getElementById("cons_s_2_f_3").value = cons_sem_2_fas_3.toFixed(0);

  document.getElementById("sem_3_f_3").value = semana_3_fase_3;
  document.getElementById("cons_s_3_f_3").value = cons_sem_3_fas_3.toFixed(0);
}