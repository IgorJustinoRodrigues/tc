<!-- Modal Structure -->
<div id="confirmacao" class="modal">
    <div class="modal-content">
        <div id="confirmacao_descricao"></div>
    </div>
    <div class="modal-footer">
        <a class="modal-close waves-effect waves-green btn-flat">Não</a>
        <a class="modal-close waves-effect waves-green btn-flat green white-text" id="confirmacao_link">Sim</a>
    </div>
</div>

<script src="<?=JS?>/materialize.js"></script>
    <script src="<?=JS?>/init.js"></script>
    <?=$js?>
    <?php
    if($Sessao::existeMensagem()){
    ?>
    <script>M.toast({html: '<?=$Sessao::retornaMensagem()?>'})</script>
    <?php
    $Sessao::limpaMensagem();
    }
    ?>
    </body>
</html>