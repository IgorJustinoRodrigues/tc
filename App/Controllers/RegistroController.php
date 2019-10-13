<?php

namespace App\Controllers;
use App\Lib\Sessao;
use App\Models\BO\RegistroBO;
use App\Models\Entidades\Registro;

class RegistroController extends Controller{
    public function entrada(){
        $this->validaUsuario();
        $this->nivelAcesso(4);
        
        $this->render('registro/entrada');
    }
    
    public function novaEntrada() {
        $this->validaUsuario();
        $this->nivelAcesso(4);
        $vetor = $_POST;

            $retorno = [
                "status" => 0,
                "msg" => "Preencha a placa do veiculo!"
            ];
            
        if(trim($vetor['placa']) != ''){
            $bo = new RegistroBO();

            $tabela = Registro::TABELA;
            $dados = [
                "usuario_id" => Sessao::getUsuario('id'),
                "veiculo_id" => 1,
                "entrada" => date('Y-m-d H:i:s'),
                "condutor" => $vetor['condutor'],
                "motivo" => $vetor['motivo'],
                "status" => 2
            ];
            $validacao = Registro::OBRIGATORIO;
            
            $id = $bo->inserir($tabela, $dados, $validacao);
            
            if($id){
                $retorno = [
                    "status" => 1,
                    "msg" => "Registro inserido!"
                ];

                echo json_decode($retorno);                
            } else {
                $retorno = [
                    "status" => 0,
                    "msg" => "Falha ao inserir registro!"
                ];

                echo json_decode($retorno);                                
            }
        } else {
            $retorno = [
                "status" => 0,
                "msg" => "Preencha a placa do veiculo!"
            ];
            
            echo json_decode($retorno);
        }
    }
}