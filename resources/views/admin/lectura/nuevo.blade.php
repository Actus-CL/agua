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


                        <h4>Seleccionar medidor</h4>
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Medidor <span class="required">*</span>
                                    </label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                         <input type="text" name="medidor_serie" id="autocompleteMedidor" class="form-control col-md-7 col-xs-12" />
                                        <input type="hidden" name="medidor_id" id="medidor_id"   />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Nueva Lectura <span class="required">*</span>
                                    </label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                        <input type="text" name="lectura_actual" id="txt_lectura" class="form-control col-md-7 col-xs-12" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Periodo Activo  <span class="required">*</span>
                                    </label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                        <input type="text"  class="form-control col-md-7 col-xs-12" readonly value="{{$bag['periodo_lec']->nombre}}" />
                                        <input type="hidden" name="l_periodo_id" id="l_periodo_id"  value="{{$bag['periodo_lec']->id}}" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Maximo prom mensual  <span class="required">*</span>
                                    </label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                        <input type="text" id="max_prom_mensual"  class="form-control col-md-7 col-xs-12" readonly value="15" />
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
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Ultima Lectura <span class="required">*</span>
                                    </label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                        <input type="text" id="lectura_ultima" name="lectura_ultima" readonly="readonly" class="form-control col-md-7 col-xs-12" >
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
                        <div class="ln_solid"></div>
                        <div class="row">
                            <h4>Ultimos 6 periodos</h4>

                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    @foreach($bag['periodos'] as $p)
                                    <th>{{$p->nombre}}</th>
                                    @endforeach
                                </tr>
                                </thead>
                                <tbody >
                                <tr>
                                    @foreach($bag['periodos'] as $p)
                                        <td>
                                            <input type="text"  name="periodo_id[{{$p->id}}]"  data-medidorid="{{$p->id}}" readonly="readonly"  class="periodo_lectura"  >
                                        </td>
                                    @endforeach
                                </tr>

                                </tbody>
                            </table>
                            </div>

                            <div class="ln_solid"></div>
                            <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12">

                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Medidor <span class="required">*</span>
                                    </label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">

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
    <script src={{asset("assets/admin/js/jquery.autocomplete.min.js")}} type="text/javascript"></script>

    <script>




        $( document ).ready(function() {
            var max_lectura=0;
            var num_p_vacios=0;
            var periodos_vacios;
            var countries = [
                @foreach($bag['medidor'] as $m )
                    { value: '{{$m->serie}}', data: '{{$m->id}}' },
                @endforeach
            ];
            $('#autocompleteMedidor').autocomplete({
                lookup: countries,
                onSelect: function (suggestion) {
                    max_lectura=0;
                    num_p_vacios=0;

                    var val =  suggestion.data;

                    $('#medidor_id').val(val);
                    $('.periodo_lectura').val("");
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
                            $('#lectura_ultima').val(respuesta['medidor'].lectura_ultima);
                            if(respuesta['medidor'].asociado==0){
                                alert("El medidor no está asociado");
                            }
                        }
                    });
                    $.ajax({
                        url: "{{route("admin.lectura.periodo.detalle")}}",
                        type: "post",
                        data: {medidor_id:val},
                        success: function (data) {
                            //console.log(data);
                            var respuesta = $.parseJSON( data);
                            //console.log(respuesta );
                            for (i = 0; i < respuesta.length; i++) {
                                $('input[name="periodo_id['+respuesta[i].periodo_id+']"]').val(respuesta[i].consumo_promedio);
                                    if(respuesta[i].consumo_promedio>0){
                                        max_lectura=respuesta[i].consumo_promedio;
                                    }
                            }
                            num_p_vacios=0;
                            var txt_periodos=$('.periodo_lectura');
                            for (i = 0; i < txt_periodos.length; i++) {
                                if(txt_periodos[i].value==""){
                                    num_p_vacios=num_p_vacios+1;
                                }
                            }
                        }
                    });



                    //alert('You selected: ' + suggestion.value + ', ' +);
                }
            });


            $('#txt_lectura').on( 'keyup', function(e){
                var val = $(this).val();
                var prom_mensual= val/num_p_vacios;

                 console.log(prom_mensual);
                 //max_prom_mensual


               /* var txt_periodos=$('.periodo_lectura');
                //console.log(txt_periodos[1].value);
                for (i = 0; i < txt_periodos.length; i++) {
                    //$('input[name="periodo_id['+respuesta[i].periodo_id+']"]').val(respuesta[i].consumo_promedio);
                    if(txt_periodos[i].value==""){
                        num_p_vacios=num_p_vacios+1;
                    }
                }

                */

                //console.log(e.key);
                // alert("hola"+key);
               /* var val = $(this).val();
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
*/


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
