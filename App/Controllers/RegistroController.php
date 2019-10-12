<?php

namespace App\Controllers;
use App\Lib\Sessao;
use App\Models\BO\RegistroBO;
use App\Models\Entidades\Registro;

class RegistroController extends Controller{
    public function entrada(){
        $this->validaUsuario();
        $this->nivelAcesso(4);
        
        $this->render('registro/entrada');
    }
}