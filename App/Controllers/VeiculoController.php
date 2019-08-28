<?php

namespace App\Controllers;
use App\Lib\Sessao;
use App\Models\BO\VeiculoBO;
use App\Models\Entidades\Veiculo;

class VeiculoController extends Controller{
    public function index(){
        $this->render('veiculo/index');
    }
}