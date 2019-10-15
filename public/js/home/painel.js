listar();

function listar(){
    var pagina = $("#pagina").val();
    $.ajax({
        type: 'post',
        dataType:'json',
        url: $("#link").val() + 'auditoria/listarAuditoria',//Definindo o arquivo onde serão buscados os dados
        data: {pagina:pagina},
        beforeSend: function () {
            $("#msg").text("Buscando mais registros de auditorias...");
        },
        success: function(lista){
            $("#msg").text("");
            if(lista.length>0){
                $(".td").remove();

                for(var i=0;lista.length>i;i++){
                    var newRow = $("<tr>");
                    var cols = "";

                    cols += '<td>'+lista[i].tipo+'</td>';	   
                    cols += '<td class="descricao">'+lista[i].descricao+'</td>';
                    cols += '<td><td><a onclick="ver(';
                    cols += lista[i].id;
                    cols += ')"><i class="material-icons">open_in_new</i></a></td></td>';

                    newRow.append(cols);	    

                    $("#tabela").append(newRow);
                }
                
                $("#pagina").val(parseInt(pagina) + 1);
                
                if(lista.length < 5 && pagina > 1){
                    $("#buscar").addClass('hide');
                    M.toast({html: 'Sem mais registros de auditoria...'});
                }
            } else {
                $("#buscar").addClass('hide');
                M.toast({html: 'Sem mais registros de auditoria...'});
            }
        }
    });
}

function ver(id){
    var instance = M.Modal.getInstance($('.modal'));
    instance.open();
    
    $.ajax({
        type: 'post',
        dataType:'json',
        url: $("#link").val() + 'auditoria/verAuditoria',
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