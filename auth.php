<?php
session_start();
include 'config.php';
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $username = $_POST['username'];
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
  <title>تسجيل الدخول</title>
  <style>
    body {
      font-family: 'Cairo', sans-serif;
      background-color: #fef9f4;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .container {
      background-color: #f3efea;
      padding: 30px;
      border-radius: 10px;
      width: 350px;
      box-shadow: 0 0 15px rgba(102, 51, 0, 0.1);
    }

    .form-box {
      display: none;
    }

    .form-box.active {
      display: block;
    }

    h2 {
      text-align: center;
      color: #a9745a;
    }

    input {
      width: 100%;
      padding: 10px;
      margin-bottom: 12px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    button {
      width: 100%;
      padding: 10px;
      background-color: #c8a88e;
      border: none;
      color: #fff;
      font-weight: bold;
      border-radius: 5px;
      cursor: pointer;
    }

    .switch {
      margin-top: 10px;
      text-align: center;
      font-size: 14px;
    }

    .switch a {
      color: #a9745a;
      cursor: pointer;
      text-decoration: underline;
    }

    .error {
      color: red;
      text-align: center;
      margin-bottom: 10px;
    }
  </style>
</head>
<body>

  <div class="container">

    <!-- تسجيل الدخول -->
    <div id="loginForm" class="form-box active">
      <h2>تسجيل الدخول</h2>
      <form action="login-process.php" method="post">
        <input type="email" name="email" placeholder="البريد الإلكتروني" required>
        <input type="password" name="password" placeholder="كلمة المرور" required>
        <button type="submit">دخول</button>
      </form>
      <div class="switch">
        ما عندك حساب؟ <a onclick="showRegister()">إنشاء حساب</a><br>
        <div style="margin-top: 10px;">
  <a href="admin-login.php" style="color: #8a5a3b; text-decoration: none;">دخول المشرف</a>
</div>
      </div>
    </div>

    <!-- إنشاء حساب -->
    <div id="registerForm" class="form-box">
      <h2>إنشاء حساب</h2>
      <form action="register-process.php" method="post">
        <input type="text" name="name" placeholder="الاسم الكامل" required>
        <input type="email" name="email" placeholder="البريد الإلكتروني" required>
        <input type="password" name="password" placeholder="كلمة المرور" required>
        <input type="password" name="confirm" placeholder="تأكيد كلمة المرور" required>
        <button type="submit">تسجيل جديد</button>
      </form>
      <div class="switch">
        عندك حساب؟ <a onclick="showLogin()">تسجيل الدخول</a>
      </div>
    </div>
  </div>

  <!-- JavaScript للتبديل -->
  <script>
    function showLogin() {
      document.getElementById('loginForm').classList.add('active');
      document.getElementById('registerForm').classList.remove('active');
      document.getElementById('adminForm').classList.remove('active');
    }

    function showRegister() {
      document.getElementById('loginForm').classList.remove('active');
      document.getElementById('registerForm').classList.add('active');
      document.getElementById('adminForm').classList.remove('active');
    }

    function showAdmin() {
      document.getElementById('loginForm').classList.remove('active');
      document.getElementById('registerForm').classList.remove('active');
      document.getElementById('adminForm').classList.add('active');
    }
  </script>

</body>
</html>