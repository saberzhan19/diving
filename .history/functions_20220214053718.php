<?php


function get_user_by_email( $email ) {

    $email = $_SESSION["email"];
    $password = $_SESSION["password"];

    $pdo = new PDO("mysql:host=localhost;dbname=rahimain", "root", "");

    $sql = "SELECT * FROM dive WHERE email = :email AND password = :password";
    
    $statement = $pdo->prepare($sql);
    $statement->execute([
                "email" => $email,
                "password" => password_hash($password, PASSWORD_DEFAULT)
            ]);
    $users = $statement->fetch(PDO::FETCH_ASSOC);

    return $dive;
    
};

function add_user($email, $password) {
    
    $pdo = new PDO("mysql:host=localhost;dbname=rahimain", "root", "");

    $sql = "INSERT INTO dive (email, password) VALUES (:email, :password)";
    // подготавлеваем запрос
    $statement = $pdo->prepare($sql);
    // выполнениям запрос
    $statement->execute([
    "email" => $email,    
    "password" => password_hash($password, PASSWORD_DEFAULT)
    ]);

};

function set_flash_message($name, $message) {
    
    $_SESSION[$name] = $message;   
    
};

function display_flash_message($name) {
    if(isset($_SESSION["$name"]))
    echo "<div class=\"alert alert-{$name} text-dark\" role=\"alert\">{$_SESSION[$name]}<div>" ;
    unset($_SESSION["$name"]);
};

function redirect_to($path) {
    header("Location: {$path}");
    exit;
};

function is_not_logged_in() {
    if(is_not_logged_in()){
        redirect_to('page_login');
    }

    $users = get_users();
}

function is