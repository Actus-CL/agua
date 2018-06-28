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
                    <form   data-parsley-validate class="form-horizontal form-label-left autoform"  method="post">
                      <input type="hidden" value="{{$bag['cliente']->id}}" id="id" name="id">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">

                              <div class="form-check">
                                <ul class="list-group">

                                  @foreach($bag['proyecto'] as $p)
                                    <?php
                                    $checked = "";
                                    $proyectos = $bag['cliente']->proyectos;
                                    $cliente=$bag['cliente'];

                                    $consulta = $proyectos->where('id', $p->id)->first();
                                    // dd($consulta);
                                    if($consulta){
                                      $checked = "checked";
                                    }else{
                                      $checked = "";
                                    }
                                    ?>
                                    <li class="list-group-item">
                                        <input class="form-check-input checkPj" type="checkbox" value="{{ $p->id }}" id="proyecto_id" clienteid="{{ $cliente->id }}" proyectoid="{{ $p->id }}" name="proyecto_id" {{$checked}}>
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
                                <a href="{{ route('admin.cliente.lista') }}"  class="btn btn-success"   >Volver</a>
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
