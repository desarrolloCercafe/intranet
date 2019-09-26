$(document).ready(function () {
	$("#Consolidado_ceba").hide();
	$("#consolidado_precebo").hide();
	$('[name="parametros[]"]').select2();
	$('#granja').select2();
	$("#procesando").hide();

	$(document).on('change','#decision',function (event) {
		if ($("#decision option:selected").val() == 1) {
			$("#consolidado_precebo").show();
			$("#Consolidado_ceba").hide();
		}else if ($("#decision option:selected").val() == 2) {
			$("#consolidado_precebo").hide();
			$("#Consolidado_ceba").show();
		}
	})

	$(document).on('click','#filtro',()=>{
		if ($("#decision option:selected").val() ==1) {
			var token = document.head.querySelector('meta[name="csrf-token"]').content;
			$("#procesando").show();

			var json = {
				fecha1:$("#selecionar_anno1").val(),
				mes :$("[name='parametros[]']").val(),
				granja:$("#granja").val()
			}

			$.ajax({
				method:'POST',
				headers:{'X-CSRF-TOKEN':token},
				url:'Consolidado',
				data:json
			}).done(function (msg) {
	            var tabla = msg.Consolidacion;
	            $('#consolidado').html("");
	            if (tabla == 0) {
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
	            	$("#procesando").hide();
		            $.each(tabla, function(key,value){
						tabla = "<tr>";
							tabla += "<td>" + value.año_traslado + "</td>";
							tabla += "<td>" + value.edad_inicial.toFixed(0) + "</td>";
							tabla += "<td>" + value.dias_permanecia.toFixed(0) + "</td>";
							tabla += "<td>" + value.edad_final.toFixed(0) + "</td>";
							tabla += "<td>"+value.t_numero_inicial+"</td>";
							tabla += "<td>"+value.numero_final+"</td>";
							tabla += "<td>" + value.numero_muertes + "</td>";
							tabla += "<td>"+value.numero_descartes+"</td>";
							tabla += "<td  class=mortalidad>" + value.promedio_mortalidad.toFixed(2)  + "</td>";
							tabla += "<td>" + value.total_peso_ini.toFixed(2) + "</td>";
							tabla += "<td class=peso>" + value.promedio.toFixed(2) + "</td>";
							tabla += "<td>" + value.total_peso_fin + "</td>";
							tabla += "<td class=peso>"+ value.total_peso_promedio_fin.toFixed(2) + "</td>";
							tabla += "<td>"+value.total_ganancia_lote.toFixed(2)+"</td>";
							tabla += "<td>"+value.total_ato_promedio_fin.toFixed(2)+"</td>";
							tabla += "<td class=peso><strong> "+value.total_ato_promedio_dia_fin.toFixed(3)+"</strong></td>";
							tabla += "<td> "+value.total_cons_total+"</td>";
							tabla += "<td>"+value.total_cons_promedio_dia.toFixed(3)+"</td>";
							tabla += "<td class=peso>"+value.total_cons_promedio_dia_ini.toFixed(3)+"</td>";
							tabla += "<td class=peso>"+value.total_conversion_ajust_fin.toFixed(2)+"</td>";
						tabla += "</tr>"
						$("#consolidado").append(tabla);
					});
				}
			})
		}else if ($("#decision option:selected").val() == 2){
			var token = document.head.querySelector('meta[name="csrf-token"]').content;
		$("#procesando").show();

		var json = {
			fecha1:$("#selecionar_anno1").val(),
			mes :$("[name='parametros[]']").val(),
			granja:$("#granja").val()
		}
		console.log(json);
		$.ajax({
			method:'POST',
			headers:{'X-CSRF-TOKEN':token},
			url:'consolidadoceba',
			data:json
		}).done(function (msg) {
            var tabla_ceba = msg.Consolidado_ceba;
            console.log(tabla_ceba);
            $('#ConsolidadoCeba').html("");
            if (tabla_ceba ==0) {
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
            	$("#procesando").hide();
	            $.each(tabla_ceba, function(key,value){
	            	var html = '';
					html += "<tr>";
						html += "<tr>";
						html += "<td>" + value.año + "</td>";
						html += "<td>"+value.edad_inicial.toFixed(2)+"</td>";	
						html += "<td>"+value.inic+"</td>";
						html += "<td>" + value.cant_final_cerdos + "</td>";
						html += "<td>"+value.muertes+"</td>";
						html += "<td>" + value.cerdos_descartados + "</td>";
						html += "<td class='mortalidad'>" + value.por_mortalidad.toFixed(2) + "</td>";
						html += "<td>" + value.peso_total_ingresado + "</td>";
						html += "<td class='peso'>" + value.peso_promedio_ingresado.toFixed(2) + "</td>";
						html += "<td>" + value.peso_total_vendido + "</td>";
						html += "<td class='peso'>" + value.peso_promedio_vendido.toFixed(2) + "</td>";
						html += "<td>" + value.dias_permanencia.toFixed(2) + "</td>";
						html += "<td class='peso'><strong>" + value.edad_final.toFixed(2) + "</strong></td>";
						html += "<td >"+ value.ganancia_lote_ceba+"</td>";
						html += "<td>" + value.peso_promedio_vendido.toFixed(2) + "</td>";
						html += "<td class='peso'><strong>"+ value.ato_promedio_fin.toFixed(3) +"</strong></td>";
						html += "<td >"+value.consumo_lote+"</td>";
						html += "<td>"+value.consumo_promedio_lote_dias.toFixed(2)+"</td>";
						html += "<td class='peso'>"+value.ato_promedio_dia_fin.toFixed(2)+"</td>";
						html += "<td class='peso'>"+value.conversion_ajust_fin.toFixed(2)+"</td>";
					html += "</tr>"	;
					console.log(html);
					$("#ConsolidadoCeba").append(html);
				});
			}
		})
		}
	})
})
