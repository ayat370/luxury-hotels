<?php
session_start();
require_once 'config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {    $username = trim($_POST['username']);    $firstname = trim($_POST['firstname']);    $lastname = trim($_POST['lastname']);    $email = trim($_POST['email']);    $phone = trim($_POST['phone']);    $password = $_POST['password'];    $confirm_password = $_POST['confirm_password'];    $terms = isset($_POST['terms']);    // Validate username    if (strlen($username) < 3) {        $errors[] = "Le nom d'utilisateur doit contenir au moins 3 caractères";    }    if (!preg_match("/^[a-zA-Z0-9_]+$/", $username)) {        $errors[] = "Le nom d'utilisateur ne peut contenir que des lettres, des chiffres et des underscores";    }    // Check if username already exists    $check_username_sql = "SELECT username FROM users WHERE username = ?";    $check_username_stmt = $conn->prepare($check_username_sql);    $check_username_stmt->execute([$username]);        if ($check_username_stmt->fetch()) {        $errors[] = "Ce nom d'utilisateur est déjà utilisé";
    
    // Validation
    $errors = [];
    
    if (strlen($password) < 8) {
        $errors[] = "Le mot de passe doit contenir au moins 8 caractères";
    }
    
    if (!preg_match("/[A-Z]/", $password)) {
        $errors[] = "Le mot de passe doit contenir au moins une majuscule";
    }
    
    if (!preg_match("/[a-z]/", $password)) {
        $errors[] = "Le mot de passe doit contenir au moins une minuscule";
    }
    
    if (!preg_match("/[0-9]/", $password)) {
        $errors[] = "Le mot de passe doit contenir au moins un chiffre";
    }
    
    if ($password !== $confirm_password) {
        $errors[] = "Les mots de passe ne correspondent pas";
    }
    
    if (!$terms) {
        $errors[] = "Vous devez accepter les conditions d'utilisation";
    }
    
    // Check if email already exists
    $check_sql = "SELECT email FROM users WHERE email = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->execute([$email]);
    
    if ($check_stmt->fetch()) {
        $errors[] = "Cette adresse email est déjà utilisée";
    }
    
    if (empty($errors)) {
        try {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
                        $sql = "INSERT INTO users (username, firstname, lastname, email, phone, password, created_at)                     VALUES (?, ?, ?, ?, ?, ?, NOW())";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$username, $firstname, $lastname, $email, $phone, $hashed_password]);
            
            $_SESSION['success'] = "Votre compte a été créé avec succès";
            header("Location: login.php");
            exit();
            
        } catch(PDOException $e) {
            $_SESSION['error'] = "Une erreur est survenue lors de la création du compte";
            header("Location: register.php");
            exit();
        }
    } else {
        $_SESSION['error'] = implode("<br>", $errors);
        header("Location: register.php");
        exit();
    }
} else {
    header("Location: register.php");
    exit();
} 