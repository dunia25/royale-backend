<?php
session_start();
include 'config.php';
include '../functions.php';

$result = $conn->query("
  SELECT o.*, u.name AS customer_name
  FROM orders o
  JOIN users u ON o.user_id = u.id
  ORDER BY o.id DESC
");
?>

<!DOCTYPE html>
<html lang="ar">
<head>
  <meta charset="UTF-8">
  <title>إدارة الطلبات</title>
  <link rel="stylesheet" href="admin.css">
</head>
<body>
  <div class="dashboard">
    <h2>📦 إدارة الطلبات</h2>
    <table>
      <tr>
        <th>رقم الطلب</th>
        <th>العميل</th>
        <th>الإجمالي $</th>
        <th>الدفع</th>
        <th>الشحن</th>
        <th>أدوات</th>
      </tr>

      <?php while($row = $result->fetch_assoc()): ?>
      <tr>
        <td>#<?= $row['id'] ?></td>
        <td><?= htmlspecialchars($row['customer_name']) ?></td>
        <td>$<?= number_format($row['total'], 2) ?></td>

        <!-- حالة الدفع -->
        <td>
          <form method="POST" action="update_order_status.php">
            <input type="hidden" name="order_id" value="<?= $row['id'] ?>">
            <select name="payment_status" onchange="this.form.submit()">
              <option value="بانتظار الدفع" <?= $row['payment_status'] === 'بانتظار الدفع' ? 'selected' : '' ?>>بانتظار الدفع</option>
              <option value="مدفوع" <?= $row['payment_status'] === 'مدفوع' ? 'selected' : '' ?>>مدفوع</option>
            </select>
        </td>

        <!-- حالة الشحن -->
        <td>
            <select name="shipping_status" onchange="this.form.submit()">
              <option value="قيد التجهيز" <?= $row['shipping_status'] === 'قيد التجهيز' ? 'selected' : '' ?>>قيد التجهيز</option>
              <option value="تم الشحن" <?= $row['shipping_status'] === 'تم الشحن' ? 'selected' : '' ?>>تم الشحن</option>
              <option value="تم التوصيل" <?= $row['shipping_status'] === 'تم التوصيل' ? 'selected' : '' ?>>تم التوصيل</option>
            </select>
            </form>
        </td>

        <td>
          <a href="view_order.php?id=<?= $row['id'] ?>">👁️ عرض</a>
        </td>
      </tr>
      <?php endwhile; ?>
    </table>

    <a href="admin_dashboard.php">⬅️ رجوع</a>
  </div>
</body>
</html>