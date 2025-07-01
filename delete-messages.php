<?php
session_start();
include 'config.php';

if (isset($_GET['id'])) {
  $id = intval($_GET['id']);
  $stmt = $conn->prepare("DELETE FROM messages WHERE id = ?");
  $stmt->bind_param("i", $id);
  $stmt->execute();
}

header("Location: manage_messages.php");
exit;