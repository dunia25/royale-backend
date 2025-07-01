<?php
session_start();
include 'config.php';
include '../functions.php';

if (!isset($_GET['id'])) {
    header("Location: manage_products.php");
    exit;
}

$id = intval($_GET['id']);
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "المنتج غير موجود.";
    exit;
}

$product = $result->fetch_assoc();
$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitize_input($_POST['name']);
    $description = sanitize_input($_POST['description']);
    $price = floatval($_POST['price']);
    $category = sanitize_input($_POST['category']);
    $image = $product['image']; // الصورة القديمة الافتراضية

    // إذا تم رفع صورة جديدة
    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        $tmp = $_FILES['image']['tmp_name'];
        $target = "../images/" . $image;
        move_uploaded_file($tmp, $target);
    }

    $update = $conn->prepare("UPDATE products SET name=?, description=?, price=?, category=?, image=?, updated_at=NOW() WHERE id=?");
    $update->bind_param("ssdssi", $name, $description, $price, $category, $image, $id);

    if ($update->execute()) {
        $success = "✅ تم تحديث المنتج بنجاح.";
        // إعادة تحميل المنتج بالتعديل الجديد
        $product['name'] = $name;
        $product['description'] = $description;
        $product['price'] = $price;
        $product['category'] = $category;
        $product['image'] = $image;
    } else {
        $error = "❌ حدث خطأ أثناء التعديل.";
    }
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
  <meta charset="UTF-8">
  <title>تعديل المنتج</title>
  <link rel="stylesheet" href="admin.css">
</head>
<body>
  <div class="dashboard">
    <h2>✏️ تعديل المنتج</h2>

    <?php if ($success): ?><p class="success"><?= $success ?></p><?php endif; ?>
    <?php if ($error): ?><p class="error"><?= $error ?></p><?php endif; ?>

    <form method="POST" enctype="multipart/form-data" class="admin-form">
      <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>
      <textarea name="description" required><?= htmlspecialchars($product['description']) ?></textarea>
      <input type="number" step="0.01" name="price" value="<?= $product['price'] ?>" required>
      <input type="text" name="category" value="<?= htmlspecialchars($product['category']) ?>" required>

      <p>الصورة الحالية:</p>
      <img src="../images/<?= $product['image'] ?>" width="100"><br><br>
      <input type="file" name="image">

      <button type="submit">حفظ التعديلات</button>
    </form>

    <a href="manage_products.php">⬅️ رجوع</a>
  </div>
</body>
</html>

