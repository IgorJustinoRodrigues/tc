$(document).ready(function(){
    $('.modal').modal();
});

$('.cpf').mask('000.000.000-00');
$('.telefone').mask('(00) 0 0000-0000');

function confirmacao(descricao, link){
    $("#confirmacao_descricao").html(descricao);
    $("#confirmacao_link").attr("href", $("#link").val() + link);
    var instance = M.Modal.getInstance($("#confirmacao"));            
    instance.open();
}