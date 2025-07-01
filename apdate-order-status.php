<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = intval($_POST['order_id']);
    $payment = $_POST['payment_status'];
    $shipping = $_POST['shipping_status'];

    $stmt = $conn->prepare("UPDATE orders SET payment_status=?, shipping_status=? WHERE id=?");
    $stmt->bind_param("ssi", $payment, $shipping, $order_id);
    $stmt->execute();
}

header("Location: manage_orders.php");
exit;