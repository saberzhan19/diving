<?php

session_start();
require "functions.php";

$email = $_POST["email"];
$password = $_POST["password"];
$hash = password_hash($password, PASSWORD_DEFAULT);

$user = get_user_by_email($email);

// если эл. адрес занят, то перенаправляем назад

if(!empty($user)){
    set_flash_message("danger", "<strong>Уведомление!</strong> Этот эл. адрес уже занят другим пользователем.");
    // 5 - возваращем false
    redirect_to("page_register.php");exit();
}

// 09 - Авторизация пользователя
add_user($email, $password);

// 4 - форма. Формируем флеш сообщение
set_flash_message("success", "Регистрация успешна");

redirect_to("page_login.php");
