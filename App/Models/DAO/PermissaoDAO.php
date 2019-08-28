<?php
    namespace App\Models\DAO;

    use App\Models\Entidades\Permissao;

    class PermissaoDAO extends BaseDAO{
       
        public function alterar($tabela, $dados, $condicao, $valorCondicao, $quantidade, $debug = null) {
            
            try {
                $permissao = $this->selecionarVetor($tabela, ["*"], 1, 0, "codigo = ?", [$dados["codigo"]], null, $debug);
                if($permissao){
                    $dados_alterar = array();

                    foreach( $permissao as $indice => $valor ) {
                        $dados_alterar[$indice] = !isset($dados[$indice]) ? $permissao[$indice] : $dados[$indice];
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

                $permissao_obj = [];

                foreach ($resultado as $i => $v) {
                    $permissao_obj[] = new Permissao($v);
                }

                return $permissao_obj;
            } else {
                return FALSE;
            }
        }
                
        function selecionar($tabela, $campos, $quantidade, $pagina, $condicao, $valorCondicao, $orderBy, $debug = null) {
            
            $resultado = $this->select($tabela, $campos, $quantidade, $pagina, $condicao, $valorCondicao, $orderBy, $debug);
            
            if($resultado){

                $permissao_obj = null;

                foreach ($resultado as $i => $v) {
                    $permissao_obj = new Permissao($v);
                }
            
                return $permissao_obj;
            } else {
                return FALSE;
            }
        }        
    }   
?>