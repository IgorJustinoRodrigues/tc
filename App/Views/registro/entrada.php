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
                    <h2 class="white-text" style="margin-top: 30px" id="quant_carros">26</h2>
                    <h5 class="white-text" style="margin-top: -25px">Carros no campus</h5>
                </div>
            </div>
        </div>
    </div>
    <div class="col s12 m6 l4">
        <div class="blue card" style="width: 100%; height: 140px;">
            <div class="row">
                <div class="col s12 center-align">
                    <h2 class="white-text" style="margin-top: 30px" id="quant_registros">84</h2>
                    <h5 class="white-text" style="margin-top: -25px">Registros hoje</h5>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col s12 l6">
        <form class="container" action="<?=LINK?>registro/salvar" method="POST">
            <div class="row">
              <div class="input-field col s12">
                <i class="material-icons prefix">more</i>
                <input type="text" id="placa" class="autocomplete placa" style="font-size: 40px; text-transform: uppercase" required>
                <label for="placa">Placa</label>
              </div>
            </div>
            <div class="row">
              <div class="input-field col s12">
                <i class="material-icons prefix">person_pin</i>
                <input type="text" id="condutor" style="font-size: 40px; text-transform: uppercase" required>
                <label for="condutor">Condutor</label>
              </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                <i class="material-icons prefix">verified_user</i>
                <select name="motivo" required>
                    <option value="1">Aula</option>
                        <option value="2">Passeio</option>
                        <option value="3">Trazer Aluno</option>
                    </select>
                    <label for="motivo">Motivo</label>
                </div>
            </div>
            <div class="row">
                <button type="submit" class="btn col s12 green">Cadastrar Nova Entrada</button>
            </div>
        </form>
    </div>
    <div class="col s12 l6">
        <div  style="max-height: 350px;overflow:auto;">
            <table id="tabela" class="striped">
                <thead>
                    <tr class="blue white-text">
                        <th class="center-align" style="width: 40%">Placa</th>
                        <th class="center-align" style="width: 30%">Entrada</th>
                        <th class="center-align" style="width: 30%">Opções</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td class="center-align" style="font-size: 30px">ABC-1234</td>
                        <td class="center-align" style="font-size: 30px">12/10 15:38</td>
                        <td class="center-align">
                            <a onclick="confirmar_saida_registro(1)" class="waves-effect waves-light btn green hvr-grow"><i class="material-icons">done</i></a>
                            <a onclick="ver_registro_campus(1)" class="waves-effect waves-light btn blue hvr-grow"><i class="material-icons">search</i></a>
                            <a onclick="cancelar_registro(1)" class="waves-effect waves-light btn red hvr-grow"><i class="material-icons">delete_sweep</i></a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="ver-registro-campus" class="modal">
    <div class="modal-content">
        <h4>Detalhes de Registro</h4>
        <div id="info-modal"> </div>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-green btn-flat">Fechar</a>
    </div>
</div>

<div id="cancelar-registro" class="modal">
    <div class="modal-content">
        <h4>Cancelar Registro</h4>
        <div id="info-modal"> </div>
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