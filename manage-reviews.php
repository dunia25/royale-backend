<?php
session_start();
include 'config.php';

$reviews = $conn->query("
  SELECT r.*, u.name AS user_name, p.name AS product_name 
  FROM reviews r
  JOIN users u ON r.user_id = u.id
  JOIN products p ON r.product_id = p.id
  ORDER BY r.created_at DESC
");
?>

<!DOCTYPE html>
<html lang="ar">
<head>
  <meta charset="UTF-8">
  <title>إدارة التقييمات</title>
  <link rel="stylesheet" href="admin.css">
</head>
<body>
  <div class="dashboard">
    <h2>⭐ إدارة التقييمات</h2>
    <table>
      <tr>
        <th>المستخدم</th>
        <th>المنتج</th>
        <th>التقييم</th>
        <th>المحتوى</th>
        <th>الحالة</th>
        <th>إجراء</th>
      </tr>
      <?php while($r = $reviews->fetch_assoc()): ?>
      <tr>
        <td><?= htmlspecialchars($r['user_name']) ?></td>
        <td><?= htmlspecialchars($r['product_name']) ?></td>
        <td><?= $r['rating'] ?> ⭐</td>
        <td><?= htmlspecialchars($r['comment']) ?></td>
        <td><?= $r['status'] ?></td>
        <td>
          <?php if($r['status'] == 'بانتظار'): ?>
            <a href="review_action.php?id=<?= $r['id'] ?>&action=accept">✅ قبول</a> |
            <a href="review_action.php?id=<?= $r['id'] ?>&action=reject">❌ رفض</a> |
          <?php endif; ?>
          <a href="review_action.php?id=<?= $r['id'] ?>&action=delete" onclick="return confirm('هل أنت متأكد؟')">🗑️ حذف</a>
        </td>
      </tr>
      <?php endwhile; ?>
    </table>
    <a href="admin_dashboard.php">⬅️ رجوع</a>
  </div>
</body>
</html>