<?php

namespace App\Models\DAO;

use App\Lib\Conexao;

abstract class BaseDAO{
    private $conexao;

    public function __construct(){
        $this->conexao = Conexao::getConnection();
    }
    
    public function conectar(){
        return $this->conexao;
    }

    public function sql($sql){
        if(isset($sql)){
            $conexao = $this->conectar();
            
            $conexao->query($sql);
            
            if($conexao->affected_rows > 0){
                return true;
            } else {
                return FALSE;
            }
        }
    }
    
    public function inserir($tabela, $campos, $debug = null){
        if(isset($tabela) and isset($campos)){
            $x = 1;            
            
            $sql = "INSERT INTO `";
            $sql .= $tabela;
            $sql .= "` (";                

            foreach ($campos as $key => $value) {
                if($x == 1){
                    $x++;
                } else {
                    $sql .= ', ';
                }
                $sql .= "`" . $key . "`";
            }

            $sql .= ") VALUES (";

            $x = 1;
            foreach ($campos as $key => $value) {
                if($x == 1){
                    $x++;
                } else {
                    $sql .= ', ';  
                }
                if($value != "null"){
                    $sql .= "'" . $value . "'   ";                    
                } else {
                    $sql .= $value;
                }
            }

            $sql .= ")";

            $conexao = $this->conectar();
            
            $conexao->query($sql);
            
            if($debug){
                var_dump($sql);
            }
            
            $id = $conexao->insert_id;
            if($conexao->affected_rows > 0){
                if($id){
                    
                    return $id;
                } else {
                    return true;
                }
            } else {
                return FALSE;
            }
        }
    }
    
    public function select($tabela, $campos, $quantidade, $pagina, $condicao, $valorCondicao, $orderBy, $debug = null){
        if(isset($tabela)){
            
            $x = 1;

            $sql = "SELECT ";

            foreach ($campos as $key => $value) {
                if($x == 1){
                    $x++;
                } else {
                    $sql .= ', ';
                }

                if(strpos($value, '&&') !== 0){
                    $sql .= $value;
                } else {
                    $sql .= str_replace("&&", "", $value);
                }
            }
            $sql .= " FROM ";
            $sql .= $tabela;

            if($condicao != ''){
                $sql .= " WHERE ";

                $array = str_split($condicao);
                $x = 0;
                $y = 0;

                foreach ($array as $car){
                    if($car == '?'){
                        if(isset($valorCondicao[$x])){
                            $array[$y] = $valorCondicao[$x];
                            $x++;
                        } else {
                            $array[$y] = $valorCondicao[--$x];
                        }
                    }                
                    $y++;
                }

                $condicao = implode('', $array);

                $sql .= $condicao;
            }
            
            if($orderBy){
                $sql .= ' ORDER BY ';
                $sql .= $orderBy;
            }
            
            if($quantidade){
                $sql .= ' LIMIT ';
                if($pagina){
                    $sql .= $pagina;
                } else {
                    $sql .= '0';
                }
                
                $sql .= ", ";
                    
                $sql .= $quantidade;
            }

            if($debug){
                var_dump($sql);
            }            

            $conexao = $this->conectar();

            $resultado = $conexao->query($sql);

            if($resultado){
                return $resultado;
            } else {
                return FALSE;
            }
        }
    }
    
    public function update($tabela, $dados, $condicao, $valorCondicao, $quantidade, $debug = null) {
        if(isset($tabela)){
            $x = 1;

            $sql = "UPDATE `";
            $sql .= $tabela;
            $sql .= "` SET ";                

            foreach ($dados as $key => $value) {
                if($x == 1){
                    $x++;
                } else {
                    $sql .= ', ';
                }
                if($value != "null" and strpos($value, '&&') !== 0){
                    $sql .= "`" . $key . "` = '" . $value . "'";
                } else {
                    $sql .= "`" . $key . "` = " . str_replace("&&", "", $value);
                }
            }

            $sql .= " WHERE ";

            $array = str_split($condicao);
            $x = 0;
            $y = 0;

            foreach ($array as $car){
                if($car == '?'){
                    if(isset($valorCondicao[$x])){
                        $array[$y] = $valorCondicao[$x];
                        $x++;
                    } else {
                        $array[$y] = $valorCondicao[--$x];
                    }
                }                
                $y++;
            }

            $condicao = implode('', $array);

            $sql .= $condicao;
            
            if($quantidade != null and trim($quantidade) != '' and is_numeric($quantidade)){
                $sql .= " LIMIT ";
                $sql .= $quantidade;
            }

            if($debug){
                var_dump($sql);
            }
            
            $conexao = $this->conectar();

            $conexao->query($sql);

            if($conexao->affected_rows > 0){
                $conexao->close();
                return true;
            } else {
                $conexao->close();
                return FALSE;
            }
        }
    }
    
    public function delete($tabela, $condicao, $valorCondicao, $quantidade, $debug = null) {
        if(isset($tabela)){
            $x = 1;

            $sql = "DELETE FROM `";
            $sql .= $tabela;
            $sql .= "` WHERE ";                

            $array = str_split($condicao);
            $x = 0;
            $y = 0;

            foreach ($array as $car){
                if($car == '?'){
                    if(isset($valorCondicao[$x])){
                        $array[$y] = $valorCondicao[$x];
                        $x++;
                    } else {
                        $array[$y] = $valorCondicao[--$x];
                    }
                }                
                $y++;
            }

            $condicao = implode('', $array);

            $sql .= $condicao;
            
            if($quantidade != null and trim($quantidade) != '' and is_numeric($quantidade)){
                $sql .= " LIMIT ";
                $sql .= $quantidade;
            }

            if($debug){
                var_dump($sql);
            }
            
            $conexao = $this->conectar();

            $conexao->query($sql);

            if($conexao->affected_rows > 0){
                $conexao->close();
                return TRUE;
            } else {
                $conexao->close();
                return FALSE;
            }
        }        
    }
    
    public function listarVetor($tabela, $campos, $quantidade, $pagina, $condicao, $valorCondicao, $orderBy, $debug = null){
        $resultado = $this->select($tabela, $campos, $quantidade, $pagina, $condicao, $valorCondicao, $orderBy, $debug);

        if($resultado){

            $array = [];

            foreach ($resultado as $i => $v) {
                $array[] = $v;
            }

            return $array;
        } else {
            return FALSE;
        }
    }

    function selecionarVetor($tabela, $campos, $quantidade, $pagina, $condicao, $valorCondicao, $orderBy, $debug = null) {

        $resultado = $this->select($tabela, $campos, $quantidade, $pagina, $condicao, $valorCondicao, $orderBy, $debug);

        if($resultado){

            $item = null;

            foreach ($resultado as $i => $v) {
                $item = $v;
            }

            return $item;
        } else {
            return FALSE;
        }
    }   
}