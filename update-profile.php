<div class="profile-form">
  <h2>تعديل معلومات الحساب</h2>

  <form action="update-profile.php" method="post">
    
    <div class="form-box">
      <label for="email">📧 البريد الإلكتروني</label>
      <input type="email" id="email" name="email" required>
    </div>

    <div class="form-box">
      <label for="new_password">🔒 كلمة سر جديدة (اختياري)</label>
      <input type="password" id="new_password" name="new_password">
    </div>

    <div class="form-box">
      <label for="current_password">🔐 كلمة السر الحالية</label>
      <input type="password" id="current_password" name="current_password" required>
    </div>

    <button type="submit">💾 حفظ التغييرات</button>
    <a class="back-link" href="profile.php">⟵ الرجوع للملف</a>
  </form>
</div>

<style>
body {
  background-color: #fdf7f1;
  font-family: 'Cairo', sans-serif;
  direction: rtl;
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  margin: 0;
  padding: 0;
}

.profile-form {
  background-color: #f3efea;
  padding: 40px 30px;
  border-radius: 12px;
  width: 380px;
  box-shadow: 0 0 15px rgba(139, 103, 73, 0.1);
  text-align: center;
}

.profile-form h2 {
  margin-bottom: 30px;
  color: #8d5c3c;
}

.form-box {
  background-color: #fffaf5;
  border: 1px solid #e3d6c7;
  border-radius: 10px;
  padding: 18px;
  margin-bottom: 20px;
  text-align: right;
}

.form-box label {
  display: block;
  margin-bottom: 8px;
  font-size: 14px;
  color: #5a4031;
  font-weight: bold;
}

.form-box input {
  width: 100%;
  padding: 12px;
  border: 1px solid #ccc2b7;
  border-radius: 6px;
  font-size: 15px;
  background-color: #ffffff;
}

button {
  width: 100%;
  padding: 14px;
  background-color: #b48a6b;
  color: white;
  border: none;
  border-radius: 6px;
  font-weight: bold;
  font-size: 15px;
  cursor: pointer;
  transition: background-color 0.3s;
  margin-top: 10px;
}

button:hover {
  background-color: #a9745a;
}

.back-link {
  display: block;
  margin-top: 20px;
  font-size: 14px;
  color: #805c47;
  text-decoration: underline;
}
</style>