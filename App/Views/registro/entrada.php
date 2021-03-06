<div class="row">
    <div class="col s12 m6 l4">
        <div class="blue card" style="width: 100%; height: 140px;">
            <div class="row">
                <div class="col s12 center-align">
                    <h3 class="white-text" id="hora"></h3>
                    <h5 class="white-text"><samp id="dia-escrito"></samp> | <span id="dia"></span></h5>
                </div>
            </div>
        </div>
    </div>
    <div class="col s12 m6 l4">
        <div class="blue card" style="width: 100%; height: 140px;">
            <div class="row">
                <div class="col s12 center-align">
                    <h2 class="white-text" style="margin-top: 30px" id="quant_carros"></h2>
                    <h5 class="white-text" style="margin-top: -25px">Veículos no campus</h5>
                </div>
            </div>
        </div>
    </div>
    <div class="col s12 m6 l4">
        <div class="blue card" style="width: 100%; height: 140px;">
            <div class="row">
                <div class="col s12 center-align">
                    <h2 class="white-text" style="margin-top: 30px" id="quant_registros"></h2>
                    <h5 class="white-text" style="margin-top: -25px">Registros hoje</h5>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col s12 l6">
        <div class="container">
            <div class="row">
              <div class="input-field col s12">
                <i class="material-icons prefix">more</i>
                <input type="text" id="placa" class="autocomplete placa" style="font-size: 40px; text-transform: uppercase" required autocomplete="off" onkeypress ="autoComplete()">
                <label for="placa">Placa</label>
              </div>
            </div>
            <div class="row">
              <div class="input-field col s12">
                <i class="material-icons prefix">person_pin</i>
                <input type="text" id="condutor" style="font-size: 40px; text-transform: uppercase" required >
                <label for="condutor">Condutor</label>
              </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                <i class="material-icons prefix">verified_user</i>
                <select name="motivo" id="motivo" required>
                    <option value="1">Não informado</option>
                        <option value="2">Aluno(a)</option>
                        <option value="3">Transporte escolar</option>
                        <option value="4">Professor(a)</option>
                        <option value="5">Responsável por aluno</option>
                        <option value="6">Visita</option>
                        <option value="7">Evento</option>
                    </select>
                    <label for="motivo">Motivo</label>
                </div>
            </div>
            <div class="row">
                <a onclick="novaEntrada()" class="btn col s12 green">Cadastrar Nova Entrada</a>
            </div>
        </div>
    </div>
    <div class="col s12 l6">
        <div  style="max-height: 350px;overflow:auto;">
            <div id='msg'></div>
            <table id="tabela" class="striped">
                <thead>
                    <tr class="blue white-text">
                        <th class="center-align" style="width: 40%">Placa</th>
                        <th class="center-align" style="width: 30%">Entrada</th>
                        <th class="center-align" style="width: 30%">Opções</th>
                    </tr>
                </thead>

            </table>
        </div>
    </div>
</div>

<div id="ver-registro-campus" class="modal ver_registro_campus">
    <div class="modal-content">
        <h4>Detalhes de Registro</h4>
        <div id="info_modal_ver"></div>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-green btn-flat">Fechar</a>
    </div>
</div>

<div id="cancelar-registro" class="modal">
    <div class="modal-content">
        <h4>Cancelar Registro</h4>
        <div id="info-modal-cancelar"></div>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-green btn-flat">Fechar</a>
    </div>
</div>

<div id="confirmar-saida-registro" class="modal">
    <div class="modal-content">
        <h4>Confirmar Saída</h4>
        <div id="info-modal"> </div>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-green btn-flat">Fechar</a>
    </div>
</div>

<div class="modal informacoes_veiculo">
    <div class="modal-content">
        <h4>Informações do veículo</h4>
        <div class='row' id="tipo_usuario_btn"></div>
        <br>
        <div class='row' id="info_modal_info_veiculo"></div>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-green btn-flat">Fechar</a>
    </div>
</div>