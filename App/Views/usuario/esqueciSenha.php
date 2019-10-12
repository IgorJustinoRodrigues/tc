<div class="container">
    <div class="row">
        <form action="<?=LINK?>usuario/verificarEmail" method="post" class="col s10 offset-s1 m8 offset-m2 l6 offset-l3">
            <h2 class="center-align">Recuperar Senha</h2>
            <div class="row">
                <div class="input-field col s12">
                    <input id="email" type="email" name="email" class="validate" value="<?=$Sessao::retornaFormulario('email')?>" required>
                    <label for="email">E-mail</label>
                </div>
                <div class="input-field col s12">
                    <a href="<?=LINK?>usuario/login" style="margin-top: -30px;" class="right">Fazer login!</a>
                </div>
                <br>
                <button class="btn waves-effect waves-light blue right col s12 m4" style="margin-bottom: 10px" type="submit">Verificar</button>
                <a href="<?=LINK?>" class="btn waves-effect waves-light black col s12 m4" type="submit">Voltar</a>
            </div>
        </form>
    </div>
</div>