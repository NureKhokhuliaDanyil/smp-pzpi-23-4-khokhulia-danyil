<?php
session_start();

include 'header.php';

$page = isset($_GET['page']) ? $_GET['page'] : '';
$isAuthenticated = isset($_SESSION['user']);

switch ($page) {
    case "home":
        if ($isAuthenticated) {
            include 'home.php';
        } else {
            include 'page404.php';
        }
        break;
    case "products":
        if ($isAuthenticated) {
            include 'products.php';
        } else {
            include 'page404.php';
        }
        break;
    case "about_us":
        if ($isAuthenticated) {
            include 'about_us.php';
        } else {
            include 'page404.php';
        }
        break;
    case "basket":
        if ($isAuthenticated) {
            include 'basket.php';
        } else {
            include 'page404.php';
        }
        break;
    case "login":
        include 'login.php';
        break;
    default:
        include 'page404.php';
        break;
}

include 'footer.php';
?>