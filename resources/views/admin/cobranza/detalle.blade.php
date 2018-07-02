@extends('admin.layouts.admin')

@section('content')
    <!-- page content -->
    <!-- top tiles -->



    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Detalle de cobranza <small>cliente: {{$bag['cliente']->nombreCompleto()}}</small></h2>
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
                    <form   data-parsley-validate class="form-horizontal form-label-left autoform"  method="post">
                      <input type="hidden" value="{{$bag['cliente']->id}}" id="id" name="id">

                      <!-- Datos del cliente -->

                      <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <table class="table">
                            <thead class="thead-light">
                              <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Rut</th>
                                <th scope="col">Dirección</th>
                                <th scope="col">Correo electrónico</th>
                                <th scope="col">Teléfono de contacto</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <th scope="row">{{$bag['cliente']->id}}</th>
                                <td>{{$bag['cliente']->rut}}</td>
                                <td>{{$bag['cliente']->direccion}}</td>
                                <td>{{$bag['cliente']->email}}</td>
                                <td>{{$bag['cliente']->telefono}}</td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>

                      <!-- Datos de boletas -->
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">


                              <table class="table table-hover">
                                <thead>
                                  <tr>
                                    <th scope="col">Nº de boleta</th>
                                    <th scope="col">Fecha de emisión</th>
                                    <th scope="col">Fecha de vencimiento</th>
                                    <th scope="col">Nº de cuenta</th>
                                    <th scope="col">Nº de medidor</th>
                                    <th scope="col">Proyecto</th>
                                    <th scope="col">Periodo</th>
                                    <th scope="col">Total</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  @foreach($bag['boleta'] as $boleta)
                                    <tr>
                                      <th scope="row">{{$boleta->correlativo}}</th>
                                      <td>{{$boleta->f_emision}}</td>
                                      <td>{{$boleta->f_vencimiento}}</td>
                                      <td>{{$boleta->cuenta_id}}</td>
                                      <?php
                                        $cuenta = App\Cuenta::find($boleta->cuenta_id)->first();
                                        $medidor = App\Medidor::find($cuenta->medidor_id)->first();
                                        $proyecto = App\Proyecto::find($cuenta->proyecto_id)->first();
                                        $periodo = App\Periodo::find($boleta->periodo_id)->first();
                                      ?>
                                      <td>{{$medidor->serie}}</td>
                                      <td>{{$proyecto->nombre}}</td>
                                      <td>{{$periodo->nombre}}</td>
                                      <td>{{$boleta->total}}</td>
                                    </tr>
                                  @endforeach

                                </tbody>
                              </table>
                            </div>

                        </div>


                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                <a href="{{ route('admin.cobranza.lista') }}"  class="btn btn-success"   >Volver</a>
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
            $('.checkPj').click(function() {

                if (!$(this).is(':checked')) {
                    action="{{ route('admin.cliente.desasociar.proyecto') }}";
                }else{
                    action="{{ route('admin.cliente.asociar.proyecto') }}";
                }

                var proyecto_id=$(this).attr('proyectoid');
                var cliente_id=$(this).attr('clienteid');
                $.ajax({
                    url: action,
                    type: 'POST',
                    data: {cliente_id:cliente_id, proyecto_id:proyecto_id},
                    success: function (data) {
                        var respuesta = $.parseJSON( data);
                        //console.log(respuesta.correcto);

                        if ( respuesta.correcto ==1) {

                                //alert("Se han guardado las modificaciones");

                        }else{
                            //alert("Se han guardado las modificaciones");
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
