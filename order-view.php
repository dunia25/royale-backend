<?php
session_start();
include 'config.php';

if (!isset($_SESSION['admin_id'])) {
  header("Location: admin-login.php");
  exit;
}

if (!isset($_GET['id'])) {
  echo "🚫 معرف الطلب غير موجود.";
  exit;
}

$order_id = intval($_GET['id']);

$stmt = $conn->prepare("
  SELECT orders.*, users.Name AS customer_name 
  FROM orders 
  JOIN users ON orders.user_id = users.id 
  WHERE orders.id = ?
");
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
  echo "🚫 الطلب غير موجود.";
  exit;
}

$order = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>تفاصيل الطلب</title>
  <style>
    body {
      background: #fdf8f3;
      font-family: 'Cairo', sans-serif;
      padding: 40px;
      color: #4b2e1e;
    }
    .box {
      background: #fff;
      padding: 25px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(138,90,60,0.1);
      max-width: 500px;
      margin: auto;
    }
    h2 {
      color: #8a5a3b;
      text-align: center;
      margin-bottom: 20px;
    }
    .row {
      margin: 10px 0;
    }
    .label {
      color: #7a4b33;
      font-weight: bold;
    }
    .value {
      color: #333;
    }
    .back-btn {
      display: block;
      width: fit-content;
      margin: 25px auto 0;
      padding: 8px 16px;
      background-color: #c8a88e;
      color: white;
      border-radius: 5px;
      text-decoration: none;
      font-weight: bold;
    }
    .back-btn:hover {
      background-color: #b88f75;
    }
  </style>
</head>
<body>

  <div class="box">
    <h2>تفاصيل الطلب #<?= $order['id'] ?></h2>

    <div class="row"><span class="label">الزبونة:</span> <span class="value"><?= htmlspecialchars($order['customer_name']) ?></span></div>
    <div class="row"><span class="label">الحالة:</span> <span class="value"><?= htmlspecialchars($order['status']) ?></span></div>
    <div class="row"><span class="label">الإجمالي:</span> <span class="value"><?= number_format($order['total_amount'], 2) ?> $</span></div>
    <div class="row"><span class="label">تاريخ الطلب:</span> <span class="value"><?= $order['created_at'] ?></span></div>

    <a href="admin-dashboard.php" class="back-btn">← الرجوع للوحة التحكم</a>
  </div>

</body>
</html>