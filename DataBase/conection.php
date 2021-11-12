<?php

class Conection{

     public static function conectar(){
          $serverName = "localhost";
          $connectionInfo = array( "Database"=>"marketplace");
          $con = sqlsrv_connect( $serverName, $connectionInfo);
          if($con) {
               //echo "Conexión establecida.<br />";
          }else{
               echo "No se pudo establecer la conexión.<br />";
               die( print_r( sqlsrv_errors(), true));
          }
          return $con;
     }
}
?>