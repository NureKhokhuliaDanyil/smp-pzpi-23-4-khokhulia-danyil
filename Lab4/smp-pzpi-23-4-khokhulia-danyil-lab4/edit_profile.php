<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$profile = require 'profile.php';

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $surname = trim($_POST['surname'] ?? '');
    $date_of_birth = $_POST['date_of_birth'] ?? '';
    $description = trim($_POST['description'] ?? '');

    if (empty($name) || strlen($name) < 2) {
        $errors[] = 'Ім’я повинно бути не менше 2 символів.';
    }
    if (empty($surname) || strlen($surname) < 2) {
        $errors[] = 'Прізвище повинно бути не менше 2 символів.';
    }
    if (empty($date_of_birth)) {
        $errors[] = 'Дата народження обов’язкова.';
    } else {
        try {
            $birth_date = new DateTime($date_of_birth);
            $today = new DateTime();
            $age = $today->diff($birth_date)->y;
            if ($age < 16) {
                $errors[] = 'Вам повинно бути не менше 16 років.';
            }
        } catch (Exception $e) {
            $errors[] = 'Неправильний формат дати народження.';
        }
    }
    if (empty($description) || strlen($description) < 50) {
        $errors[] = 'Опис повинен містити не менше 50 символів.';
    }

    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/';
        $file_name = basename($_FILES['photo']['name']);
        $file_path = $upload_dir . $file_name;
        $allowed_types = ['image/jpeg', 'image/png'];
        $file_type = mime_content_type($_FILES['photo']['tmp_name']);

        if (!in_array($file_type, $allowed_types)) {
            $errors[] = 'Допускаються лише файли JPEG та PNG.';
        } elseif (!move_uploaded_file($_FILES['photo']['tmp_name'], $file_path)) {
            $errors[] = 'Помилка при завантаженні файлу.';
        }
    }

    if (empty($errors)) {
        $profile = [
            'name' => $name,
            'surname' => $surname,
            'date_of_birth' => $date_of_birth,
            'description' => $description,
            'photo' => isset($_FILES['photo']) ? $file_name : $profile['photo'],
        ];

        file_put_contents(
            'profile.php',
            '<?php return ' . var_export($profile, true) . '; ?>'
        );

        header('Location: edit_profile.php?success=true');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редагування профілю</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
    }

     .container {
        margin: 100px auto 50px auto; 
        background: #fff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        flex-grow: 1;
    }

    .form-header {
        display: flex;
        gap: 30px;
    }

    .form-photo {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .form-photo img {
        max-width: 200px;
        border: 1px solid #ccc;
        border-radius: 5px;
        margin-bottom: 10px;
    }

    .form-fields {
        flex: 2;
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }

    .form-field {
        flex: 1 1 45%;
        display: flex;
        flex-direction: column;
    }

    .form-field label {
        font-weight: bold;
        margin-bottom: 5px;
    }

    input[type="text"],
    input[type="date"],
    textarea,
    input[type="file"] {
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    textarea {
        height: 100px;
        resize: vertical;
        margin-top: 10px;
        width: 100%;
    }

    .form-description {
        margin-top: 30px;
    }

    .submit-button {
        display: flex;
        justify-content: flex-end;
        margin-top: 20px;
    }

    button {
        padding: 10px 25px;
        background-color: #007BFF;
        color: white;
        border: none;
        border-radius: 6px;
        font-weight: bold;
        cursor: pointer;
        transition: 0.3s;
    }

    button:hover {
        background-color: #0056b3;
    }

    .error-message {
        color: red;
        margin-top: 10px;
    }

    .success-message {
        color: green;
        margin-bottom: 10px;
    }
</style>

</head>
<body>
<?php
include 'header.php';
?>
   <div class="container">
    <h2>Редагування профілю</h2>

    <?php if (isset($_GET['success'])) echo '<p class="success-message">Профіль оновлений успішно!</p>'; ?>
    <?php if (!empty($errors)) echo '<p class="error-message">' . implode('<br>', $errors) . '</p>'; ?>

    <form action="edit_profile.php" method="POST" enctype="multipart/form-data">
        <div class="form-header">

            <div class="form-photo">
                <?php if (!empty($profile['photo'])): ?>
                    <img src="uploads/<?php echo htmlspecialchars($profile['photo']); ?>" alt="User Photo">
                <?php else: ?>
                    <div style="width:200px;height:200px;border:1px solid #ccc;border-radius:5px;display:flex;align-items:center;justify-content:center;color:#aaa;">No Image</div>
                <?php endif; ?>
                <input type="file" name="photo">
            </div>

            <div class="form-fields">
                <div class="form-field">
                    <label for="name">Ім’я:</label>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($profile['name']); ?>" required>
                </div>
                <div class="form-field">
                    <label for="surname">Прізвище:</label>
                    <input type="text" id="surname" name="surname" value="<?php echo htmlspecialchars($profile['surname']); ?>" required>
                </div>
                <div class="form-field">
                    <label for="date_of_birth">Дата народження:</label>
                    <input type="date" id="date_of_birth" name="date_of_birth" value="<?php echo htmlspecialchars($profile['date_of_birth']); ?>" required>
                </div>
            </div>
        </div>

        <div class="form-description">
            <label for="description"><strong>Короткий опис:</strong></label>
            <textarea id="description" name="description" required><?php echo htmlspecialchars($profile['description']); ?></textarea>
        </div>

        <div class="submit-button">
            <button type="submit">Зберегти</button>
        </div>
    </form>
</div>

    <?php
include 'footer.php';
?>

</body>
</html>