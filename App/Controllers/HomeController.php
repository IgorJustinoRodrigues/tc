<?php

namespace App\Controllers;
use App\Lib\Sessao;
use App\Models\BO\UsuarioBO;
use App\Models\Entidades\Usuario;

class HomeController extends Controller{
    public function index(){
        $this->render('home/index', 'Início');
    }

    public function painel(){
        $this->validaUsuario();
        
        $usuarioBO = new UsuarioBO();
        $quant_usuario = $usuarioBO->selecionarVetor(Usuario::TABELA, ['count(id) as quant_usuario'], null, null, "status != ?", [0], null);
        $this->setViewParam('quant_usuario', $quant_usuario['quant_usuario']);
        
        $lista = $this->exibirAuditoria(5);
        $this->setViewParam('auditoria', $lista);
        
        $this->render('home/painel', "Meu painel");
    }
    
}