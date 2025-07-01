<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
  die("⚠️ الرجاء تسجيل الدخول لعرض الطلبات.");
}

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY id DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="ar">
<head>
  <meta charset="UTF-8">
  <title>طلباتي</title>
  <style>
    body {
      background: #f5f0e6;
      color: #5a3e2b;
      font-family: 'Segoe UI', sans-serif;
      padding: 20px;
    }
    .order-box {
      background: #fff8f0;
      border: 1px solid #d2b48c;
      border-radius: 10px;
      padding: 20px;
      margin-bottom: 30px;
    }
    .order-box h3 {
      margin-top: 0;
      border-bottom: 1px solid #d2b48c;
      padding-bottom: 10px;
      color: #4b2e19;
    }
    .order-products {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      margin-top: 15px;
    }
    .order-item {
      background: #fdf7f2;
      border: 1px solid #e0c9a6;
      border-radius: 8px;
      padding: 10px;
      width: 230px;
      box-shadow: 0 2px 5px rgba(90, 62, 43, 0.1);
    }
    .order-item img {
      width: 100%;
      height: 150px;
      object-fit: cover;
      border-radius: 5px;
      margin-bottom: 10px;
    }
    .order-item h4 {
      margin: 0 0 5px;
      font-size: 16px;
      color: #4b2e19;
    }
    .order-item p {
      margin: 3px 0;
      font-size: 14px;
      color: #7b5b3c;
    }
    .meta-info p {
      margin: 5px 0;
      font-size: 15px;
      color: #5a3e2b;
    }
  </style>
</head>
<body>

<h1>طلباتي</h1>

<?php while ($order = $result->fetch_assoc()): ?>
  <div class="order-box">
    <h3>طلب رقم: <?= htmlspecialchars($order['id']) ?></h3>

    <?php
      $products = json_decode($order['products'], true);
      if (is_array($products)):
    ?>
      <div class="order-products">
        <?php foreach ($products as $item): ?>
          <div class="order-item">
            <img src="Images/<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>">
            <h4><?= htmlspecialchars($item['name']) ?></h4>
            <p>السعر: <?= htmlspecialchars($item['price']) ?> $</p>
            <p>الكمية: <?= htmlspecialchars($item['quantity']) ?></p>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <p>❌ تعذر عرض المنتجات في هذا الطلب.</p>
    <?php endif; ?>

    <div class="meta-info">
      <p><strong>المبلغ الكلي:</strong> <?= htmlspecialchars($order['total_amount']) ?> $</p>
      <p><strong>الدفع:</strong> <?= htmlspecialchars($order['payment_status']) ?></p>
      <p><strong>الشحن:</strong> <?= htmlspecialchars($order['shipping_status']) ?></p>
      <p><strong>العنوان:</strong> <?= htmlspecialchars($order['address']) ?></p>
      <p><strong>رقم الهاتف:</strong> <?= htmlspecialchars($order['phone']) ?></p>
      <p><strong>التاريخ:</strong> <?= htmlspecialchars($order['order_date']) ?></p>
    </div>
  </div>
<?php endwhile; ?>

</body>
</html>