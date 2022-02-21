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

// по схеме авторизация, 2 - вызов функции авторизации

function display_flash_message($name) {
   
    if(isset($_SESSION["$name"])){

        echo "<div class=\"alert alert-{$name} text-dark\" role=\"alert\">{$_SESSION[$name]}</div>" ;
        unset($_SESSION["$name"]);
    }

};


function login ($email, $password){

    $user = get_user_by_email($email);

    //  3 - форма   Если:
    // 1. Нет такого Пользователя? 
    // 2. Хэш пароля не совпадает?

    if (!$user) {
        set_flash_message('danger', '<strong>Внимание!</strong> Такого пользователя не существует');
        return false;
    }
    
    // внизу код не правильный ввиду того, что $hash - это строка, $students - это массив. Они всегда будут не правильными.
    // if( $hash != $students) {
    //     set_flash_message('danger' ,'<strong>Внимание!</strong> Пароль не правильный');
    //     return false;
    //  }
    

    // $password из формы отсюда
    // $user['password'] из базы данных 
     if(!password_verify($password, $user['password'])) {
        set_flash_message('danger' ,'<strong>Внимание!</strong> Пароль не верный');
        return false;
     }
     
     //  10 - возваращем true
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

    function create(string $table_name, array $params)
    {
        $fields = '';
        $params2 = $params;
        $keys = array_keys($params2);
        $count = count($keys);
        for ($i = 0; $i < $count; ++$i) {
            $fields .=  ':' . $keys[$i];
            if ($count - 1 != $i) {
                $fields .=  ',';
            }
        }
        $comma_separated = implode(",", $keys);
        $sql = "INSERT INTO $table_name ($comma_separated) VALUES ($fields) ";
        return query($sql, $params);
    }

function get_users()
{
    $pdo = new PDO("mysql:host=localhost;dbname=rahimain", "root", "");
    $sql = "SELECT * FROM diving";

    if($_SESSION['user']['role'] == 1){
        return $pdo->query($sql);
    }else {
        $sql .= ' WHERE id= :id';
        $params = ['id' => $_SESSION['user']['id']];
        return query($sql, $params);
    }
}
function query(string $sql, array $params)
{
    $pdo = dbh();
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

