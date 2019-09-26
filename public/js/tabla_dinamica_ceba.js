$(document).ready(function () {
	// $("#myTable").DataTable();
	$('[name="meses[]"]').select2({
		placeholder: "Mes/s",
        allowClear: true
	});
	$('#granjas_ceba').select2();
	$("#exportar_ceba").attr('disabled',true);
	$("#pdf").attr('disabled',true);
	$("#procesando").hide();
	
	$(document).on('click','#filtro_ceba',()=>{
		$("#exportar_ceba").attr('disabled',false);
		$("#pdf").attr('disabled',false);
		$("#procesando").show();
		var token = document.head.querySelector('meta[name="csrf-token"]').content;


		var json = {
			granja:$("#granjas_ceba").val(),
			fecha1:$("#ano_mes").val(),
			mes:$("[name='meses[]']").val()

		}
		// console.log(json)
		$.ajax({
			method:'POST',
			headers:{'X-CSRF-TOKEN':token},
			url:'Tabla_Dinamica_Ceba',
			data:json
		}).done(function (msg) {
            var tabla_ceba = msg.data;
            if (tabla_ceba ==0) {
            	$("#procesando").hide();
            	swal({
                	title:'No Hay Registro',
                	tabla_ceba:'',
                	type:'info',
                	showCancelButton: false,
                	confirmButtonClass:'btn-danger',
                	confirmButtonText:'Cerrar',
                	closeOnConfirm:true
                })
            }else{
            	$('#busqueda').html("");
            	$("#procesando").hide();
	            $.each(tabla_ceba, function(key,value){
					tabla_ceba = "<tr>";
						tabla_ceba += "<td>" + value.año + "</td>";
						tabla_ceba += "<td>"+value.edad_inicial+"</td>";
						tabla_ceba += "<td>" + value.fecha_ingreso_lote + "</td>";
						tabla_ceba += "<td class='peso'><strong>" + value.lote + "</strong></td>";
						tabla_ceba += "<td>" + value.fecha_salida_lote + "</td>";
						tabla_ceba += "<td>"+value.inic+"</td>";
						tabla_ceba += "<td >" + value.cant_final_cerdos + "</td>";
						tabla_ceba += "<td>"+value.muertes+"</td>";
						tabla_ceba += "<td>" + value.cerdos_descartados + "</td>";
						tabla_ceba += "<td class=mortalidad>" + value.por_mortalidad + "</td>";
						tabla_ceba += "<td>" + value.peso_total_ingresado + "</td>";
						tabla_ceba += "<td class='peso'>" + value.peso_promedio_ingresado + "</td>";
						tabla_ceba += "<td  >" + value.peso_total_vendido + "</td>";
						tabla_ceba += "<td class='peso'>" + value.peso_promedio_vendido + "</td>";
						tabla_ceba += "<td>" + value.dias_permanencia + "</td>";
						tabla_ceba += "<td class='peso'>" + value.edad_final + "</td>";
						tabla_ceba += "<td>" + value.ganancia_lote + "</td>";
						tabla_ceba += "<td >"+ (value.ganancia_lote / value.inic).toFixed(2)+"</td>";
						tabla_ceba += "<td class='peso'> <strong>"+((value.ganancia_lote / value.inic)/value.dias_permanencia).toFixed(3)+"</strong></td>";
						tabla_ceba += "<td >"+value.consumo_lote+"</td>";
						tabla_ceba += "<td>"+(value.consumo_lote/value.inic).toFixed(2)+"</td>";
						tabla_ceba += "<td class='peso'>"+((value.consumo_lote/value.inic)/value.dias_permanencia).toFixed(2)+"</td>";
						tabla_ceba += "<td class='peso'>"+(value.consumo_lote / value.ganancia_lote).toFixed(2)+"</td>";
					tabla_ceba += '</tr>';	
					$("#busqueda").append(tabla_ceba);
				}); 
			}        
		})
	})
})
