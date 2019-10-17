$(document).keypress(function(e) {
    if(e.which == 13){
        buscar();
    }
});    

function buscar(){
    window.location.href = ($("#link").val() + 'registro/listar/'+$('#busca').val());
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
                    if(registro.saida != null){
                        html += "<h6><b>Saída:</b> "+registro.saida+"</h6>";
                    }
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
