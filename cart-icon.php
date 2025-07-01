<?php
session_start();
$count = isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0;
?>

<a href="cart.php" style="
  position: fixed;
  bottom: 20px;
  right: 20px;
  font-size: 24px;
  background-color: #fff;
  padding: 10px 16px;
  border: 2px solid #a37b55;
  border-radius: 50px;
  box-shadow: 0 3px 8px rgba(0,0,0,0.1);
  text-decoration: none;
  color: #6e4c2d;
  z-index: 9999;">
  🛒
  <span style="
    position: absolute;
    top: -8px;
    right: -8px;
    background: #d90000;
    color: #fff;
    font-size: 12px;
    font-weight: bold;
    padding: 3px 7px;
    border-radius: 50%;
  ">
    <?= $count ?>
  </span>
</a>