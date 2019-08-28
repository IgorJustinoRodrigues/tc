<?php

namespace App\Lib;


class Sessao{    
    public static function setUsuario($usuario) {
        $_SESSION['usuario'] = $usuario;
    }
    
    public static function getUsuario($indice) {
        return (isset($_SESSION['usuario'][$indice])) ? $_SESSION['usuario'][$indice] : "";        
    }
    
    public static function limpaUsuario(){
        unset($_SESSION['usuario']);
    }

    public static function logado(){
        return ($_SESSION['logadoUsuario']) ? $_SESSION['logadoUsuario'] : false;   
    }

        
    public static function setLogado($status){
        $_SESSION['logadoUsuario'] = $status;
    }
    
    public static function gravaMensagem($mensagem){
        $_SESSION['mensagem'] != '' ? $_SESSION['mensagem'] = $_SESSION['mensagem'] . "<br>" . $mensagem : $_SESSION['mensagem'] = $mensagem;
    }

    public static function limpaMensagem(){
        unset($_SESSION['mensagem']);
    }

    public static function retornaMensagem(){
        $msg = ($_SESSION['mensagem']) ? $_SESSION['mensagem'] : "";

        return $msg;
    }

    public static function existeMensagem(){
        return $_SESSION['mensagem'] == '' ? false : true;
    }

    public static function gravaFormulario($form){
        $_SESSION['form'] = $form;
    }

    public static function limpaFormulario(){
        unset($_SESSION['form']);
    }

    public static function retornaFormulario($key){
        return (isset($_SESSION['form'][$key])) ? $_SESSION['form'][$key] : "";
    }    
}