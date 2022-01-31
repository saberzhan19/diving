<?php 

session_start();
require "functions.php";

$email = $_POST["email"];
$password = $_POST["password"];

$students = get_user_by_email( $email );

if (!$students){
    set_flash_message('danger', 'Не существует такого пользователя');
    redirect_to("page_login.php");
}

if (!password_verify($hash, $email)) {
    set_flash_message('danger', 'У вас 3 попытки');
    redirect_to('page_login.php');
}

add_user($email, $password);

redirect_to("page_students.php");