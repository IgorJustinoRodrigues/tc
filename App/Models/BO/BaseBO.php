<?php

namespace App\Models\BO;

abstract class BaseBO{
    public function sql($sql){
        $dao = $this->instanciaDAO();

        return $dao->sql($sql);
    }

    public function inserir($tabela = null, $dados = null, $validacao = [], $debug = null){
        $dao = $this->instanciaDAO();
        if($tabela == null || trim($tabela) == ''){
            return false;
        }

        foreach ($validacao as $item){

            if($dados["$item"] == null || $dados["$item"] == 'null' || trim($dados["$item"]) == ''){
                \App\Lib\Sessao::gravaMensagem("Campo: " . $item . ", não preencido!<br>");
                return false;
            }                
        }

        return $dao->inserir($tabela, $dados, $debug);
    }

    public function update($tabela = null, $dados = [], $condicao = null, $valorCondicao = [], $quantidade = 1, $validacao = [], $debug = null){
        $dao = $this->instanciaDAO();

        if($tabela == null || trim($tabela) == ''){
            return false;
        }                            
    
        foreach ($validacao as $item){

            if($dados["$item"] == null || $dados["$item"] == 'null' || trim($dados["$item"]) == ''){
                \App\Lib\Sessao::gravaMensagem("Campo: " . $item . ", não preencido!<br>");
                return false;
            }                
        }

        return $dao->update($tabela, $dados, $condicao, $valorCondicao, $quantidade, $debug);
    }
    
    public function listar($tabela = null, $campos = ["*"], $quantidade = null, $pagina = null, $condicao = null, $valorCondicao = null, $orderBy = null, $debug = null){
        $dao = $this->instanciaDAO();

        if($tabela == null || trim($tabela) == ''){
            return false;
        }   

        return $dao->listar($tabela, $campos, $quantidade, $pagina, $condicao, $valorCondicao, $orderBy, $debug); 
    }
    
    public function selecionar($tabela = null, $campos = ["*"], $quantidade = null, $pagina = null, $condicao = null, $valorCondicao = null, $orderBy = null, $debug = null){
        $dao = $this->instanciaDAO();

        if($tabela == null || trim($tabela) == ''){
            return false;
        }   

        return $dao->selecionar($tabela, $campos, $quantidade, $pagina, $condicao, $valorCondicao, $orderBy, $debug); 
    }
    
    public function salvar($tabela = null, $dados = [], $condicao = null, $valorCondicao = [], $quantidade = null, $validacao = [], $debug = null){
        $dao = $this->instanciaDAO();
        if($tabela == null || trim($tabela) == ''){
            return false;
        }   


        foreach ($validacao as $item){
            if($dados["$item"] == null || $dados["$item"] == 'null' || trim($dados["$item"]) == ''){
                \App\Lib\Sessao::gravaMensagem("Campo: " . $item . ", não preencido!<br>");
                return false;
            }                
               
        }

        if(count($dados) < 1){
            return false;
        }

        return $dao->alterar($tabela, $dados, $condicao, $valorCondicao, $quantidade, $debug);
    }

    public function excluir($tabela = null, $condicao = null, $valorCondicao = [], $quantidade = null, $debug = null){
        $dao = $this->instanciaDAO();

        if($tabela == null || trim($tabela) == ''){
            return false;
        }   

        return $dao->delete($tabela, $condicao, $valorCondicao, $quantidade, $debug);
    }
    
    public function listarVetor($tabela = null, $campos = ["*"], $quantidade = null, $pagina = null, $condicao = null, $valorCondicao = null, $orderBy = null, $debug = null){
        $dao = $this->instanciaDAO();

        if($tabela == null || trim($tabela) == ''){
            return false;
        }   

        return $dao->listarVetor($tabela, $campos, $quantidade, $pagina, $condicao, $valorCondicao, $orderBy, $debug); 
    }
    
    public function selecionarVetor($tabela = null, $campos = ["*"], $quantidade = null, $pagina = null, $condicao = null, $valorCondicao = null, $orderBy = null, $debug = null){
        $dao = $this->instanciaDAO();

        if($tabela == null || trim($tabela) == ''){
            return false;
        }   

        return $dao->selecionarVetor($tabela, $campos, $quantidade, $pagina, $condicao, $valorCondicao, $orderBy, $debug); 
    }
    
}