<br>
<style>
    
</style>
<div class="row">
    <div class="col s12 m6 l4">
        <div class="blue card" style="width: 100%; height: 100px;">
            <div class="row">
                <div class="col s2 m3 l3">
                    <i class="large material-icons white-text" style="margin-top: 8px">assignment_ind</i>            
                </div>
                <div class="col s10 m7 l9">
                    <h4 class="white-text">134 Usuários</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col s12 m6 l4">
        <div class="blue card" style="width: 100%; height: 100px;">
            <div class="row">
                <div class="col s2 m3 l3">
                    <i class="large material-icons white-text">directions_car</i>            
                </div>
                <div class="col s10 m7 l9">
                    <h4 class="white-text">134 Veículos</h4>
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
                    <h4 class="white-text">123 Registros</h4>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col s12 l4">
        <h4 class="center">Auditoria</h4>
        <table>
            <thead>
                <tr>
                    <th>Tipo</th>
                    <th>Descrição</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                <?php
                foreach ($viewVar['auditoria'] as $item){
                ?>
                <tr>
                    <td><?=$this->tipo($item['tipo'])?></td>
                    <td class="descricao"><?=$item['descricao']?></td>
                    <td><a class="modal-trigger" href="#ver-auditoria"><i class="material-icons">open_in_new</i></a></td>
                </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<!-- Modal Structure -->
  <div id="ver-auditoria" class="modal">
    <div class="modal-content">
      <h4>Modal Header</h4>
      <p>A bunch of text</p>
    </div>
    <div class="modal-footer">
      <a href="#!" class="modal-close waves-effect waves-green btn-flat">Agree</a>
    </div>
  </div>    