$(document).ready( function () {
    $('#granjas_Cerca').DataTable();

    $(document).on('click','#eliminando',function () {
    	swal({
            title:'Exito',
            text:'Se ha Eliminado la Granja Con Exito',
            type: 'success',
            showCancelButton: false,
            showConfirmButton: false
        });
    })

    $(document).on('click','#crear',function () {
    	swal({
            title:'Exito',
            text:'Se ha Creado la Granja Con Exito',
            type: 'success',
            showCancelButton: false,
            showConfirmButton: false
        });
    })

    $(document).on('click','#editar',function () {
    	swal({
            title:'Exito',
            text:'Se ha Actualizado la Granja Con Exito',
            type: 'success',
            showCancelButton: false,
            showConfirmButton: false
        });
    })
});

