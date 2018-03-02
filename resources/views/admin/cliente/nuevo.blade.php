@extends('admin.layouts.admin')

@section('content')
    <!-- page content -->
    <!-- top tiles -->



    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Nuevo Cliente <small> </small></h2>
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
                    <form   data-parsley-validate class="form-horizontal form-label-left autoform" action="{{route("admin.cliente.nuevo")}}" method="post">
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12">

                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Nombres <span class="required">*</span>
                                    </label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                        <input type="text" id="nombre" name="nombre" required="required" class="form-control col-md-7 col-xs-12" >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-3 col-xs-12" for="last-name">Apellido Paterno <span class="required">*</span>
                                    </label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                        <input type="text" id="apellido_paterno" name="apellido_paterno" required="required" class="form-control col-md-7 col-xs-12">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="middle-name" class="control-label col-md-4 col-sm-3 col-xs-12">Apellido Materno</label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                        <input id="apellido_materno" name="apellido_materno" class="form-control col-md-7 col-xs-12" type="text" >
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-6 col-sm-6 col-xs-12">

                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Rut <span class="required">*</span>
                                    </label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                        <input type="text" id="rut" name="rut" required="required"  class="form-control col-md-7 col-xs-12">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="last-name">Email  <span class="required">*</span>
                                    </label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                        <input type="text" id="email" name="email" required="required" class="form-control col-md-7 col-xs-12">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="middle-name" class="control-label col-md-4 col-sm-4 col-xs-12">Direccion</label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                        <input id="direccion" name="direccion" class="form-control col-md-7 col-xs-12" type="text" >
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                <button class="btn btn-primary" type="button">Cancel</button>
                                <button class="btn btn-primary" type="reset">Reset</button>
                                <button type="submit" class="btn btn-success" >Submit</button>
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


            $('.autoform').on('submit', function(){
                var bt = $(this).find('button[type="submit"]');
                bt.attr("disabled","disabled");
                event.preventDefault();
                var action = $(this).attr("action");
                var method = $(this).attr("method");
                $.ajax({
                    url: action,
                    type: method,
                    data: $(this).serialize(),
                    success: function (data) {
                        var respuesta = $.parseJSON( data);
                        //console.log(respuesta.correcto);

                        if ( respuesta.correcto ==1) {
                            if (respuesta.mensajeOK != null){
                                alert(respuesta.mensajeOK);
                            }else{
                                alert("Se han guardado las modificaciones");
                            }
                            if (respuesta.redireccion!= null){
                                //  $.(respuesta.redireccion);
                            }else{
                                location.reload();
                            }
                        }else{
                            if (respuesta.mensajeBAD!= null){
                                alert(respuesta.mensajeBAD);
                            }else{
                                alert("Ha ocurrido un problema");
                            }
                        }
                        // alert("Lo sentimos, ha ocurrido un problema");
                        bt.removeAttr("disabled");
                    }
                });
            });

            $('#rut').on('blur', function(){
                var rut = $(this).val();
                //alert("sfsd");
                $.ajax({
                    url: "{{route("admin.cliente.validar.rut")}}",
                    type: "post",
                    data: {rut:rut},
                    success: function (data) {
                    }
                });
            });
        });
        </script>
@endsection

@section('styles')
    @parent
    {{ Html::style(mix('assets/admin/css/dashboard.css')) }}
@endsection
