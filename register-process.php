<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $password = $_POST['password'];
  $confirm = $_POST['confirm'];

  // التحقق من تطابق كلمة المرور
  if ($password !== $confirm) {
    echo "كلمة المرور غير متطابقة!";
    exit;
  }

  // تشفير كلمة المرور
  $hashed = password_hash($password, PASSWORD_DEFAULT);

  // التحقق من وجود الإيميل مسبقًا
  $check = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");
  if (mysqli_num_rows($check) > 0) {
    echo "الإيميل مستخدم من قبل!";
    exit;
  }

  // إدخال المستخدم الجديد
  mysqli_query($conn, "INSERT INTO users (Name, email, password) VALUES ('$name', '$email', '$hashed')");
  $_SESSION['user_id'] = mysqli_insert_id($conn);
  header("Location: profile.php");
  exit;
}
?>