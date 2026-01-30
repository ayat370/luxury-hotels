<?php
session_start();
require_once 'config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $remember = isset($_POST['remember']);
    
    try {
        $sql = "SELECT user_id, firstname, lastname, email, password, is_admin FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$email]);
        
        if ($user = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $user['firstname'] . ' ' . $user['lastname'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['is_admin'] = $user['is_admin'];
                
                if ($remember) {
                    // Set remember me cookie - 30 days
                    setcookie('remember_token', 
                             base64_encode($user['user_id'] . ':' . $user['email']), 
                             time() + (86400 * 30), 
                             '/');
                }
                
                if ($user['is_admin']) {
                    header("Location: admin/dashboard.php");
                } else {
                    header("Location: index.php");
                }
                exit();
            }
        }
        
        $_SESSION['error'] = "Email ou mot de passe incorrect";
        header("Location: login.php");
        exit();
        
    } catch(PDOException $e) {
        $_SESSION['error'] = "Une erreur est survenue lors de la connexion";
        header("Location: login.php");
        exit();
    }
} else {
    header("Location: login.php");
    exit();
} 