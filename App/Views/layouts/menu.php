<nav class="nav-preto">
    <div class="nav-wrapper">
        <a href="<?=LINK?>" class="brand-logo">
            <img src="<?=IMAGEM?>/logo.png" class="logo margem" />
        </a>
        <a href="#" data-target="slide-out" class="sidenav-trigger"><i class="material-icons">menu</i></a>
        <ul class="right hide-on-med-and-down margem">
            <li><a href="<?=LINK?>">INÍCIO</a></li>
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
        </ul>
    </div>
</nav>  

<ul id="slide-out" class="sidenav">
    <li>
        <div class="user-view">
            <div class="background">
                <img src="<?=IMAGEM?>/fundo.png" class="fundo">
            </div>
            <a href="<?=LINK?>"><img src="<?=IMAGEM?>/logo.png" width="100%"></a>
        </div>
    </li>
    <li><a href="<?=LINK?>">INÍCIO</a></li>
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
</ul>       