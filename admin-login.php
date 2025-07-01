<?php
session_start();
include 'config.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $username = trim($_POST['username']);
  $password = $_POST['password'];

  $stmt = $conn->prepare("SELECT * FROM admins WHERE username = ?");
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows === 1) {
    $admin = $result->fetch_assoc();

    if (password_verify($password, $admin['password'])) {
      $_SESSION['admin_id'] = $admin['id'];
      $_SESSION['admin_username'] = $admin['username'];
      header("Location: admin-dashboard.php");
      exit;
    } else {
      $error = "❌ كلمة المرور غير صحيحة";
    }
  } else {
    $error = "❌ اسم المستخدم غير موجود";
  }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>دخول المشرف</title>
  <style>
    body {
      background-color: #fdf8f3;
      font-family: 'Cairo', sans-serif;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
      margin: 0;
    }
    .login-box {
      background-color: #fff;
      padding: 35px;
      border-radius: 12px;
      box-shadow: 0 0 12px rgba(138, 90, 60, 0.1);
      width: 340px;
    }
    h2 {
      text-align: center;
      color: #8a5a3b;
      margin-bottom: 20px;
    }
    input, button {
      width: 100%;
      padding: 10px;
      margin-bottom: 12px;
      border: 1px solid #d8cabc;
      border-radius: 6px;
      font-family: inherit;
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
    <h2>تسجيل دخول المشرف 👨‍💼</h2>
    <form method="post">
      <input type="text" name="username" placeholder="اسم المستخدم" required>
      <input type="password" name="password" placeholder="كلمة المرور" required>
      <button type="submit">دخول</button>
    </form>
    <?php if (!empty($error)): ?>
      <div class="error"><?= $error ?></div>
    <?php endif; ?>
  </div>

</body>
</html>
