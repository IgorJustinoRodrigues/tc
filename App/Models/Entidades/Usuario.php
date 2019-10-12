<?php

namespace App\Models\Entidades;

class Usuario{
    const TABELA = 'usuario';
    const CAMPOS = ['id', 'nome', 'email', 'fone', 'endereco', 'bairro', 'cidade', 'cargo', 'ultimaSenha', 'senha', 'token', 'status', 'cadastro', 'tipo_usuario_id'];
    const OBRIGATORIO = ['nome', 'email', 'cargo', 'status', 'tipo_usuario_id'];
    
    private $id;
    private $nome;
    private $email;
    private $fone;
    private $endereco;
    private $bairro;
    private $cidade;
    private $cargo;
    private $ultimaSenha;
    private $senha;
    private $token;
    private $status;
    private $cadastro;
    private $tipo_usuario_id;
    
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

    function getNome() {
        return $this->nome;
    }

    function getEmail() {
        return $this->email;
    }

    function getFone() {
        return $this->fone;
    }

    function getEndereco() {
        return $this->endereco;
    }

    function getBairro() {
        return $this->bairro;
    }

    function getCidade() {
        return $this->cidade;
    }

    function getCargo() {
        return $this->cargo;
    }

    function getSenha() {
        return $this->senha;
    }

    function getUltimaSenha() {
        return $this->ultimaSenha;
    }

    function getToken() {
        return $this->token;
    }

    function getStatus() {
        return $this->status;
    }

    function getCadastro() {
        return $this->cadastro;
    }

    function getTipo_usuario_id() {
        return $this->tipo_usuario_id;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setFone($fone) {
        $this->fone = $fone;
    }

    function setEndereco($endereco) {
        $this->endereco = $endereco;
    }

    function setBairro($bairro) {
        $this->bairro = $bairro;
    }

    function setCidade($cidade) {
        $this->cidade = $cidade;
    }

    function setCargo($cargo) {
        $this->cargo = $cargo;
    }

    function setSenha($senha) {
        $this->senha = $senha;
    }

    function setUltimaSenha($ultimaSenha) {
        $this->ultimaSenha = $ultimaSenha;
    }

    function setToken($token) {
        $this->token = $token;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function setCadastro($cadastro) {
        $this->cadastro = $cadastro;
    }

    function setTipo_usuario_id($tipo_usuario) {
        $this->tipo_usuario_id = $tipo_usuario;
    }
}