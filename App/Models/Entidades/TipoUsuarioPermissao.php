<?php

namespace App\Models\Entidades;

class TipoUsuarioPermissao{
    const TABELA = 'tipo_usuario_permissao';
    const CAMPOS = ['tipo_usuario_id', 'permissao_id'];
    const OBRIGATORIO = ['tipo_usuario_id', 'permissao_id'];
    
    private $tipo_usuario_id;
    private $permissao_id;
    
    public function __construct($dados = null) {
        if ($dados != null) {
            foreach( $this as $indice => $valor ) {
                $this->$indice = isset($dados[$indice]) ? $dados[$indice] : null;
            }
        }
    }
    
    function getTipo_usuario_id() {
        return $this->tipo_usuario_id;
    }

    function getPermissao_id() {
        return $this->permissao_id;
    }

    function setTipo_usuario_id($tipo_usuario_id) {
        $this->tipo_usuario_id = $tipo_usuario_id;
    }

    function setPermissao_id($permissao_id) {
        $this->permissao_id = $permissao_id;
    }
}