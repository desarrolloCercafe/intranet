$(document).ready(function () {
	$("#ceba").hide();
	$("#precebo").hide();
	$("#procesando").hide();
	$(document).on('change','#decision',function (event) {
		if ($("#decision option:selected").val() == 1) {
			$("#precebo").show();
			$("#ceba").hide();
		}else if ($("#decision option:selected").val() == 2) {
			$("#precebo").hide();
			$("#ceba").show();
		}
	})
	$(document).on('click','#buscar',()=>{
		if ($("#decision option:selected").val() ==1) {
			var token = document.head.querySelector('meta[name="csrf-token"]').content;
			$("#procesando").show();

			var json = {
				fecha1:$("#selecionar_anno1").val(),
				fecha2:$('#selecionar_anno2').val()
			}
			
			$.ajax({
				method:'POST',
				headers:{'X-CSRF-TOKEN':token},
				url:'GeneralPrecebo',
				data:json
			}).done(function (msg) {
	            var tabla = msg.generalprecebo;
	         
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
            	$('#transportar_datos').html("");
            	$("#procesando").hide();
	            $.each(tabla, function(key,value){
					tabla = "<tr>";
						tabla += "<td>" + value.año_traslado + "</td>";
						tabla += "<td>" + value.edad_destete + "</td>";
						tabla += "<td>" + value.dias_permanencia.toFixed(2) + "</td>";
						tabla += "<td>" + value.edad_final + "</td>";
						tabla += "<td>"+value.fecha_destete+"</td>";
						tabla += "<td class=lote><strong>" + value.lote + "</strong></td>";
						tabla += "<td>"+value.fecha_traslado+"</td>";
						tabla += "<td>" + value.numero_inicial + "</td>";
						tabla += "<td>" + value.numero_final + "</td>";
						tabla += "<td>" + value.numero_muertes + "</td>";
						tabla += "<td>" + value.numero_descartes + "</td>";
						tabla += "<td  class=mortalidad>" + value.porciento_mortalidad + "</td>";
						tabla += "<td>" + value.peso_ini + "</td>";
						tabla += "<td class=peso>" + value.peso_promedio_ini + "</td>";
						tabla += "<td>"+value.peso_fin+"</td>";
						tabla += "<td class=peso>"+ value.peso_promedio_fin+"</td>";
						tabla += "<td> "+value.ganancia_lote+"</td>";
						tabla += "<td>"+value.ato_promedio_fin+"</td>";
						tabla += "<td class=peso><strong>"+value.ato_promedio_dia_fin+"</strong></td>";
						tabla += "<td>"+value.cons_total+"</td>";
						tabla += "<td>"+value.cons_promedio+"</td>";
						tabla += "<td class=peso>"+value.cons_promedio_dia_ini+"</td>";
						tabla += "<td class=peso>"+value.conversion_ajust_fin+"</td>";
					$("#transportar_datos").append(tabla);	
				}); 
			}          
			})
		}else if ($("#decision option:selected").val() == 2) {
			$("#procesando").show();
			var token = document.head.querySelector('meta[name="csrf-token"]').content;
			var json = {
				fecha1:$("#selecionar_anno1").val(),
				fecha2:$('#selecionar_anno2').val()
			}
			$.ajax({
				method:'POST',
				headers:{'X-CSRF-TOKEN':token},
				url:'GeneralCeba',
				data:json
			}).done(function (msg) {
	            var tabla_ceba = msg.Consolidado_ceba;
	            // console.log(tabla_ceba);

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
	            	$('#transportar_datos_ceba').html("");
	            	$("#procesando").hide();
		            $.each(tabla_ceba, function(key,value){
						tabla_ceba = "<tr>";
							tabla_ceba += "<td>" + value.año + "</td>";
							tabla_ceba += "<td>"+value.edad_inicial+"</td>";
							tabla_ceba += "<td>" + value.fecha_ingreso_lote + "</td>";
							tabla_ceba += "<td class=peso><strong>" + value.lote + "</strong></td>";
							tabla_ceba += "<td>" + value.fecha_salida_lote + "</td>";
							tabla_ceba += "<td>"+value.inic+"</td>";
							tabla_ceba += "<td >" + value.cant_final_cerdos + "</td>";
							tabla_ceba += "<td>"+value.muertes+"</td>";
							tabla_ceba += "<td>" + value.cerdos_descartados + "</td>";
							tabla_ceba += "<td class=mortalidad>" + value.por_mortalidad + "</td>";
							tabla_ceba += "<td>" + value.peso_total_ingresado + "</td>";
							tabla_ceba += "<td class=peso>" + value.peso_promedio_ingresado + "</td>";
							tabla_ceba += "<td  >" + value.peso_total_vendido + "</td>";
							tabla_ceba += "<td class=peso>" + value.peso_promedio_vendido + "</td>";
							tabla_ceba += "<td>" + value.dias_permanencia.toFixed(2) + "</td>";
							tabla_ceba += "<td class=peso>" + value.edad_final + "</td>";
							tabla_ceba += "<td >"+ value.ganancia_lote_ceba+"</td>";
							tabla_ceba += "<td >"+ value.ato_promedio_fin+"</td>";
							tabla_ceba += "<td class=peso> <strong>"+value.ato_promedio_dia_fin.toFixed(2)+"</strong></td>";
							tabla_ceba += "<td >"+value.consumo_lote+"</td>";
							tabla_ceba += "<td>"+value.final.toFixed(2)+"</td>";
							tabla_ceba += "<td class=peso>"+value.cons_promedio_dia_ini.toFixed(2)+"</td>";
							tabla_ceba += "<td class=peso>"+value.conversion_ajust_fin.toFixed(2)+"</td>";
					    $("#transportar_datos_ceba").append(tabla_ceba);       	
				    }) 
				}        
			})
		}
	})
})
