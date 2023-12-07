<?php
session_start();  // Start a new or resume an existing session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // get username and password from HTTP parameters
    $username = $_POST['username'];
    $password = $_POST['password'];

    // check if username and password are correct
    function loginSuccess($username, $password) {
        global $db;
        $stmt = $db->prepare('SELECT * FROM Person WHERE username = ? AND password = ?'); #isto ou vem como 1 (max) ou 0 (vazio) se nao existir na base de dados
        $stmt->execute(array($username, hash('sha256', $password))); 
        return $stmt->fetch(); # se select vier vazio o fetch vai dar booleano falso
    }


    try {
        $db = new PDO('sqlite:../database/database.db');
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        if (loginSuccess($username, $password)) {
          $_SESSION['username'] = $username;
          $_SESSION['user_id'] = loginSuccess($username, $password)['id'];
          header('Location: ../'); 
          exit();
        } else {
          $_SESSION['msg'] = 'Invalid username or password!';
          header('Location: ../pages/login.php'); 
          exit();
        }

        
    
    } catch (PDOException $e) {
        $_SESSION['msg'] = 'Error: ' . $e->getMessage();
    }
    
    
}
?>
