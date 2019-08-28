<?php

namespace App\Controllers;
use App\Lib\Sessao;
use App\Models\BO\TipoUsuarioPermissaoBO;
use App\Models\Entidades\TipoUsuarioPermissao;

class TipoUsuarioPermissaoController extends Controller{
    public function index(){
        $this->render('tipoUsuarioPermissao/index');
    }
}