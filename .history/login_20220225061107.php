<?php

session_start();

$email = $_SESSION["email"];
$password = $_SESSION["password"];

$pdo = new PDO("mysql:host=localhost;dbname=rahimain", "root", "");

$sql = "SELECT * FROM people";

$statement = $pdo->prepare($sql);
$