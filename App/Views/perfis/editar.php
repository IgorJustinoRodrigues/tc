<div class="container">
    <form action="<?=LINK?>perfis/salvar" method="post">
        <input id="id" type="hidden" name="id" value="<?=$viewVar['perfil']['id']?>" required>
        <h3>Edição de perfil</h3>
        <div class="row">
            <div class="input-field col s12">
                <input id="nome" type="text" name="descricao" class="validate" value="<?=$viewVar['perfil']['descricao']?>" required>
                <label for="nome">Nome*</label>
            </div>
            <div class="col s12">
                <h6>Permissões</h6>
            </div>
            <?php
            foreach ($viewVar['permissoes'] as $item){
            ?>
            <div class="input-field col s12 m6 l4">
                <div class="switch">
                    <label>
                        <input type="checkbox" name="permissoes_id[]" value="<?=$item['id']?>" <?=  in_array($item['id'], $viewVar['perfil']['permissoes']) ? 'checked' : '' ?> id="permissao<?=$item['id']?>"/>
                        <span class="lever"></span>
                        <span style="font-size: 18px"><?=$item['descricao']?></span>
                    </label>
                </div>
            </div>
            <?php
            }
            ?>
            <div class="col s12">
                <br>
            </div>
            <button class="btn waves-effect waves-light black right col s12 m4" style="margin-bottom: 10px" type="submit">Salvar</button>
            <a href="<?=LINK?>perfis/listar" class="btn waves-effect waves-light blue col s12 m4" type="submit">Voltar
            </a>
        </div>
    </form>
</div>