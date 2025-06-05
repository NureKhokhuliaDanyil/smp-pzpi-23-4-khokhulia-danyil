<?php
session_start();
include 'header.php';
?>

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }

    .login-container {
        text-align: center;
        padding: 20px;
        background-color: white;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        width: 300px;
    }

    h1 {
        color: #333;
    }

    form {
        margin-top: 20px;
    }

    input[type="text"], input[type="password"] {
        width: 100%;
        padding: 10px;
        margin: 5px 0;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    button {
        padding: 10px 20px;
        background-color: #007BFF;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    button:hover {
        background-color: #0056b3;
    }

    .error-message {
        color: red;
        margin-top: 10px;
    }
</style>

<div class="login-container">
    <h1>Авторизація</h1>
    <?php
    if (isset($_GET['error'])) {
        echo '<p class="error-message">Помилка: ' . htmlspecialchars($_GET['error']) . '</p>';
    }
    ?>
    <form action="process_login.php" method="POST">
        <label for="username">Ім'я користувача:</label><br>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">Пароль:</label><br>
        <input type="password" id="password" name="password" required><br><br>

        <button type="submit">Увійти</button>
    </form>
</div>

<?php include 'footer.php'; ?>