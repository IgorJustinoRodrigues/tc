<?php
    namespace App\Models\BO;
    
    use App\Models\DAO\UsuarioDAO;
    
    class UsuarioBO extends BaseBO{
        public function instanciaDAO(){
            return new UsuarioDAO();
        }
        
    }
?>