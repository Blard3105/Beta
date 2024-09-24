<?php

$host = "localhost";

$port = "5432"; 

$dbname = "beta";

$username = "postgres";

$password = "PCamilo";

//crear variables de conectividad
$data_connection = "
host = $host
port = $port
dbname = $dbname
user = $username
password = $password";

$conn =pg_connect($data_connection);

    //verificar conectividad
    if (!$conn) {
        die("Connection failed: ". pg_last_error());
    }
    else {echo "Connection successfully";
    }


    //cerrar la conexion

    pg_close($conn);

?>