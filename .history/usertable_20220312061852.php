<?php

session_start();
include 'functions.php';

$email = $_SESSION['email'];
$password = $_SESSION['password'];

if (is_not_logged_in()){
    redirect_to("login.php");
}

if(admin()){
    re
}