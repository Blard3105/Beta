<?php
require('../../config/db_connection.php');

$email = $_POST['email'];
$pass = $_POST['password'];
$enc_pass = md5($pass);

$query = "INSERT INTO users (email, password)
VALUES ('$email', '$enc_pass')";
$result = pg_query($conn, $query);

if($result) {
    echo "<br>registered successfully";
} else {
    echo "Registered failed";
}
pg_close($conn);
?>