<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$products = [
    'Молоко пастеризоване' => 12,
    'Хліб чорний' => 9,
    'Сир білий' => 21,
    'Сметана 20%' => 25,
    'Кефір 1%' => 19,
    'Вода газована' => 18,
    'Печиво "Весна"' => 14
];

function normalizeKey($name) {
    return md5($name);
}

function validateFormData($products, $postData) {
    $errors = false;
    $validatedData = [];

    foreach ($products as $product => $price) {
        $key = normalizeKey($product);
        $value = isset($postData[$key]) ? trim($postData[$key]) : '0';

        if (!preg_match('/^\d+$/', $value)) {
            $errors = true;
            $validatedData[$key] = 0;
        } else {
            $validatedData[$key] = (int)$value;
        }
    }

    return ['errors' => $errors, 'data' => $validatedData];
}

$errorMessage = '';
$inputValues = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $validation = validateFormData($products, $_POST);
    $error = $validation['errors'];
    $inputValues = $validation['data'];

    if (!$error) {
        $currentBasket = isset($_SESSION['basket']) ? $_SESSION['basket'] : [];

        $existingItems = [];
        foreach ($currentBasket as $item) {
            $existingItems[$item['name']] = $item;
        }

        $newBasket = [];

        foreach ($products as $product => $price) {
            $key = normalizeKey($product);
            $quantity = $inputValues[$key];

            if ($quantity > 0) {
                if (isset($existingItems[$product])) {
                    $existingItem = $existingItems[$product];
                    $existingItem['quantity'] += $quantity;
                    $existingItem['total'] = $existingItem['price'] * $existingItem['quantity'];
                    $newBasket[] = $existingItem;
                } else {
                    $newBasket[] = [
                        'id' => $key,
                        'name' => $product,
                        'price' => $price,
                        'quantity' => $quantity,
                        'total' => $price * $quantity
                    ];
                }
            }
        }

        foreach ($currentBasket as $item) {
            $found = false;
            foreach ($newBasket as $newItem) {
                if ($newItem['name'] === $item['name']) {
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                $newBasket[] = $item;
            }
        }

        if (!empty($newBasket)) {
            $_SESSION['basket'] = $newBasket;
            header('Location: basket.php');
            exit;
        }
    } else {
        $errorMessage = 'Перевірте будь ласка введені дані.';
    }
} else {
    foreach ($products as $product => $price) {
        $inputValues[normalizeKey($product)] = 0;
    }
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
  <meta charset="UTF-8">
  <title>Товари — Продовольчий магазин "Весна"</title>
  <style>
    body {
      margin: 0;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }
    main {
      flex: 1;
      padding: 40px;
      display: flex;
      justify-content: center;
    }
    form {
      width: 100%;
      max-width: 700px;
    }
    h2 {
      text-align: center;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
    }
    th, td {
      padding: 10px;
      border-bottom: 1px solid #ccc;
    }
    th {
      text-align: left;
    }
    th.price, td.price,
    th.quantity, td.quantity {
      text-align: right;
      width: 20%;
    }
    th.product, td.product {
      width: 60%;
    }
    input[type="number"] {
      width: 60px;
      text-align: right;
    }
    .button-wrapper {
      text-align: center;
      margin-top: 20px;
    }
    button {
      padding: 10px 20px;
      font-size: 16px;
      cursor: pointer;
    }
    .error-message {
      color: red;
      font-weight: bold;
      text-align: center;
      margin-bottom: 15px;
    }
  </style>
</head>
<body>
  <?php include 'header.php'; ?>

  <main>
    <form method="POST" action="products.php">
      <h2>Оберіть товари</h2>

      <?php if ($errorMessage): ?>
        <div class="error-message"><?= htmlspecialchars($errorMessage) ?></div>
      <?php endif; ?>

      <table>
        <thead>
          <tr>
            <th class="product">Товар</th>
            <th class="price">Ціна (грн)</th>
            <th class="quantity">Кількість</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($products as $product => $price):
              $key = normalizeKey($product);
              $value = isset($inputValues[$key]) ? $inputValues[$key] : 0;
          ?>
            <tr>
              <td class="product"><?= htmlspecialchars($product) ?></td>
              <td class="price"><?= $price ?></td>
              <td class="quantity">
                <input type="number" name="<?= $key ?>" min="0" value="<?= htmlspecialchars($value) ?>">
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

      <div class="button-wrapper">
        <button type="submit">Додати в кошик</button>
      </div>
    </form>
  </main>

  <?php include 'footer.php'; ?>
</body>
</html>