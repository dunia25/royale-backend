<?php
$servername = "sql204.infinityfree.com";
$username   = "if0_39356499";
$password   = "R5lXN1ZJH1ht";
$dbname     = "if0_39356499_beautybd";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
}

$conn->set_charset("utf8");
?>