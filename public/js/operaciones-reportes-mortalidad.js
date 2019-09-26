Date.prototype.getWeekNumber = function () {
    var d = new Date(+this); 
    d.setHours(0, 0, 0, 0);   
    d.setDate(d.getDate() + 4 - (d.getDay() || 7)); 
    return Math.ceil((((d - new Date(d.getFullYear(), 0, 1)) / 8.64e7) + 1) / 7);
};

function fechasMuerte()
{
  var fm = document.getElementById("fecha_m").value;
  var elem = fm.split('-');

  document.getElementById("año_m").value = elem[0];
  document.getElementById("mes_m").value = elem[1];
  document.getElementById("dia_m").value = elem[2];
  				
  var mes = elem[1] - 1;
  var anno = elem[0];
  var semana = new Date(elem[0], mes, elem[2]);
  var l = semana.getWeekNumber();
  document.getElementById("semana_m").value = l;
}
