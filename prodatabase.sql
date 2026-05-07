-- 1. Create the database with full UTF-8 support for Arabic text
CREATE DATABASE IF NOT EXISTS saudi_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE saudi_db;

-- 2. Admin Table
CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Note: Storing plain text passwords ('password') is a major security risk. 
-- In a real-world application, you should hash this using PHP's password_hash() function.
INSERT INTO admin (username, password) VALUES ('admin', 'password');

-- 3. Regions Table
CREATE TABLE regions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    image VARCHAR(255)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. Places Table
CREATE TABLE places (
    id INT AUTO_INCREMENT PRIMARY KEY,
    region_id INT,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    image VARCHAR(255),
    -- Added ON DELETE CASCADE so if you delete a region in the admin panel, its places are cleanly removed too
    FOREIGN KEY (region_id) REFERENCES regions(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- data
INSERT INTO regions (id, name, description, image) VALUES 
(1, 'الرياض', 'عاصمة المملكة العربية السعودية ومركزها المالي والإداري. تتميز بتطورها العمراني السريع ومزجها الرائع بين الأصالة التاريخية والمعاصرة الحديثة.', 'riyadh.jpg'),
(2, 'مكة المكرمة', 'أقدس بقاع الأرض وقبلة المسلمين، تحتضن المسجد الحرام والكعبة المشرفة، وتستقبل ملايين الحجاج والمعتمرين من كافة أنحاء العالم سنوياً.', 'mecca.jpg'),
(3, 'العلا', 'متحف التاريخ المفتوح في شمال غرب المملكة، تتميز بآثارها النبطية في مدائن صالح وطبيعتها الصخرية الساحرة.', 'alula.jpg'),
(4, 'الخبر', 'واجهة بحرية حديثة ومدينة نابضة بالحياة في المنطقة الشرقية.', 'khobar.jpg'),
(5, 'أبها', 'مدينة جبلية ذات طبيعة خلابة ومناخ معتدل طوال العام في منطقة عسير.', 'abha.jpg'),
(6, 'تبوك', 'مواقع تاريخية وطبيعة متنوعة تجمع بين البحر، الجبال، والصحراء في شمال المملكة.', 'tabuk.jpg');

INSERT INTO places (region_id, name, description, image) VALUES 
(1, 'قصر المصمك', 'حصن تاريخي مبني من الطين، يمثل نقطة انطلاق توحيد المملكة.', 'masmak.jpg'),
(1, 'الدرعية التاريخية', 'مهد الدولة السعودية الأولى وموقع تراث عالمي مسجل في منظمة اليونسكو.', 'diriyah.jpg'),
(1, 'برج المملكة', 'أحد أبرز المعالم المعمارية في العاصمة، يتميز بتصميمه الفريد وجسر المشاهدة المعلق.', 'kingdom_tower.jpg'),
(2, 'غار حراء', 'الغار الذي نزل فيه الوحي لأول مرة على النبي محمد صلى الله عليه وسلم، ويقع في جبل النور.', 'hira.jpg'),
(2, 'أبراج البيت (برج الساعة)', 'مجمع أبراج يقع بجوار المسجد الحرام، ويضم أطول ساعة في العالم.', 'clock_tower.jpg'),
(3, 'مدائن صالح (الحجر)', 'أول موقع في السعودية يدرج ضمن قائمة اليونسكو للتراث العالمي.', 'hegra.jpg'),
(3, 'قاعة المرايا', 'أكبر مبنى مغطى بالمرايا في العالم، يعكس جمال الطبيعة الصحراوية المحيطة به.', 'maraya.jpg'),
(4, 'مركز إثراء', 'مركز الملك عبدالعزيز الثقافي العالمي، تحفة معمارية ومركز رائد للثقافة والفنون.', 'ithra.jpg'),
(4, 'كورنيش الخبر', 'واجهة بحرية خلابة تضم مساحات خضراء ومرافق ترفيهية تناسب العائلات.', 'khobar_corniche.jpg'),
(5, 'السودة', 'أعلى قمة في المملكة العربية السعودية، تتميز بغابات العرعر والضباب الكثيف.', 'soudah.jpg'),
(5, 'قرية رجال ألمع', 'قرية تراثية مبنية من الحجر والطين، تعكس فن العمارة التقليدية في عسير.', 'rijal_almaa.jpg'),
(6, 'وادي الديسة', 'وادٍ ساحر يتميز بتشكيلاته الصخرية الحمراء وجداول المياه العذبة.', 'disah_valley.jpg'),
(6, 'جبل اللوز', 'من أعلى السلاسل الجبلية في منطقة حسمى، ويشتهر بتساقط الثلوج عليه في فصل الشتاء.', 'jabal_allawz.jpg');
