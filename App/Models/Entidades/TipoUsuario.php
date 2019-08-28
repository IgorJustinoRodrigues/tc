<?php

namespace App\Models\Entidades;

class TipoUsuario{
    const TABELA = 'tipo_usuario';
    const CAMPOS = ['id', 'descricao', 'status'];
    const OBRIGATORIO = ['descricao', 'status'];
    
    private $id;
    private $descricao;
    private $status;
    
    public function __construct($dados = null) {
        if ($dados != null) {
            foreach( $this as $indice => $valor ) {
                $this->$indice = isset($dados[$indice]) ? $dados[$indice] : null;
            }
        }
    }
    
    function getId() {
        return $this->id;
    }

    function getDescricao() {
        return $this->descricao;
    }

    function getStatus() {
        return $this->status;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    function setStatus($status) {
        $this->status = $status;
    }
}