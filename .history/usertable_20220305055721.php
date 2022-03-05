<?php

session_start();
include 'functions.php';

$email = $_SESSION['email'];
$pa

$login = is_not_logged_in($email);