<?php
$serverName = "localhost";
$password = "password";
$user = "user";

$connectionInfo = array( "Database"=>"marketplace");
$Conn = sqlsrv_connect( $serverName, $connectionInfo, $user, $password);
if($Conn) {
     //echo "Conexión establecida.<br />";
}else{
     echo "Conexión no se pudo establecer.<br />";
     die( print_r( sqlsrv_errors(), true));
}
?>