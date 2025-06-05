<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Обмежений доступ</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
        }

        .container {
            background-color: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }
        a {
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: #333;
            font-weight: bold;
            font-size: 18px;
            transition: color 0.3s ease;
        }
        h1 {
            margin-bottom: 20px;
        }
        a:hover {
         color: #007BFF;
        }

    </style>
</head>
<body>
    <div class="container">
        <h2>Для перегляду цього контенту вам потрібно пройти авторизацію.</h2>
        <a href="login.php">Перейти на сторінку Login</a>
    </div>
</body>
</html>