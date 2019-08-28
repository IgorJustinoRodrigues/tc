<?php
    namespace App\Models\BO;
    
    use App\Models\DAO\PermissaoDAO;
    
    class PermissaoBO extends BaseBO{
        public function instanciaDAO(){
            return new PermissaoDAO();
        }
        
    }
?>