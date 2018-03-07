@extends('admin.layouts.admin')

@section('content')
    <!-- page content -->
    <!-- top tiles -->



    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Ingresar nueva lectura <small> </small></h2>
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
                    <form   data-parsley-validate class="form-horizontal form-label-left autoform" action="{{route("admin.lectura.nuevo")}}" method="post">
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12">

                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Medidor <span class="required">*</span>
                                    </label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                        <input type="text" name="country" id="autocomplete-custom-append" class="form-control col-md-10" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group xdisplay_inputx has-feedback">
                                    <label class="control-label col-md-4 col-sm-3 col-xs-12" for="last-name">Desde
                                    </label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                        <input type="text" class="inputfecha form-control has-feedback-left" id="single_cal1"  name="desde"  value=""  aria-describedby="inputSuccess2Status">
                                        <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                        <span id="inputSuccess2Status" class="sr-only">(success)</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="middle-name" class="control-label col-md-4 col-sm-3 col-xs-12">Hasta</label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                        <input type="text" class="inputfecha form-control has-feedback-left" id="single_cal1"  name="hasta"  aria-describedby="inputSuccess2Status">
                                        <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                        <span id="inputSuccess2Status" class="sr-only">(success)</span>
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-6 col-sm-6 col-xs-12">

                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Mes <span class="required">*</span>
                                    </label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                        <input type="text" id="mes" name="mes"  required="required" value=" "  class="form-control col-md-7 col-xs-12">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="last-name">Año  <span class="required">*</span>
                                    </label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                        <input type="text" id="anio" name="anio"  required="required" value=" " class="form-control col-md-7 col-xs-12">
                                    </div>
                                </div>

                            </div>
                        </div>


                        <div class="ln_solid"></div>

                        <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                <button type="submit" class="btn btn-success" id="btsubmit" >Guardar</button>
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

            $('input[name="mes"],input[name="anio"]').on( 'blur', function(){
                var mes = $('input[name="mes"]').val();
                var anio = $('input[name="anio"]').val();
                var nombre = mes+anio;
                console.log(nombre);
                $('input[name="nombre"]').val(nombre);
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

        });
    </script>
    @parent
    {{ Html::script(mix('assets/admin/js/dashboard.js')) }}
@endsection

@section('styles')
    @parent
    {{ Html::style(mix('assets/admin/css/dashboard.css')) }}
@endsection
