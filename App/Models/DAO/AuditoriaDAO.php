<?php
    namespace App\Models\DAO;

    use App\Models\Entidades\Auditoria;

    class AuditoriaDAO extends BaseDAO{
       
        public function alterar($tabela, $dados, $condicao, $valorCondicao, $quantidade, $debug = null) {
            
            try {
                $auditoria = $this->selecionarVetor($tabela, ["*"], 1, 0, "codigo = ?", [$dados["codigo"]], null, $debug);
                if($auditoria){
                    $dados_alterar = array();

                    foreach( $auditoria as $indice => $valor ) {
                        $dados_alterar[$indice] = !isset($dados[$indice]) ? $auditoria[$indice] : $dados[$indice];
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

                $auditoria_obj = [];

                foreach ($resultado as $i => $v) {
                    $auditoria_obj[] = new Auditoria($v);
                }

                return $auditoria_obj;
            } else {
                return FALSE;
            }
        }
                
        function selecionar($tabela, $campos, $quantidade, $pagina, $condicao, $valorCondicao, $orderBy, $debug = null) {
            
            $resultado = $this->select($tabela, $campos, $quantidade, $pagina, $condicao, $valorCondicao, $orderBy, $debug);
            
            if($resultado){

                $auditoria_obj = null;

                foreach ($resultado as $i => $v) {
                    $auditoria_obj = new Auditoria($v);
                }
            
                return $auditoria_obj;
            } else {
                return FALSE;
            }
        }        
    }   
?>