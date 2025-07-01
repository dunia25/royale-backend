<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
  header("Location: admin-login.php");
  exit;
}
include 'db.php'; // الاتصال بقاعدة البيانات
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>لوحة المشرف</title>
  <style>
    body {
      background-color: #fff;
      font-family: 'Cairo', sans-serif;
      padding: 40px;
      color: #4b2e1e;
    }
    h1 {
      text-align: center;
      color: #a9745a;
    }
    table {
      width: 100%;
      margin-top: 30px;
      border-collapse: collapse;
      background-color: #f9f6f1;
    }
    th, td {
      border: 1px solid #d8c8b8;
      padding: 12px;
      text-align: center;
    }
    th {
      background-color: #f3efea;
      color: #7a4b33;
    }
    tr:hover {
      background-color: #f1e8de;
    }
    .logout-btn {
      display: block;
      width: fit-content;
      margin: 20px auto;
      background-color: #c8a88e;
      color: #fff;
      padding: 8px 16px;
      text-decoration: none;
      border-radius: 5px;
      font-weight: bold;
    }
    .logout-btn:hover {
      background-color: #b88f75;
    }
  </style>
</head>
<body>

<h1>لوحة تحكم المشرف 👑</h1>

<a href="admin-logout.php" class="logout-btn">تسجيل الخروج</a>

<table>
  <tr>
    <th>رقم الطلب</th>
    <th>اسم الزبونة</th>
    <th>الحالة</th>
    <th>الإجمالي</th>
    <th>الإجراء</th>
  </tr>
  <?php
  $orders = mysqli_query($conn, "
    SELECT orders.id, orders.status, orders.total_amount, users.Name 
    FROM orders 
    JOIN users ON orders.user_id = users.id 
    ORDER BY orders.id DESC
  ");

  while ($row = mysqli_fetch_assoc($orders)) {
    echo "<tr>";
    echo "<td>" . $row['id'] . "</td>";
    echo "<td>" . htmlspecialchars($row['Name']) . "</td>";
    echo "<td>" . $row['status'] . "</td>";
    echo "<td>" . htmlspecialchars($row['Name']) . "</td>";
    echo "<td>" . $row['total_amount'] . "$</td>";
    echo "<td><a href='order-view.php?id=" . $row['id'] . "'>عرض</a></td>";
    echo "</tr>";
  }
  ?>
</table>

</body>
</html>