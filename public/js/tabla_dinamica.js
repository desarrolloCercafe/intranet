$(document).ready(function () {
	$('[name="parametros[]"]').select2({
		placeholder: "Mes/s",
        allowClear: true
	});
	$("#exportar_precebo").attr('disabled',true);
	$("#pdf").attr('disabled',true);
	$('#granja').select2();
	$("#procesando").hide();

	$(document).on('click','#filtro',()=>{
		var token = document.head.querySelector('meta[name="csrf-token"]').content;
		$("#procesando").show();
		$("#exportar_precebo").attr('disabled',false);
		$("#pdf").attr('disabled',false);

		var json = {
			fecha1:$("#selecionar_anno1").val(),
			mes :$("[name='parametros[]']").val(),
			granja:$("#granja").val()
		}
	
        // $('#busqueda tr td').remove();
        // $('#totales').html("");
		$.ajax({
			method:'POST',
			headers:{'X-CSRF-TOKEN':token},
			url:'http://201.236.212.130:82/intranetcercafe/public/admin/TablaDinamica',
			data:json
		}).done(function (msg) {
            var tabla = msg.data;
            if (tabla ==0) {
            	$("#procesando").hide();
            	swal({
                	title:'No Hay Registro',
                	tabla:'',
                	type:'info',
                	showCancelButton: false,
                	confirmButtonClass:'btn-danger',
                	confirmButtonText:'Cerrar',
                	closeOnConfirm:true
           
                 })
            }else{
            	$('#busqueda').html("");
            	$("#procesando").hide();
	            $.each(tabla, function(key,value){
					tabla = "<tr>";
						tabla += "<td>" + value.año_traslado + "</td>";
						tabla += "<td>" + value.edad_destete + "</td>";
						tabla += "<td>" + value.dias_permanencia + "</td>";
						tabla += "<td>" + value.edad_final + "</td>";
						tabla += "<td>"+value.fecha_destete+"</td>";
						tabla += "<td class='lote'><strong>" + value.lote + "</strong></td>";
						tabla += "<td>"+value.fecha_traslado+"</td>";
						tabla += "<td>" + value.numero_inicial + "</td>";
						tabla += "<td>" + value.numero_final + "</td>";
						tabla += "<td>" + value.numero_muertes + "</td>";
						tabla += "<td>" + value.numero_descartes + "</td>";
						tabla += "<td  class='mortalidad'>" + value.porciento_mortalidad + "</td>";
						tabla += "<td>" + value.peso_ini + "</td>";
						tabla += "<td class='peso'>" + value.peso_promedio_ini + "</td>";
						tabla += "<td>"+value.peso_fin+"</td>";
						tabla += "<td class='peso'>"+ value.peso_promedio_fin+"</td>";
						tabla += "<td>"+value.ganancia_lote+"</td>";
						tabla += "<td>"+(value.ganancia_lote / value.numero_inicial).toFixed(1)+"</td>";
						tabla += "<td class='peso'><strong>"+((value.ganancia_lote / value.numero_inicial) / value.dias_permanencia).toFixed(3)+"</strong></td>";
						tabla += "<td>"+value.cons_total+"</td>";
						tabla += "<td>"+value.cons_promedio+"</td>";
						tabla += "<td class='peso'>"+value.cons_promedio_dia_ini+"</td>";
						tabla += "<td class='peso'>"+(value.cons_total / value.ganancia_lote).toFixed(2)+"</td>";
					tabla += '</tr>'

					$("#busqueda").append(tabla);	        	
				}); 
			}        
		})
	})
})
