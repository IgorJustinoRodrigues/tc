<?php
    namespace App\Models\DAO;

    use App\Models\Entidades\Veiculo;

    class VeiculoDAO extends BaseDAO{
       
        public function alterar($tabela, $dados, $condicao, $valorCondicao, $quantidade, $debug = null) {
            
            try {
                $veiculo = $this->selecionarVetor($tabela, ["*"], 1, 0, "codigo = ?", [$dados["codigo"]], null, $debug);
                if($veiculo){
                    $dados_alterar = array();

                    foreach( $veiculo as $indice => $valor ) {
                        $dados_alterar[$indice] = !isset($dados[$indice]) ? $veiculo[$indice] : $dados[$indice];
                    }

                    $resultado = $this->update($tabela, $dados, $condicao, $valorCondicao, $quantidade, $debug);      

                    if($resultado != FALSE){
                        return $dados_alterar;
                    } else {
                        return FALSE;
                    }
                } else {
                    return FALSE;
                }

            }catch (\Exception $e){
                throw new Exception();
            }
        }
        
        public function listar($tabela, $campos, $quantidade, $pagina, $condicao, $valorCondicao, $orderBy, $debug = null){
            $resultado = $this->select($tabela, $campos, $quantidade, $pagina, $condicao, $valorCondicao, $orderBy, $debug);
            
            if($resultado){

                $veiculo_obj = [];

                foreach ($resultado as $i => $v) {
                    $veiculo_obj[] = new Veiculo($v);
                }

                return $veiculo_obj;
            } else {
                return FALSE;
            }
        }
                
        function selecionar($tabela, $campos, $quantidade, $pagina, $condicao, $valorCondicao, $orderBy, $debug = null) {
            
            $resultado = $this->select($tabela, $campos, $quantidade, $pagina, $condicao, $valorCondicao, $orderBy, $debug);
            
            if($resultado){

                $veiculo_obj = null;

                foreach ($resultado as $i => $v) {
                    $veiculo_obj = new Veiculo($v);
                }
            
                return $veiculo_obj;
            } else {
                return FALSE;
            }
        }        
    }   
?>