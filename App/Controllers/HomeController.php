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
    
    function tipo($tipo){
        switch ($tipo) {
            case 1:
                return "Inserção";
                break;

            case 2:
                return "Edição";
                break;

            case 3:
                return "Seleção";
                break;

            case 4:
                return "Exclusão";
                break;

            case 5:
                return "Login";
                break;

            case 6:
                return "Logoff";
                break;

            default:
                return "Outros";
                break;
        }
        
    }

}