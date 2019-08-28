<?php
    namespace App\Models\DAO;

    use App\Models\Entidades\TipoUsuarioPermissao;

    class TipoUsuarioPermissaoDAO extends BaseDAO{
       
        public function alterar($tabela, $dados, $condicao, $valorCondicao, $quantidade, $debug = null) {
            
            try {
                $tipoUsuarioPermissao = $this->selecionarVetor($tabela, ["*"], 1, 0, "codigo = ?", [$dados["codigo"]], null, $debug);
                if($tipoUsuarioPermissao){
                    $dados_alterar = array();

                    foreach( $tipoUsuarioPermissao as $indice => $valor ) {
                        $dados_alterar[$indice] = !isset($dados[$indice]) ? $tipoUsuarioPermissao[$indice] : $dados[$indice];
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

                $tipoUsuarioPermissao_obj = [];

                foreach ($resultado as $i => $v) {
                    $tipoUsuarioPermissao_obj[] = new TipoUsuarioPermissao($v);
                }

                return $tipoUsuarioPermissao_obj;
            } else {
                return FALSE;
            }
        }
                
        function selecionar($tabela, $campos, $quantidade, $pagina, $condicao, $valorCondicao, $orderBy, $debug = null) {
            
            $resultado = $this->select($tabela, $campos, $quantidade, $pagina, $condicao, $valorCondicao, $orderBy, $debug);
            
            if($resultado){

                $tipoUsuarioPermissao_obj = null;

                foreach ($resultado as $i => $v) {
                    $tipoUsuarioPermissao_obj = new TipoUsuarioPermissao($v);
                }
            
                return $tipoUsuarioPermissao_obj;
            } else {
                return FALSE;
            }
        }        
    }   
?>