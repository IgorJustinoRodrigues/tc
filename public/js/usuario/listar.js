$(document).keypress(function(e) {
    if(e.which == 13){
        buscar();
    }
});    

function buscar(controler){
    window.location.href = ($("#link").val() + controler +'/listar/'+$('#busca').val());
}