<?php

session_start();
include 'functions.php';

$email = $_SESSION['email'];
$password = $_SESSION['password'];

if (is_not_logged_in()){
    redirect_to("login.php");
}

if(!user()){
    echo $_SESSION('admin');
}

$pdo = new PDO("mysql:host=localhost;dbname=rahimain", "root", "");

$sql = "SELECT* FROM people";

$statement = $pdo->prepare($sql);
$statement->execute();
$users = $statement->fetch(PDO::FETCH_ASSOC);


