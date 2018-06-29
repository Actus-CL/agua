@extends('admin.layouts.admin')

@section('content')
    <!-- page content -->
    <!-- top tiles -->


    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Facturar periodo <small> </small></h2>
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
                    <form   data-parsley-validate class="form-horizontal form-label-left autoform" action="{{route("admin.periodo.facturar.guardar")}}" method="post">


                        <h4> </h4>
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12">


                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Periodo Activo  <span class="required">*</span>
                                    </label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                        <input type="text"  class="form-control col-md-7 col-xs-12" readonly value="{{$bag['periodo_fac']->nombre}}" />
                                        <input type="hidden" name="periodo_id"   value="{{$bag['periodo_fac']->id}}" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Maximo prom mensual  <span class="required">*</span>
                                    </label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                        <input type="text" id="consumo_mensual_maximo"   name="consumo_mensual_maximo" class="form-control col-md-7 col-xs-12" readonly value="{{$bag["p"]['consumo_mensual_maximo']}}" />
                                    </div>
                                </div>

                            </div>


                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">
                                    </label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                        @if($bag['periodo_fac']->emitido==1)
                                            El periodo ya ha sido emitido
                                        @else
                                            <button type="submit" class="btn btn-success" id="btsubmit" >Procesar</button>
                                        @endif
                                    </div>
                                </div>


                            </div>
                        </div>
                        <div class="ln_solid"></div>
                   

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
