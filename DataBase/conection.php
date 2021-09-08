<?php
$serverName = "localhost";

public static function conectar(){
     $connectionInfo = array( "Database"=>"marketplace");
     $Conn = sqlsrv_connect( $serverName, $connectionInfo);
     if($Conn) {
          echo "Conexión establecida.<br />";
     }else{
          echo "Conexión no se pudo establecer.<br />";
          die( print_r( sqlsrv_errors(), true));
     }
 }
?>