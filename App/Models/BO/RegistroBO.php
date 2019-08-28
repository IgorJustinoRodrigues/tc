<?php
    namespace App\Models\BO;
    
    use App\Models\DAO\RegistroDAO;
    
    class RegistroBO extends BaseBO{
        public function instanciaDAO(){
            return new RegistroDAO();
        }
        
    }
?>