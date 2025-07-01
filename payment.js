function showPaymentDetails(method) {
    let paymentBox = document.getElementById("payment-box");
    paymentBox.style.display = "block";
    paymentBox.innerHTML = ""; 

    if (method === "credit-card") {
        paymentBox.innerHTML = `
            <h3>💳 بيانات بطاقة الائتمان</h3>
            <label>رقم البطاقة: <input type="text" placeholder="XXXX XXXX XXXX XXXX"></label>
            <label>تاريخ الانتهاء: <input type="text" placeholder="MM/YY"></label>
            <label>رمز CVV: <input type="text" placeholder="XXX"></label>
        `;
    } else if (method === "bank-transfer") {
        paymentBox.innerHTML = `
            <h3>🏦 الدفع عبر التحويل البنكي</h3>
            <label>اسم البنك: <input type="text" placeholder="أدخل اسم البنك"></label>
            <label>رقم الحساب: <input type="text" placeholder="XXXX XXXX XXXX"></label>
            <label>رمز SWIFT: <input type="text" placeholder="SWIFT CODE"></label>
        `;
    } else if (method === "paypal") {
        paymentBox.innerHTML = `
            <h3>🅿️ الدفع عبر PayPal</h3>
            <label>بريد PayPal: <input type="email" placeholder="example@paypal.com"></label>
            <label>كلمة المرور: <input type="password" placeholder="••••••"></label>
        `;
    } else if (method === "mobile-payment") {
        paymentBox.innerHTML = `
            <h3>📱 الدفع عبر الهاتف</h3>
            <label>رقم الهاتف: <input type="text" placeholder="أدخل رقم الهاتف"></label>
            <label>مزود الخدمة: 
                <select>
                    <option value="mtn">MTN</option>
                    <option value="syriatel">Syriatel</option>
                </select>
            </label>
        `;
    } else if (method === "cash-on-delivery") {
        paymentBox.innerHTML = `
            <h3>💵 الدفع عند الاستلام</h3>
            <p>🚚 سيتم دفع المبلغ نقدًا عند استلام الطلب.</p>
        `;
    }
}

function processPayment() {
    alert("✅ تم إرسال بيانات الدفع بنجاح!");
}