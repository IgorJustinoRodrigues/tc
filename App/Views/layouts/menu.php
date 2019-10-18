<nav class="nav-preto">
    <div class="nav-wrapper">
        <a href="<?=$Sessao::logado() ? LINK . 'home/painel' : LINK?>" class="brand-logo">
            <img src="<?=IMAGEM?>/logo.png" class="logo margem" />
        </a>
        <a href="#" data-target="slide-out" class="sidenav-trigger"><i class="material-icons">menu</i></a>
        <ul class="right hide-on-med-and-down margem">
            <li><a href="<?=$Sessao::logado() ? LINK . 'home/painel' : LINK?>">Início</a></li>
            <?php
            if($Sessao::logado()){
            ?>
            <?php
            if(in_array(4,$Sessao::getUsuario('permissoes'))){
            ?>
            <li><a href="<?=$Sessao::logado() ? LINK . 'registro/entrada' : LINK?>">Nova Entrada</a></li>
            <?php
            }
            ?>
            <li><a class="dropdown-trigger" href="#!" data-target="relatorio">Relatorio<i class="material-icons right">arrow_drop_down</i></a></li>
            <ul id="relatorio" class="dropdown-content">
                <li><a href="<?=LINK?>registro/listar">Entradas</a></li>
            </ul>
            <li><a class="dropdown-trigger" href="#!" data-target="cadastro">Cadastro<i class="material-icons right">arrow_drop_down</i></a></li>
            <ul id="cadastro" class="dropdown-content">
                <?php
                if(in_array(1,$Sessao::getUsuario('permissoes'))){
                ?>
                <li><a href="<?=LINK?>usuario/cadastro">Usuário</a></li>
                <li><a href="<?=LINK?>perfis/cadastro">Perfis</a></li>
                <?php
                }
                ?>
            </ul>
            <li><a class="dropdown-trigger" href="#!" data-target="listagem">Listagem<i class="material-icons right">arrow_drop_down</i></a></li>
            <ul id="listagem" class="dropdown-content">
                <?php
                if(in_array(1,$Sessao::getUsuario('permissoes'))){
                ?>
                <li><a href="<?=LINK?>usuario/listar">Usuário</a></li>
                <li><a href="<?=LINK?>perfis/listar">Perfis</a></li>
                <?php
                }
                ?>
                <?php
                if(in_array(2,$Sessao::getUsuario('permissoes'))){
                ?>
                <li><a href="<?=LINK?>auditoria/listar">Auditoria</a></li>
                <?php
                }
                ?>
            </ul>
            <li title="<?=$Sessao::getUsuario("cargo")?>"><a class="dropdown-trigger" href="#!" data-target="dropdown1"><?=$Sessao::getUsuario("nome")?><i class="material-icons right">arrow_drop_down</i></a></li>
            <ul id="dropdown1" class="dropdown-content">
                <li><a href="<?=LINK?>usuario/sair">SAIR</a></li>
                <li class="divider"></li>
                <li><a href="<?=LINK?>usuario/visualizar/<?=$Sessao::getUsuario("id")?>">Meus dados</a></li>
                <li><a><?=$Sessao::getUsuario("tipo_usuario")?></a></li>
            </ul>
            <?php
            } else {
            ?>
            <li><a href="<?=LINK?>usuario/login">Login</a></li>            
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
    <li><a href="<?=$Sessao::logado() ? LINK . 'home/painel' : LINK?>">Início</a></li>
    <?php
    if($Sessao::logado()){
    ?>
    <?php
    if(in_array(4,$Sessao::getUsuario('permissoes'))){
    ?>
    <li><a href="<?=$Sessao::logado() ? LINK . 'registro/entrada' : LINK?>">Nova Entrada</a></li>
    <?php
    }
    ?>
    <li><a class="dropdown-trigger" href="#!" data-target="relatorio2">Relatorio<i class="material-icons right">arrow_drop_down</i></a></li>
    <ul id="relatorio2" class="dropdown-content">
        <li><a href="<?=LINK?>registro/listar">Entradas</a></li>
    </ul>
    <li><a class="dropdown-trigger" href="#!" data-target="cadastro2">Cadastro<i class="material-icons right">arrow_drop_down</i></a></li>
    <ul id="cadastro2" class="dropdown-content">
        <?php
        if(in_array(1,$Sessao::getUsuario('permissoes'))){
        ?>
        <li><a href="<?=LINK?>usuario/cadastro">Usuário</a></li>
        <li><a href="<?=LINK?>perfis/cadastro">Perfis</a></li>
        <?php
        }
        ?>
    </ul>
    <li><a class="dropdown-trigger" href="#!" data-target="listagem2">Listagem<i class="material-icons right">arrow_drop_down</i></a></li>
    <ul id="listagem2" class="dropdown-content">
        <?php
        if(in_array(1,$Sessao::getUsuario('permissoes'))){
        ?>
        <li><a href="<?=LINK?>usuario/listar">Usuário</a></li>
        <li><a href="<?=LINK?>perfis/listar">Perfis</a></li>
        <?php
        }
        ?>
        <?php
        if(in_array(2,$Sessao::getUsuario('permissoes'))){
        ?>
        <li><a href="<?=LINK?>auditoria/listar">Auditoria</a></li>
        <?php
        }
        ?>
    </ul>
    <li title="<?=$Sessao::getUsuario("cargo")?>"><a class="dropdown-trigger" href="#!" data-target="dropdown"><?=$Sessao::getUsuario("nome")?><i class="material-icons right">arrow_drop_down</i></a></li>
    <ul id="dropdown" class="dropdown-content">
        <li><a href="<?=LINK?>usuario/sair">SAIR</a></li>
        <li class="divider"></li>
        <li><a href="<?=LINK?>usuario/visualizar/<?=$Sessao::getUsuario("id")?>">Meus dados</a></li>
        <li><a><?=$Sessao::getUsuario("tipo_usuario")?></a></li>
    </ul>
    <?php
    } else {
    ?>
    <li><a href="<?=LINK?>usuario/login">Login</a></li>            
    <?php
    }
    ?>
</ul>       