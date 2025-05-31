<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove'])) {
    $itemToRemove = $_POST['remove'];
    foreach ($_SESSION['basket'] as $index => $item) {
        if ($item['name'] === $itemToRemove) {
            unset($_SESSION['basket'][$index]);
            $_SESSION['basket'] = array_values($_SESSION['basket']);
            break;
        }
    }
}

header('Location: basket.php');
exit;