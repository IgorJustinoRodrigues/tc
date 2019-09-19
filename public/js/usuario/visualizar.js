function editar(){
    $('input').attr("disabled", false);
    $('select').attr("disabled", false);
    $("#salvar").removeClass("hide");
    $("#cancelar").removeClass("hide");
    $("#alterar").addClass("hide");
    $("#confirmarSenha").removeClass('hide');
}