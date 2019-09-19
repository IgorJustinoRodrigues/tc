<nav class="nav-preto">
    <div class="nav-wrapper">
        <a href="<?=$Sessao::logado() ? LINK . 'home/painel' : LINK?>" class="brand-logo">
            <img src="<?=IMAGEM?>/logo.png" class="logo margem" />
        </a>
        <a href="#" data-target="slide-out" class="sidenav-trigger"><i class="material-icons">menu</i></a>
        <ul class="right hide-on-med-and-down margem">
            <li><a href="<?=$Sessao::logado() ? LINK . 'home/painel' : LINK?>">Inicio</a></li>
            <?php
            if($Sessao::logado()){
            ?>
            <li><a class="dropdown-trigger" href="#!" data-target="relatorio">Relatorio<i class="material-icons right">arrow_drop_down</i></a></li>
            <ul id="relatorio" class="dropdown-content">
                <li><a href="<?=LINK?>relatorio/gerar/geral">Geral</a></li>
                <li><a href="<?=LINK?>relatorio/gerar/usuario">Usuários</a></li>
                <li><a href="<?=LINK?>relatorio/gerar/veiculos">Veiculos</a></li>
            </ul>
            <li><a class="dropdown-trigger" href="#!" data-target="cadastro">Cadastro<i class="material-icons right">arrow_drop_down</i></a></li>
            <ul id="cadastro" class="dropdown-content">
                <li><a href="<?=LINK?>usuario/cadastro">Usuário</a></li>
            </ul>
            <li><a class="dropdown-trigger" href="#!" data-target="listagem">Listagem<i class="material-icons right">arrow_drop_down</i></a></li>
            <ul id="listagem" class="dropdown-content">
                <li><a href="<?=LINK?>usuario/listar">Usuário</a></li>
            </ul>
            <li title="<?=$Sessao::getUsuario("cargo")?>"><a class="dropdown-trigger" href="#!" data-target="dropdown1"><?=$Sessao::getUsuario("nome")?><i class="material-icons right">arrow_drop_down</i></a></li>
            <ul id="dropdown1" class="dropdown-content">
                <li><a href="<?=LINK?>usuario/sair">SAIR</a></li>
                <li class="divider"></li>
                <li><a href="<?=LINK?>usuario/meusDados">Meus dados</a></li>
            </ul>
            <?php
            } else {
            ?>
            <li><a href="<?=LINK?>usuario/login">LOGIN</a></li>            
            <?php
            }
            ?>
        </ul>
    </div>
</nav>  

<ul id="slide-out" class="sidenav">
    <li>
        <div class="user-view">
            <div class="background">
                <img src="<?=IMAGEM?>/fundo.png" class="fundo">
            </div>
            <a href="<?=$Sessao::logado() ? LINK . 'home/painel' : LINK?>"><img src="<?=IMAGEM?>/logo.png" width="100%"></a>
        </div>
    </li>
    <li><a href="<?=$Sessao::logado() ? LINK . 'home/painel' : LINK?>">INÍCIO</a></li>
    <li title="<?=$Sessao::getUsuario("cargo")?>"><a class="dropdown-trigger" href="#!" data-target="dropdown2"><?=$Sessao::getUsuario("nome")?><i class="material-icons right">arrow_drop_down</i></a></li>
    <ul id="dropdown2" class="dropdown-content">
        <?php
        if($Sessao::logado()){
        ?>
        <li><a href="<?=LINK?>usuario/sair">SAIR</a></li>
        <?php
        } else {
        ?>
        <li><a href="<?=LINK?>usuario/login">LOGIN</a></li>            
        <?php
        }
        ?>
        <li class="divider"></li>
        <li><a href="<?=LINK?>usuario/meusDados">Meus dados</a></li>
    </ul>
</ul>       