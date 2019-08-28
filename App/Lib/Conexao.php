<?php

namespace App\Lib;

use mysqli;

class Conexao{
    private static $connection;

    private function __construct(){}

    public static function getConnection() {
        $con = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if($con->connect_errno){
            die("N&atilde;o foi possivel conectar, n&deg; do erro: " . $con->connect_errno . ", mensagem: " . $con->connect_error);
        }
        return $con;
    }
}