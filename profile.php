<?php
session_start();
include 'config.php';

// تحقق من الجلسة
$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
  header("Location: login.php");
  exit;
}

// جلب بيانات المستخدم من قاعدة البيانات
$stmt = $conn->prepare("SELECT name, email, loyalty_points FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="ar">
<head>
  <meta charset="UTF-8">
  <title>الملف الشخصي</title>
  <link href="https://fonts.googleapis.com/css2?family=Cairo&display=swap" rel="stylesheet">
  <style>
    body {
      background-color: #fdf8f3;
      font-family: 'Cairo', sans-serif;
      direction: rtl;
      margin: 0;
      padding: 0;
    }

    .profile-container {
      max-width: 500px;
      margin: 60px auto;
      background-color: #f3efea;
      padding: 35px;
      border-radius: 15px;
      box-shadow: 0 0 20px rgba(139, 103, 73, 0.08);
      text-align: center;
    }

    h2 {
      color: #8a5a3b;
      margin-bottom: 25px;
    }

    .info-box {
      background-color: #fffaf5;
      border: 1px solid #e2d6c7;
      border-radius: 10px;
      padding: 20px;
      margin-bottom: 30px;
      text-align: right;
    }

    .info-box p {
      margin: 10px 0;
      color: #5c3e2d;
      font-size: 15px;
    }

    .links {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 10px;
    }

    .links a {
      background-color: #b48a6b;
      color: white;
      text-decoration: none;
      padding: 10px 16px;
      border-radius: 8px;
      font-size: 14px;
      transition: background-color 0.3s;
    }

    .links a:hover {
      background-color: #a9745a;
    }
  </style>
</head>
<body>

<div class="profile-container">
  <h2>أهلًا بك، <?= htmlspecialchars($user['name']) ?> 👑</h2>

  <div class="info-box">
    <p>📧 <strong>البريد الإلكتروني:</strong> <?= htmlspecialchars($user['email']) ?></p>
    <p>🌟 <strong>نقاط الولاء:</strong> <?= $user['loyalty_points'] ?> نقطة</p>
  </div>

  <div class="links">
    <a href="orders.php">📦 طلباتي</a>
    <a href="loyalty.php">🌟 نقاطي</a>
    <a href="index.php" class="return-btn">← العودة إلى المتجر</a>
    <a href="edit-profile.php">🛠 تعديل البيانات</a>
    <a href="logout.php">🚪 تسجيل الخروج</a>
  </div>
</div>

</body>
</html>