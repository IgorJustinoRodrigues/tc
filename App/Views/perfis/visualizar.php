<div class="container">
    <h3><?=$viewVar['perfil']['descricao']?></h3>
    <ul class="collapsible">
        <li class="active">
            <div class="collapsible-header"><i class="material-icons">search</i>Permissões</div>
            <div class="collapsible-body">
                <div class="row">
                    <?php
                    foreach ($viewVar['perfil']['permissoes'] as $item){
                    ?>
                    <div class="col s4">
                        <h6>
                            <?=$item['descricao']?>
                        </h6>
                    </div>
                    <?php
                    }
                    ?>
                </div>

                <a class="btn green texto-branco" href="<?=LINK?>perfis/editar/<?=$viewVar['perfil']['id']?>">Editar</a>
            </div>
        </li>        
        <li>
            <div class="collapsible-header"><i class="material-icons">people</i>Usuários</div>
            <div class="collapsible-body">
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
                } else {
                    echo "<h5>Não existem usuários neste perfil!</h5>";
                }
                ?>
            </div>
        </li>
        <li>
            <div class="collapsible-header"><i class="material-icons">more_horiz</i>Excluir</div>
            <div class="collapsible-body">
                <a class="btn red texto-branco" onclick="confirmacao('<h6>Excluir o perfil <?=$viewVar['perfil']['descricao']?>?</h6>', 'perfis/apagar/<?=$viewVar['perfil']['id']?>')">Excluir</a>
            </div>
        </li>
    </ul>

    <a class="btn blue texto-branco" href="<?=LINK?>perfis/listar">Voltar</a>    
</div>