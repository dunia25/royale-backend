<?php
session_start();
include 'config.php';
include '../functions.php';

$result = $conn->query("SELECT * FROM products ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="ar">
<head>
  <meta charset="UTF-8">
  <title>إدارة المنتجات</title>
  <link rel="stylesheet" href="admin.css">
</head>
<body>
  <div class="dashboard">
    <h2>🛍️ إدارة المنتجات</h2>

    <a href="add_product.php" class="button">➕ إضافة منتج</a>

    <table>
      <tr>
        <th>الصورة</th>
        <th>الاسم</th>
        <th>السعر</th>
        <th>القسم</th>
        <th>الإجراءات</th>
      </tr>
      <?php while($row = $result->fetch_assoc()): ?>
      <tr>
        <td><img src="../images/<?= $row['image'] ?>" width="60"></td>
        <td><?= htmlspecialchars($row['name']) ?></td>
        <td>$<?= number_format($row['price'], 2) ?></td>
        <td><?= htmlspecialchars($row['category']) ?></td>
        <td>
          <a href="edit_product.php?id=<?= $row['id'] ?>">✏️ تعديل</a> |
          <a href="delete_product.php?id=<?= $row['id'] ?>" onclick="return confirm('هل أنت متأكد من الحذف؟')">🗑️ حذف</a>
        </td>
      </tr>
      <?php endwhile; ?>
    </table>

    <a href="admin_dashboard.php">⬅️ رجوع</a>
  </div>
</body>
</html>