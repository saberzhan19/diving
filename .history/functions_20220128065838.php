<?php



function get_user_by_email( $email ) {

    $email = $_POST["email"];
    $password = $_POST["password"];

    $pdo = new PDO("mysql:host=localhost;dbname=rahimain", "root", "");

    $sql = "SELECT * FROM diving WHERE email = :email";
    
    $statement = $pdo->prepare($sql);
    $statement->execute([
                "email" => $email,
            ]);
    $diving = $statement->fetch(PDO::FETCH_ASSOC);

    return $diving;
    
};

function set_flash_message($name, $message) {
    
    $_SESSION[$name] = $message;   

};

function redirect_to($path) {
    header("Location: {$path}");
    exit;
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

    return $pdo->lastInsertId();

};


function display_flash_message($name) {
   
    if(isset($_SESSION["$name"])){

        echo "<div class=\"alert alert-{$name} text-dark\" role=\"alert\">{$_SESSION[$name]}</div>" ;
        unset($_SESSION["$name"]);
    }

};


function login ($email, $password){
    $st = get_user_by_email($email);
    if (empty($students)) {
        set_flash_message('danger', 'такого пользователя не существует');
        return false;
    }
    elseif(!check_password($students, $password)) {
       set_flash_message('danger' ,'пароль не верный');
       return false;
    } else {
        $_SESSION['email'] = $students['email'];
        $_SESSION['id'] = $students['id'];
        return true;
    }
}

function check_password($students, $password){

    if ($students['password'] == $password){
        return true;
    }
    return false;
}