<?php 

session_start();
require "functions.php";

$email = $_POST["email"];
$password = $_POST["password"];
$hash = password_hash($password, PASSWORD_DEFAULT);

$user = login( $email, $password);

if (!$user){

    redirect_to("page_login.php");

}
// 12 - перена
redirect_to("page_students.php");