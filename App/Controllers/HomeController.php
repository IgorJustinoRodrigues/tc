<?php

namespace App\Controllers;
use App\Lib\Sessao;
use App\Models\BO\UsuarioBO;
use App\Models\Entidades\Usuario;
use App\Models\BO\VeiculoBO;
use App\Models\Entidades\Veiculo;
use App\Models\BO\RegistroBO;
use App\Models\Entidades\Registro;

class HomeController extends Controller{
    public function index(){
        $this->redirect('usuario/login');
    }

    public function painel(){
        $this->validaUsuario();
        
        $usuarioBO = new UsuarioBO();
        $quant_usuario = $usuarioBO->selecionarVetor(Usuario::TABELA, ['count(id) as quant_usuario'], null, null, "status != ?", [0], null);
        $this->setViewParam('quant_usuario', $quant_usuario['quant_usuario']);
        
        $veiculoBO = new VeiculoBO();
        $quant_veiculo = $veiculoBO->selecionarVetor(Veiculo::TABELA, ['count(id) as quant_veiculo'], null, null, "", [], null);
        $this->setViewParam('quant_veiculo', $quant_veiculo['quant_veiculo']);
        
        $registroBO = new RegistroBO();
        $quant_registro = $registroBO->selecionarVetor(Registro::TABELA, ['count(id) as quant_registro'], null, null, "status != ?", [0], null);
        $this->setViewParam('quant_registro', $quant_registro['quant_registro']);
        
        $this->render('home/painel', "Meu painel");
    }
    
}