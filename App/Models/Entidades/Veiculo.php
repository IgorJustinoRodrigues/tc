<?php

namespace App\Models\Entidades;

class Veiculo{
    const TABELA = 'veiculo';
    const CAMPOS = ['id', 'tipo', 'modelo', 'placa', 'cidadePlaca', 'cor', 'observacoes', 'cadastro'];
    const OBRIGATORIO = ['placa', 'cadastro'];
    
    private $id;
    private $tipo;
    private $modelo;
    private $placa;
    private $cidadePlaca;
    private $cor;
    private $observacoes;
    private $cadastro;
    
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

    function getTipo() {
        return $this->tipo;
    }

    function getModelo() {
        return $this->modelo;
    }

    function getPlaca() {
        return $this->placa;
    }

    function getCidadePlaca() {
        return $this->cidadePlaca;
    }

    function getCor() {
        return $this->cor;
    }

    function getObservacoes() {
        return $this->observacoes;
    }

    function getCadastro() {
        return $this->cadastro;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    function setModelo($modelo) {
        $this->modelo = $modelo;
    }

    function setPlaca($placa) {
        $this->placa = $placa;
    }

    function setCidadePlaca($cidadePlaca) {
        $this->cidadePlaca = $cidadePlaca;
    }

    function setCor($cor) {
        $this->cor = $cor;
    }

    function setObservacoes($observacoes) {
        $this->observacoes = $observacoes;
    }

    function setCadastro($cadastro) {
        $this->cadastro = $cadastro;
    }
}