<?php session_start(); ?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>الدفع - RoyaStyle</title>
  <style>
    body { font-family: 'Cairo', sans-serif; background: #fcf8f2; padding: 40px; color: #3e2f1c; }
    h1 { color: #a37b55; }
    form { background: #fff; padding: 20px; border-radius: 8px; max-width: 600px; margin-top: 20px; box-shadow: 0 2px 6px rgba(0,0,0,0.08); }
    label { display: block; margin-top: 15px; font-weight: bold; }
    input[type="text"], input[type="email"] {
      width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px; margin-top: 5px;
    }
    .payment-methods { margin-top: 20px; }
    .payment-methods label { font-weight: normal; }
    button {
      margin-top: 25px;
      padding: 10px 20px;
      background: #27ae60;
      color: white;
      border: none;
      border-radius: 6px;
      font-size: 16px;
      font-weight: bold;
      cursor: pointer;
    }
    button:hover { background: #1f8d4b; }
  </style>
</head>
<body>

<h1>💳 الدفع</h1>

<form action="process-payment.php" method="post">
  <label>الاسم الكامل:</label>
  <input type="text" name="fullname" required>

  <label>عنوان التوصيل:</label>
  <input type="text" name="address" required>

  <label>البريد الإلكتروني:</label>
  <input type="email" name="email" required>

  <div class="payment-methods">
    <label><input type="radio" name="method" value="cod" checked> الدفع عند الاستلام</label><br>
    <label><input type="radio" name="method" value="card"> بطاقة ائتمان</label><br>
    <label><input type="radio" name="method" value="paypal"> PayPal</label>
  </div>

  <button type="submit">✅ تأكيد الدفع</button>
</form>

</body>
</html>