<?php 

session_start();
require "functions.php";

$email = $_POST["email"];
$password = $_POST["password"];

$students = login( $email, $password);

if (!$students){
    set_flash_message('danger', 'Не существует такого пользователя');
    redirect_to("page_login.php");
}
    

add_user($email, $password);

redirect_to("page_students.php");