<?php
session_start();
include 'config.php';
include 'functions.php';

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitize_input($_POST['name']);
    $email = sanitize_input($_POST['email']);
    $password = sanitize_input($_POST['password']);

    // التحقق من عدم وجود الحقول فارغة
    if (empty($name) || empty($email) || empty($password)) {
        $error = "جميع الحقول مطلوبة ✋";
    } else {
        // تشفير كلمة السر
        $hashedPassword = hash_password($_POST['password']);
        
        // التحقق إذا المستخدم موجود مسبقًا
        $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $error = "البريد الإلكتروني مستخدم مسبقًا 🚫";
        } else {
            // إضافة المستخدم
            $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $name, $email, $hashedPassword);

            if ($stmt->execute()) {
                $success = "تم إنشاء الحساب بنجاح 🎉";
            } else {
                $error = "حدث خطأ أثناء التسجيل 😓";
            }
            $stmt->close();
        }
        $check->close();
    }
}
?>

<!-- نموذج HTML بسيط للتسجيل -->
<!DOCTYPE html>
<html lang="ar">
<head>
  <meta charset="UTF-8">
  <title>تسجيل مستخدم جديد</title>
</head>
<body>
  <h2>👤 تسجيل حساب جديد</h2>

  <?php if ($success) echo "<p style='color:green;'>$success</p>"; ?>
  <?php if ($error) echo "<p style='color:red;'>$error</p>"; ?>

  <form method="POST">
    <label>الاسم:</label><br>
    <input type="text" name="name"><br><br>

    <label>البريد الإلكتروني:</label><br>
    <input type="email" name="email"><br><br>

    <label>كلمة السر:</label><br>
    <input type="password" name="password"><br><br>

    <button type="submit">إنشاء الحساب ✅</button>
  </form>
</body>
</html>