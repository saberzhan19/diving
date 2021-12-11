<?php

function get_user_by_email( $email ) {

    $email = $_SESSION["email"];
    $password = $_SESSION["password"];

    $pdo = new PDO("mysql:host=localhost;dbname=rahimain", "root", "");

    $sql = "SELECT * FROM diving WHERE email = :email";
    
    $statement = $pdo->prepare($sql);
    $statement->execute([
                "email" => $email,
            ]);
    $diving = $statement->fetch(PDO::FETCH_ASSOC);

    return $diving;
    
};

function add_user($email, $password) {
    
    $pdo = new PDO("mysql:host=localhost;dbname=rahimain", "root", "");

    $sql = "INSERT INTO diving (email, password) VALUES (:email, :password)";
    // подготавлеваем запрос
    $statement = $pdo->prepare($sql);
    // выполнениям запрос
    $statement->execute([
         "email" => $email,    
         "password" => password_hash($password, PASSWORD_DEFAULT)
    ]);

};

function set_flash_message($name, $message) {

   echo $_SESSION[$name] = $message;   
    // unset($_SESSION[$name]);
};

function display_flash_message($name) {
   
    if(isset($_SESSION["$name"]))
        echo "<div class='alert alert-{$name} text-dark' role='alert\">{$_SESSION[$name]}<div>" ;
        unset($_SESSION["$name"]);

};

function redirect_to($path) {
    header("Location: {$path}");
    exit;
};
