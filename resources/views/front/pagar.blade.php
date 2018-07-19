@extends('front.layout')

@section('content')
    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Proceso de pago<small></small></h2>
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
                    <div class="col-md-3 col-sm-3 col-xs-12 profile_left">
                        {{--<div class="profile_img">--}}
                            {{--<div id="crop-avatar">--}}
                                {{--<!-- Current avatar -->--}}
                                {{--<img class="img-responsive avatar-view" src="images/picture.jpg" alt="Avatar" title="Change the avatar">--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        <h3>{{ $cliente->nombreCompleto() }}</h3>

                        <ul class="list-unstyled user_data">
                            <li><i class="fa fa-map-marker user-profile-icon"></i> {{ $cliente->direccion }}
                            </li>

                            <li>
                                <i class="fa fa-briefcase user-profile-icon"></i> {{ $cliente->rut }}
                            </li>

                            <li class="m-top-xs">
                                <i class="fa fa-external-link user-profile-icon"></i>
                                {{ $cliente->email }}
                            </li>
                        </ul>

                        <br />


                    </div>
                    <form data-parsley-validate class="form-horizontal form-label-left autoform" action="{{route("protection.cliente.pagar.update")}}"  method="post">
                      <input type="hidden" value="{{$cliente->id}}" id="cliente_id" name="cliente_id">

                    <div class="col-md-9 col-sm-9 col-xs-12">

                            <div>
                              <h3>Detalle de pagos a cancelar</h3>
                              <hr>

                                    <div>

                                        <table class="data table table-striped no-margin">
                                            <thead>
                                            <tr>
                                                <th>Periodo</th>
                                                <th>Cuenta</th>
                                                <th>Fecha Emision</th>
                                                <th>Fecha Vencimiento</th>
                                                <th>Valor</th>
                                                <th>Estado</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($boletas as $boleta)
                                            <tr>
                                                <td>{{$boleta->periodo->nombre}}</td>
                                                <td>{{$boleta->cuenta->proyecto->nombre}}</td>
                                                <td>{{$boleta->f_emision}}</td>
                                                <td>{{$boleta->f_vencimiento}}</td>
                                                <td>{{$boleta->total}}</td>
                                                <td>
                                                    <?php
                                                    if($boleta->estado_pago_id==1){
                                                        $tipo_b="success"; //pendiente
                                                    }else  if($boleta->estado_pago_id==2){
                                                        $tipo_b="danger"; //atrasada
                                                    }else{
                                                        $tipo_b="primary"; //pagada
                                                    }
                                                    ?>
                                                    <button type="button" class="btn btn-{{$tipo_b}} btn-xs">
                                                        {{$boleta->estado_pago->nombre}}
                                                    </button>

                                                </td>
                                            </tr>


                                            @endforeach
                                            <tr>
                                              <td colspan="4"></td>
                                              <?php

                                              $valores = App\Boleta::select('total')->where('cliente_id', $cliente->id)->where('estado_pago_id', '<>', 3)->get();
                                              $final = 0;
                                              foreach($valores as $valor){
                                                $final += $valor->total;
                                              }

                                              ?>
                                              <td colspan="2"><h4>Total a pagar: {{$final}}</h4></td>


                                              <td></td>

                                            </tr>


                                            </tbody>
                                        </table>


                                    </div>

                            </div>



                            <hr>
                            <button type="submit" class="btn btn-success" id="btsubmit">Siguiente</button>
                    </div> <!-- fin div lateral md 9 -->
                  </form>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('scripts')
    <script>


        $( document ).ready(function() {
            if ($('#graf_historial_boletas').length){

                Morris.Bar({
                    element: 'graf_historial_boletas',
                    data: [
                        @foreach ($periodos as $p)
                        {periodo: '{{$p->nombre_formato()}}', consumo: {{$p->consumo_cliente($cliente->id)}}} ,
                        @endforeach
                    ],
                    xkey: 'periodo',
                    ykeys: ['consumo'],
                    labels: ['Consumo'],
                    barRatio: 0.4,
                    barColors: ['#26B99A', '#34495E', '#ACADAC', '#3498DB'],
                    xLabelAngle: 35,
                    hideHover: 'auto',
                    resize: true
                });

            }


        });
    </script>
    @parent
    {{ Html::script(mix('assets/admin/js/dashboard.js')) }}
@endsection

@section('styles')
    @parent
    {{ Html::style(mix('assets/admin/css/dashboard.css')) }}
@endsection
