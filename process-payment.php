<?php
session_start();

// استقبال بيانات النموذج
$fullname = $_POST['fullname'] ?? '';
$address  = $_POST['address'] ?? '';
$email    = $_POST['email'] ?? '';
$method   = $_POST['method'] ?? '';

// تفريغ العربة بعد الطلب (اختياري حالياً)
$_SESSION['cart'] = [];

?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>تم الطلب</title>
  <style>
    body { font-family: 'Cairo', sans-serif; background: #f8f4ef; padding: 60px; text-align: center; color: #4c3b29; }
    .confirmation {
      background: #fff;
      padding: 30px;
      border-radius: 10px;
      max-width: 500px;
      margin: auto;
      box-shadow: 0 3px 8px rgba(0,0,0,0.1);
    }
    h1 { color: #27ae60; }
    p { margin-top: 10px; font-size: 16px; }
    .back-link {
      margin-top: 30px;
      display: inline-block;
      padding: 10px 20px;
      background: #a9895b;
      color: white;
      border-radius: 6px;
      text-decoration: none;
      font-weight: bold;
    }
    .back-link:hover { background: #8a6c44; }
  </style>
</head>
<body>

<div class="confirmation">
  <h1>✅ تم تأكيد الطلب!</h1>
  <p>شكراً <strong><?= htmlspecialchars($fullname) ?></strong> على طلبك.</p>
  <p>سيتم التوصيل إلى: <?= htmlspecialchars($address) ?></p>
  <p>تم اختيار وسيلة الدفع: 
    <?php
      switch ($method) {
        case 'cod': echo 'الدفع عند الاستلام'; break;
        case 'card': echo 'بطاقة ائتمان'; break;
        case 'paypal': echo 'PayPal'; break;
        default: echo 'غير محددة';
      }
    ?>
  </p>
  <a href="products.php" class="back-link">🔁 الرجوع للمتجر</a>
</div>

</body>
</html>