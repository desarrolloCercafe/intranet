@extends('template.plantilla') 
@section('content')
    @include('flash::message')
    <title>Solicitar Medicamentos | Cercafe</title>
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
            $("#pro_id").select2({
                placeholder: 'Seleccione Medicamento.'
            });
        });

        // Refresca Producto: Refresco la Lista de Productos dentro de la Tabla
        // Si es vacia deshabilito el boton guardar para obligar a seleccionar al menos un producto al usuario
        // Sino habilito el boton Guardar para que pueda Guardar

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
            var text = $('#pro_id').val(); //Capturo el Value del Producto
            //var text = $('#pro_id').find(':selected').text(); Capturo el Nombre del Producto- Texto dentro del Select
            var granja_1 = $("select[name='granja']").val();
            var tipo_p = $("select[name='tipo_pedido']").val();

            // console.log(granja_1);

            @foreach($productos as $producto)   
                var ref_medicamento = <?php echo json_encode($producto->ref_medicamento); ?>;
                var nombre_medicamento = <?php echo json_encode($producto->nombre_medicamento); ?>;
                if (granja_1 =='') {
                    swal({ 
                        title:"Granja Vacía",
                        text:'',
                        type:'warning',
                        showCancelButton:false,
                        buttons:true,
                        warningMode:true
                    });
                }
                else
                {
                    if(tipo_p == 0)
                    {
                        swal({ 
                            title:"Especificar Tipo de Pedido",
                            text:'',
                            type:'warning',
                            showCancelButton:false,
                            buttons:true,
                            warningMode:true
                        });
                    }
                    else
                    { 
                        if (text == ref_medicamento)
                        {
                            $("#generar").show();
                            var id = <?php echo json_encode($producto->id); ?>;
                            var sptext = text.split();
                            var newtr = '<tr class="item" data-id="' + id + '">';
                            newtr = newtr + '<td class="iProduct">' + ref_medicamento + '</td>';
                            newtr = newtr + '<td class="iProduct">' + nombre_medicamento + '</td>';
                            newtr = newtr + '<td class="iProduct"><input type="number" class="form-control" id="cant" name="ListaPro"/></td>';
                            newtr = newtr + '<td><button type="button" class="btn btn-danger btn-xs remove-item"><i class="fa fa-times"></i></button></td></tr>';  
                        }
                    }
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

            $('#pro_id').val('');
        }  
    </script>
   
    <div class="panel panel-default">
            <div class="panel-heading" id="titulo">
                <h4 style="font-size: 30px;"><i class="fa fa-list-alt" aria-hidden="true"></i> Nuevo Pedido</h4>
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
                        <select name="tipo_pedido" class="form-control" id="t_pedido">
                            <option value="0">Seleccione tipo de Pedido</option>
                            <option value="1">Pedido del Mes</option>
                            <option value="2">Pedido Adicional</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="button" class="btn btn-success" id="agregar_medicamento" data-toggle="modal" data-target="#myModal"><span class="fa fa-plus"></span> Agregar Medicamento</button>
                    </div>
                    <script type="text/javascript">
                        function enviarProductos()
                        {
                            pedido = [];
                            var cont = 0;
                            $('#ProSelected').find('tr').each(function(i,el)
                            {
                                var granja = $('#granjas').val();
                                var t_pedido = $('#t_pedido').val();
                                var $tds = $(this).find('td');
                                var codigo = $tds.eq(0).text();
                                var medicamento = $tds.eq(1).text();
                                var cantidad = $tds.eq(2).find("#cant").val();

                                item = {}
                                item["granja"] = granja;
                                item["codigo"] = codigo;
                                item["medicamento"] = medicamento;
                                item["cantidad"] = cantidad;
                                item["tipo"] = t_pedido;
                                
                                pedido.push(item);    
                            });
                            pedido["pedido_medicamentos"] = pedido;
                           
                            pedido.forEach(function(element) 
                            {
                                if (element["cantidad"] != '') 
                                {
                                    vacio = element["cantidad"];
                                }else{
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
                                    url: "http://201.236.212.130:82/intranetcercafe/public/admin/pedidoMedicamentos",
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
                    <label for="" class="control-label"><h4>Digite el nombre o codigo del Medicamento en el siguiente campo:</h4></label>
                    <select class="form-control" id="pro_id" name="pro_id" style="width: 100% !important;">
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