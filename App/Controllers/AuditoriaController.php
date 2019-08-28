<?php

namespace App\Controllers;
use App\Lib\Sessao;
use App\Models\BO\AuditoriaBO;
use App\Models\Entidades\Auditoria;

class AuditoriaController extends Controller{
    public function index(){
        $this->render('auditoria/index');
    }
}