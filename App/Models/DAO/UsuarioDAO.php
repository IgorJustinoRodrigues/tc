<?php
    namespace App\Models\DAO;

    use App\Models\Entidades\Usuario;

    class UsuarioDAO extends BaseDAO{
       
        public function alterar($tabela, $dados, $condicao, $valorCondicao, $quantidade, $debug = null) {
            
            try {
                $usuario = $this->selecionarVetor($tabela, ["*"], 1, 0, "codigo = ?", [$dados["codigo"]], null, $debug);
                if($usuario){
                    $dados_alterar = array();

                    foreach( $usuario as $indice => $valor ) {
                        $dados_alterar[$indice] = !isset($dados[$indice]) ? $usuario[$indice] : $dados[$indice];
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

                $usuario_obj = [];

                foreach ($resultado as $i => $v) {
                    $usuario_obj[] = new Usuario($v);
                }

                return $usuario_obj;
            } else {
                return FALSE;
            }
        }
                
        function selecionar($tabela, $campos, $quantidade, $pagina, $condicao, $valorCondicao, $orderBy, $debug = null) {
            
            $resultado = $this->select($tabela, $campos, $quantidade, $pagina, $condicao, $valorCondicao, $orderBy, $debug);
            
            if($resultado){

                $usuario_obj = null;

                foreach ($resultado as $i => $v) {
                    $usuario_obj = new Usuario($v);
                }
            
                return $usuario_obj;
            } else {
                return FALSE;
            }
        }        
    }   
?>