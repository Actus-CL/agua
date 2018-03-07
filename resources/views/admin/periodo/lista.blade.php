@extends('admin.layouts.admin')

@section('content')
    <!-- page content -->
    <!-- top tiles -->



    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Listado de Periodos <small> </small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#">Settings 1</a>
                                </li>
                                <li><a href="#">Settings 2</a>
                                </li>
                            </ul>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br />
                    <table id="datatable" class="table table-striped table-bordered" >
                        <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Activo</th>
                            <th>Desde</th>
                            <th>Hasta</th>
                            <th>Pago</th>
                            <th>Corte</th>
                            <th> </th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    $( document ).ready(function() {

        var tabla = $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.periodo.lista.tabla')}}",
            columns: [
                {data: 'nombre', name: 'nombre'},
                {data: 'activo', name: 'activo'},
                {data: 'desde', name: 'desde'},
                {data: 'hasta', name: 'hasta'},
                {data: 'f_vencimiento_pago', name: 'f_vencimiento_pago'},
                {data: 'f_vencimiento_corte', name: 'f_vencimiento_corte'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ],
            "bFilter": true,
            "iDisplayLength": 10,
            "language": {
                "lengthMenu": "Mostrando _MENU_ resultados por página",
                "zeroRecords": "Sin resultados",
                "info": "Página _PAGE_ de _PAGES_",
                "infoEmpty": "Vacío",
                "infoFiltered": "(Filtrado desde _MAX_ resultados)",
                "processing":     "Procesando...",
                "search":         "Buscar:",
                "paginate": {
                    "first":      "Inicio",
                    "last":       "Fin",
                    "next":       "Siguiente",
                    "previous":   "Atrás"
                }
            }

        });


        $('#tabla-listado-propiedades').delegate('.bt_eliminar','click',   function(){

            var id = $(this).data("id");
            $.ajax({
                url: '{{url('admin/propiedad')}}/'+id,
                type: 'DELETE',
                data: $('#form-listado-propiedades').serialize(),
                success: function (data) {
                    if(data=="eliminado"){
                        alert('La propiedad ha sido eliminado');
                        location.reload();
                    }
                }
            });
        });

    });

</script>

@parent
{{ Html::script(mix('assets/admin/js/dashboard.js')) }}
@endsection

@section('styles')
    @parent
    {{ Html::style(mix('assets/admin/css/dashboard.css')) }}
@endsection
