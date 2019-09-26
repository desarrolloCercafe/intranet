@extends('template.plantilla') 
@section('content')
    @include('flash::message')
    <title>Agregar Medicamentos | Cercafe</title>
    <script type="text/javascript"> 
        $(document).ready(function () {
            $("#generar").hide();
            $("#advertencia").hide();
            $("#generar").click(function () {
                $("#advertencia").show();
            });
            $("#granjas").select2({
                placeholder: 'Granja.'
            }); 
            $("#pro_id_edit").select2({
                placeholder: 'Seleccione Medicamento.'
            }); 
        }); 
        $(document).ready(function(){visualizarAntiguos();});
        // Refresca Producto: Refresco la Lista de Productos dentro de la Tabla
        // Si es vacia deshabilito el boton guardar para obligar a seleccionar al menos un producto al usuario
        // Sino habilito el boton Guardar para que pueda Guardar
        function visualizarAntiguos()
        {
            @foreach($pr_db as $p)
                var ref_medicamento = <?php echo json_encode($p["codigo"]) ?>;
                var nombre_medicamento = <?php echo json_encode($p["descripcion"]) ?>;
                var cantidad = <?php echo json_encode($p["unidades"]) ?>;
                var id = <?php echo json_encode($p["id"]); ?>;
                var newtr = '<tr class="item" data-id="' + id + '">';
                newtr = newtr + '<td class="iProduct">' + ref_medicamento + '</td>';
                newtr = newtr + '<td class="iProduct">' + nombre_medicamento + '</td>';
                newtr = newtr + '<td class="iProduct"><input type="number" class="form-control" id="cant" name="ListaPro" value="'+ cantidad +'"/></td>';
                newtr = newtr + '<td><button type="button" class="btn btn-danger btn-xs remove-item"><i class="fa fa-times"></i></button></td></tr>';
                $('#ProSelected').append(newtr);
            @endforeach
            $("#generar").show();
            //Agrego el Producto al tbody de la Tabla con el id=ProSelected
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

            $('#pro_id_edit').val('');
        }

        function RefrescaProducto() 
        {
            var ip = [];
            var i = 0;
            $('#guardar').attr('disabled', 'disabled'); //Deshabilito el Boton Guardar
            $('.iProduct').each(function(index, element) {
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
            var text = $('#pro_id_edit').val();

            @foreach($productos as $producto)   
                var ref_medicamento = <?php echo json_encode($producto->ref_medicamento); ?>;
                if(text == ref_medicamento)
                {
                    var nombre_medicamento = <?php echo json_encode($producto->nombre_medicamento); ?>;
                    var id = <?php echo json_encode($producto->id); ?>;
                    var sptext = text.split();
                    var newtr = '<tr class="item" data-id="' + id + '">';
                    newtr = newtr + '<td class="iProduct">' + ref_medicamento + '</td>';
                    newtr = newtr + '<td class="iProduct">' + nombre_medicamento + '</td>';
                    newtr = newtr + '<td class="iProduct"><input type="number" class="form-control" id="cant" name="ListaPro"/></td>';
                    newtr = newtr + '<td><button type="button" class="btn btn-danger btn-xs remove-item"><i class="fa fa-times"></i></button></td></tr>';
                }
            @endforeach

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

            $('#pro_id_edit').val('');
        }  
        
    </script>
   
    <div class="panel panel-default">
            <div class="panel-heading" id="titulo">
                <h4 style="font-size: 30px;"><i class="fa fa-list-alt" aria-hidden="true"></i> Agregar Producto al pedido PME{{$consecutivo}}</h4>
            </div>
            <br>
            <div class="container-fluid">
                {!! Form::open(['class' => 'form-inline']) !!}
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token" required />
                    <input type="hidden" value="{{$fecha}}" id="f_pedido_mod" required />
                    <div class="form-group">
                        <button type="button" class="btn btn-success" id="agregar_medicamento_pedido" data-toggle="modal" data-target="#myModal"><span class="fa fa-plus"></span> Agregar Medicamento </button>
                    </div>
                    <script type="text/javascript">
                        function enviarProductos()
                        {
                            pedido = [];
                            var cont = 0;
                            $('#ProSelected').find('tr').each(function(i,el)
                            {
                                var granja = $('#granjas').val();
                                var $tds = $(this).find('td');
                                var codigo = $tds.eq(0).text();
                                var medicamento = $tds.eq(1).text();
                                var cantidad = $tds.eq(2).find("#cant").val();
                                var fecha = $('#f_pedido_mod').val();

                                item = {}
                                item["consecutivo"] = {{$consecutivo}};
                                item["granja"] = {{$g}};
                                item["codigo"] = codigo;
                                item["medicamento"] = medicamento;
                                item["cantidad"] = cantidad;
                                item["fecha_pedido"] = fecha.toString();

                                pedido.push(item);    
                            });
                            pedido["pedido_medicamentos"] = pedido;

                            pedido.forEach(function(element) 
                            {
                                if (element["cantidad"] != '') 
                                {
                                    vacio = element["cantidad"];
                                    // console.log("Granja: " + element["granja"] + " " + "Fecha: " + element["fecha_pedido"] + " " + "Ref: " +  element["codigo"] + " " + "Medicamento: " + element["medicamento"] + " " + "Cantidad: " +  element["cantidad"]);
                                }
                                else
                                {
                                    swal({
                                        title:"Cantidad Vacia.",
                                        text:'Uno o mas campos de cantidad estan vacios.',
                                        type:'error',
                                        showCancelButton:false,
                                        confirmButtonClass:'btn-danger',
                                        confirmButtonText:'Corregir',
                                    });
                                    cont ++;
                                }
                            });

                            if (cont == 0)
                            {
                                var token = $("#token").val();    
                                $.ajax({
                                    type: "PUT",
                                    headers: {'X-CSRF-TOKEN': token},
                                    url: "http://201.236.212.130:82/intranetcercafe/public/admin/pedidoMedicamentos/update",
                                    dataType: 'json',
                                    data: {data: JSON.stringify(pedido)},
                                });
                                swal({
                                    title:'Pedido Enviado Satisfactoriamente.',
                                    text:'',
                                    type:'success',
                                    showCancelButton:false,
                                    confirmButtonClass:'btn-success',
                                    confirmButtonText:'Recargar',
                                }, 
                                function(isConfirm)
                                {
                                    location.reload(true);
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
                            <td><strong>Medicamento</strong></td>
                            <td><strong>Cantidad</strong></td>
                            <td><strong>Accion</strong></td>
                        </tr>
                    </thead>
                    <tbody id="ProSelected">
                        <tr>

                        </tr>
                    </tbody>
                </table>
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
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h1 class="modal-title" style="color: red;"><i class="fa fa-medkit fa-2x" aria-hidden="true""></i> Buscar Medicamento</h1>
                </div>
                <div class="modal-body">
                    <label for="" class="control-label">
                        <h4>Digite el nombre o codigo del Medicamento en el siguiente campo:</h4>
                    </label>
                    <select class="form-control" id="pro_id_edit" name="pro_id" style="width: 100% !important;">
                        <option></option>
                        @foreach($productos as $producto)
                            @if($producto->disable != 1)
                                <option value="{{$producto->ref_medicamento}}">{{$producto->nombre_medicamento}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="agregarProducto()" data-dismiss="modal">Agregar</button>
                </div>
            </dv>
        </div>
    </div>
    <script type="text/javascript">
        $(document).on('click', '.open-Modal', function()
        {
            var myDNI = $(this).data('id'); 
            $('.modal-body #DNI').val( myDNI ); 
        });
    </script> 
@endsection