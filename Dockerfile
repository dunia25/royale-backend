# استخدام صورة PHP مع Apache
FROM php:7.4-apache

# نسخ جميع ملفات المشروع داخل الخادم
COPY . /var/www/html/