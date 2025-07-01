<?php
//  دالة لتشفير كلمة السر
function hash_password($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

//  دالة للتحقق من كلمة السر المشفّرة
function verify_password($input, $hashed) {
    return password_verify($input, $hashed);
}

//  دالة لعرض حالة الطلب بشكل مرتب
function get_order_status_label($status) {
    switch($status) {
        case 'pending': return '⏳ قيد المعالجة';
        case 'paid': return '💰 مدفوع';
        case 'shipped': return '📦 تم الشحن';
        case 'delivered': return '✅ تم التوصيل';
        case 'cancelled': return '❌ ملغي';
        default: return '🔍 غير معروف';
    }
}

//  دالة لتنظيف مدخلات المستخدم
function sanitize_input($data) {
    return htmlspecialchars(trim($data));
}

//  دالة لتوليد كود تتبّع عشوائي
function generateTrackingCode($prefix = 'RB') {
    return $prefix . strtoupper(bin2hex(random_bytes(4)));
}

//  دالة لإرسال رسالة من نموذج "اتصل بنا"
function sendContactMessage($name, $email, $message) {
    $to = 'admin@royale-beauty.com'; // بدّليها بإيميلك الحقيقي
    $subject = "رسالة من $name";
    $headers = "From: $email\r\nContent-Type: text/plain; charset=utf-8";
    $body = "الاسم: $name\nالبريد: $email\n\nالرسالة:\n$message";

    return mail($to, $subject, $body, $headers);
}

//  دالة لحساب مجموع السلة
function calculateCartTotal($cart) {
    $total = 0;
    foreach ($cart as $item) {
        $price = (float)$item['price'];
        $qty = (int)$item['quantity'];
        $total += $price * $qty;
    }
    return $total;
}
?>
