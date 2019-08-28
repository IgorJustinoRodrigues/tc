<?php
    namespace App\Models\BO;
    
    use App\Models\DAO\TipoUsuarioDAO;
    
    class TipoUsuarioBO extends BaseBO{
        public function instanciaDAO(){
            return new TipoUsuarioDAO();
        }
        
    }
?>