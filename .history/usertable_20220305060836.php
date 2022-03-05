<?php

session_start();
include 'functions.php';

$email = $_SESSION['email'];
$password = $_SESSION['password'];

$login = is_not_logged_in($email);

if (!$login) {
    redirect_to("page_login.php");
}