<div class="container">
    <div class="row">
        <form action="<?=LINK?>usuario/entrar" method="post" class="col s10 offset-s1 m8 offset-m2 l6 offset-l3">
            <h2 class="center-align">Login</h2>
            <div class="row">
                <div class="input-field col s12">
                    <input id="nome" type="text" name="nome" class="validate" value="<?=$Sessao::retornaFormulario('nome')?>" required>
                    <label for="nome">Nome</label>
                </div>
                <div class="input-field col s12">
                    <input id="senha" type="password" name="senha" class="validate" required>
                    <label for="senha">Senha</label>
                </div>
                <button class="btn waves-effect waves-light black right col s12 m4" style="margin-bottom: 10px" type="submit">Acessar
                </button>
                <a href="<?=LINK?>" class="btn waves-effect waves-light blue col s12 m4" type="submit">Voltar
                </a>
            </div>
        </form>
    </div>
</div>