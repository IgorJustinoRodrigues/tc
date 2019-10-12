$(document).ready(function(){
    $('.modal').modal();
    $(".dropdown-trigger").dropdown();
    $('.sidenav').sidenav();
    $('select').formSelect();
    $('.collapsible').collapsible();

    $('.carousel.carousel-slider').carousel({
        fullWidth: true,
        indicators: true
    });
});

$('.cpf').mask('000.000.000-00');
$('.telefone').mask('(00) 0 0000-0000');
$('.placa').mask('AAA-0000');

function confirmacao(descricao, link){
    $("#confirmacao_descricao").html(descricao);
    $("#confirmacao_link").attr("href", $("#link").val() + link);
    var instance = M.Modal.getInstance($("#confirmacao"));            
    instance.open();
}