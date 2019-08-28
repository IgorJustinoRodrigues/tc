<?php

namespace App\Lib;

use Exception;
use App\Lib\Sessao;
use App\Controllers\Controller;

class Erro extends Controller{
    private $message;
    private $code;

    public function __construct($objetoException = Exception::class){
        $this->code     = $objetoException->getCode();
        $this->message  = $objetoException->getMessage();
    }

    public function render(){
        Sessao::gravaMensagem("Erro: " . $this->code  . " - " . $this->message);
        $this->redirect('home/');
    }
}