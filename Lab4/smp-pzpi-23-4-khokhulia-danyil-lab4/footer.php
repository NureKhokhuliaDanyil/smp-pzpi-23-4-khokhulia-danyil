<footer class="footer">
  <style>
    .footer {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 20px;
      padding: 13px;
      border-top: 3px solid black;
      position: absolute;
      bottom: 0;
      left: 0;
      right: 0;
      background-color: #f9f9f9;
    }

    .footer a.footer-link {
      display: flex;
      align-items: center;
      gap: 10px;
      text-decoration: none;
      color: #333;
      font-weight: bold;
      font-size: 18px;
      transition: color 0.3s ease, text-decoration 0.3s ease;
    }

    .footer a.footer-link:hover {
      color: #007BFF;
      text-decoration: underline;
    }

    .footer span {
      color: #888;
    }
  </style>

  <a href="home.php" class="footer-link">Home</a>
  <span>|</span>
  <a href="products.php" class="footer-link">Products</a>
  <span>|</span>
  <a href="basket.php" class="footer-link">Basket</a>
  <span>|</span>
  <a href="about_us.php" class="footer-link">About Us</a>
</footer>
