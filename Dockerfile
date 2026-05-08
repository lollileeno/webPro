# استخدام نسخة PHP الرسمية مع خادم Apache
FROM php:8.1-apache

# تثبيت المكتبات اللازمة لـ PostgreSQL
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# تفعيل mod_rewrite في أباتشي
RUN a2enmod rewrite

# نسخ ملفات المشروع إلى مجلد السيرفر
COPY . /var/www/html/

# إعطاء الصلاحيات لمجلد الصور
RUN chown -R www-data:www-data /var/www/html/images
RUN chmod -R 755 /var/www/html/images

EXPOSE 80
