@extends('admin.layouts.admin')

@section('content')
    <!-- page content -->
    <!-- top tiles -->



    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Asociar medidor a Cliente <small> </small></h2>
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
                    <form   data-parsley-validate class="form-horizontal form-label-left autoform" action="{{route("admin.cuenta.nuevo")}}" method="post">
                        <h4>Seleccionar un cliente</h4>
                    <table id="datatable" class="table table-striped table-bordered" >
                        <thead>
                        <tr>
                            <th>Nº</th>
                            <th>Rut</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Direccion</th>
                            <th> </th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>

                    </table>
                    <div class="ln_solid"></div>
                        <h4>Cliente seleccionado</h4>
                         <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12">

                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Nombres <span class="required">*</span>
                                    </label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                        <input type="text" id="nombre" name="nombre" readonly="readonly" class="form-control col-md-7 col-xs-12" >
                                        <input type="hidden" id="cliente_id" name="cliente_id"  class="form-control col-md-7 col-xs-12" >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-3 col-xs-12" for="last-name">Apellido Paterno <span class="required">*</span>
                                    </label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                        <input type="text" id="apellido_paterno" name="apellido_paterno" readonly="readonly" class="form-control col-md-7 col-xs-12">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="middle-name" class="control-label col-md-4 col-sm-3 col-xs-12">Apellido Materno</label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                        <input id="apellido_materno" name="apellido_materno" readonly="readonly" class="form-control col-md-7 col-xs-12" type="text" >
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-6 col-sm-6 col-xs-12">

                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Rut <span class="required">*</span>
                                    </label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                        <input type="text" id="rut" name="rut"  data-tabla="cliente" readonly="readonly"  class="autoval form-control col-md-7 col-xs-12">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="last-name">Email
                                    </label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                        <input type="text" id="email" name="email" data-tabla="cliente" readonly="readonly" class="autoval form-control col-md-7 col-xs-12">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="middle-name" class="control-label col-md-4 col-sm-4 col-xs-12">Direccion</label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                        <input id="direccion" name="direccion" class="form-control col-md-7 col-xs-12" type="text"  readonly="readonly" >
                                    </div>
                                </div>


                            </div>
                        </div>
                        <div class="ln_solid"></div>

                        <h4>Seleccionar proyecto inmobiliario</h4>
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12">

                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Proyecto <span class="required">*</span>
                                    </label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                        {{Form::select('proyecto_id',[],null,['class'=>'form-control'])}}

                                    </div>
                                </div>
                            </div>


                            <div class="col-md-6 col-sm-6 col-xs-12">



                            </div>
                        </div>

                        <div class="ln_solid"></div>
                        <h4>Seleccionar medidor</h4>
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Medidor <span class="required">*</span>
                                    </label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                        {{Form::select('medidor_id',$bag['medidor'],null,['class'=>'form-control'])}}

                                    </div>
                                </div>
                            </div>


                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Modelo <span class="required">*</span>
                                    </label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                        <input type="text" id="modelo_medidor" name="modelo_medidor"   readonly="readonly" class="autoval form-control col-md-7 col-xs-12" >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Lectura Inicial <span class="required">*</span>
                                    </label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                        <input type="text" id="lectura_inicial" name="lectura_inicial" readonly="readonly" class="form-control col-md-7 col-xs-12" >
                                    </div>
                                </div>


                            </div>
                        </div>




                        <div class="ln_solid"></div>



                        <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                <button type="submit" class="btn btn-success" id="btsubmit" disabled >Guardar Asociacion</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>

    </div>


@endsection

@section('scripts')
    <script>
        $( document ).ready(function() {



            $('#datatable').delegate('.rbseleccionar','click', function(){
                var val = $(this).val();
              // var tabla = $(this).data('tabla');

                //var campo = $(this).attr('name');
               // alert("sfsd" + val);
                $.ajax({
                    url: "{{route("admin.cliente.detalle")}}",
                    type: "post",
                    data: {val:val},
                    success: function (data) {
                        //console.log(data);
                        var respuesta = $.parseJSON( data);
                        $('#nombre').val(respuesta.nombre);
                        $('#apellido_paterno').val(respuesta.apellido_paterno);
                        $('#apellido_materno').val(respuesta.apellido_materno);
                        $('#rut').val(respuesta.rut);
                        $('#email').val(respuesta.email);
                        $('#direccion').val(respuesta.direccion);
                        $('#cliente_id').val(respuesta.id);
                    }
                });
                $.ajax({
                    url: "{{route("admin.cliente.detalle.proyectos")}}",
                    type: "post",
                    data: {val:val},
                    success: function (data) {
                        //console.log(data);
                        var respuesta = $.parseJSON( data);
                        //console.log(respuesta[0]['nombre']);

                        if(respuesta.length > 0 ) {
                            $('select[name="proyecto_id"]').html("");
                            for (var p in respuesta) {
                                $('select[name="proyecto_id"]').append("<option value='" + respuesta[p].id + "'> " + respuesta[p].nombre + "</option>");
                            }
                            $("#btsubmit").removeAttr("disabled");
                        }else{
                            alert("Este cliente no está asociado a ningun proyecto");
                        }


                    }
                });

            });


            $('select[name="medidor_id"]').on( 'change', function(){
                    var val = $(this).val();
                    $.ajax({
                        url: "{{route("admin.medidor.detalle")}}",
                        type: "post",
                        data: {val:val},
                        success: function (data) {
                            //console.log(data);
                            var respuesta = $.parseJSON( data);
                            //console.log(respuesta['modelo']);
                            // $('#nombre').val(respuesta.nombre);
                            $('#lectura_inicial').val(respuesta['medidor'].lectura_inicial);
                            $('#modelo_medidor').val(respuesta['modelo'][respuesta['medidor'].medidor_modelo_id]);
                        }
                    });



                });




            var tabla = $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.cuenta.lista.clientes.tabla')}}",
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'rut', name: 'rut'},
                    {data: 'nombre', name: 'nombre'},
                    {data: 'email', name: 'email'},
                    {data: 'direccion', name: 'direccion'},
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
        });
    </script>
    @parent
    {{ Html::script(mix('assets/admin/js/dashboard.js')) }}
@endsection

@section('styles')
    @parent
    {{ Html::style(mix('assets/admin/css/dashboard.css')) }}
@endsection
