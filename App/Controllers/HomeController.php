<?php

namespace App\Controllers;
use App\Lib\Sessao;

class HomeController extends Controller{
    public function index(){
        $this->render('home/index', 'Início');
    }

    public function painel(){
        $this->validaUsuario();


        $lista = $this->exibirAuditoria(5);

        $this->setViewParam('auditoria', $lista);
        
        $this->render('home/painel', "Meu painel");
    }
    
}