<?php
session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location: /royale_beauty/login.php");
  exit;
}

if (empty($_SESSION['cart'])) {
  echo "🚫 لا توجد منتجات لإتمام الطلب.";
  exit;
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
  <meta charset="UTF-8">
  <title>إتمام الطلب</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #fef9f3;
      padding: 30px;
      color: #4b2e19;
    }
    form {
      background: #fffaf2;
      padding: 20px;
      border: 1px solid #d2b48c;
      max-width: 500px;
      margin: auto;
      border-radius: 10px;
    }
    label {
      display: block;
      margin-top: 15px;
      font-weight: bold;
    }
    input, select {
      width: 100%;
      padding: 8px;
      margin-top: 5px;
      border: 1px solid #c4a484;
      border-radius: 5px;
    }
    button {
      margin-top: 20px;
      background: #b38755;
      color: white;
      padding: 10px 15px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    button:hover {
      background: #a07044;
    }
  </style>
</head>
<body>

<h2 style="text-align:center;">📋 تعبئة بيانات التوصيل</h2>

<form action="orders.php" method="post">
  <label for="fullname">👤 الاسم الكامل</label>
  <input type="text" name="fullname" id="fullname" required>

  <label for="phone">📞 رقم الهاتف</label>
  <input type="text" name="phone" id="phone" required>

  <label for="address">📍 العنوان</label>
  <input type="text" name="address" id="address" required>

  <label for="payment_method">💳 طريقة الدفع</label>
  <select name="payment_method" id="payment_method" required>
    <option value="">-- اختر طريقة الدفع --</option>
    <option value="عند الاستلام">💵 عند الاستلام</option>
    <option value="دفع إلكتروني">🪙 دفع إلكتروني</option>
  </select>

  <button type="submit">✅ تأكيد الطلب</button>
</form>

</body>
</html>