@extends('template.plantilla')
@section('content')
    <title>Calendario de Concentrados | Cercafe</title>
    <div id='calendar'> 
    </div>
    <div id="modal-event" class="modal fade" tabindex="-1" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background: #A30303; color: #ffffff; text-align: center;">
                    <!--clases de bootstrap por defecto -->
                    <h3><strong>Informacion del Pedido</strong></h3><!-- cabezera del modal -->
                </div>
                <div class="modal-body">
                    {{ Form::open(['method' => 'put']) }}
                        <div class="form-group">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token" required />
                            <input type="hidden" value="" id="id_pedido">
                       
                            {{ Form::label('_date_start', 'Fecha de Entrega') }}
                            {{ Form::text('_date_start', old('_date_start'), ['class' => 'form-control', 'readonly' => 'true']) }}
                        </div>

                        <div class="form-group">     
                            {{ Form::label('_consecutivo', 'Consecutivo') }}
                            {{ Form::text('_consecutivo', old('_consecutivo'), ['class' => 'form-control','readonly' => 'true']) }}
                        </div>

                        <div class="form-group">
                            {{ Form::label('_placa', 'Placa') }}
                            {{ Form::text('_placa', old('_placa'), ['class' => 'form-control','readonly' => 'true']) }}
                        </div>
                        
                        <div class="form-group">
                            {{ Form::label('_conductor', 'Conductor') }}
                            {{ Form::text('_conductor', old('_conductor'), ['class' => 'form-control','readonly' => 'true']) }}
                        </div>

                        <div class="form-group">
                            {{ Form::label('_time_start', 'Hora de Entrega') }}
                            {{ Form::text('_time_start', old('_time_start'), ['class' => 'form-control','readonly' => 'true']) }}
                        </div>
                        {{-- <div class="form-group">
                            {{Form::label('_date','Fecha Modificada')}}
                            {{Form::hidden('_date',old('_date'),['class'=>'form-control','readonly'=>'true'])}}
                        </div> --}}
                    {{Form::close()}}
                </div>
                <div class="modal-footer">
                    @if(Auth::User()->rol_id == 7 || Auth::User()->rol_id == 10)
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    @else
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-success" id="actualizar">Actualizar</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">

        var evt=[];
        $.ajax({
            url:'entregas/get',
            type:"GET",
            dataType:"JSON",
            async:false
        }).done(function(r){
            evt = r;
        });

        $(document).ready(function(){
            $('#time_start').mdtimepicker(); 
            $('#calendar').fullCalendar({
                header: 
                {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,listWeek',
                },
                
                navLinks: true, 
                editable: true,
                selectable: true,
                selectHelper: true,

                select: function(start)
                {
                    start = moment(start.format());
                    $('#date_start').val(start.format('YYYY-MM-DD'));
                    $('#responsive-modal').modal('show');
                },

                events: evt,
                eventClick: function(event)
                {
                    var horaDefecto = '00:00:00';
                    var hora1 = '16:00:00';
                    var hora2 = '24:00:00';
                    var date_start = $.fullCalendar.moment(event.start).format('YYYY-MM-DD');
                    var time_start = $.fullCalendar.moment(event.start).format('HH:mm:ss');
                    
                    var f = time_start.toString();

                    $('#modal-event #id_pedido').val(event.id)
                    $('#modal-event #_consecutivo').val(event.name);
                    $('#modal-event #_placa').val(event.vehiculo_seleccionado);
                    $('#modal-event #_date_start').val(date_start);
                    $('#modal-event #_time_start').val(time_start);
                    $('#modal-event #_conductor').val(event.conductor_seleccionado);
                    // $('#modal-event #_date').val(d);

                    var hoy = new Date();
                    var fecha = new Date(date_start + ' ' + time_start);
                    // console.log(fecha)

                    fecha.setDate(fecha.getDate() + 1);
                    
                    // if (hoy.getTime() > fecha.getTime())
                    // {
                    //     $("#modal-event").modal("show");
                    // }else{
                    //     swal({
                    //         title:'Señor Usuario',
                    //         text:'Le Recordamos que Tiene un Plazo de 24 Horas para Poder Cambiar el Pedido en Caso de que su Conductor no Pueda a la Hora Especificada.',
                    //         type:'info',
                    //         showCancelButton:true,
                    //         cancelButtonClass:'btn-default',
                    //         cancelButtonText:'No Cambiar.',
                    //         confirmButtonClass:'btn-success',
                    //         confirmButtonText:'Cambiar Hora.',
                    //         closeOnConfirm:true,
                    //         closeOnCancel:true
                    //     },function (isConfirm) {
                    //         if (isConfirm) {
                    //             $('#modal-event').modal('show');
                    //             $('#_time_start').mdtimepicker({
                    //                 date: false, 
                    //                 shortTime: false,
                    //                 format: 'hh:mm:ss'
                    //             }); 
                    //             $("#_time_start").attr('readonly',true);
                    //             $("#actualizar").show();
                    //         }
                    //     });
                    // }


                    if (f > hora1 && f < hora2) 
                    {
                        swal({
                            title:'Pedido no Valido',
                            text:'Por Favor Verifique la Hora',
                            type:'error',
                            showCancelButton:false,
                            confirmButtonClass: "btn-warning",
                            confirmButtonText: "Corregir Hora",
                            closeOnConfirm: true
                        },function () {
                            $('#modal-event').modal('show');
                            $('#_time_start').mdtimepicker({
                                date: false, 
                                shortTime: false,
                                format: 'hh:mm:ss'
                            }); 
                            $("#_time_start").attr('readonly',true);
                            $("#actualizar").show();
                        })
                    }
                    else if(f == horaDefecto)
                    {
                        @if(Auth::User()->rol_id == 7 || Auth::User()->rol_id == 10)
                            $('#modal-event').modal('show');
                        @else
                            swal({
                                title:'Pedido Pendiente',
                                text:'Por Favor Seleccione una Hora',
                                type:'warning',
                                showCancelButton:false,
                                confirmButtonClass: "btn-warning",
                                confirmButtonText: "Seleccionar Hora de Envío",
                                closeOnConfirm: true
                            },function () {
                                $('#modal-event').modal('show');
                                $('#_time_start').mdtimepicker({
                                    date: false,
                                    shortTime: false, 
                                    format: 'hh:mm:ss'
                                }); 
                                $("#_time_start").attr('readonly',true);
                                $("#actualizar").show(); 
                            }) 
                        @endif
                    }
                    else
                    {
                        $("#_time_start").attr('readonly',true);
                        $("#actualizar").hide();
                        $('#modal-event').modal('show');
                    }
                }
            });
        });
        $('#time_start').mdtimepicker({
            date: false,
            shortTime: false,
            format: 'hh:mm:ss'
        });

        $("#actualizar").click(function () 
        {
            var d = new Date();
            var m = d.getMonth() + 1;
            var mes = (m < 10) ? '0' + m : m;
            d = (d.getFullYear()+'-'+mes+'-'+d.getDate()+' '+d.getHours()+':'+d.getMinutes()+':'+d.getSeconds());
            console.log(d);
            var token = $("#token").val();
            var id = $("#id_pedido").val();
            var new_consecutivo = $("#_consecutivo").val();
            var new_placa = $("#_placa").val();
            var new_conductor = $("#_conductor").val();
            var new_date_start = $("#_date_start").val();
            var new_time_start = $("#_time_start").val();
            var new_fecha_modificada = d;

            p = [];

            item = {}
            item["id_p"] = id;
            item["consecutivo"] = new_consecutivo;
            item["date_start"] = new_date_start;
            item["time_start"] = new_time_start;
            item["placa"] = new_placa;
            item["conductor"] = new_conductor;
            item["fecha_modificada"] = new_fecha_modificada;
            
            p.push(item);  
            // console.log(p);
            swal({
                title:'Hora Actualizada',
                text:'Se ha Actualizado esta Entrega.',
                type:'success',
                showCancelButton:false,
                confirmButtonClass:'btn-success',
                confirmButtonText:'!Aceptar!',
                closeOnConfirm:true
            },function (isConfirm) 
            {
                location.reload(true);
            });

            // console.log(new_time_start);

            $.ajax({
                method:'PUT',
                headers:{'X-CSRF-TOKEN':token},
                url:'entregaconcentrados/update',
                dataType: 'json',
                data: {data: JSON.stringify(p)}
            }).done(function (result) {
            });
        })
    </script>
@endsection