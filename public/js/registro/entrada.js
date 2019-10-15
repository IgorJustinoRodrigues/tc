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
    var instance = M.Modal.getInstance($('.ver_registro_campus'));
    instance.open();
    
    $.ajax({
        type: 'post',
        dataType:'json',
        url: $("#link").val() + 'registro/verRegistro',
        data: {id:id},
        beforeSend: function () {            
            $("#info_modal_ver").html("<h5>Buscando...</h5>");
        },
        success: function(registro){
            if(registro){
                var html = "<h6><b>Entrada:</b> "+registro.entrada+"</h6>";
                    if(registro.condutor != ''){
                        html += "<h6><b>Condutor do veículo:</b> "+registro.condutor+"</h6>";
                    }
                    html += "<h6><b>Motivo da entrada:</b> "+registro.motivo+"</h6>";
                    if(registro.descricao != null){
                        html += "<h6><b>Descrição do registro:</b> "+registro.descricao+"</h6>";
                    }
                    if(registro.status != null){
                        html += "<h6><b>Status do registro:</b> "+registro.status+"</h6>";
                    }
                    if(registro.tipo != null){
                        html += "<h6><b>Tipo do veículo:</b> "+registro.tipo+"</h6>";
                    }
                    if(registro.tipo != null){
                        html += "<h6><b>Modelo do veículo:</b> "+registro.modelo+"</h6>";
                    }
                    html += "<h6><b>Placa do veículo:</b> <a onclick='informacoes_veiculo("+registro.veiculo_id+")'>"+registro.placa+"</a></h6>";
                    if(registro.cidadePlaca != null){
                        html += "<h6><b>Cidade da placa:</b> "+registro.cidadePlaca+"</h6>";
                    }
                    if(registro.cor != null){
                        html += "<h6><b>Cor do veículo:</b> "+registro.cor+"</h6>";
                    }
                    if(registro.observacoes != null){
                        html += "<h6><b>Observações do veículo:</b> "+registro.observacoes+"</h6>";
                    }
                    html += "<h6><b>Data de cadastro do veículo:</b> "+registro.cadastro+"</h6>";
                
                $("#info_modal_ver").html(html);
            } else {
                $("#info_modal_ver").html("Registro não encontrado!");                
            }
        }
    });    
}


function cancelar_registro(id){
    if(confirm("Cancelar entrada?")){

        $.ajax({
            type: 'post',
            dataType:'json',
            url: $("#link").val() + 'registro/cancelarRegistro',
            data: {id:id},
            success: function(resposta){
                if(resposta.status == '1'){            
                    M.toast({html: resposta.msg});
                } else {

                }
            }
        });    
    }
}

function confirmar_saida_registro(id){
    if(confirm("Confirmar saída?")){

        $.ajax({
            type: 'post',
            dataType:'json',
            url: $("#link").val() + 'registro/confirmarSaidaRegistro',
            data: {id:id},
            success: function(resposta){
                if(resposta.status == '1'){            
                    M.toast({html: resposta.msg});
                } else {

                }
            }
        });    
    }
}

$(document).keypress(function(e) {
    if(e.which == 13){
        novaEntrada();
    }
});    

function novaEntrada(){
    var placa = $("#placa").val();
    var condutor = $("#condutor").val();
    var motivo = $("#motivo option:selected").val();

    if(placa !== ''){
        $.ajax({
            type: 'post',
            dataType:'json',
            url: $("#link").val() + 'registro/novaEntrada',
            data: {placa:placa, condutor:condutor, motivo:motivo},
            beforeSend: function() {
                $("#msgModal").html("<h5>Registrando nova entrada...</h5>");
            },
            success: function(retorno){
                if(retorno.status == '1'){
                    $("#placa").val("");
                    $("#condutor").val("");
                    M.toast({html: retorno.msg});
                } else {
                    M.toast({html: retorno.msg});
                }
            }
        });

    } else {
        M.toast({html: 'Informe a placa!'})
        $("#placa").focus();
    }
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

listar()
window.setInterval("listar()",2000);

function listar(){
    $.ajax({
        type: 'post',
        dataType:'json',
        url: $("#link").val() + 'registro/listarRegistrosAcesso',//Definindo o arquivo onde serão buscados os dados
        success: function(lista){
            $("#msg").text("");
                $(".tr").remove();
            if(lista['registro'].length>0){
                $("#quant_carros").text(lista['registro'].length);
                $("#quant_registros").text(lista['totalHoje']);

                for(var i=0;lista['registro'].length>i;i++){
                    var newRow = $("<tr class='tr'>");
                    var cols = "";
                        
                    cols += '<td class="center-align" style="font-size: 30px">'+lista['registro'][i].placa+'</td>';
                    cols += '<td class="center-align" style="font-size: 30px">'+lista['registro'][i].entrada+'</td>';                           
                    cols += '<td class="center-align">'
                    cols += '<a onclick="confirmar_saida_registro('+lista['registro'][i].id+')" class="waves-effect waves-light btn green hvr-grow"><i class="material-icons">done</i></a>';
                    cols += '<a onclick="ver_registro_campus('+lista['registro'][i].id+')" class="waves-effect waves-light btn blue hvr-grow"><i class="material-icons">search</i></a>';
                    cols += '<a onclick="cancelar_registro('+lista['registro'][i].id+')" class="waves-effect waves-light btn red hvr-grow"><i class="material-icons">delete_sweep</i></a>';
                    cols +='</td>';

                    newRow.append(cols);	    

                    $("#tabela").append(newRow);
                }
    
            } else {
                $("#quant_carros").text(0);
                $("#quant_registros").text(lista['totalHoje']);
                $("#msg").text("Sem entradas!");
            }
        }
    });
}

function informacoes_veiculo(id){
    var instance = M.Modal.getInstance($('.informacoes_veiculo'));
    instance.open();
    
    $.ajax({
        type: 'post',
        dataType:'json',
        url: $("#link").val() + 'registro/infoVeiculo',
        data: {id:id},
        beforeSend: function () {            
            $("#info_modal_info_veiculo").html("<h5>Buscando...</h5>");
        },
        success: function(registro){
            if(registro){
                var html = "<h6><b>Tipo:</b> "+registro.tipo+"</h6>";
                    html += "<h6><b>Data de cadastro do veículo:</b> "+registro.cadastro+"</h6>";
                
                $("#info_modal_info_veiculo").html(html);
            } else {
                $("#info_modal_info_veiculo").html("Registro não encontrado!");                
            }
        }
    });    
    
}