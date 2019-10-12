<div class="container">
    <h3><?=$viewVar['usuario']->getNome()?></h3>
    <?php
    if($viewVar['usuario']->getStatus() == 0){
        echo '<div class="card-panel red darken-1 white-text center-align"><h5>Usuário excluido!</h5></div>';
    }
    ?>
    <ul class="collapsible">
        <li class="active">
            <div class="collapsible-header"><i class="material-icons">search</i>Informações</div>
            <div class="collapsible-body">
                <form action="<?=LINK?>usuario/salvar" method="POST" id="formulario">
                    <input type="hidden" name="id" value="<?=$viewVar['usuario']->getId()?>"/>
                    <div class="row">
                        <div class="input-field col s12">
                            <input type="text" class="form-control" id="nome" name="nome" value="<?=$viewVar['usuario']->getNome()?>" disabled required>
                            <label for="nome">Nome</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input id="email" type="email" name="email" class="validate" value="<?=$viewVar['usuario']->getEmail()?>" disabled required>
                            <label for="email">E-mail*</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input id="fone" type="text" name="fone" class="validate telefone" value="<?=$viewVar['usuario']->getFone()?>" disabled>
                            <label for="fone">Fone</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input id="cargo" type="text" name="cargo" class="validate" value="<?=$viewVar['usuario']->getCargo()?>" disabled required>
                            <label for="cargo">Cargo*</label>
                        </div>
                        <?php
                        if(in_array(1,$Sessao::getUsuario('permissoes'))){
                        ?>
                        <div class="input-field col s12 m6">
                            <select id="tipo_usuario_id" name="tipo_usuario_id" required>
                                <?php
                                foreach ($viewVar['tipo_usuario'] as $item){
                                ?>
                                <option value="<?=$item['id']?>" <?=$viewVar['usuario']->getTipo_usuario_id() == $item['id'] ? 'selected' : ''?>><?=$item['descricao']?></option>
                                <?php
                                }
                                ?>
                            </select>
                            <label for="tipo_usuario_id">Tipo de usuário*</label>
                        </div>
                        <?php
                            } else {
                        ?>
                        <div class="input-field col s12 m6">
                            <label for="tipo_usuario_id">Tipo de usuário*</label>
                            <input type="text" class="form-control" value="<?=$Sessao::getUsuario("tipo_usuario")?>" disabled readonly>
                        </div>
                        <?php
                            }
                        ?>
                        <div class="input-field col s12 m6">
                            <input type="password" class="form-control" id="senha" name="senha" disabled>
                            <label for="senha">Alterar senha</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input type="password" class="form-control" id="senha2" name="senha2" disabled>
                            <label for="senha2">Confirmar nova senha</label>
                        </div>
                        <div class="input-field col s12">
                            <input id="endereco" type="text" name="endereco" class="validate" value="<?=$viewVar['usuario']->getEndereco()?>" disabled>
                            <label for="endereco">Endereço</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input id="bairro" type="text" name="bairro" class="validate" value="<?=$viewVar['usuario']->getBairro()?>" disabled>
                            <label for="bairro">Bairro</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input id="cidade" type="text" name="cidade" class="validate" value="<?=$viewVar['usuario']->getCidade()?>" disabled>
                            <label for="cidade">Cidade</label>
                        </div>
                        <div class="input-field col s12">
                            <div class="switch">
                                <label>
                                    Desativado
                                    <input type="checkbox" name="status" class="validate" <?=$viewVar['usuario']->getStatus() == "2" ? "":"checked"?> disabled>
                                    <span class="lever"></span>
                                    Ativo
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <a class="btn red texto-branco hide" href="<?=LINK?>usuario/visualizar/<?=$viewVar['usuario']->getId()?>" id="cancelar">Cancelar</a> &nbsp;
                        <button type="submit" class="btn green hide" id="salvar">Salvar</button>
                        <a class="btn green texto-branco" id="alterar" onclick="editar()">Editar</a>
                    </div>
                </form>
            </div>
        </li>
        
        <li>
            <div class="collapsible-header"><i class="material-icons">more_horiz</i>Excluir</div>
            <div class="collapsible-body">
                <?php
                if($Sessao::getUsuario('id') == $viewVar['usuario']->getId()){
                ?>
                <a class="btn red texto-branco" onclick="confirmacao('<h6>Excluir sua conta <?=$viewVar['usuario']->getNome()?>?</h6><br>Você não terá mais acesso a sua conta.', 'usuario/excluir/<?=$viewVar['usuario']->getId()?>')">Excluir</a>
                <?php
                } else {
                ?>
                <a class="btn red texto-branco" onclick="confirmacao('<h6>Excluir o usuario <?=$viewVar['usuario']->getNome()?>?</h6><br>Todos os registros relacionados a ele serão perdidos.', 'usuario/excluir/<?=$viewVar['usuario']->getId()?>')">Excluir</a>                
                <?php
                }
                ?>
            </div>
        </li>
    </ul>
</div>