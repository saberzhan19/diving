<?php 

session_start();
require "functions.php";

$email = $_POST["email"];
$password = $_POST["password"];
$hash = password_hash($password, PASSWORD_DEFAULT);

$user = login( $email, $password);

if (!$user){
// 7
    redirect_to("page_login.php");

}
// 12 - перенаправление
redirect_to("page_students.php");