<?php 

session_start();
require "functions.php";

$email = $_POST["email"];
$password = $_POST["password"];
$hash = password_hash($password, PASSWORD_DEFAULT);


$students = login( $email, $password);

if (!$students){

    redirect_to("page_login.php");

}
    

redirect_to("page_students.php");