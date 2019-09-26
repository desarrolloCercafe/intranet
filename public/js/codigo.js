$(document).ready(iniciar);

function iniciar() {

	$('#date_picker_desde').datepicker({
		changeMonth: true,
		changeYear: true,
		yearRange: "1950:2100",
		dateFormat: "yy-mm-dd",
		showButtonPanel: true,
	});
	$('#date_picker_hasta').datepicker({
		changeMonth: true,
		changeYear: true,
		yearRange: "1950:2100",
		dateFormat: "yy-mm-dd",
		showButtonPanel: true,
	});
	$('#date_picker_nacimiento').datepicker({
		changeMonth: true,
		changeYear: true,
		yearRange: "1950:2100",
		dateFormat: "yy-mm-dd",
		showButtonPanel: true,
	});
	$('#date_picker_solicitud').datepicker({
		changeMonth: true,
		changeYear: true,
		yearRange: "1950:2100",
		dateFormat: "yy-mm-dd",
		showButtonPanel: true,
	});
	$('#fecha_destete').datepicker({
		changeMonth: true,
		changeYear: true,
		yearRange: "1950:2100",
		dateFormat: "yy-mm-dd",
		showButtonPanel: true,
	});
	$('#fecha_traslado').datepicker({
		changeMonth: true,
		changeYear: true,
		yearRange: "1950:2100",
		dateFormat: "yy-mm-dd",
		showButtonPanel: true,
	});
	$('#fecha_ingreso').datepicker({ 
		changeMonth: true,
		changeYear: true,
		yearRange: "1950:2100",
		dateFormat: "yy-mm-dd",
		showButtonPanel: true,
	});
	$('#fecha_salida').datepicker({
		changeMonth: true,
		changeYear: true,
		yearRange: "1950:2100",
		dateFormat: "yy-mm-dd",
		showButtonPanel: true, 
	});
	$('#fecha_m').datepicker({
		changeMonth: true,
		changeYear: true,
		yearRange: "1950:2100",
		dateFormat: "yy-mm-dd",
		showButtonPanel: true,
	});

	$('#fecha_entrega').datetimepicker({
		changeMonth: true,
		changeYear: true,
		yearRange: "1950:2100",
		dateFormat: "yy-mm-dd",
		timeFormat: "hh:mm TT",
		firstDay: 1,
		showWeek:true,
		showButtonPanel: true,
		controlType: 'select',
		oneLine: true,
	});
	$("#desde").datepicker({
		changeMonth: true,
		changeYear: true,
		yearRange: "1950:2100",
		dateFormat: "yy-mm-dd",
		showButtonPanel: true,
	});
	$("#hasta").datepicker({
		changeMonth: true,
		changeYear: true,
		yearRange: "1950:2100",
		dateFormat: "yy-mm-dd",
		showButtonPanel: true,
	});
	$("#desde_mortalidad").datepicker({
		changeMonth: true,
		changeYear: true,
		yearRange: "1950:2100",
		dateFormat: "yy-mm-dd",
		showButtonPanel: true,
	});

	$("#hasta_mortalidad").datepicker({
		changeMonth: true,
		changeYear: true,
		yearRange: "1950:2100",
		dateFormat: "yy-mm-dd",
		showButtonPanel: true,
	});
	
	$("#desde_consumo").datepicker({
		changeMonth: true,
		changeYear: true,
		yearRange: "1950:2100",
		dateFormat: "yy-mm-dd",
		showButtonPanel: true,
	});

	$("#hasta_consumo").datepicker({
		changeMonth: true,
		changeYear: true,
		yearRange: "1950:2100",
		dateFormat: "yy-mm-dd",
		showButtonPanel: true,
	});

	$("#desde_consumo_promedio_con_mortalidad").datepicker({
		changeMonth: true,
		changeYear: true,
		yearRange: "1950:2100",
		dateFormat: "yy-mm-dd",
		showButtonPanel: true,
	});

	$("#hasta_consumo_promedio_con_mortalidad").datepicker({
		changeMonth: true,
		changeYear: true,
		yearRange: "1950:2100",
		dateFormat: "yy-mm-dd",
		showButtonPanel: true,
	});

	$("#desde_ganancia_promedio_con_mortalidad").datepicker({
		changeMonth: true,
		changeYear: true,
		yearRange: "1950:2100",
		dateFormat: "yy-mm-dd",
		showButtonPanel: true,
	});

	$("#hasta_ganancia_promedio_con_mortalidad").datepicker({
		changeMonth: true,
		changeYear: true,
		yearRange: "1950:2100",
		dateFormat: "yy-mm-dd",
		showButtonPanel: true,
	});

	$("#desde_numero_inicial").datepicker({
		changeMonth: true,
		changeYear: true,
		yearRange: "1950:2100",
		dateFormat: "yy-mm-dd",
		showButtonPanel: true,
	});

	$("#hasta_numero_inicial").datepicker({
		changeMonth: true,
		changeYear: true,
		yearRange: "1950:2100",
		dateFormat: "yy-mm-dd",
		showButtonPanel: true,
	});

	$("#desde_numero_final").datepicker({
		changeMonth: true,
		changeYear: true,
		yearRange: "1950:2100",
		dateFormat: "yy-mm-dd",
		showButtonPanel: true,
	});

	$("#hasta_numero_final").datepicker({
		changeMonth: true,
		changeYear: true,
		yearRange: "1950:2100",
		dateFormat: "yy-mm-dd",
		showButtonPanel: true,
	});

	$("#modificar_f_semen").datepicker({
		changeMonth: true,
		changeYear: true,
		yearRange: "1950:2100",
		dateFormat: "yy-mm-dd", 
		showButtonPanel: true,
	});
	$("#data_list").DataTable();
	$("input[type='radio']").checkboxradio();
	$("[name='cargo']").select2();
	$("[name='granja']").select2();

	// $("select").select2();

	$("#file").on("change",function(e){

		var files = $ (this)[0].files;

		if(files.length >= 2){
			$("#label_span").text(files.length +" archivos selecionados ");

		}else{
			var filename =e.target.value.split('\\').pop();
			$("#label_span").text(filename);
		}
	});

	$("[data-toggle='tooltip']").tooltip();

	$("#agente").select2();
	$("#granja").select2();
}