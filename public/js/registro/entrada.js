var now = new Date();
var mName = now.getMonth() +1 ;
var dName = now.getDay() +1;
var dayNr = now.getDate();
var yearNr=now.getYear();
    if(dName==1) {Day = "Domingo";}
    if(dName==2) {Day = "Segunda-feira";}
    if(dName==3) {Day = "Terça-feira";}
    if(dName==4) {Day = "Quarta-feira";}
    if(dName==5) {Day = "Quinta-feira";}
    if(dName==6) {Day = "Sexta-feira";}
    if(dName==7) {Day = "Sábado";}
    if(mName==1){Month = "Jan";}
    if(mName==2){Month = "Fev";}
    if(mName==3){Month = "Mar";}
    if(mName==4){Month = "Abr";}
    if(mName==5){Month = "Mai";}
    if(mName==6){Month = "Jun";}
    if(mName==7){Month = "Jul";}
    if(mName==8){Month = "Ago";}
    if(mName==9){Month = "Set";}
    if(mName==10){Month = "Out";}
    if(mName==11){Month = "Nov";}
    if(mName==12){Month = "Dez";}
    if(yearNr < 2000) {Year = 1900 + yearNr;}
    else {Year = yearNr;}
    
    $("#dia").text(dayNr + "/" + Month + "/" + Year);
    $("#dia-escrito").text(Day);

var Elem = document.getElementById("hora");

function Horario(){ 
    var Hoje = new Date(); 
    var Horas = Hoje.getHours(); 
    if(Horas < 10){ 
      Horas = "0"+Horas; 
    }
    
    var Minutos = Hoje.getMinutes(); 
    if(Minutos < 10){ 
      Minutos = "0"+Minutos; 
    }
    
    var Segundos = Hoje.getSeconds(); 
    if(Segundos < 10){ 
      Segundos = "0"+Segundos; 
    } 

    Elem.innerHTML = Horas+":"+Minutos+":"+Segundos; 
} 

window.setInterval("Horario()",1000);

function ver_registro_campus(id){
    var instance = M.Modal.getInstance($('#ver-registro-campus'));
    instance.open();
    
    $.ajax({
        type: 'post',
        dataType:'json',
        url: $("#link").val() + 'registro/verRegistro',
        data: {id:id},
        beforeSend: function () {            
            $("#info-modal").html("<h5>Buscando...</h5>");
        },
        success: function(auditoria){
            if(auditoria){
                var html = "<h6><b>Tipo:</b> "+auditoria.tipo+"</h6>";
                html += "<h6><b>Usuário:</b> <a target='_blank' href='"+$("#link").val()+"usuario/visualizar/"+auditoria.usuario_id+"'>"+auditoria.nome+"</a></h6>";
                html += "<h6><b>Cargo:</b> "+auditoria.cargo+"</h6>";
                html += "<h6><b>Descrição:</b> "+auditoria.descricao+"</h6><br>";
                if(auditoria.tabela != ''){
                    html += "<h6><b>Tabela:</b> "+auditoria.tabela+"</h6>";
                }
                var campos = jQuery.parseJSON(auditoria.campos);
                if(auditoria.campos != '[]'){
                    html += "<h6><b>Campos:</b></h6>";
                    for (var key in campos) {
                        if(campos[key] == 'null'){
                            html += "<p style='margin-left: 30px'><b>"+key+":</b> -</p>";
                        } else {
                            html += "<p style='margin-left: 30px'><b>"+key+":</b> "+campos[key]+"</p>";                            
                        }
                    }
                }
                html += "<h6><b>Data:</b> "+auditoria.data+"</h6>";
                
                $("#info-modal").html(html);
            } else {
                
            }
        }
    });    
}

function cancelar_registro(id){
    var instance = M.Modal.getInstance($('#cancelar-registro'));
    instance.open();
    
    $.ajax({
        type: 'post',
        dataType:'json',
        url: $("#link").val() + 'registro/cancelarRegistro',
        data: {id:id},
        beforeSend: function () {            
            $("#info-modal").html("<h5>Cancelando...</h5>");
        },
        success: function(auditoria){
            if(auditoria){
                
            } else {
                
            }
        }
    });    
}

function confirmar_saida_registro(id){
    var instance = M.Modal.getInstance($('#confirmar-saida-registro'));
    instance.open();
    
    $.ajax({
        type: 'post',
        dataType:'json',
        url: $("#link").val() + 'registro/confirmarSaidaRegistro',
        data: {id:id},
        beforeSend: function () {            
            $("#info-modal").html("<h5>Finalizando...</h5>");
        },
        success: function(auditoria){
            if(auditoria){
                
            } else {
                
            }
        }
    });    
}

 $(document).ready(function(){
    $('input.autocomplete').autocomplete({
      data: {
        "Apple": null,
        "Microsoft": null,
        "Google": 'https://placehold.it/250x250'
      },
    });
    
    var instance = M.Autocomplete.getInstance($('input.autocomplete'));
    instance.open();
  });