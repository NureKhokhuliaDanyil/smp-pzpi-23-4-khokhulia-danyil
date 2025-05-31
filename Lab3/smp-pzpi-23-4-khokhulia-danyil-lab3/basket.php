<?php
session_start();
error_reporting(0);

$basket = isset($_SESSION['basket']) ? $_SESSION['basket'] : [];
?>

<!DOCTYPE html>
<html lang="uk">
<head>
  <meta charset="UTF-8">
  <title>Кошик — Продовольчий магазин "Весна"</title>
  <style>
    body {
      font-family: Arial, sans-serif;
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

    table {
      width: 100%;
      max-width: 800px;
      border-collapse: collapse;
    }

    th, td {
      padding: 10px;
      border-bottom: 1px solid #ccc;
      text-align: left;
    }

    th {
      background-color: #f0f0f0;
    }

    .center {
      text-align: center;
      margin-top: 40px;
    }

    .btn-remove {
      padding: 5px 10px;
      background-color: #c62828;
      color: white;
      border: none;
      cursor: pointer;
    }

    a {
      color: #007bff;
      text-decoration: none;
    }

    a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <?php include 'header.php' ?>

  <main>
    <?php if (empty($basket)): ?>
      <div class="center">
        <p>Кошик порожній. <a href="products.php">Перейти до покупок</a></p>
      </div>
    <?php else: ?>
      <form method="post" action="remove_item.php">
        <table>
          <thead>
            <tr>
              <th>ID</th>
              <th>Назва товару</th>
              <th>Ціна (грн)</th>
              <th>Кількість</th>
              <th>Сума</th>
              <th>Дія</th>
            </tr>
          </thead>
          <tbody>
            <?php 
              $id = 1;
              $total = 0;
              foreach ($basket as $item): 
                $total += $item['total'];
            ?>
              <tr>
                <td><?= $id++ ?></td>
                <td><?= htmlspecialchars($item['name']) ?></td>
                <td><?= $item['price'] ?></td>
                <td><?= $item['quantity'] ?></td>
                <td><?= $item['total'] ?></td>
                <td>
                  <button class="btn-remove" type="submit" name="remove" value="<?= htmlspecialchars($item['name']) ?>">
                    Вилучити
                  </button>
                </td>
              </tr>
            <?php endforeach; ?>
            <tr>
              <td colspan="4" style="text-align: right;"><strong>Загальна сума:</strong></td>
              <td colspan="2"><strong><?= $total ?> грн</strong></td>
            </tr>
          </tbody>
        </table>
      </form>
    <?php endif; ?>
  </main>

  <?php include 'footer.php' ?>
</body>
</html>
