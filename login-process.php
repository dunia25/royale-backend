<?php
session_start();
include 'config.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $email = trim($_POST['email']);
  $password = $_POST['password'];

  $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    if (password_verify($password, $user['password'])) {
      $_SESSION['user_id'] = $user['id'];
      $_SESSION['user_name'] = $user['Name'];
      header("Location: profile.php");
      exit;
    } else {
      $error = "❌ كلمة المرور غير صحيحة";
    }
  } else {
    $error = "❌ البريد الإلكتروني غير موجود";
  }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>تسجيل دخول المستخدم</title>
  <style>
    body {
      background-color: #fdf8f3;
      font-family: 'Cairo', sans-serif;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
    }
    .login-box {
      background-color: #fff;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 0 10px rgba(0,0,0,0.08);
      width: 320px;
    }
    h2 {
      color: #8a5a3b;
      text-align: center;
    }
    input, button {
      width: 100%;
      padding: 10px;
      margin: 12px 0;
      border: 1px solid #d8cabc;
      border-radius: 6px;
    }
    button {
      background-color: #b48a6b;
      color: white;
      font-weight: bold;
      border: none;
      cursor: pointer;
    }
    .error {
      color: #a33;
      font-size: 14px;
      text-align: center;
    }
  </style>
</head>
<body>

<div class="login-box">
  <h2>تسجيل دخول المستخدم</h2>
  <form method="post">
    <input type="email" name="email" placeholder="البريد الإلكتروني" required>
    <input type="password" name="password" placeholder="كلمة المرور" required>
    <button type="submit">دخول</button>
  </form>

  <?php if (!empty($error)): ?>
    <div class="error"><?= $error ?></div>
  <?php endif; ?>
</div>

</body>
</html>