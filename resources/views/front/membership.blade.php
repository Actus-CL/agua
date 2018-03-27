@extends('front.layout')

@section('content')
    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Estado de cuenta <small></small></h2>
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

                        <a class="btn btn-success"><i class="fa fa-edit m-right-xs"></i>Editar Perfil</a>
                        <br />
                        <hr>
                        <!-- start skills -->
                        <h4>Detalles</h4>
                        <ul class="list-unstyled user_data">
                            <li>
                               <b>
                                   Cuentas asociadas:
                               </b>
                                {{ $cliente->cuentas->count() }}
                            </li>
                            <li>
                                <b>
                                    Total Adeudado:
                                </b>
                                    $ {{$cliente->monto_adeudado()}}
                            </li>

                        </ul>
                        <!-- end of skills -->

                    </div>
                    <div class="col-md-9 col-sm-9 col-xs-12">

                        <div class="profile_title">
                            <div class="col-md-12">
                                <h2>Consumo últimos 12 periodos</h2>
                            </div>
                            {{--<div class="col-md-6">--}}
                                {{--<div id="reportrange" class="pull-right" style="margin-top: 5px; background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #E6E9ED">--}}
                                    {{--<i class="glyphicon glyphicon-calendar fa fa-calendar"></i>--}}
                                    {{--<span>December 30, 2014 - January 28, 2015</span> <b class="caret"></b>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        </div>
                        <!-- start of user-activity-graph -->
                        <div id="graf_historial_boletas" style="width:100%; height:280px;"></div>
                        <!-- end of user-activity-graph -->

                        <div class="" role="tabpanel" data-example-id="togglable-tabs">
                            <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                                <?php
                                $activo="active";
                                ?>
                                @foreach( $cliente->cuentas as $cuenta)
                                    <li role="presentation" class="{{$activo}}"><a href="#tab_content{{$cuenta->id}}" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Nro:{{$cuenta->id}} -  {{$cuenta->proyecto->nombre}}, {{$cuenta->direccion}}</a>
                                    </li>
                                        <?php
                                        $activo="";
                                        ?>
                                @endforeach
                            </ul>
                            <div id="myTabContent" class="tab-content">
                                <?php
                                $activo="active";
                                ?>
                                @foreach( $cliente->cuentas as $cuenta)
                                    <div role="tabpanel" class="tab-pane fade {{$activo}} in" id="tab_content{{$cuenta->id}}" aria-labelledby="home-tab">
                                        <ul class="quick-list">
                                            <li><i class="fa fa-bars"></i><b>Medidor:</b>  Serie ({{$cuenta->medidor->serie}}), Ultima Lectura({{$cuenta->medidor->lectura_ultima}})</li>
                                            <li><i class="fa fa-bar-chart"></i><b>Lugar:</b>  {{$cuenta->proyecto->nombre}}, {{$cuenta->direccion}}</li>
                                            <li><i class="fa fa-support"></i><b>Estado:</b> {{$cuenta->cuentaEstado->nombre}} </li>
                                        </ul>



                                        <table class="data table table-striped no-margin">
                                            <thead>
                                            <tr>
                                                <th>Periodo</th>
                                                <th>Fecha Emision</th>
                                                <th>Fecha Vencimiento</th>
                                                <th>Valor</th>
                                                <th>Estado</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($cuenta->boletas as $boleta)
                                            <tr>
                                                <td>{{$boleta->periodo->nombre}}</td>
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


                                            </tbody>
                                        </table>


                                    </div>

                                        <?php
                                        $activo="";
                                        ?>
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

        @if($valid)
            Bienvenido XXXXX
            <br/>
            Acá podrá:
            <ul>
                <li>Visualizar el estado de su cuenta</li>
                <li>Ver el historial de su cuenta</li>
                <li>Realizar pago</li>
            </ul>
        @else
            Tu cuenta está suspendida
        @endif



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
