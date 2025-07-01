<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// حذف عنصر
if (isset($_GET['remove'])) {
  unset($_SESSION['cart'][$_GET['remove']]);
  $_SESSION['cart'] = array_values($_SESSION['cart']);
}

// تفريغ السلة
if (isset($_GET['clear'])) {
  unset($_SESSION['cart']);
}

// تابع المجموع
$total = 0;
?>
<!DOCTYPE html>
<html lang="ar">
<head>
  <meta charset="UTF-8">
  <title>🛒 سلة المشتريات</title>
  <style>
    body {
      font-family: 'Tahoma', sans-serif;
      direction: rtl;
      background: #faf6f3;
      padding: 40px;
      color: #3a2a2a;
    }

    h1 {
      text-align: center;
      color: #513c39;
      margin-bottom: 30px;
    }

    .cart-item {
      display: flex;
      align-items: center;
      background: #fff;
      margin-bottom: 20px;
      padding: 15px;
      border-radius: 10px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    }

    .cart-item img {
      width: 80px;
      height: 80px;
      object-fit: cover;
      border-radius: 8px;
      margin-left: 15px;
      border: 1px solid #eee;
    }

    .details {
      flex: 1;
    }

    .details h3 {
      margin: 0 0 8px;
    }

    .details p {
      margin: 4px 0;
      font-size: 14px;
    }

    .remove {
      background: #d98880;
      color: #fff;
      padding: 6px 10px;
      border-radius: 6px;
      text-decoration: none;
      font-size: 13px;
    }

    .remove:hover {
      background: #c0392b;
    }

    .summary {
      text-align: center;
      margin-top: 30px;
      background: #fff9f5;
      border: 1px dashed #d9c6b6;
      border-radius: 10px;
      padding: 20px;
    }

    .summary h3 {
      margin-bottom: 10px;
      font-size: 20px;
    }

    .buttons {
      margin-top: 15px;
      display: flex;
      justify-content: center;
      gap: 15px;
      flex-wrap: wrap;
    }

    .btn {
      background: #a67c73;
      color: white;
      padding: 10px 16px;
      text-decoration: none;
      border-radius: 8px;
      font-size: 14px;
    }

    .btn:hover {
      background: #8c665d;
    }
  </style>
</head>
<body>

<h1>🛍️ سلة مشترياتك</h1>

<?php if (!empty($_SESSION['cart'])): ?>
  <?php foreach ($_SESSION['cart'] as $index => $item): 
    $name  = htmlspecialchars($item['name']);
    $price = $item['price'];
    $qty   = $item['quantity'] ?? 1;
    $image = htmlspecialchars($item['image'] ?? 'no-image.jpg');
    $total += $price * $qty;
  ?>
    <div class="cart-item">
      <img src="images/<?= $image ?>" alt="<?= $name ?>">
      <div class="details">
        <h3><?= $name ?></h3>
        <p>السعر: $<?= $price ?> × <?= $qty ?> = $<?= $price * $qty ?></p>
      </div>
      <a href="?remove=<?= $index ?>" class="remove">🗑️ حذف</a>
    </div>
  <?php endforeach; ?>

  <div class="summary">
    <h3>💰 المجموع الكلي: $<?= $total ?></h3>
    <div class="buttons">
      <a href="index.php" class="btn">← مواصلة التسوق</a>
      <a href="?clear=1" class="btn">🧹 تفريغ السلة</a>
      <a href="checkout.php" class="btn">💳 المتابعة للدفع</a>
    </div>
  </div>

<?php else: ?>
  <p style="text-align:center; font-size: 16px;">🧺 سلتك حالياً فاضية يا أميرة. <a href="index.php" style="color:#a67c73;">ابدئي تسوقك الآن</a></p>
<?php endif; ?>

</body>
</html>