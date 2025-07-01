const express = require("express");
const mongoose = require("mongoose");
const bcrypt = require("bcrypt");
const jwt = require("jsonwebtoken");

const app = express();
app.use(express.json());

mongoose.connect("mongodb://localhost:27017/myDatabase");

// نموذج المستخدم في قاعدة البيانات
const userSchema = new mongoose.Schema({
    username: String,
    email: String,
    password: String
});
const User = mongoose.model("User", userSchema);

// ✅ تسجيل المستخدم مع تشفير كلمة المرور
app.post("/register", async (req, res) => {
    const { username, email, password } = req.body;
    const hashedPassword = await bcrypt.hash(password, 10);
    const newUser = await User.create({ username, email, password: hashedPassword });

    res.status(201).json({ message: `🎉 المستخدم ${username} مسجل بنجاح!` });
});

// ✅ تسجيل الدخول وإصدار JWT
app.post("/login", async (req, res) => {
    const { email, password } = req.body;
    const user = await User.findOne({ email });

    if (!user || !await bcrypt.compare(password, user.password)) {
        return res.status(401).json({ error: "❌ البريد الإلكتروني أو كلمة المرور غير صحيحة" });
    }

    const token = jwt.sign({ userId: user._id }, "mySecretKey", { expiresIn: "2h" });
    res.json({ message: "✅ تسجيل الدخول ناجح!", token });
});

app.listen(5000, () => console.log("🚀 السيرفر يعمل على http://localhost:5000"));

/*اعادة تعيين كلمة المرور*/
app.post("/forgot-password", async (req, res) => {
    const { email } = req.body;
    const user = await User.findOne({ email });

    if (!user) {
        return res.status(404).json({ error: "❌ المستخدم غير موجود!" });
    }

    const resetToken = jwt.sign({ userId: user._id }, "mySecretKey", { expiresIn: "15m" });
    // يمكن إرسال `resetToken` عبر البريد الإلكتروني هنا.

    res.json({ message: "✅ تم إرسال رابط استعادة كلمة المرور!", token: resetToken });
});

/*انشاء صفحة لاستعادة كلمة السر */
app.post("/reset-password", async (req, res) => {
    const { token, newPassword } = req.body;

    try {
        const decoded = jwt.verify(token, "mySecretKey");
        const hashedPassword = await bcrypt.hash(newPassword, 10);
        await User.findByIdAndUpdate(decoded.userId, { password: hashedPassword });

        res.json({ message: "✅ تم إعادة تعيين كلمة المرور بنجاح!" });
    } catch (error) {
        res.status(400).json({ error: "❌ الرابط غير صالح أو انتهت مدته!" });
    }
});

/*اضافة اشعار بعد تغيير كلمة المرور*/
app.post("/reset-password", async (req, res) => {
    const { token, newPassword } = req.body;

    try {
        const decoded = jwt.verify(token, "mySecretKey");
        const hashedPassword = await bcrypt.hash(newPassword, 10);
        await User.findByIdAndUpdate(decoded.userId, { password: hashedPassword });

        res.json({ message: "✅ تم إعادة تعيين كلمة المرور بنجاح! يمكنك الآن تسجيل الدخول." });
    } catch (error) {
        res.status(400).json({ error: "❌ الرابط غير صالح أو انتهت مدته!" });
    }
});


/*ادارة الطلبات والتوصيل */
app.post("/order", async (req, res) => {
    const { userId, paymentMethod, deliveryOption } = req.body;
    const newOrder = await Order.create({ userId, paymentMethod, deliveryOption, status: "pending" });

    res.status(201).json({ message: "✅ الطلب مسجل بنجاح!", orderId: newOrder._id });
});

app.get("/order/:id", async (req, res) => {
    const order = await Order.findById(req.params.id);
    if (!order) return res.status(404).json({ error: "❌ الطلب غير موجود!" });

    res.json(order);
});

/*دمج عمليات الدفع */
const paypal = require('@paypal/checkout-server-sdk');

app.post("/process-payment", async (req, res) => {
    // ربط البيانات وإرسال الطلب إلى PayPal للمعالجة
});

/*نظام نقاط الولاء*/
app.post("/apply-loyalty", async (req, res) => {
    const { userId, orderValue } = req.body;
    const pointsEarned = Math.floor(orderValue / 10); // كل 10$ = نقطة
    await User.findByIdAndUpdate(userId, { $inc: { loyaltyPoints: pointsEarned } });

    res.json({ message: `✅ تم إضافة ${pointsEarned} نقاط إلى حسابك!` });
});

//جلب ال API
app.get("/analytics/orders", async (req, res) => {
    const totalOrders = await Order.countDocuments();
    const totalUsers = await User.countDocuments();

    const allOrders = await Order.find();
    const paymentMethods = {};
    allOrders.forEach(order => {
        paymentMethods[order.paymentMethod] = (paymentMethods[order.paymentMethod] || 0) + 1;
    });

    const topPayment = Object.entries(paymentMethods).sort((a, b) => b[1] - a[1])[0][0];

    // عدد الطلبات حسب اليوم لآخر 7 أيام
    const pastWeek = [...Array(7)].map((_, i) => {
        const day = new Date();
        day.setDate(day.getDate() - (6 - i));
        return day.toISOString().slice(0, 10);
    });

    const counts = await Promise.all(pastWeek.map(async date => {
        const count = await Order.countDocuments({ createdAt: { $regex: `^${date}` } });
        return { day: date, count };
    }));

    res.json({ totalOrders, totalUsers, topPayment, week: counts });
});

// جلب API لحالة الطلب
app.get("/order-location/:id", async (req, res) => {
    const order = await Order.findById(req.params.id);
    if (!order || !order.location) return res.status(404).json({ error: "❌ الطلب غير موجود أو لا يحتوي على موقع!" });

    res.json({ location: order.location });
});


//ارسال رمز التأكيد عند تسجيل الدخول 
const nodemailer = require("nodemailer");

app.post("/send-otp", async (req, res) => {
    const { email } = req.body;
    const otp = Math.floor(100000 + Math.random() * 900000); // رمز عشوائي 6 أرقام

    // إعداد البريد الإلكتروني
    const transporter = nodemailer.createTransport({
        service: "gmail",
        auth: { user: "your-email@gmail.com", pass: "your-password" }
    });

    await transporter.sendMail({
        from: "your-email@gmail.com",
        to: email,
        subject: "رمز التحقق",
        text: `رمز التحقق الخاص بك هو: ${otp}`
    });

    res.json({ message: "✅ تم إرسال رمز التحقق!" });
});

//اعداد الدردشة 
const io = require("socket.io")(server);

io.on("connection", (socket) => {
    socket.on("message", (data) => {
        io.emit("message", data); // بث الرسالة للجميع
    });
});

//انشاء API البحث 
app.get("/search", async (req, res) => {
    const query = req.query.q;
    const searchQuery = `SELECT * FROM products WHERE name LIKE ?`;
    
    db.query(searchQuery, [`%${query}%`], (err, results) => {
        if (err) res.status(500).json({ error: "❌ خطأ في البحث!" });
        else res.json(results);
    });
});