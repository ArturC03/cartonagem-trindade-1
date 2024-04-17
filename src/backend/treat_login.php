<?php
require '../includes/config.inc.php';

$username = $_POST['username'];
$pass = $_POST['password'];

$password = sha1($pass);

$result = my_query("SELECT * from user WHERE (email = '$username' OR username = '$username') AND password = '$password';");

if (!count($result) >= 1) {
    $data['success'] = false;
} else {
    $data['success'] = true;
    $_SESSION['username'] = $result[0]['id_user'];
}
echo json_encode($data);
