<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit;
}

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT loyalty_points FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>نقاط الولاء</title>
  <style>
    body {
      background-color: #fdf8f3;
      font-family: 'Cairo', sans-serif;
      padding: 40px;
      color: #4b2e1e;
      text-align: center;
    }
    .points-box {
      background-color: #fff;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 0 10px rgba(138,90,60,0.08);
      max-width: 400px;
      margin: auto;
    }
    h2 {
      color: #8a5a3b;
    }
    .points {
      font-size: 24px;
      font-weight: bold;
      margin-top: 20px;
      color: #a36d4e;
    }
    .back-btn {
      margin-top: 25px;
      display: inline-block;
      padding: 10px 18px;
      background-color: #c8a88e;
      color: white;
      text-decoration: none;
      border-radius: 5px;
      font-weight: bold;
    }
    .back-btn:hover {
      background-color: #b88f75;
    }
  </style>
</head>
<body>

<div class="points-box">
  <h2>🌟 نقاط الولاء الخاصة بك</h2>
  <div class="points"><?= $user['loyalty_points'] ?> نقطة</div>
  <a href="profile.php" class="back-btn">← الرجوع إلى حسابك</a>
</div>

</body>
</html>