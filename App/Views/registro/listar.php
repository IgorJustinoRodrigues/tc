<div class="container">
    <div class="row">
        <h3><?=count($viewVar['lista'])?> Registros</h3>
        <h5><?=$viewVar['busca']?></h5>
        <a href="<?=LINK?>registro/listar/todos" class="waves-effect waves-green btn-flat green white-text">Todos</a>
        <a href="<?=LINK?>registro/listar/ultimo30" class="waves-effect waves-green btn-flat green white-text">Ultimos 30 dias</a>
        <a href="<?=LINK?>registro/listar/ultimo7" class="waves-effect waves-green btn-flat green white-text">Ultimos 7 dias</a>
        <a href="<?=LINK?>registro/listar/" class="waves-effect waves-green btn-flat green white-text">Hoje</a>
    </div>
    <?php
    if (count($viewVar['lista']) > 0){
    ?>
   <table class="table responsive-table highlight">
        <thead>
            <tr>
                <th scope="col" style="width: 15%">Placa</th>
                <th scope="col" style="width: 30%">Condutor</th>
                <th scope="col" style="width: 20%">Entrada</th>
                <th scope="col" style="width: 20%">Saída</th>
                <th scope="col" style="width: 10%">Status</th>
                <th scope="col" style="width: 5%">Ver</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($viewVar['lista'] as $item){
            ?>
            <tr title="<?=$item['status'] == 1 ? "Saída confirmada" : ""?> <?=$item['status'] == 2 ? "No campus" : ""?> <?=$item['status'] == 0 ? "Cancelado" : ""?>">
                <td style="font-size: 20px"><a onclick="informacoes_veiculo(<?=$item['veiculo_id']?>)"><?=$item['placa']?></a></td>
                <td style="font-size: 20px"><?=$item['condutor'] == "" ? "-" : $item['condutor']?></td>
                <td style="font-size: 20px"><?=$item['entrada']?></td>
                <td style="font-size: 20px"><?=$item['saida'] == "" ? "-" : $item['saida']?></td>
                <td ><a class="waves-effect waves-light btn <?=$item['status'] == 1 ? "green" : ""?> <?=$item['status'] == 2 ? "blue" : ""?> <?=$item['status'] == 0 ? "red" : ""?>"><i class="material-icons">adjust</i></a></td>
                <td>
                    <a onclick="ver_registro_campus(<?=$item['id']?>)" ><i class="material-icons green-text">open_in_new</i></a>
                </td>
            </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>
<?php
} else {
?>
<br>
<br>
<h5>Nenhum registro encontrado!</h5>
<?php
}
?>

<div class="modal informacoes_veiculo">
    <div class="modal-content">
        <h4>Informações do veículo</h4>
        <div class='row' id="tipo_usuario_btn"></div>
        <br>
        <div class='row' id="info_modal_info_veiculo"></div>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-green btn-flat">Fechar</a>
    </div>
</div>

<div id="ver-registro-campus" class="modal ver_registro_campus">
    <div class="modal-content">
        <h4>Detalhes de Registro</h4>
        <div id="info_modal_ver"></div>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-green btn-flat">Fechar</a>
    </div>
</div>
