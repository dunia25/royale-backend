<?php
$host = 'localhost';
$db   = 'luxury_site';
$user = 'root';
$pass = 'your_password';
$charset = 'utf8mb4';

// الاتصال بقاعدة البيانات
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
  PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
  $pdo = new PDO($dsn, $user, $pass, $options);

  // حفظ البيانات
  $stmt = $pdo->prepare("INSERT INTO messages (name, email, phone, message)
                         VALUES (:name, :email, :phone, :message)");
  $stmt->execute([
    ':name'    => $_POST['name'],
    ':email'   => $_POST['email'],
    ':phone'   => $_POST['phone'],
    ':message' => $_POST['message'],
  ]);

  // إعادة توجيه مع رسالة نجاح
  header("Location: contact.php?success=true");
  exit();

} catch (PDOException $e) {
  echo "❌ حدث خطأ: " . $e->getMessage();
}
?>