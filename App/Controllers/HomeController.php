<?php

namespace App\Controllers;
use App\Lib\Sessao;

class HomeController extends Controller{
    public function index(){
        $this->render('home/index', 'Início');
    }

    public function painel(){
        $this->validaUsuario();
        
        $this->render('home/painel', "Meu painel");
    }
}