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
    $students = $statement->fetch(PDO::FETCH_ASSOC);

    return $students;
    
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

    $user = get_user_by_email($email);

    if (!$user) {
        set_flash_message('danger', '<strong>Внимание!</strong> Такого пользователя не существует');
        return false;
    }
    
    // внизу код не правильный ввиду того, что $hash - это строка, $students - это массив. Они всегда будут не правильными.
    // if( $hash != $students) {
    //     set_flash_message('danger' ,'<strong>Внимание!</strong> Пароль не правильный');
    //     return false;
    //  }
    
     if(!password_verify($password, $has)) {
        set_flash_message('danger' ,'<strong>Внимание!</strong> Пароль не верный');
        return false;
     }
     

     $_SESSION['diving'] = $user;
    
     return true;
        
}

