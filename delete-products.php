<?php
session_start();
include 'config.php';

if (isset($_GET['id'])) {
  $id = intval($_GET['id']);

  // حذف الصورة من المجلد (اختياري)
  $stmt = $conn->prepare("SELECT image FROM products WHERE id = ?");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($row = $result->fetch_assoc()) {
    $image_path = "../images/" . $row['image'];
    if (file_exists($image_path)) {
      unlink($image_path);
    }
  }

  // حذف المنتج من القاعدة
  $delete = $conn->prepare("DELETE FROM products WHERE id = ?");
  $delete->bind_param("i", $id);
  $delete->execute();
}

header("Location: manage_products.php");
exit;