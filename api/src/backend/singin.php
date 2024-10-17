<?php
//nombre de html ['email'];
//Db connection
require('../../config/db_connection.php');
//get data from register form


$email = $_POST['email'];
$pass = $_POST['password'];
//Encrypt password with md5 hashing algoritm
$enc_pass = md5($pass);

/*show password and email
echo "email:" . $email;
echo "<br>Password:" . $pass;
echo "<br>Enc. Password " . $enc_pass;
*/
//validate if email already exists
$query = "SELECT * FROM users WHERE email = '$email'";
$result = pg_query($conn, $query);
$row = pg_fetch_assoc($result);
if ($row) {
    $query = "SELECT * FROM users WHERE password='$enc_pass'";
    $result = pg_query($conn, $query);
    $row = pg_fetch_assoc($result);
    if ($row) {
        echo "<script>alert('correct')</script>";
    } else {
        echo "<script>alert('password incorrect')</script>";
    }
    header ('refresh:0; url=http://127.0.0.1/beta/api/src/login_form.html');
    exit();
}
// Query to insert data into users table

//Execute the query
$result = pg_query($conn, $query);
if ($result) {
    echo "<script>alert('No registration')</script>";
    header ('refresh:0; url=http://127.0.0.1/beta/api/src/login_form.html');
} else {
    echo "Registration failed!";
}
pg_close($conn)

?>