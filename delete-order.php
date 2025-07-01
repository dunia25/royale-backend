<?php
session_start();
include 'config.php';

if (!isset($_SESSION['admin'])) {
  header("Location: admin-login.php");
  exit;
}

$order_id = $_GET['id'];

mysqli_query($conn, "DELETE FROM order_items WHERE order_id = $order_id");
mysqli_query($conn, "DELETE FROM orders WHERE id = $order_id");

header("Location: admin_dashboard.php");
exit;