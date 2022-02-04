<?php

session_start();
require "functions.php";

$email = $_POST["email"];
$password = $_POST["password"];
$hash = password_hash($password, PASSWORD_DEFAULT);

$students = get_user_by_email($email);

// если эл. адрес занят, то перенаправляем назад

if(!empty($students)){
    set_flash_message("danger", "<strong>Уведомление!</strong> Этот эл. адрес уже занят другим пользователем.");
    redirect_to("page_register.php");exit();
}

add_user($email, $hash);

set_flash_message("success", "Регистрация успешна");

redirect_to("page_login.php");
