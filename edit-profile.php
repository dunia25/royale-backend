<?php
session_start();

// بيانات المستخدم الوهمية (ممكن استبدالها من قاعدة بيانات لاحقاً)
if (!isset($_SESSION['user'])) {
  $_SESSION['user'] = [
    'name' =>"user"
    'email' => "example@gmail.com"
    'phone' => "093-483-482"
  ];
}
$user = $_SESSION['user'];

// لو تم إرسال النموذج
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $_SESSION['user']['name'] = $_POST['name'];
  $_SESSION['user']['email'] = $_POST['email'];
  $_SESSION['user']['phone'] = $_POST['phone'];

  header("Location: profile.php"); // يرجع المستخدم إلى صفحة الحساب بعد الحفظ
  exit();
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>تعديل المعلومات</title>
  <style>
    body { font-family: 'Cairo', sans-serif; background: #fdfaf6; padding: 60px; color: #4b3928; }
    h1 { color: #a37b55; font-size: 26px; }
    form {
      background: #fff; padding: 30px; max-width: 600px;
      margin: auto; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }
    label { display: block; margin-top: 15px; font-weight: bold; }
    input[type="text"], input[type="email"] {
      width: 100%; padding: 10px; border: 1px solid #ccc;
      border-radius: 6px; margin-top: 6px;
    }
    button {
      margin-top: 25px; padding: 10px 20px;
      background: #27ae60; color: white; border: none;
      border-radius: 6px; font-weight: bold; cursor: pointer;
    }
    button:hover { background: #1e8d4b; }
  </style>
</head>
<body>

<h1>✏️ تعديل معلوماتي</h1>

<form method="post" action="edit-profile.php">
  <label>الاسم الكامل:</label>
  <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>

  <label>البريد الإلكتروني:</label>
  <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>

  <label>رقم الهاتف:</label>
  <input type="text" name="phone" value="<?= htmlspecialchars($user['phone']) ?>" required>

  <button type="submit">💾 حفظ التعديلات</button>
</form>

</body>
</html>
