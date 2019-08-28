<?php

namespace App\Controllers;
use App\Lib\Sessao;
use App\Models\BO\TipoUsuarioBO;
use App\Models\Entidades\TipoUsuario;

class TipoUsuarioController extends Controller{
    public function index(){
        $this->render('tipoUsuario/index');
    }
}