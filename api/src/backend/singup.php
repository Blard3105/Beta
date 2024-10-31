<?php
//nombre de html ['email'];
//Db connection
require('../../config/db_connection.php');
//get data from register form
function save_db_supadb($email, $pass) {
    $SUPABASE_URL = "https://flcdyvfdghobpuapncqe.supabase.co";
    $SUPABASE_KEY = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImZsY2R5dmZkZ2hvYnB1YXBuY3FlIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MzAzODgzNjMsImV4cCI6MjA0NTk2NDM2M30.eV-rySMY2ccabbRuexs7xBt6ns5PIQn01VY9BA3u1zA";

$URl = "$SUPABASE_URL/reset/v1/users/";
$data = [
    "email" => $email,
    "password" => $pass,
];
$optiosns = [
    "http" => [
        "method" => "POST",
        "header" => "Content-Type: application/json\r\nAuthorization: Bearer $SUPABASE_KEY",
        "content" => json_encode($data)
    ],
];
$context = stream_context_create($optiosns);
$response = file_get_contents($URl, false, $context);
$response_data = json_decode($response, true);

if ($response === false) {
    echo "Error al conectar la base de datos";
    exit;
}
echo "user has been created". json_encode($response_data);
}

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
    echo "<script>alert('Email already exists!')</script>";
    header ('refresh:0; url=http://127.0.0.1/beta/api/src/register_form.html');
    exit();
}
// Query to insert data into users table
$query = "INSERT INTO users (email,password)
VALUES ('$email', '$enc_pass');
";
//Execute the query
$result = pg_query($conn, $query);
if ($result) {
    if($conn and $query == $result){
        echo "<script>alert('Registration successful!')</script>";
        header ('refresh:0; url=http://127.0.0.1/beta/api/src/login_form.html');
    }
} else {
    echo "Registration failed!";
}
pg_close($conn)
?>