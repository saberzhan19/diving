<?php

function get_user_by_email( $email ) {

    $email = $_POST["email"];
    $password = $_POST["password"];

    $pdo = new PDO("mysql:host=localhost;dbname=rahimain", "root", "");

    $sql = "SELECT * FROM people WHERE email = :email";
    
    $statement = $pdo->prepare($sql);
    $statement->execute([
                "email" => $email
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

    $sql = "INSERT INTO people (email, password) VALUES (:email, :password)";
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
        

    //  if(!password_verify($password, $user['password'])) {
    //     set_flash_message('danger' ,'<strong>Внимание!</strong> Пароль не верный');
    //     return false;
    //  }
     
     $_SESSION['people'] = $user;
     return true;
        
}

function is_not_logged_in() {
    if(isset($_SESSION['people'])){
        return true;
    }
    return false;
}

function create_user($params)
    {
        if(!empty($params['password']))
            $params['password'] = password_hash($params['password'], PASSWORD_DEFAULT);
            
        if (create('users', $params)) {
            return true;
        }
        return false;
    }

    
function get_users()
{
    $pdo = new PDO("mysql:host=localhost;dbname=rahimain", "root", "");
    $sql = "SELECT * FROM people";

    if($_SESSION['people']['role'] == 1){
        return $pdo->query($sql);
    }else {
        $sql .= ' WHERE id= :id';
        $params = ['id' => $_SESSION['people']['id']];
        return query($sql, $params);
    }
}

