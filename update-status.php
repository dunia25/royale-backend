<?php
session_start();
include 'db.php';

if (!isset($_SESSION['admin'])) {
  header("Location: admin-login.php");
  exit;
}

$order_id = $_POST['order_id'];
$status = $_POST['status'];

mysqli_query($conn, "UPDATE orders SET status = '$status' WHERE id = $order_id");
header("Location: admin_dashboard.php");
exit;