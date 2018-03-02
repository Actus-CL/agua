$('.autoform').on('submit', function(){
    var bt = $(this).find('button[type="submit"]');
    bt.attr("disabled","disabled");
    event.preventDefault();

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
    //


});