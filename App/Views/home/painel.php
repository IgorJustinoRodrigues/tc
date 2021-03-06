<br>
<div class="row">
    <?php
    if(in_array(1,$Sessao::getUsuario('permissoes'))){
    ?>
    <div class="col s12 m6 l4">
        <a href="<?=LINK?>usuario/listar">
            <div class="blue card" style="width: 100%; height: 100px;">
                <div class="row">
                    <div class="col s2 m3 l3">
                        <i class="large material-icons white-text" style="margin-top: 8px">assignment_ind</i>            
                    </div>
                    <div class="col s10 m7 l9">
                        <h4 class="white-text"><?=$viewVar['quant_usuario'] > 0 ? $viewVar['quant_usuario'] : 0?> Usuário<?=$viewVar['quant_usuario'] > 1 ? 's' : ''?></h4>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <?php
    }
    ?>
    <div class="col s12 m6 l4">
        <div class="blue card" style="width: 100%; height: 100px;">
            <div class="row">
                <div class="col s2 m3 l3">
                    <i class="large material-icons white-text">directions_car</i>
                </div>
                <div class="col s10 m7 l9">
                    <h4 class="white-text"><?=$viewVar['quant_veiculo'] > 0 ? $viewVar['quant_veiculo'] : 0?> Veículo<?=$viewVar['quant_veiculo'] > 1 ? 's' : ''?></h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col s12 m6 l4">
        <div class="blue card" style="width: 100%; height: 100px;">
            <div class="row">
                <div class="col s2 m3 l3">
                    <i class="large material-icons white-text">equalizer</i>            
                </div>
                <div class="col s10 m7 l9">
                    <h4 class="white-text"><?=$viewVar['quant_registro'] > 0 ? $viewVar['quant_registro'] : 0?> Registro<?=$viewVar['quant_registro'] > 1 ? 's' : ''?></h4>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <input type="hidden" id="pagina" value="1">
    <div class="col s12 l5">
        <h4 class="center">Auditoria</h4>
        <div id="msg" class="center-align"></div>
        <div  style="max-height: 350px;overflow:auto;">
            <table id="tabela">
                <thead>
                    <tr>
                        <th>Tipo</th>
                        <th>Descrição</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                </tbody>
            </table>
        </div>
        <a class="btn blue right" id="buscar" onclick="listar()">Buscar</a>
    </div>
    <?php
    if(in_array(4,$Sessao::getUsuario('permissoes'))){
    ?>
    <div class="col s12 l7">
        <canvas id="line-chart" width="100%"></canvas>
    </div>
    <?php
    }
    ?>
</div>

<div id="ver-auditoria" class="modal">
    <div class="modal-content">
        <h4>Detalhes de Auditoria</h4>
        <div id="info-modal"> </div>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-green btn-flat">Fechar</a>
    </div>
</div>    