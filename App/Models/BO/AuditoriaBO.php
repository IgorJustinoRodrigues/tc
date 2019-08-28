<?php
    namespace App\Models\BO;
    
    use App\Models\DAO\AuditoriaDAO;
    
    class AuditoriaBO extends BaseBO{
        public function instanciaDAO(){
            return new AuditoriaDAO();
        }
        
    }
?>