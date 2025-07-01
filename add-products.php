<?php
session_start();
include 'config.php';
include '../functions.php';

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitize_input($_POST['name']);
    $description = sanitize_input($_POST['description']);
    $price = floatval($_POST['price']);
    $category = sanitize_input($_POST['category']);
    $image = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];

    $imagePath = "../images/" . $image;
    if (move_uploaded_file($tmp, $imagePath)) {
        $stmt = $conn->prepare("INSERT INTO products (name, description, price, image, category) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdss", $name, $description, $price, $image, $category);
        if ($stmt->execute()) {
            $success = "✅ تم إضافة المنتج بنجاح.";
        } else {
            $error = "❌ حدث خطأ أثناء الحفظ.";
        }
    } else {
        $error = "❌ لم يتم رفع الصورة.";
    }
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
  <meta charset="UTF-8">
  <title>إضافة منتج</title>
  <link rel="stylesheet" href="admin.css">
</head>
<body>
  <div class="dashboard">
    <h2>➕ إضافة منتج</h2>
    <?php if ($success): ?><p class="success"><?= $success ?></p><?php endif; ?>
    <?php if ($error): ?><p class="error"><?= $error ?></p><?php endif; ?>

    <form method="POST" enctype="multipart/form-data" class="admin-form">
      <input type="text" name="name" placeholder="اسم المنتج" required>
      <textarea name="description" placeholder="الوصف" required></textarea>
      <input type="number" step="0.01" name="price" placeholder="السعر $" required>
      <input type="text" name="category" placeholder="القسم (مثلاً: عناية بالبشرة)" required>
      <input type="file" name="image" required>
      <button type="submit">إضافة</button>
    </form>

    <a href="manage_products.php">⬅️ الرجوع</a>
  </div>
</body>
</html>