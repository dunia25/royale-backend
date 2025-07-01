<?php
$conn = new mysqli("localhost", "root", "", "royale_beauty");
if ($conn->connect_error) {
    die("فشل الاتصال: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");

$html = file_get_contents("index.html");

// تعديل Regex ليستخرج المنتجات بشكل مرن أكثر
preg_match_all(
    '/<div class="product-card">.*?<img[^>]*src="([^"]+)".*?<h3>(.*?)<\/h3>.*?<p[^>]*>(.*?)<\/p>.*?<p class="product-price">\\$?(\d+(?:\.\d{1,2})?)<\/p>/s',
    $html,
    $matches,
    PREG_SET_ORDER
);

$count = 0;
$skipped = [];

foreach ($matches as $product) {
    $image = $conn->real_escape_string(trim($product[1]));
    $name = $conn->real_escape_string(trim($product[2]));
    $description = $conn->real_escape_string(trim($product[3]));
    $price = floatval($product[4]);

    if (!$name || !$price) {
        $skipped[] = $name ?: $image;
        continue;
    }

    $sql = "INSERT INTO products (name, description, price, image) 
            VALUES ('$name', '$description', $price, '$image')";

    if ($conn->query($sql)) {
        $count++;
    } else {
        $skipped[] = $name;
    }
}

$conn->close();

// الطباعة النهائية
echo "✅ تم استيراد <strong>$count</strong> منتج بنجاح.<br>";

if (!empty($skipped)) {
    echo "⚠️ المنتجات التالية لم تتم إضافتها:<br><ul>";
    foreach ($skipped as $fail) {
        echo "<li>$fail</li>";
    }
    echo "</ul>";
} else {
    echo "🎉 تم استيراد كل المنتجات بدون مشاكل!";
}
?>