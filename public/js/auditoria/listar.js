$(document).keypress(function(e) {
    if(e.which == 13){
        buscar();
    }
});    

function buscar(){
    window.location.href = ($("#link").val() + 'auditoria/listar/'+$('#busca').val());
}