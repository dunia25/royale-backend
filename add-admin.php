<?php
session_start();
include 'db_connection.php';
$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $username = trim($_POST['username']);
  $email = trim($_POST['email']);
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

  // تحقق من التكرار
  $check = $conn->prepare("SELECT id FROM admins WHERE username = ?");
  $check->bind_param("s", $username);
  $check->execute();
  $check->store_result();

  if ($check->num_rows > 0) {
    $message = "⚠️ هذا الاسم مستخدم مسبقًا.";
  } else {
    $stmt = $conn->prepare("INSERT INTO admins (username, email, password, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("sss", $username, $email, $password);

    if ($stmt->execute()) {
      $message = "✅ تمت إضافة المشرف بنجاح!";
    } else {
      $message = "❌ فشل في الإضافة: " . $stmt->error;
    }
  }
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
  <meta charset="UTF-8">
  <title>إضافة مشرف</title>
  <style>
    body {
      background-color: #f8f4ee;
      font-family: 'Cairo', sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      direction: rtl;
    }
    .box {
      background: #fff;
      padding: 25px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(138, 90, 60, 0.2);
      width: 330px;
    }
    h2 {
      text-align: center;
      color: #8a5a3b;
      margin-bottom: 15px;
    }
    input {
      width: 100%;
      margin-bottom: 10px;
      padding: 10px;
      border: 1px solid #d8cabc;
      border-radius: 6px;
    }
    button {
      width: 100%;
      padding: 10px;
      background: #b48a6b;
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
    }
    .msg {
      margin-top: 10px;
      text-align: center;
      color: #944;
    }
  </style>
</head>
<body>
  <div class="box">
    <h2>إضافة مشرف</h2>
    <form method="POST">
      <input type="text" name="username" placeholder="اسم المستخدم" required>
      <input type="email" name="email" placeholder="البريد الإلكتروني" required>
      <input type="password" name="password" placeholder="كلمة المرور" required>
      <button type="submit">إضافة</button>
    </form>
    <?php if (!empty($message)): ?>
      <div class="msg"><?= $message ?></div>
    <?php endif; ?>
  </div>
</body>
</html>