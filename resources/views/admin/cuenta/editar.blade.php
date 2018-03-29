@extends('admin.layouts.admin')

@section('content')
    <!-- page content -->
    <!-- top tiles -->



    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Editar cuenta: <small>Nº {{$bag['cuenta']->id}}</small></h2>
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
                    <form   data-parsley-validate class="form-horizontal form-label-left autoform" action="{{route("admin.cuenta.editar.update")}}" method="post">
                      <input type="hidden" id="id" name="id" value="{{$bag['cuenta']->id}}">
                      <input type="hidden" id="medidor_actual" name="medidor_actual" value="{{$bag['cuenta']->medidor_id}}">
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12">

                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Cliente
                                    </label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                        <input type="text" id="cliente_id" name="cliente_id" value="{{$bag['cuenta']->cliente->nombreCompleto()}}" class="form-control col-md-7 col-xs-12" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12">

                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Medidor actual
                                    </label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                        <input type="text" id="medidor" name="medidor" value="{{$bag['cuenta']->medidor->serie}}" class="form-control col-md-7 col-xs-12" readonly>
                                    </div>
                                </div>
                            </div>



                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-6">

                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Cambiar medidor <span class="required">*</span>
                                    </label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                        {{Form::select('medidor_id',$bag['medidor'],null,['class'=>'form-control', 'placeholder' => 'Seleccione otro medidor'])}}

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


        });
    </script>
    @parent
    {{ Html::script(mix('assets/admin/js/dashboard.js')) }}
@endsection

@section('styles')
    @parent
    {{ Html::style(mix('assets/admin/css/dashboard.css')) }}
@endsection
