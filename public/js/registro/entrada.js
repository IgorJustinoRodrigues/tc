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
                    if(registro.modelo != null){
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
                    if(retorno.veiculo_id){
                        informacoes_veiculo(retorno.veiculo_id);
                    }
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
    $('input.autocomplete').autocomplete({});

    var instance = M.Autocomplete.getInstance($('input.autocomplete'));
    instance.open();
});

listar()
listarAutoComplete();
window.setInterval("listar()", 1000);
window.setInterval("listarAutoComplete()",10000);

function listarAutoComplete(){
    $.ajax({
        type: 'post',
        dataType:'json',
        url: $("#link").val() + 'registro/listarAutoComplete',
        success: function(lista){        
            var instance = M.Autocomplete.getInstance($('input.autocomplete'));

            instance.updateData(lista);
        }
    });
}

function autoComplete(){
    var instance = M.Autocomplete.getInstance($('input.autocomplete'));
    instance.close();
    instance.open();
}

function listar(){
    $.ajax({
        type: 'post',
        dataType:'json',
        url: $("#link").val() + 'registro/listarRegistrosAcesso',
        success: function(lista){
            $("#msg").text("");
                $(".tr").remove();
            if(lista['registro'].length>0){
                $("#quant_carros").text(lista['registro'].length);
                $("#quant_registros").text(lista['totalHoje']);

                for(var i=0;lista['registro'].length>i;i++){
                    var newRow = $("<tr class='tr'>");
                    var cols = "";
                        
                    cols += '<td class="center-align" style="font-size: 30px"><a onclick="informacoes_veiculo('+lista['registro'][i].veiculo_id+')">'+lista["registro"][i].placa+'</td>';
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
                var html = "<div class='col s12 m3'><a class='btn-large btn-tipo' style='background-color: ";
                    if(registro.tipo == '1'){
                        html += '#0c429c';
                    } else {
                        html += '#0088f5';                        
                    }
                    html += "' onclick='atualizarDadosVeiculo(";
                    html += '"tipo", 1, ' + registro.id;
                    html += ")'><i class='material-icons'>motorcycle</i></a><p class='center-align'>Motocicleta</p></div>";

                    html += "<div class='col s12 m3'><a class='btn-large btn-tipo' style='background-color: ";
                    if(registro.tipo == '2'){
                        html += '#0c429c';
                    } else {
                        html += '#0088f5';                        
                    }
                    html += "' onclick='atualizarDadosVeiculo(";
                    html += '"tipo", 2, ' + registro.id;
                    html += ")'><i class='material-icons'>directions_car</i></a><p class='center-align'>Carros</p></div>";

                    html += "<div class='col s12 m3'><a class='btn-large btn-tipo' style='background-color: ";
                    if(registro.tipo == '3'){
                        html += '#0c429c';
                    } else {
                        html += '#0088f5';                        
                    }
                    html += "' onclick='atualizarDadosVeiculo(";
                    html += '"tipo", 3, ' + registro.id;
                    html += ")'><i class='material-icons'>directions_bus</i></a><p class='center-align'>Van/Ônibus</p></div>";

                    html += "<div class='col s12 m3'><a class='btn-large btn-tipo' style='background-color: ";
                    if(registro.tipo == '4'){
                        html += '#0c429c';
                    } else {
                        html += '#0088f5';                        
                    }
                    html += "' onclick='atualizarDadosVeiculo(";
                    html += '"tipo", 4, ' + registro.id;
                    html += ")'><i class='material-icons'>traffic</i></a><p class='center-align'>Outros</p></div>";
                
                $("#tipo_usuario_btn").html(html);
                
                var html2 = '<div class="input-field col s12 m6"><i class="material-icons prefix">grade</i><input type="text" id="modelo" value="'+registro.modelo+'" onblur="atualizarDadosVeiculo(';
                    html2 += "'modelo', ";
                    html2 += "'', " + registro.id;
                    html2 += ')"><label class="active" for="modelo">Modelo</label></div>';

                    html2 += '<div class="input-field col s12 m6"><i class="material-icons prefix">color_lens</i><input type="text" id="cor" value="'+registro.cor+'" onblur="atualizarDadosVeiculo(';
                    html2 += "'cor', ";
                    html2 += "'', " + registro.id;
                    html2 += ')"><label class="active" for="cor">Cor</label></div>';

                    html2 += '<div class="input-field col s12 m6"><i class="material-icons prefix">center_focus_weak</i><input type="text" id="placa" class="placa" value="'+registro.placa+'" disabled><label class="active" for="placa">Placa</label></div>';

                    html2 += '<div class="input-field col s12 m6"><i class="material-icons prefix">location_on</i><input type="text" id="cidadePlaca" value="'+registro.cidadePlaca+'" onblur="atualizarDadosVeiculo(';
                    html2 += "'cidadePlaca', ";
                    html2 += "'', " + registro.id;
                    html2 += ')"><label class="active" for="cidadePlaca">Cidade da Placa</label></div>';

                    html2 += '<div class="input-field col s12"><i class="material-icons prefix">location_on</i><textarea id="observacoes" class="materialize-textarea" onblur="atualizarDadosVeiculo(';
                    html2 += "'observacoes', ";
                    html2 += "'', " + registro.id;
                    html2 += ')">'+registro.observacoes+'</textarea><label class="active" for="observacoes">Observações</label></div>';

                $("#info_modal_info_veiculo").html(html2);
            } else {
                $("#info_modal_info_veiculo").html("Registro não encontrado!");                
            }
        }
    });        
}

function atualizarDadosVeiculo(campo, valor, id){
    if(valor == ""){
        valor = $("#"+campo).val();
    }
    
    var instance = M.Modal.getInstance($('.ver_registro_campus'));
    instance.close();

    
    $.ajax({
        type: 'post',
        dataType:'json',
        url: $("#link").val() + 'registro/atualizarDadosVeiculo',
        data: {campo:campo, valor:valor, id:id},
        success: function(retorno){
            M.toast({html: retorno.msg});
            informacoes_veiculo(id);
        }
    });
}
