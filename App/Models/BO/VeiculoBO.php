<?php
    namespace App\Models\BO;
    
    use App\Models\DAO\VeiculoDAO;
    
    class VeiculoBO extends BaseBO{
        public function instanciaDAO(){
            return new VeiculoDAO();
        }
        
    }
?>