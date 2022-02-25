<?php

session_start();
require "functions.php";

$email = $_POST["email"];
$password = $_POST["password"];
$hash = password_hash($password, PASSWORD_DEFAULT);

$user = login( $email, $password);

if (!$user){
// 7 - авторизация вернула false
    redirect_to("page_login.php");

}
// 11 - авторизация вернула true
// 12 - перенаправление
redirect_to("page_students.php");

