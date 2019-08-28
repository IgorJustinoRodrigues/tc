<?php
    namespace App\Models\DAO;

    use App\Models\Entidades\TipoUsuario;

    class TipoUsuarioDAO extends BaseDAO{
       
        public function alterar($tabela, $dados, $condicao, $valorCondicao, $quantidade, $debug = null) {
            
            try {
                $tipoTipoUsuario = $this->selecionarVetor($tabela, ["*"], 1, 0, "codigo = ?", [$dados["codigo"]], null, $debug);
                if($tipoTipoUsuario){
                    $dados_alterar = array();

                    foreach( $tipoTipoUsuario as $indice => $valor ) {
                        $dados_alterar[$indice] = !isset($dados[$indice]) ? $tipoTipoUsuario[$indice] : $dados[$indice];
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

                $tipoTipoUsuario_obj = [];

                foreach ($resultado as $i => $v) {
                    $tipoTipoUsuario_obj[] = new TipoUsuario($v);
                }

                return $tipoTipoUsuario_obj;
            } else {
                return FALSE;
            }
        }
                
        function selecionar($tabela, $campos, $quantidade, $pagina, $condicao, $valorCondicao, $orderBy, $debug = null) {
            
            $resultado = $this->select($tabela, $campos, $quantidade, $pagina, $condicao, $valorCondicao, $orderBy, $debug);
            
            if($resultado){

                $tipoTipoUsuario_obj = null;

                foreach ($resultado as $i => $v) {
                    $tipoTipoUsuario_obj = new TipoUsuario($v);
                }
            
                return $tipoTipoUsuario_obj;
            } else {
                return FALSE;
            }
        }        
    }   
?>