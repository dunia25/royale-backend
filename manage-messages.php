<?php
session_start();
include 'config.php';
$result = $conn->query("SELECT * FROM messages ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="ar">
<head>
  <meta charset="UTF-8">
  <title>📨 رسائل العملاء</title>
  <link rel="stylesheet" href="admin.css">
</head>
<body>
  <div class="dashboard">
    <h2>📨 صندوق رسائل العملاء</h2>

    <table>
      <tr>
        <th>الاسم</th>
        <th>البريد</th>
        <th>الموضوع</th>
        <th>الرسالة</th>
        <th>التاريخ</th>
        <th>🗑️</th>
      </tr>
      <?php while($msg = $result->fetch_assoc()): ?>
      <tr>
        <td><?= htmlspecialchars($msg['name']) ?></td>
        <td><?= htmlspecialchars($msg['email']) ?></td>
        <td><?= htmlspecialchars($msg['subject']) ?></td>
        <td><?= nl2br(htmlspecialchars($msg['message'])) ?></td>
        <td><?= date('Y-m-d H:i', strtotime($msg['created_at'])) ?></td>
        <td>
          <a href="delete_message.php?id=<?= $msg['id'] ?>" onclick="return confirm('هل تريد حذف هذه الرسالة؟')">🗑️</a>
        </td>
      </tr>
      <?php endwhile; ?>
    </table>

    <a href="admin_dashboard.php">⬅️ رجوع</a>
  </div>
</body>
</html>