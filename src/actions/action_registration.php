<?php
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/person.class.php');
session_start();      

# check if username already exists
function checkUsername($username) {
    global $db;
    $stmt = $db->prepare('SELECT * FROM Person WHERE username = ?'); #isto ou vem como 1 (max) ou 0 (vazio) se nao existir na base de dados
    $stmt->execute(array($username)); 
    return $stmt->fetch(); # se select vier vazio o fetch vai dar booleano falso
}

# turn inputs into variables
if ($_SERVER["REQUEST_METHOD"] == "POST") {     # block will only be executed when the form is submitted using the POST method -> for security
    
    $first_name = $_POST['first_name'];
    $surname = $_POST['surname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $birth_date = $_POST['birth_date'];
    $gender = $_POST['gender'];
    $occupation = $_POST['occupation'];

    $db=Database::getDatabase(); 

    # check if inserted info is correct
    if (strlen($first_name) == 0) { # temos que fazer checks. por ex, username não deve ser vazio
        $_SESSION['msg'] = 'Invalid name!'; 
        header('Location: ../pages/registration.php'); # !!! como o utilizador é reencamionhado para outra pag, so consigo mandar a msg de erro ao utilizador atraves da session ($S_SESSION).
        die(); # para logo aqui a msg de erro tb podia ser dentro dos parentesis, mas nao se faz assim
    }

    if (strlen($surname) == 0) { # temos que fazer checks. por ex, username não deve ser vazio
        $_SESSION['msg'] = 'Invalid name!'; 
        header('Location: ../pages/registration.php'); # !!! como o utilizador é reencamionhado para outra pag, so consigo mandar a msg de erro ao utilizador atraves da session ($S_SESSION).
        die(); # para logo aqui. a msg de erro tb podia ser dentro dos parentesis, mas nao se faz assim
    }

    if (checkUsername($username)) {
        $_SESSION['msg'] = 'Username already exists!'; 
        header('Location: ../pages/registration.php'); # !!! como o utilizador é reencamionhado para outra pag, so consigo mandar a msg de erro ao utilizador atraves da session ($S_SESSION).
        die(); # para logo aqui. a msg de erro tb podia ser dentro dos parentesis, mas nao se faz assim
    }

    if (strlen($username) == 0) { # temos que fazer checks. por ex, username não deve ser vazio
        $_SESSION['msg'] = 'Invalid username!'; 
        header('Location: ../pages/registration.php'); # !!! como o utilizador é reencamionhado para outra pag, so consigo mandar a msg de erro ao utilizador atraves da session ($S_SESSION).
        die(); # para logo aqui. a msg de erro tb podia ser dentro dos parentesis, mas nao se faz assim
    }

    if (strlen($password) < 8) {
        $_SESSION['msg'] = 'Password must have at least 8 characters.';
        header('Location: ../pages/registration.php');
        die();
    }

    if ($password !== $confirm_password) {
        $_SESSION['msg'] = "Passwords don't match!";
        header('Location: ../pages/registration.php');
        die();
    }
    
    
    $check_birth_date_time = strtotime($birth_date);
    $current_time = time();

    if ($check_birth_date_time > $current_time) {
        $_SESSION['msg'] = 'Invalid date!';
        header('Location: ../pages/registration.php');
        die();
    }


    $person=Person::addPerson($username, $first_name, $surname, $email, $password, $birth_date, $gender, $occupation);
    $_SESSION['user_id'] = $person->id;
    $_SESSION['occupation'] = $occupation;

    if ($occupation === 'chef' || $occupation === 'nutritionist') {
        // Redirect to the formation submission page
        $_SESSION['reg_page'] = "formation";

    } elseif ($occupation === 'common_user') {
        // Use session variable to store the occupation to register
        $_SESSION['reg_page'] = "common_user";
    }
    header("Location: ../pages/registration.php");
        exit();

}
?>