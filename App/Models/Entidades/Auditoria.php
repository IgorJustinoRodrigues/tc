<?php

namespace App\Models\Entidades;

class Auditoria{
    const TABELA = 'auditoria';
    const CAMPOS = ['id', 'tipo', 'usuario_id', 'tabela', 'campos', 'descricao', 'data'];
    const OBRIGATORIO = ['tipo', 'usuario_id', 'tabela', 'data'];
    /*
     * Tipos
     * 1 - Inserção
     * 2 - Edição
     * 3 - Exclusão
     * 4 - Login
     * 5 - Logoff
     * 6 - Criação de Relatorio
     * 7 - Outros
     */
    private $id;
    private $tipo;
    private $usuario_id;
    private $tabela;
    private $campos;
    private $descricao;
    private $data;
    
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

    function getUsuario_id() {
        return $this->usuario_id;
    }

    function getTabela() {
        return $this->tabela;
    }

    function getCampos() {
        return $this->campos;
    }

    function getDescricao() {
        return $this->descricao;
    }

    function getData() {
        return $this->data;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    function setUsuario_id($usuario_id) {
        $this->usuario_id = $usuario_id;
    }

    function setTabela($tabela) {
        $this->tabela = $tabela;
    }

    function setCampos($campos) {
        $this->campos = $campos;
    }

    function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    function setData($data) {
        $this->data = $data;
    }
}