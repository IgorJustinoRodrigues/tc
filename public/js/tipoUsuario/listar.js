$(document).keypress(function(e) {
    if(e.which == 13){
        buscar();
    }
});    

function buscar(){
    window.location.href = ($("#link").val() + 'tipoUsuario/listar/'+$('#busca').val());
}