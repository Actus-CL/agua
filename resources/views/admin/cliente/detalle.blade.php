@extends('admin.layouts.admin')

@section('content')
    <!-- page content -->
    <!-- top tiles -->



    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Proyectos <small>cliente: {{$bag['cliente']->nombreCompleto()}}</small></h2>
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
                    <form   data-parsley-validate class="form-horizontal form-label-left autoform" action="{{route("admin.cliente.guardar.proyecto")}}" method="post">
                      <input type="hidden" value="{{$bag['cliente']->id}}" id="id" name="id">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">

                              <div class="form-check">
                                <ul class="list-group">

                                  @foreach($bag['proyecto'] as $p)
                                    <?php
                                    $checked = "";
                                    $proyectos = $bag['cliente']->proyectos;

                                    $consulta = $proyectos->where('id', $p->id)->first();
                                    // dd($consulta);
                                    if($consulta){
                                      $checked = "checked";
                                    }else{
                                      $checked = "";
                                    }
                                    ?>
                                    <li class="list-group-item">
                                        <input class="form-check-input" type="checkbox" value="{{$p->id}}" id="proyecto_id" name="proyecto_id" {{$checked}}>
                                        <label class="form-check-label" for="proyecto_id">{{$p->nombre}}</label>
                                    </li>
                                  @endforeach

                                </ul>
                              </div>

                            </div>

                        </div>


                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                <button type="submit" class="btn btn-success" id="btsubmit" >Guardar cambios</button>
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
