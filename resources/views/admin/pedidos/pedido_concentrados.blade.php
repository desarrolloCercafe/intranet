@extends('template.plantilla') 
@section('content')
@include('flash::message')
    <title>Solicitar Concentrados | Cercafe</title>
    <script type="text/javascript"> 
        $(document).ready(function () {
            $("#generar").hide();
            $("#advertencia").hide();
            $("#granjas").select2({
                placeholder: "Granja."
            }); 
            $('#pro_id').select2({
                placeholder: "Seleccione Concentrado."
            });
            $("#fecha_estimada").datepicker({
                changeMonth: true,
                changeYear: true,
                yearRange: "1950:2100",
                dateFormat: "yy-mm-dd",
                showButtonPanel: true,
            })
        });  
        // Refresca Producto: Refresco la Lista de Productos dentro de la Tabla
        // Si es vacia deshabilito el boton guardar para obligar a seleccionar al menos un producto al usuario
        // Sino habilito el boton Guardar para que pueda Guardar

        function RefrescaProducto() 
        {
            var ip = []; 
            var i = 0;
            $('#guardar').attr('disabled', 'disabled'); //Deshabilito el Boton Guardar
            $('.iProduct').each(function(index, element) 
            {
                i++;
                ip.push({
                    id_pro: $(this).val()
                });
            });
            // Si la lista de Productos no es vacia Habilito el Boton Guardar
            if (i > 0) {
                $('#guardar').removeAttr('disabled', 'disabled');
            }
            var ipt = JSON.stringify(ip); //Convierto la Lista de Productos a un JSON para procesarlo al controlador
            $('#ListaPro').val(encodeURIComponent(ipt));
        }

        function agregarProducto() 
        {   
            var fecha_estimada = $("#fecha_estimada").val();
            // console.log(fecha_estimada)
            var text = $('#pro_id').val(); //Capturo el Value del Producto
            //var text = $('#pro_id').find(':selected').text(); Capturo el Nombre del Producto- Texto dentro del Select
            var granja_1 = $("select[name='granja']").val();
 
            @foreach($productos as $producto)   
                var ref_concentrado = <?php echo json_encode($producto->ref_concentrado); ?>;
                var nombre_concentrado = <?php echo json_encode($producto->nombre_concentrado); ?>;
                var kg = <?php echo json_decode($producto->kg); ?>;
                var unidad_m = <?php echo json_encode($producto->unidad_medida); ?>;
                if(unidad_m == "1")
                {
                    var medida = "Bultos";
                }
                else
                {
                    var medida = "Granel";
                }

                if (granja_1 == '' || fecha_estimada == '') 
                {
                    swal({ 
                        title:"Faltan Campos por Llenar",
                        text:'',
                        type:'warning',
                        showCancelButton:false,
                        buttons:true,
                        warningMode:true
                    });
                }
                else
                {
                    if (text == ref_concentrado)
                    {
                        $("#generar").show();
                        var id = <?php echo json_encode($producto->id); ?>;
                        var sptext = text.split();
                        var newtr = '<tr class="item" data-id="' + id + '">';
                        newtr = newtr + '<td class="iProduct">' + ref_concentrado + '</td>';
                        newtr = newtr + '<td class="iProduct">' + nombre_concentrado + '</td>';
                        if (medida == "Granel")
                        {
                            newtr = newtr + '<td class="iProduct"><input type="hidden" class="form-control" id="cant" name="ListaPro" readonly value="0"/></td>';
                            newtr = newtr + '<td class="iProduct"><input type="number" class="form-control" id="kilos_granel" name="ListaPro" placeholder="Ingrese # KG..."/></td>';
                        }
                        else
                        {
                            newtr = newtr + '<td class="iProduct"><input type="number" class="form-control" id="cant" name="ListaPro" placeholder="Ingrese # Bultos..."/></td>';
                            newtr = newtr + '<td class="iProduct"><input type="hidden" class="form-control" id="kilos_granel" name="ListaPro" readonly value="0"/></td>';
                        }
                        newtr = newtr + '<td class="iProduct" id="medida">' + medida + '</td>';
                        newtr = newtr + '<td><button type="button" class="btn btn-danger btn-xs remove-item"><i class="fa fa-times"></i></button></tr>';
                    }
                }
            @endforeach

            $("#generar").click(function () {
                $("#advertencia").show();
            });

            $('#ProSelected').append(newtr); //Agrego el Producto al tbody de la Tabla con el id=ProSelected
            RefrescaProducto(); //Refresco Productos
            $('.remove-item').off().click(function(e) {
                $(this).parent('td').parent('tr').remove(); //En accion elimino el Producto de la Tabla
                if ($('#ProSelected tr.item').length == 0)
                    $('#ProSelected .no-item').slideDown(300);
                RefrescaProducto();
            });
            $('.iProduct').off().change(function(e) {
                RefrescaProducto();
            });

            $('#pro_id').val('');
        }    
    </script>
   
    <div class="panel panel-default">
        <div class="panel-heading" id="titulo">
            <h4 style="font-size: 25px;"><i class="fa fa-list-alt" aria-hidden="true"></i> Nuevo Pedido de Concentrados</h4>
        </div>
        <br>
        <div class="container-fluid">
            {!! Form::open(['class' => 'form-inline']) !!}
                <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token" required />
                <div class="form-group">
                    <select name="granja" class="form-control" id="granjas">
                        <option value=""></option>
                        @if(Auth::User()->rol_id == 7)
                            @foreach($granjas as $granja)
                                <option value="{{$granja->id}}">{{$granja->nombre_granja}}</option>     
                            @endforeach
                        @else 
                            @foreach($g_as as $g)
                                @if($g->user_id == Auth::User()->id)
                                    @foreach($granjas as $granja)
                                        @if($g->granja_id == $granja->id)
                                            <option value="{{$granja->id}}">{{$granja->nombre_granja}}</option>
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach
                        @endif
                    </select> 
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" readonly style="cursor: pointer;" id="fecha_estimada" placeholder="Fecha Estimada">
                </div>
                <div class="form-group">
                    <button type="button" class="btn btn-success" id="agregar_concentrados" data-toggle="modal" data-target="#myModal"><span class="fa fa-plus"></span> Agregar concentrados</button>
                </div>
                <script type="text/javascript">
                    $("#generar").click(function () {
                        var fecha = $("#fecha_estimada").val();
                    })
                    function verificarBultosyKilos()
                    {
                        sumar = [];
                        var cont = 0;
                        var total_bultos = 0;
                        var total_kilos = 0;
                        var total_kilos_g = 0;
                        var acumulado_nutal = 0;
                        
                        $('#ProSelected').find('tr').each(function(i,el)
                        {
                            var granja = $('select').val();
                            var f_entrega = $("input[name='fecha_entrega']").val();
                            var $tds = $(this).find('td');
                            var codigo = $tds.eq(0).text();
                            var concentrados = $tds.eq(1).text();
                            let cantidad = $tds.eq(2).find("#cant").val();
                            var kilos_granel = $tds.eq(3).find("#kilos_granel").val();
                            var unidad = $tds.eq(4).text();
                            var kilos_por_cuarenta = 40;
                            var kilos_por_veinte = 20;
                            var total= 0;
                            if (!isNaN(cantidad))
                            {
                                total_bultos = !isNaN(total_bultos) ? parseInt(total_bultos, 10) : 0;
                                total_bultos = parseInt(cantidad, 10) + parseInt(total_bultos, 10); 
                                document.getElementById("total_bultos").value = total_bultos;

                                if (codigo == "022111")
                                {
                                    acumulado_nutal = !isNaN(acumulado_nutal) ? parseInt(acumulado_nutal, 10) : 0;
                                    acumulado_nutal = kilos_por_veinte * parseInt(cantidad, 10);
                                }
                                else
                                {
                                    if(unidad != "Granel")
                                    {
                                        total_kilos = !isNaN(total_kilos) ? parseInt(total_kilos, 10) : 0;
                                        if(cont == 0 && unidad == "Bultos")
                                        {
                                            total_kilos = kilos_por_cuarenta * parseInt(cantidad, 10);
                                        }
                                        else
                                        {
                                            total_kilos = kilos_por_cuarenta * parseInt(total_bultos, 10);
                                        }
                                    }
                                }
                                total_kilos_g = !isNaN(total_kilos_g) ? parseInt(total_kilos_g, 10) : 0;
                                total_kilos_g = parseInt(kilos_granel) + parseInt(total_kilos_g, 10);

                                total = !isNaN(total) ? parseInt(total, 10) : 0;
                                total = parseInt(total_kilos, 10) + parseInt(total_kilos_g, 10) + parseInt(acumulado_nutal, 10);
                                document.getElementById("total_kilos").value = total;
                            }
                            cont ++;
                        });
                    }
                </script>
                <script type="text/javascript">
                    function enviarProductos()
                    {
                        pedido = [];
                        var cont = 0;
                        $('#ProSelected').find('tr').each(function(i,el)
                        {
                            var granja = $('select').val();
                            var f_entrega = 'por verificar';
                            var $tds = $(this).find('td');
                            var codigo = $tds.eq(0).text();
                            var concentrados = $tds.eq(1).text();
                            var cantidad = $tds.eq(2).find("#cant").val();
                            var kilos_granel = $tds.eq(3).find("#kilos_granel").val();
                            var unidad = $tds.eq(4).text();
                            var t_bultos = $("input[name='total_bultos']").val();
                            var t_kilos = $("input[name='total_kilos']").val();
                            var conductor = 'por verificar';
                            var vehiculo = 'por verificar';
                            var fecha_estimada = $("#fecha_estimada").val();

                            @foreach($productos as $producto)  
                                var concentrado = <?php echo json_encode($producto->nombre_concentrado); ?>;

                                if (concentrado == concentrados) 
                                {
                                    var kilos = <?php echo json_encode($producto->kg); ?>;
                                }
                            @endforeach

                            item = {}
                            item["granja"] = granja;
                            item["fecha_entrega"] = f_entrega;
                            item["codigo"] = codigo;
                            item["concentrado"] = concentrados;
                            item["cantidad"] = cantidad; 
                            item["kilos_bulto"] = kilos;
                            item["kilos_granel"] = kilos_granel;
                            item["total_bultos"] = t_bultos;
                            item["total_kilos"] = t_kilos;
                            item["conductor"] = conductor;
                            item["vehiculo"] = vehiculo;
                            item["fecha_estimada"] = fecha_estimada; 
                            item["unidad_medida"] = unidad; 
                            
                            pedido.push(item);    
                        });
                        pedido["pedido_concentrados"] = pedido;
                       
                        pedido.forEach(function(element) 
                        {
                            if (element["cantidad"] != '') 
                            {
                                vacio = element["cantidad"];
                            }
                            else
                            {
                                swal({ 
                                    title:"Cantidad Vacia.",
                                    text:'Uno o mas campos de cantidad estan vacios.',
                                    type:'error',
                                    showCancelButton:false,
                                    buttons:true,
                                    dangerMode:true
                                });
                                cont ++;
                            }
                        });  
                    
                        if (cont == 0)
                        {
                            var token = $("#token").val();    
                            $.ajax({
                                type: "POST",
                                headers: {'X-CSRF-TOKEN': token},
                                url: "http://201.236.212.130:82/intranetcercafe/public/admin/pedidoConcentrados",
                                dataType: 'json',
                                data: {data: JSON.stringify(pedido)},
                            });
                            swal({
                                title:'Pedido Enviado Satisfactoriamente.',
                                text:'',
                                type:'success',
                                showCancelButton:false,
                                buttons:true,
                                successMode:true
                            })
                            .then((willDelete) => {
                              if (willDelete) {
                                 location.reload(true);
                              } else {
                                swal("Ha ocurrido un Error!");
                              }
                            });
                        }
                    }
                </script>
            {{Form::close()}}
        </div>
        <div class="panel-body table-responsive">
            <table id="TablaPro"  class="table table-bordered table-hover text-center" cellspacing="0" width="100%">
                <thead style="background-color: #df0101;"> 
                    <tr style="color: white;">
                        <td><strong>Codigo</strong></td>
                        <td><strong>Concentrados</strong></td>
                        <td><strong># Bultos</strong></td>
                        <td><strong># Kilos</strong></td>
                        <td><strong>Unidad de Medida</strong></td>
                        <td><strong>Accion </strong></td>
                    </tr>
                </thead>
                <tbody id="ProSelected">
                    <tr>
                       
                    </tr>
                </tbody>
            </table> 
            <div class="form-inline" align="right" style="margin-top: 1em;">
                <input type="button" id="verificar" class="btn btn-info" value="Verificar Totales" onclick="verificarBultosyKilos();">
                <label>Total de Bultos: </label>
                <input style="width: 60px;" name="total_bultos" class="form-control" type="text" id="total_bultos" readonly value="0">
                <label>Total de Kilos: </label>
                <input style="width: 60px;" name="total_kilos" class="form-control" type="text" id="total_kilos" readonly value="0">
            </div>           
        </div>
    </div>
    
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h1 class="modal-title" style="color: red;"><i class="fa fa-medkit fa-2x" aria-hidden="true""></i> Buscar concentrados</h1>
                </div>
                <div class="modal-body">
                    <label for="" class="control-label"><h4>Digite el nombre o codigo del concentrados en el siguiente campo:</h4></label>
                    <select class="form-control" id="pro_id" name="pro_id" style="width: 100% !important;">
                        <option value=""></option>
                        @foreach($productos as $producto) 
                            @if($producto->disable != 1)
                                <option value="{{$producto->ref_concentrado}}">{{$producto->nombre_concentrado}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="agregarProducto()" data-dismiss="modal">Agregar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid form-group pull-right">
        <button type="button" id="generar" class="btn btn-warning btn-lg"><i class="fa fa-send-o"></i> <strong>Generar Pedido</strong></button>
    </div>

    <div class="container-fluid" id="advertencia">
        <h2><strong>¿Estas Seguro?</strong></h2>
        <h4><strong>Verifica toda la información del pedido</strong>...<strong style="color: #df0101">RECUERDA</strong> que despues de enviado, <strong>NO</strong> hay posibilidad de cambiar informacion.</h4>
        <a href="#" data-dismiss="modal" class="btn btn-primary btn-lg" onclick="enviarProductos()">Solicitar Pedido</a>
    </div>
    <script type="text/javascript">
        $(document).on('click', '.open-Modal', function()
        {
            var myDNI = $(this).data('id'); 
            $('.modal-body #DNI').val( myDNI ); 
        });
    </script> 
@endsection