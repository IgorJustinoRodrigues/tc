<?php
    namespace App\Models\BO;
    
    use App\Models\DAO\TipoUsuarioPermissaoDAO;
    
    class TipoUsuarioPermissaoBO extends BaseBO{
        public function instanciaDAO(){
            return new TipoUsuarioPermissaoDAO();
        }
        
    }
?>