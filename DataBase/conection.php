<?php
$serverName = "localhost\proyecto-de-administracion-bd"; //serverName\instanceName
$connectionInfo = array( "Database"=>"marketplace", "UID"=>"user", "PWD"=>"password");
$conn = sqlsrv_connect( $serverName, $connectionInfo);

if( $conn ) {
     echo "Conexión establecida.<br />";
}else{
     echo "Conexión no se pudo establecer.<br />";
     die( print_r( sqlsrv_errors(), true));
}
?>