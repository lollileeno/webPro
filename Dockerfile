# استخدام نسخة PHP الرسمية مع خادم Apache
FROM php:8.1-apache

# تفعيل إضافة mysqli للاتصال بقاعدة البيانات
RUN docker-php-ext-install mysqli
RUN docker-php-ext-enable mysqli

# تفعيل mod_rewrite في أباتشي (مهم للروابط)
RUN a2enmod rewrite

# نسخ ملفات المشروع إلى مجلد السيرفر
COPY . /var/www/html/

# إعطاء الصلاحيات لمجلد الصور لكي تنجح عملية الرفع
RUN chown -R www-data:www-data /var/www/html/images
RUN chmod -R 755 /var/www/html/images

# فتح المنفذ 80
EXPOSE 80
