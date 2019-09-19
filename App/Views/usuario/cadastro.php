<div class="container">
    <form action="<?=LINK?>usuario/salvar" method="post">
        <h3>Cadastro de usuário</h3>
        <div class="row">
            <div class="input-field col s12">
                <input id="nome" type="text" name="nome" class="validate" value="<?=$Sessao::retornaFormulario('nome')?>" required>
                <label for="nome">Nome*</label>
            </div>
            <div class="input-field col s12 m6">
                <input id="email" type="email" name="email" class="validate" value="<?=$Sessao::retornaFormulario('email')?>" required>
                <label for="email">E-mail*</label>
            </div>
            <div class="input-field col s12 m6">
                <input id="fone" type="text" name="fone" class="validate telefone" value="<?=$Sessao::retornaFormulario('fone')?>">
                <label for="fone">Fone</label>
            </div>
            <div class="input-field col s12 m6">
                <input id="cargo" type="text" name="cargo" class="validate" value="<?=$Sessao::retornaFormulario('cargo')?>" required>
                <label for="cargo">Cargo*</label>
            </div>
            <div class="input-field col s12 m6">
                <select id="tipo_usuario_id" name="tipo_usuario_id" required>
                    <?php
                    foreach ($viewVar['tipo_usuario'] as $item){
                    ?>
                    <option value="<?=$item['id']?>" <?=$Sessao::retornaFormulario('tipo_usuario_id') == $item['tipo_usuario_id'] ? 'selected' : ''?>><?=$item['descricao']?></option>
                    <?php
                    }
                    ?>
                </select>
                <label for="tipo_usuario_id">Tipo de usuário</label>
            </div>
            <div class="input-field col s12">
                <input id="endereco" type="text" name="endereco" class="validate" value="<?=$Sessao::retornaFormulario('endereco')?>">
                <label for="endereco">Endereço</label>
            </div>
            <div class="input-field col s12 m6">
                <input id="bairro" type="text" name="bairro" class="validate" value="<?=$Sessao::retornaFormulario('bairro')?>">
                <label for="bairro">Bairro</label>
            </div>
            <div class="input-field col s12 m6">
                <input id="cidade" type="text" name="cidade" class="validate" value="<?=$Sessao::retornaFormulario('cidade')?>">
                <label for="cidade">Cidade</label>
            </div>
            <div class="input-field col s12 m6">
                <input id="senha" type="password" name="senha" class="validate" required>
                <label for="senha">Senha*</label>
            </div>
            <div class="input-field col s12 m6">
                <input id="senha2" type="password" name="senha2" class="validate" required>
                <label for="senha2">Confirmar senha*</label>
            </div>
            <div class="input-field col s12">
                <div class="switch">
                    <label>
                        Desativado
                        <input type="checkbox" name="status" class="validate" <?=$Sessao::retornaFormulario("status") == "off" ? "":"checked"?>>
                        <span class="lever"></span>
                        Ativo
                    </label>
                </div>
            </div>

            <button class="btn waves-effect waves-light black right col s12 m4" style="margin-bottom: 10px" type="submit">Salvar</button>
            <a href="<?=LINK?>usuario/listar" class="btn waves-effect waves-light blue col s12 m4" type="submit">Voltar
            </a>
        </div>
    </form>
</div>