<?php
    namespace App\Models\DAO;

    use App\Models\Entidades\Registro;

    class RegistroDAO extends BaseDAO{
       
        public function alterar($tabela, $dados, $condicao, $valorCondicao, $quantidade, $debug = null) {
            
            try {
                $registro = $this->selecionarVetor($tabela, ["*"], 1, 0, "codigo = ?", [$dados["codigo"]], null, $debug);
                if($registro){
                    $dados_alterar = array();

                    foreach( $registro as $indice => $valor ) {
                        $dados_alterar[$indice] = !isset($dados[$indice]) ? $registro[$indice] : $dados[$indice];
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

                $registro_obj = [];

                foreach ($resultado as $i => $v) {
                    $registro_obj[] = new Registro($v);
                }

                return $registro_obj;
            } else {
                return FALSE;
            }
        }
                
        function selecionar($tabela, $campos, $quantidade, $pagina, $condicao, $valorCondicao, $orderBy, $debug = null) {
            
            $resultado = $this->select($tabela, $campos, $quantidade, $pagina, $condicao, $valorCondicao, $orderBy, $debug);
            
            if($resultado){

                $registro_obj = null;

                foreach ($resultado as $i => $v) {
                    $registro_obj = new Registro($v);
                }
            
                return $registro_obj;
            } else {
                return FALSE;
            }
        }        
    }   
?>