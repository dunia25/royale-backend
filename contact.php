<!DOCTYPE html>
<html lang="ar">
<head>
  <meta charset="UTF-8">
  <title>تواصل معنا</title>
  <style>
    * {
      box-sizing: border-box;
      font-family: 'Cairo', sans-serif;
    }

    body {
      background-color: #f9f6f1;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
    }

    .contact-wrapper {
      background: #fff;
      padding: 40px;
      max-width: 700px;
      width: 95%;
      border-radius: 16px;
      box-shadow: 0 0 30px rgba(160, 130, 100, 0.07);
      direction: rtl;
      color: #5a3d2f;
    }

    .contact-wrapper h2 {
      margin-bottom: 24px;
      color: #7a4c2f;
      font-size: 28px;
      text-align: center;
    }

    .contact-wrapper form input,
    .contact-wrapper form textarea {
      width: 100%;
      padding: 14px;
      margin-bottom: 16px;
      border: 1px solid #e2d2c4;
      border-radius: 10px;
      font-size: 15px;
      background-color: #fdfaf4;
    }

    .contact-wrapper form textarea {
      resize: vertical;
      min-height: 120px;
    }

    .contact-wrapper button {
      width: 100%;
      background-color: #8a5a3b;
      color: #fff;
      padding: 14px;
      font-size: 16px;
      border: none;
      border-radius: 10px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .contact-wrapper button:hover {
      background-color: #a16a49;
    }

    .contact-info {
      margin-top: 25px;
      font-size: 14px;
      line-height: 2;
      color: #444;
    }

    .contact-info strong {
      color: #7a4c2f;
    }
  </style>
</head>
<body>

<div class="contact-wrapper">
  <h2>📬 تواصل معنا</h2>
  <form onsubmit="alert('✨ النموذج للعرض فقط'); return false;">
  <input type="text" name="name" placeholder="الاسم الكامل" required>
    <input type="email" name="email" placeholder="البريد الإلكتروني" required>
    <input type="text" name="subject" placeholder="الموضوع" required>
    <textarea name="message" placeholder="اكتبي رسالتك هنا..." required></textarea>
    <button type="submit">📨 إرسال</button>
  </form>

  <div class="contact-info">
    <p><strong>📍 العنوان:</strong> دمشق - الصالحية</p>
    <p><strong>📧 البريد:</strong> support@royalebeauty.com</p>
    <p><strong>📞 الهاتف:</strong> +963 999 123 456</p>
    <p><strong>📸 انستغرام:</strong> @royalebeauty</p>
  </div>
</div>

</body>
</html>