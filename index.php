<?php
//  بدء الجلسة
session_start();

// ربط قاعدة البيانات
include 'config.php';

//  إضافة منتج للسلة مع دعم الكمية
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
  $product_id = $_POST['product_id'];

  if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

  $found = false;

  //  فحص إذا المنتج موجود مسبقاً لزيادة الكمية
  foreach ($_SESSION['cart'] as &$item) {
    if ($item['id'] == $product_id) {
      $item['quantity'] += 1;
      $found = true;
      break;
    }
  }

  //  إذا المنتج جديد، نضيفه للسلة
  if (!$found) {
    $_SESSION['cart'][] = [
      'id'       => $product_id,
      'name'     => $_POST['product_name'],
      'price'    => $_POST['product_price'],
      'image'    => $_POST['product_image'],
      'quantity' => 1
    ];
  }
  //  منع الإضافة المكررة بالتحديث
  header("Location: " . $_SERVER['REQUEST_URI']);
  exit();
}

$display_category = [
  'makeup'   => 'مكياج',
  'skin' => 'عناية بالبشرة',
  'fragrance'  => 'عطور',
  'accessories'    => 'أدوات',
  'body' => 'عناية بالجسم',
  'hair' =>'عناية بالشعر',
  'nails'=>'عناية بالأظافر'
];

//  جلب المنتجات من قاعدة البيانات
$query = "SELECT * FROM products ORDER BY category, id DESC";
$result = mysqli_query($conn, $query);
$products_by_category = [];

if ($result && mysqli_num_rows($result) > 0) {
  while ($row = mysqli_fetch_assoc($result)) {
    $cat = strtolower(trim($row['category']));
    $products_by_category[$cat][] = $row;
  }
}
?>

<!DOCTYPE html>
<html lang="ar">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<meta charset="UTF-8">
<title>Royale-Beauty</title>
<link rel="stylesheet" href="style.css">
<link href="https://fonts.googleapis.com/css?family=Tajawal&display=swap" rel="stylesheet">
<script src="script.js" defer></script> <!-- تحسين تحميل السكريبت -->
</head>
<body>
    <div id="suggestions" class="suggestion-box"></div> <!-- وضع العنصر داخل `body` -->
</body>

<body>
    <div id="welcome-modal" class="modal">
        <div class="modal-content">
            <img src="images/Royale-Beauty.jpg" alt="شعار الموقع" class="site-logo">
        </div>
    </div>
    <script src="script.js"></script> <!-- تأكدي من وجود ملف JavaScript لإغلاق النافذة -->
</body>

  <!-- ✅ قائمة الخدمات تحت الصورة -->
    <div class="service-options">
        <a href="beauty-test.html"> اختبار الجمال</a>
        <a href="skin-analysis.html"> تحليل البشرة</a>
        <a href="seasonal-products.html"> توصيات المنتجات الموسمية</a>
        <a href="beauty-education.html"> محتوى تعليمي عن الجمال</a>
        <a href="auth.php">تسجيل الدخول</a>
        <a href="contact.php"> تواصل معنا </a>
        <a href="chat.html">دردشة Ai  </a>
    </div>
    <body>

  <title>منتجاتنا</title>
  <style>
    body { 
      font-family: Tahoma; 
      direction: rtl; 
      background: #f6f5f4; 
      padding: 40px; 
    }
    .product { 
      background: #fff; 
      padding:20px;
       margin: 15px; 
       border-radius: 10px;
      box-shadow: 0 1px 6px rgba(0,0,0,0.05);
       width: 240px;
       display: inline-block;
       vertical-align: top;
      }
    .product img {
       width: 100%;
        border-radius: 8px;
       }
    .product h3 { 
      margin: 10px 0 5px; 
      font-size: 18px;
     }
    .product p {
       color: #777;
        margin-bottom: 10px;
       }
    .product button
     { background: #a67c73;
       color: white; 
       border: none;
        padding: 8px 14px;
      border-radius: 6px; 
      cursor: pointer; 
      font-size: 15px;
     }
    .product button:hover {
       background: #8c665d;
       }

    .cart-count {
      background: white;
       color: #a67c73;
        font-weight: bold;
      padding: 2px 8px; 
      margin-right: 6px;
       border-radius: 20px;
        font-size: 14px;
    }
    .added-note {
      margin-top: 8px;
      background: #d4edda;
      color: #155724;
      padding: 5px 10px;
      border-radius: 6px;
      font-size: 13px;
      animation: fade 1.5s ease-out forwards;
    }
    .product .price {
  color: red;
  font-weight: bold;
  font-size: 16px;
}

.product-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
  gap: 20px;
  margin-top: 20px;
  padding: 20px;
  background: #fffaf4;
  border-radius: 12px;
  box-shadow: 0 0 10px rgba(0,0,0,0.05);
}
.product-card {
  background: #fdf6ef;
  border: 1px solid #e2cfc0;
  border-radius: 10px;
  padding: 15px;
  text-align: center;
  transition: transform 0.2s;
}
.product-card:hover {
  transform: scale(1.02);
}
.product-card img {
  width: 100%;
  height: 180px;
  object-fit: cover;
  border-radius: 8px;
  margin-bottom: 10px;
}
.product-card h3 {
  margin: 5px 0;
  color: #7a4c2f;
  font-size: 18px;
}
.product-card p {
  font-size: 14px;
  color: #5a3d31;
}
.product-card .price {
  margin-top: 10px;
  color: #8a5a3b;
  font-weight: bold;
}
.add-to-cart {
  margin-top: 10px;
  background-color: #8a5a3b;
  color: white;
  border: none;
  padding: 10px 14px;
  border-radius: 8px;
  cursor: pointer;
  font-size: 14px;
  transition: background 0.2s;
}
.add-to-cart:hover {
  background-color: #a16a49;
}

    @keyframes fade { 0%, 90% {opacity: 1;} 100% {opacity: 0;} }
  </style>
</head>
<body>

<?php if (!empty($products_by_category)): ?>
  <?php foreach ($products_by_category as $category => $group): ?>
    <h2><?= $display_category[$category] ?? $category ?></h2>
    <div class="products-wrapper">
      <?php foreach ($group as $product): ?>
        <div class="product">
          <img src="images/<?= $product['image'] ?>" alt="<?= htmlspecialchars($product['Name']) ?>">
          <h3><?= htmlspecialchars($product['Name']) ?></h3>
          <p class="description"><?= htmlspecialchars($product['description']) ?></p>
          <p class="price">$<?= $product['price'] ?></p>
          <form method="post">
            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
            <input type="hidden" name="product_name" value="<?= htmlspecialchars($product['Name']) ?>">
            <input type="hidden" name="product_price" value="<?= $product['price'] ?>">
            <input type="hidden" name="product_image" value="<?= $product['image'] ?>">
            <button type="submit" name="add_to_cart">🛍️ أضف إلى السلة</button>
          </form>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endforeach; ?>
<?php else: ?>
  <p>لا توجد منتجات حالياً.</p>
<?php endif; ?>

</body>
</html>

<!-- العربة -->

<a href="cart.php" style="position: fixed; bottom: 20px; right: 20px; background: #a67c73; color: white; padding: 10px 16px; border-radius: 50px; font-size: 16px; text-decoration: none; z-index: 9999;" title="عرض السلة">
  🛒 <span class="cart-count"><?= count($_SESSION['cart'] ?? []) ?></span>
</a>

<footer class="site-rating">
    <h3>⭐ كيف كانت تجربتك مع موقعنا؟</h3>
    <div class="rating">
        <span onclick="rateSite(1)">★</span>
        <span onclick="rateSite(2)">★</span>
        <span onclick="rateSite(3)">★</span>
        <span onclick="rateSite(4)">★</span>
        <span onclick="rateSite(5)">★</span>
    </div>
    <textarea id="site-review" placeholder="اكتب تعليقك هنا..."></textarea>
    <button onclick="submitSiteReview()">إرسال التقييم</button>
    <div id="site-reviews-container"></div>
</footer>

<!-- التذييل -->
<footer class="site-footer">
    <p>© 2025 Royale Beauty - جميع الحقوق محفوظة</p>
</footer>

<style>
  .products-wrapper {
  display: flex;
  flex-wrap: wrap;
  gap: 20px;
  justify-content: center;
}

.product {
  flex: 1 1 calc(25% - 20px); /* أربعة مربعات بالصف */
  max-width: calc(25% - 20px);
  background: #fff;
  border-radius: 10px;
  padding: 15px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.05);
  box-sizing: border-box;
}
.product .description {
  color: #555;
  font-size: 14px;
  margin: 6px 0 10px;
  line-height: 1.6;
}
.cart-count {
  pointer-events: auto;
  z-index: 9999;
}



    <meta name="description" content="متجر مستحضرات تجميل يقدم منتجات العناية بالبشرة والمكياج الفاخر بأفضل الأسعار.">
    <meta name="keywords" content="مستحضرات تجميل, العناية بالبشرة, ميك أب, كريمات طبيعية, عروض المكياج">

