function editar(){
    $('input').attr("disabled", false);
    $("#salvar").removeClass("hide");
    $("#cancelar").removeClass("hide");
    $("#alterar").addClass("hide");
}

function cancelar(){
    $('#formulario').each (function(){
        this.reset();
    });

    $('input').attr("disabled", true);
    $("#salvar").addClass("hide");
    $("#cancelar").addClass("hide");
    $("#alterar").removeClass("hide");  
}