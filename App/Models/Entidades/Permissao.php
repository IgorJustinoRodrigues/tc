<?php

namespace App\Models\Entidades;

class Permissao{
    const TABELA = 'permissao';
    const CAMPOS = ['id', 'descricao', 'nivel', 'status'];
    const OBRIGATORIO = ['descricao', 'nivel', 'status'];
    
    private $id;
    private $descricao;
    private $nivel;
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

    function getNivel() {
        return $this->nivel;
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

    function setNivel($nivel) {
        $this->nivel = $nivel;
    }

    function setStatus($status) {
        $this->status = $status;
    }
}