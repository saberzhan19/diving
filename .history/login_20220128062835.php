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
elseif(!cheak_password($user, $password)) {
    set_flash_message('danger' ,'пароль не верный');
    return false;
 } else {
     $_SESSION['email'] = $user['email'];
     $_SESSION['admin'] = $user['admin'];
     return true;
 }

add_user($email, $password);

redirect_to("page_students.php");