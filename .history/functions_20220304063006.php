<?php



function get_user_by_email( $email ) {

    $email = $_POST["email"];
    $password = $_POST["password"];

    $pdo = new PDO("mysql:host=localhost;dbname=rahimain", "root", "");

    $sql = "SELECT * FROM diving WHERE email = :email";
    
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
        

     if(!password_verify($password, $user['password'])) {
        set_flash_message('danger' ,'<strong>Внимание!</strong> Пароль не верный');
        return false;
     }
     
     $_SESSION['diving'] = $user;
     return true;
        
}

function is_not_logged_in() {
    if(isset($_SESSION['diving'])){
        return true;
    }
    return false;
}

function create_user(array $params)
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
    $sql = "SELECT * FROM diving";

    if($_SESSION['diving']['role'] == 1){
        return $pdo->query($sql);
    }else {
        $sql .= ' WHERE id= :id';
        $params = ['id' => $_SESSION['diving']['id']];
        return query($sql, $params);
    }
}
function query(string $sql, array $params)
{
    $pdo = new PDO("mysql:host=localhost;dbname=rahimain", "root", "");
    $stmt = $pdo->prepare($sql);
    if (!empty($params)) {
        foreach ($params as $key => $val) {
            if (is_int($val)) {
                $type = PDO::PARAM_INT;
            } else {
                $type = PDO::PARAM_STR;
            }
            $stmt->bindValue(':' . $key, $val, $type);
        }
    }
    $stmt->execute();
    return $stmt;
}
