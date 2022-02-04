<?php 

session_start();
require "functions.php";

$email = $_POST["email"];
$password = $_POST["password"];
$hash = password_hash($password, PASSWORD_DEFAULT);


$students = get_user_by_email( $email, $password);

if (!$students){

    redirect_to("page_login.php");

}
if( $password != $students['password']) {
    set_flash_message('danger' ,'<strong>Внимание!</strong> Пароль не верный');
    return false;
 }
 
 $_SESSION['diving'] = $students;

 
    

redirect_to("page_students.php");