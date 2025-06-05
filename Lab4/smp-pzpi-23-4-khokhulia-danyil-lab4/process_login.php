<?php
session_start();

$credentials = require 'credential.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        header('Location: login.php?error=Всі поля є обов’язковими');
        exit;
    }

    if ($username === $credentials['userName'] && $password === $credentials['password']) {
        $_SESSION['user'] = $username;
        $_SESSION['login_time'] = date('Y-m-d H:i:s');

        header('Location: products.php');
        exit;
    } else {
        header('Location: login.php?error=Неправильне ім’я користувача або пароль');
        exit;
    }
} else {
    header('Location: login.php');
    exit;
}
?>