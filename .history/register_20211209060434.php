<?php

session_start();
require "functions.php";


$email = $_SESSION["email"];
$password = $_SESSION["password"];

$div = get_user_by_email($email);

// если эл. адрес занят, то перенаправляем назад

if(!empty($div)){
    set_flash_message("danger", "Этот эл. адрес уже занят другим пользователем.");
    redirect_to("page_register.php");
}

add_user($email, $password);

set_flash_message("success", "Регистрация успешна");

redirect_to("/page_login.php");
