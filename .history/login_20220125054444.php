<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>Вы успешна вошли ваш аккаунт</h2>
    <a class="btn btn-success mt-3" href="page_login.php">Выйти</a>

</body>
</html>

<?php 

session_start();
require "functions.php";

$email = $_POST["email"];
$password = $_POST["password"];

$students = get_user_by_email( $email );

if (!$students){}