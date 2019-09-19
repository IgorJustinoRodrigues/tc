<div class="container">
    <div class="row">
        <div class="col s12 m4">
            <h3><?=$viewVar['paginacao']['quanUsuarios']?> Usuário<?=$viewVar['paginacao']['quanUsuarios'] == 1 ? "" : "s"?></h3>            
            <?php
            if($viewVar['paginacao']['busca'] != ''){
            ?>
            <h6>Busca: <?=$viewVar['paginacao']['busca']?> </h6>
            <?php
            }
            ?>            
        </div>
        <br>
        <div class="input-field col s10 m7 mb-2">
            <input type="text" class="form-control" id="busca" tabindex="1">
            <label for="busca">Busca</label>
        </div>
        <div class="col s2 m1 mb-3">
            <div class="input-group-append">
                <a onclick="buscar('usuario')" class="btn grey lighten-5" id="btn-buscar" tabindex="2" ><i class="material-icons black-text">send</i></a>
            </div>
        </div>
    </div>
    <?php
    if (count($viewVar['usuarios']) > 0){
    ?>
   <table class="table responsive-table highlight">
        <thead>
            <tr>
                <th scope="col" style="width: 95%">Nome</th>
                <th scope="col" style="width: 5%">Ver</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($viewVar['usuarios'] as $usuario){
            ?>
            <tr>
                <td><?=$usuario->getNome()?></td>
                <td>
                    <a href="<?=LINK?>usuario/visualizar/<?=$usuario->getId()?>"><i class="material-icons green-text">open_in_new</i></a>
                </td>
            </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
    <?php
    $pagina = $viewVar['paginacao']['pagina'];
    $total = $viewVar['paginacao']['quanPaginas'];
    $i = $viewVar['paginacao']['inicio'];
    $fim = $viewVar['paginacao']['fim'];
    ?>
    <ul class="pagination right-align">
        <li class="<?=$pagina == 1 ? "disabled" : ""?>"><a <?=$pagina == 1 ? "" : 'href="' . LINK . 'usuario/listar/' . $pagina-1 .'/'. $viewVar['paginacao']['busca'].'"'?>><i class="material-icons">chevron_left</i></a></li>
            <?php
                for($i; $i < $fim; $i++){
            ?>
            <li class="waves-effect <?=$pagina == $i+1 ? "active green" : ""?>"><a href="<?=LINK?>usuario/listar/<?=$i+1?>/<?=$viewVar['paginacao']['busca']?>"><?=str_pad($i+1, 2, "0", STR_PAD_LEFT);?></a></li>
            <?php
                }
            ?>
        <li class="<?=$pagina == $total ? "disabled" : ""?>"><a  <?=$pagina == 1 ? "" : 'href="' . LINK . 'usuario/listar/' . $pagina+1 .'/'. $viewVar['paginacao']['busca'].'"'?>><i class="material-icons">chevron_right</i></a></li>
    </ul>
</div>
<?php
} else {
?>
<br>
<br>
<h5>Ainda não existe nenhum registro cadastrado!</h5>
<a href="<?=LINK?>usuario/cadastro" class="modal-close waves-effect waves-green btn-flat green white-text">Cadastrar um usuário</a>
<?php
}
?>