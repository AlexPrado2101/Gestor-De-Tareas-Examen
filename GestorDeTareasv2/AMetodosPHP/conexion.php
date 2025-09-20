<?php

class Cconexion{

    function ConexionBD(){

        $host='localhost';
        $dbname='GestorDeTareas';
        $username='admin';
        $pasword ='admin123';
        $puerto=1433;

        try{
            $conn = new PDO ("sqlsrv:Server=$host,$puerto;Database=$dbname",$username,$pasword);
            /*echo "Se conectó correctamente a la base de datos";*/
        }
        catch(PDOException $exp){
            echo ("No se logró conectar correctamente con la base de datos: $dbname, error: $exp");
        }

        return $conn;
    }

}

?>