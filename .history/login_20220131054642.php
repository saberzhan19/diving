<?php 

session_start();
require "functions.php";

$email = $_POST["email"];
$password = $_POST["password"];

$students = login( $email, $password);

if (!$students){

    redirect_to("page_re.php");

}
    

add_user($email, $password);

redirect_to("page_students.php");