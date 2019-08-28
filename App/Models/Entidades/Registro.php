<?php

namespace App\Models\Entidades;

class Registro{
    const TABELA = 'registro';
    const CAMPOS = ['id', 'tipo_usuario_id', 'veiculo_id', 'entrada', 'saida', 'condutor', 'motivo', 'descricao', 'status'];
    const OBRIGATORIO = ['tipo_usuario_id', 'veiculo_id', 'entrada', 'status'];
    
    private $id;
    private $tipo_usuario_id;
    private $veiculo_id;
    private $entrada;
    private $saida;
    private $condutor;
    private $motivo;
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

    function getTipo_usuario_id() {
        return $this->tipo_usuario_id;
    }

    function getVeiculo_id() {
        return $this->veiculo_id;
    }

    function getEntrada() {
        return $this->entrada;
    }

    function getSaida() {
        return $this->saida;
    }

    function getCondutor() {
        return $this->condutor;
    }

    function getMotivo() {
        return $this->motivo;
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

    function setTipo_usuario_id($tipo_usuario_id) {
        $this->tipo_usuario_id = $tipo_usuario_id;
    }

    function setVeiculo_id($veiculo_id) {
        $this->veiculo_id = $veiculo_id;
    }

    function setEntrada($entrada) {
        $this->entrada = $entrada;
    }

    function setSaida($saida) {
        $this->saida = $saida;
    }

    function setCondutor($condutor) {
        $this->condutor = $condutor;
    }

    function setMotivo($motivo) {
        $this->motivo = $motivo;
    }

    function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    function setStatus($status) {
        $this->status = $status;
    }
}