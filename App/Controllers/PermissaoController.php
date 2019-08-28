<?php

namespace App\Controllers;
use App\Lib\Sessao;
use App\Models\BO\PermissaoBO;
use App\Models\Entidades\Permissao;

class PermissaoController extends Controller{
    public function index(){
        $this->render('permissao/index');
    }
}