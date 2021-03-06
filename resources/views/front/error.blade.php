@extends('layouts.app')

@section('body_class','nav-md')

@section('page')
    <div class="container body">
        <div class="main_container">
            <!-- page content -->
            <div class="col-md-12">
                <div class="col-middle">
                    <div class="text-center text-center">
                        <h1 class="error-number">Hay un problema</h1>
                        <h2>Lo siento, pero hemos detectado un problema</h2>

                        <div class="mid_center">

                            @if (session('status'))
                                <div class="alert alert-success">
                                    {{ session('status') }}
                                </div>
                            @endif

                            <a href="{{route('login')}}"> Acceder a tu cuenta?</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /page content -->
        </div>
    </div>
@stop

@section('styles')
    {{ Html::style(mix('assets/admin/css/admin.css')) }}
    <link href={{asset("assets/admin/css/dataTables.bootstrap.css")}} rel="stylesheet" type="text/css" />
@endsection

@section('scripts')
    <script src={{asset("assets/admin/js/jquery.dataTables.js")}} type="text/javascript"></script>
    <script src={{asset("assets/admin/js/dataTables.bootstrap.js")}} type="text/javascript"></script>

    <script>
        $( document ).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            $('.autoform').on('submit', function(e){
                var bt = $(this).find('button[type="submit"]');
                bt.attr("disabled","disabled");
                e.preventDefault();
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


            $('.autoval').on('focus', function(){
                $("#btsubmit").attr("disabled","disabled");
            });

            $('.autoval').on('blur', function(){
                var val = $(this).val();
                var tabla = $(this).data('tabla');

                var campo = $(this).attr('name');
                //alert("sfsd");
                $.ajax({
                    url: "{{route("admin.validar.db")}}",
                    type: "post",
                    data: {val:val,tabla:tabla,campo:campo},
                    success: function (data) {
                        console.log(data);
                        if(data==0){
                            $("#btsubmit").removeAttr("disabled");
                        }else{
                            alert("Ya se encuentra registrado en la base de datos");
                            $(this).focus();
                        }

                    }
                });
            });




        });
    </script>
    {{ Html::script(mix('assets/admin/js/admin.js')) }}
@endsection