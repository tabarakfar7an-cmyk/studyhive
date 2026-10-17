-- StudyHive database (MySQL / MariaDB)
-- استيراد: phpMyAdmin > Import، أو: mysql -u root < studyhive.sql
SET NAMES utf8mb4;
CREATE DATABASE IF NOT EXISTS `studyhive` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `studyhive`;
SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS forum_replies, forum_posts, saved_courses, resources, support_requests, courses, users;
SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE users (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(30) NOT NULL UNIQUE,
  email VARCHAR(100) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  role ENUM('student','admin') NOT NULL DEFAULT 'student',
  major VARCHAR(60) NOT NULL DEFAULT 'هندسة الحاسوب',
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE courses (
  course_code VARCHAR(30) NOT NULL PRIMARY KEY,
  title VARCHAR(100) NOT NULL,
  description VARCHAR(255) NOT NULL,
  plan VARCHAR(500) NOT NULL,
  category VARCHAR(100) NOT NULL,
  featured TINYINT NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE saved_courses (
  user_id INT UNSIGNED NOT NULL,
  course_code VARCHAR(30) NOT NULL,
  PRIMARY KEY (user_id, course_code),
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (course_code) REFERENCES courses(course_code) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE resources (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  course_code VARCHAR(30) NOT NULL,
  title VARCHAR(150) NOT NULL,
  url VARCHAR(500) NOT NULL,
  type ENUM('book','video','course','docs','practice') NOT NULL DEFAULT 'book',
  description VARCHAR(255) NOT NULL DEFAULT '',
  status ENUM('approved','pending') NOT NULL DEFAULT 'approved',
  submitted_by INT UNSIGNED NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (course_code) REFERENCES courses(course_code) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (submitted_by) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE forum_posts (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  user_id INT UNSIGNED NOT NULL,
  title VARCHAR(120) NOT NULL,
  content TEXT NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE forum_replies (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  post_id INT UNSIGNED NOT NULL,
  user_id INT UNSIGNED NOT NULL,
  content TEXT NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (post_id) REFERENCES forum_posts(id) ON DELETE CASCADE,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE support_requests (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  user_id INT UNSIGNED NULL,
  name VARCHAR(60) NOT NULL,
  email VARCHAR(100) NOT NULL,
  topic VARCHAR(100) NOT NULL,
  message TEXT NOT NULL,
  status ENUM('open','resolved') NOT NULL DEFAULT 'open',
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- بيانات أولية
INSERT INTO users (username,email,password,role) VALUES
('admin','admin@studyhive.com','$2y$10$cJDnUa8mVLBRiIBOlWjDxuS2MANgPL8/KeYx4du.mzdeM1lLC/03u','admin'),
('salah','salah@gmail.com','$2y$10$ChgMKNVa3/JH8A7/5geeXuLfWl3cGSM7vRvTQ3xn2llmpOOsUO5RG','student'),
('heba','heba@gmail.com','$2y$10$5Y0pl5v3WuOGXsnRLdFQx.bSIIVA1IAaenDHuaPFpWJMFbDfSjWMO','student'),
('yusuf','yusuf@gmail.com','$2y$10$ldWeTKq15Khbqr7Ec4xBq.U4VsXk5a79MbArG3G8UsrDwd7AOh5Qe','student');

INSERT INTO courses (course_code,title,description,plan,category,featured) VALUES
('MATH101','MATH 101 - Calculus 1','حساب التفاضل والتكامل 1.','خطة مقترحة: 1. دراسة الأسس الرياضية 2. تعلم قواعد التفاضل 3. تطبيقات عملية لحساب التفاضل.','الرياضيات والعلوم الأساسية',0),
('MATH102','MATH 102 - Calculus 2','حساب التفاضل والتكامل 2.','خطة مقترحة: 1. دراسة التكاملات 2. تطبيقات التكامل 3. التوسع في المفاهيم.','الرياضيات والعلوم الأساسية',0),
('MATH152','MATH 152 - Discrete Math','الرياضيات المنفصلة.','خطة مقترحة: 1. دراسة التراكيب الرياضية المنفصلة 2. تعلم المنطق الرياضي 3. تطبيقات على الخوارزميات.','تحليل وتصميم الخوارزميات',0),
('MATH205','MATH 205 - Differential Equations','المعادلات التفاضلية.','خطة مقترحة: 1. دراسة المعادلات التفاضلية 2. تطبيقات المعادلات في مختلف العلوم 3. حل معادلات تفاضلية باستخدام الطرق الرياضية.','الرياضيات والعلوم الأساسية',0),
('CHEM101E','CHEM 101E - Chemistry 1','الكيمياء 1.','خطة مقترحة: 1. دراسة الأساسيات الكيميائية 2. تعلم التفاعلات الكيميائية الأساسية 3. تطبيقات عملية في الكيمياء.','الرياضيات والعلوم الأساسية',0),
('PHYS101','PHYS 101 - Physics 1','الفيزياء 1.','خطة مقترحة: 1. دراسة قوانين الحركة 2. تعلم تطبيقات فيزيائية على الأرض 3. دراسة الطاقة والقوى.','الرياضيات والعلوم الأساسية',0),
('PHYS102','PHYS 102 - Physics 2','الفيزياء 2.','خطة مقترحة: 1. دراسة الموجات 2. تعلم تطبيقات الموجات على الفيزياء 3. حل تدريبات لتثبيت المفاهيم.','الرياضيات والعلوم الأساسية',0),
('PHYS105','PHYS 105 - Physics 1 Lab','مختبر الفيزياء 1 - تجارب عملية لدراسة الفيزياء.','خطة مقترحة: 1. تطبيق المفاهيم الفيزيائية عمليًا 2. إجراء تجارب لتوضيح المفاهيم الأساسية 3. استخدام الأدوات المختبرية.','الرياضيات والعلوم الأساسية',0),
('PHYS106','PHYS 106 - Physics 2 Lab','مختبر الفيزياء 2 - تجارب عملية لدراسة الفيزياء 2.','خطة مقترحة: 1. تجربة مفاهيم الموجات 2. استخدام الأدوات المتقدمة في المختبر 3. دراسة نتائج التجارب.','الرياضيات والعلوم الأساسية',0),
('CPE150','CPE 150 - C++','برمجة باستخدام C++.','خطة مقترحة: 1. تعلم أساسيات لغة C++ 2. كتابة برامج بسيطة 3. تطبيقات على البرمجة الكائنية.','برمجة الحاسوب',0),
('CPE150L','CPE 150L - C++ Lab','مختبر C++ - تطبيقات عملية على البرمجة.','خطة مقترحة: 1. تطبيق مشاريع برمجية باستخدام C++ 2. تعلم تطبيقات البرمجة الكائنية 3. حل مشاكل برمجية.','برمجة الحاسوب',0),
('CPE230','CPE 230 - Digital Logic','المنطق الرقمي.','خطة مقترحة: 1. تعلم أساسيات المنطق الرقمي 2. دراسة البوابات المنطقية 3. تصميم دوائر منطقية باستخدام الخوارزميات.','تصميم الأنظمة المدمجة',0),
('CPE231','CPE 231 - Digital Logic Lab','مختبر المنطق الرقمي.','خطة مقترحة: 1. بناء دوائر منطقية باستخدام الأجهزة الإلكترونية 2. دراسة حالات معملية لمنطق البوابات 3. تدريب عملي على تصميم الدوائر.','تصميم الأنظمة المدمجة',0),
('CPE344','CPE 344 - Microprocessors','المعالجات الدقيقة.','خطة مقترحة: 1. دراسة بناء المعالجات الدقيقة 2. فهم كيفية عمل المعالج في الأنظمة الإلكترونية 3. تطبيقات عملية على استخدام المعالجات.','تصميم الأنظمة المدمجة',0),
('CPE345','CPE 345 - Microprocessors Lab','مختبر المعالجات الدقيقة.','خطة مقترحة: 1. تطبيقات عملية على استخدام المعالجات الدقيقة 2. تعلم تصميم الأنظمة باستخدام المعالجات 3. تنفيذ مشاريع عملية على أجهزة حقيقية.','تصميم الأنظمة المدمجة',0),
('CPE364','CPE 364 - Data Structures','هياكل البيانات.','خطة مقترحة: 1. دراسة هياكل البيانات الأساسية 2. تعلم كيفية تطبيقها في البرمجة 3. دراسة هياكل البيانات المتقدمة مثل الأشجار والقوائم المرتبطة.','تحليل وتصميم الخوارزميات',0),
('CPE354L','CPE 354L - Data Structures Lab','مختبر هياكل البيانات.','خطة مقترحة: 1. تطبيق هياكل البيانات في مشاريع برمجية 2. تعلم كيفية حل المشكلات باستخدام هياكل البيانات 3. بناء تطبيقات عملية.','تحليل وتصميم الخوارزميات',0),
('CPE440','CPE 440 - Computer Architecture','معمارية الحاسوب.','خطة مقترحة: 1. دراسة كيفية تصميم المعالجات 2. تعلم مفهوم العمليات الأساسية في الحاسوب 3. دراسة هيكلية الأنظمة الرقمية.','تصميم الأنظمة المدمجة',1),
('CPE441','CPE 441 - Computer Architecture Lab','مختبر معمارية الحاسوب.','خطة مقترحة: 1. تطبيق مفاهيم معمارية الحاسوب في بيئات مختبرية 2. تصميم وحدات المعالجة 3. تعلم كيفية تطوير وتحسين الأنظمة الحاسوبية.','تصميم الأنظمة المدمجة',0),
('CPE460','CPE 460 - Operating Systems','أنظمة التشغيل.','خطة مقترحة: 1. دراسة كيفية عمل أنظمة التشغيل 2. تعلم إدارة الموارد الحاسوبية 3. دراسة أنواع أنظمة التشغيل وتطبيقاتها.','نظم التشغيل',1),
('CPE460L','CPE 460L - Operating Systems Lab','مختبر أنظمة التشغيل.','خطة مقترحة: 1. تنفيذ مشاريع مختبرية على أنظمة التشغيل 2. تعلم كيفية استخدام أدوات التحكم في الأنظمة 3. تطبيق عملي على إدارة الموارد.','نظم التشغيل',0),
('CPE466','CPE 466 - Signal Processing','معالجة الإشارات.','خطة مقترحة: 1. دراسة معالجة الإشارات الرقمية 2. تعلم طرق تحليل الإشارات 3. تطبيقات عملية على معالجة الصوت والصورة.','معالجة الإشارات',0),
('CPE466L','CPE 466L - Signal Processing Lab','مختبر معالجة الإشارات.','خطة مقترحة: 1. تطبيق الأساليب العملية في معالجة الإشارات 2. استخدام الأدوات البرمجية لتحليل الإشارات 3. مشاريع تطبيقية في معالجة الصوت والصورة.','معالجة الإشارات',0),
('CPE562','CPE 562 - Networks','الشبكات.','خطة مقترحة: 1. دراسة بروتوكولات الشبكة 2. تعلم كيفية إدارة الشبكات 3. تصميم شبكات أنظمة الكمبيوتر.','أمن المعلومات والشبكات',1),
('CPE563','CPE 563 - Networks Lab','مختبر الشبكات.','خطة مقترحة: 1. تطبيق عملي لبروتوكولات الشبكة 2. تحليل الأداء الشبكي 3. تعلم كيفية تحسين الشبكات.','أمن المعلومات والشبكات',0),
('CPE576','CPE 576 - Artificial Intelligence','الذكاء الاصطناعي.','خطة مقترحة: 1. دراسة أساسيات الذكاء الاصطناعي والبحث 2. تعلم الخوارزميات الذكية وتعلم الآلة 3. تطبيقات عملية ومشاريع صغيرة.','الذكاء الاصطناعي وتعلم الآلة',0),
('CPE578','CPE 578 - Cyber Security','أمن المعلومات.','خطة مقترحة: 1. دراسة مبادئ أمن المعلومات والتشفير 2. تعلم تقنيات الحماية واستراتيجيات الأمان 3. تطبيقات عملية على اختبار الاختراق الأخلاقي.','أمن المعلومات والشبكات',0);

INSERT INTO resources (course_code,title,url,type,description,status) VALUES
('MATH101','MIT OCW 18.01SC Single Variable Calculus','https://ocw.mit.edu/courses/18-01sc-single-variable-calculus-fall-2010/','course','مقرر كامل من MIT في تفاضل وتكامل المتغير الواحد مع محاضرات وتمارين محلولة.','approved'),
('MATH101','Khan Academy: Calculus 1','https://www.khanacademy.org/math/calculus-1','video','شروحات فيديو وتمارين تفاعلية تغطي النهايات والاشتقاق وتطبيقاته.','approved'),
('MATH101','Paul''s Online Math Notes: Calculus I','https://tutorial.math.lamar.edu/Classes/CalcI/CalcI.aspx','book','ملاحظات مفصلة مع أمثلة محلولة في حساب التفاضل والنهايات.','approved'),
('MATH101','OpenStax Calculus Volume 1','https://openstax.org/details/books/calculus-volume-1','book','كتاب جامعي مجاني في الكالكولس 1 يمكن تحميله أو قراءته على الإنترنت.','approved'),
('MATH102','Khan Academy: Integral Calculus','https://www.khanacademy.org/math/integral-calculus','video','دروس وتمارين في التكامل وتقنياته وتطبيقاته والمتسلسلات.','approved'),
('MATH102','Paul''s Online Math Notes: Calculus II','https://tutorial.math.lamar.edu/Classes/CalcII/CalcII.aspx','book','شرح مفصل لتقنيات التكامل والمتتاليات والمتسلسلات والإحداثيات القطبية.','approved'),
('MATH102','OpenStax Calculus Volume 2','https://openstax.org/details/books/calculus-volume-2','book','كتاب مجاني يغطي التكامل والمتسلسلات والمعادلات الوسيطية.','approved'),
('MATH102','MIT OCW 18.02SC Multivariable Calculus','https://ocw.mit.edu/courses/18-02sc-multivariable-calculus-fall-2010/','course','مقرر MIT في التفاضل والتكامل متعدد المتغيرات يكمل مادة الكالكولس 2.','approved'),
('MATH152','MIT OCW 6.042J Mathematics for Computer Science','https://ocw.mit.edu/courses/6-042j-mathematics-for-computer-science-spring-2015/','course','مقرر MIT في الرياضيات المتقطعة موجه لعلوم وهندسة الحاسوب.','approved'),
('MATH152','Discrete Mathematics: An Open Introduction','https://discrete.openmathbooks.org/dmoi3.html','book','كتاب مفتوح مجاني في الرياضيات المتقطعة مع تمارين وأمثلة.','approved'),
('MATH205','Paul''s Online Math Notes: Differential Equations','https://tutorial.math.lamar.edu/Classes/DE/DE.aspx','book','شرح خطوة بخطوة للمعادلات التفاضلية من الرتبة الأولى والثانية وتحويل لابلاس.','approved'),
('MATH205','MIT OCW 18.03SC Differential Equations','https://ocw.mit.edu/courses/18-03sc-differential-equations-fall-2011/','course','مقرر MIT كامل في المعادلات التفاضلية مع فيديوهات وتمارين.','approved'),
('MATH205','Khan Academy: Differential Equations','https://www.khanacademy.org/math/differential-equations','video','دروس مبسطة في المعادلات التفاضلية وطرق حلها.','approved'),
('MATH205','OpenStax Calculus Volume 3','https://openstax.org/details/books/calculus-volume-3','book','كتاب مجاني يتضمن فصلا عن المعادلات التفاضلية من الرتبة الثانية.','approved'),
('CHEM101E','OpenStax Chemistry 2e','https://openstax.org/details/books/chemistry-2e','book','كتاب كيمياء عامة جامعي مجاني مع أمثلة وتمارين.','approved'),
('CHEM101E','MIT OCW 5.111SC Principles of Chemical Science','https://ocw.mit.edu/courses/5-111sc-principles-of-chemical-science-fall-2014/','course','مقرر MIT في مبادئ الكيمياء مع محاضرات فيديو وتمارين.','approved'),
('CHEM101E','Khan Academy: Chemistry','https://www.khanacademy.org/science/chemistry','video','دروس فيديو وتمارين تغطي الذرة والروابط والتفاعلات والاتزان.','approved'),
('CHEM101E','PhET Chemistry Simulations','https://phet.colorado.edu/en/simulations/category/chemistry','practice','محاكاة تفاعلية مجانية لفهم مفاهيم الكيمياء عمليا.','approved'),
('PHYS101','OpenStax University Physics Volume 1','https://openstax.org/details/books/university-physics-volume-1','book','كتاب جامعي مجاني في الميكانيكا والحرارة والموجات.','approved'),
('PHYS101','MIT OCW 8.01SC Classical Mechanics','https://ocw.mit.edu/courses/8-01sc-classical-mechanics-fall-2016/','course','مقرر MIT في الميكانيكا الكلاسيكية مع فيديوهات وحل مسائل.','approved'),
('PHYS101','Khan Academy: Physics','https://www.khanacademy.org/science/physics','video','شروحات فيديو وتمارين في الفيزياء الميكانيكية والكهربائية.','approved'),
('PHYS101','PhET Physics Simulations','https://phet.colorado.edu/en/simulations/category/physics','practice','محاكاة تفاعلية مجانية تفيد في فهم التجارب المخبرية الفيزيائية.','approved'),
('PHYS102','OpenStax University Physics Volume 2','https://openstax.org/details/books/university-physics-volume-2','book','كتاب جامعي مجاني في الكهرباء والمغناطيسية والبصريات.','approved'),
('PHYS102','MIT OCW 8.02 Electricity and Magnetism','https://ocw.mit.edu/courses/8-02-physics-ii-electricity-and-magnetism-spring-2007/','course','مقرر MIT في الكهرباء والمغناطيسية يتضمن تجارب ومحاضرات.','approved'),
('PHYS102','Khan Academy: Physics','https://www.khanacademy.org/science/physics','video','شروحات فيديو وتمارين في الفيزياء الميكانيكية والكهربائية.','approved'),
('PHYS102','PhET Physics Simulations','https://phet.colorado.edu/en/simulations/category/physics','practice','محاكاة تفاعلية مجانية تفيد في فهم التجارب المخبرية الفيزيائية.','approved'),
('PHYS105','PhET Physics Simulations','https://phet.colorado.edu/en/simulations/category/physics','practice','محاكاة تفاعلية مجانية تفيد في فهم التجارب المخبرية الفيزيائية.','approved'),
('PHYS105','MIT OCW 8.01SC Classical Mechanics','https://ocw.mit.edu/courses/8-01sc-classical-mechanics-fall-2016/','course','مقرر MIT في الميكانيكا الكلاسيكية مع فيديوهات وحل مسائل.','approved'),
('PHYS105','OpenStax University Physics Volume 1','https://openstax.org/details/books/university-physics-volume-1','book','كتاب جامعي مجاني في الميكانيكا والحرارة والموجات.','approved'),
('PHYS106','PhET Physics Simulations','https://phet.colorado.edu/en/simulations/category/physics','practice','محاكاة تفاعلية مجانية تفيد في فهم التجارب المخبرية الفيزيائية.','approved'),
('PHYS106','MIT OCW 8.02 Electricity and Magnetism','https://ocw.mit.edu/courses/8-02-physics-ii-electricity-and-magnetism-spring-2007/','course','مقرر MIT في الكهرباء والمغناطيسية يتضمن تجارب ومحاضرات.','approved'),
('PHYS106','OpenStax University Physics Volume 2','https://openstax.org/details/books/university-physics-volume-2','book','كتاب جامعي مجاني في الكهرباء والمغناطيسية والبصريات.','approved'),
('CPE150','learncpp.com','https://www.learncpp.com/','book','أفضل موقع مجاني لتعلم C++ الحديثة من الصفر حتى المتقدم.','approved'),
('CPE150','cppreference.com C++ Reference','https://en.cppreference.com/w/cpp','docs','المرجع الرسمي غير الرسمي الأشهر للغة C++ ومكتباتها القياسية.','approved'),
('CPE150','cplusplus.com Tutorial','https://cplusplus.com/doc/tutorial/','docs','دليل تعليمي مختصر لأساسيات لغة C++ مع أمثلة.','approved'),
('CPE150','Get Started with C++ (isocpp.org)','https://isocpp.org/get-started','docs','دليل البدء الرسمي من مؤسسة ISO C++ يشمل المترجمات والكتب.','approved'),
('CPE150L','Compiler Explorer','https://godbolt.org/','practice','مترجم أونلاين لتجربة أكواد C++ وعرض ناتج لغة التجميع.','approved'),
('CPE150L','Exercism C++ Track','https://www.exercism.org/tracks/cpp','practice','تمارين برمجة مجانية بلغة C++ مع مراجعة ذاتية.','approved'),
('CPE150L','HackerRank C++ Practice','https://www.hackerrank.com/domains/cpp','practice','مسائل تدريبية متدرجة بلغة C++.','approved'),
('CPE150L','learncpp.com','https://www.learncpp.com/','book','أفضل موقع مجاني لتعلم C++ الحديثة من الصفر حتى المتقدم.','approved'),
('CPE230','Nand2Tetris','https://www.nand2tetris.org/','course','مقرر لبناء حاسوب كامل من البوابات المنطقية حتى النظام.','approved'),
('CPE230','MIT OCW 6.004 Computation Structures','https://ocw.mit.edu/courses/6-004-computation-structures-spring-2017/','course','مقرر MIT يغطي المنطق الرقمي وتصميم المعالج وبنية الحاسوب.','approved'),
('CPE230','Wikibooks: Digital Circuits','https://en.wikibooks.org/wiki/Digital_Circuits','book','كتاب مفتوح يشرح الدوائر الرقمية والجبر البولياني والمنطق التتابعي.','approved'),
('CPE230','CircuitVerse','https://circuitverse.org/','practice','محاكي دوائر منطقية رقمية أونلاين مجاني لتجربة التصاميم.','approved'),
('CPE231','CircuitVerse','https://circuitverse.org/','practice','محاكي دوائر منطقية رقمية أونلاين مجاني لتجربة التصاميم.','approved'),
('CPE231','Falstad Circuit Simulator','https://www.falstad.com/circuit/','practice','محاكي دوائر تفاعلي يعمل في المتصفح لتجربة الدوائر الكهربائية والرقمية.','approved'),
('CPE231','Tinkercad Circuits','https://www.tinkercad.com/circuits','practice','محاكاة دوائر إلكترونية وArduino مجانا في المتصفح.','approved'),
('CPE231','MIT OCW 6.111 Introductory Digital Systems Laboratory','https://ocw.mit.edu/courses/6-111-introductory-digital-systems-laboratory-spring-2006/','course','مختبر MIT للأنظمة الرقمية مع تجارب ومشاريع.','approved'),
('CPE344','Guide to x86 Assembly (UVA)','https://www.cs.virginia.edu/~evans/cs216/guides/x86.html','docs','دليل مختصر وواضح للغة التجميع x86 والمسجلات والتعليمات.','approved'),
('CPE344','x86 and AMD64 Instruction Reference','https://www.felixcloutier.com/x86/','docs','مرجع لتعليمات x86 مشتق من دليل Intel الرسمي.','approved'),
('CPE344','Arduino Documentation: Learn','https://docs.arduino.cc/learn/','docs','وثائق Arduino الرسمية لتعلم برمجة المتحكمات الدقيقة.','approved'),
('CPE344','MIT OCW 6.004 Computation Structures','https://ocw.mit.edu/courses/6-004-computation-structures-spring-2017/','course','مقرر MIT يغطي المنطق الرقمي وتصميم المعالج وبنية الحاسوب.','approved'),
('CPE345','Arduino Documentation: Learn','https://docs.arduino.cc/learn/','docs','وثائق Arduino الرسمية لتعلم برمجة المتحكمات الدقيقة.','approved'),
('CPE345','Tinkercad Circuits','https://www.tinkercad.com/circuits','practice','محاكاة دوائر إلكترونية وArduino مجانا في المتصفح.','approved'),
('CPE345','Guide to x86 Assembly (UVA)','https://www.cs.virginia.edu/~evans/cs216/guides/x86.html','docs','دليل مختصر وواضح للغة التجميع x86 والمسجلات والتعليمات.','approved'),
('CPE345','x86 and AMD64 Instruction Reference','https://www.felixcloutier.com/x86/','docs','مرجع لتعليمات x86 مشتق من دليل Intel الرسمي.','approved'),
('CPE364','Open Data Structures','https://opendatastructures.org/','book','كتاب مفتوح يشرح هياكل البيانات وتحليلها مع شيفرات برمجية.','approved'),
('CPE364','MIT OCW 6.006 Introduction to Algorithms','https://ocw.mit.edu/courses/6-006-introduction-to-algorithms-spring-2020/','course','مقرر MIT في الخوارزميات وهياكل البيانات مع محاضرات فيديو.','approved'),
('CPE364','VisuAlgo','https://visualgo.net/en','practice','تصور متحرك لهياكل البيانات والخوارزميات مع اختبارات.','approved'),
('CPE364','Data Structure Visualizations (USFCA)','https://www.cs.usfca.edu/~galles/visualization/Algorithms.html','practice','رسوم متحركة تفاعلية لخطوات عمل هياكل البيانات.','approved'),
('CPE354L','VisuAlgo','https://visualgo.net/en','practice','تصور متحرك لهياكل البيانات والخوارزميات مع اختبارات.','approved'),
('CPE354L','Data Structure Visualizations (USFCA)','https://www.cs.usfca.edu/~galles/visualization/Algorithms.html','practice','رسوم متحركة تفاعلية لخطوات عمل هياكل البيانات.','approved'),
('CPE354L','HackerRank C++ Practice','https://www.hackerrank.com/domains/cpp','practice','مسائل تدريبية متدرجة بلغة C++.','approved'),
('CPE354L','Exercism C++ Track','https://www.exercism.org/tracks/cpp','practice','تمارين برمجة مجانية بلغة C++ مع مراجعة ذاتية.','approved'),
('CPE440','UC Berkeley CS61C','https://cs61c.org/','course','مقرر بيركلي في بنية الحاسوب: RISC-V والمعالجة والذاكرة المخبئية.','approved'),
('CPE440','MIT OCW 6.823 Computer System Architecture','https://ocw.mit.edu/courses/6-823-computer-system-architecture-fall-2005/','course','مقرر MIT متقدم في بنية الحاسوب وخطوط الأنابيب والذاكرة.','approved'),
('CPE440','CS:APP Computer Systems: A Programmer''s Perspective','https://csapp.cs.cmu.edu/','book','موقع الكتاب الشهير عن أنظمة الحاسوب من منظور المبرمج.','approved'),
('CPE440','MIT OCW 6.004 Computation Structures','https://ocw.mit.edu/courses/6-004-computation-structures-spring-2017/','course','مقرر MIT يغطي المنطق الرقمي وتصميم المعالج وبنية الحاسوب.','approved'),
('CPE441','Nand2Tetris','https://www.nand2tetris.org/','course','مقرر لبناء حاسوب كامل من البوابات المنطقية حتى النظام.','approved'),
('CPE441','UC Berkeley CS61C','https://cs61c.org/','course','مقرر بيركلي في بنية الحاسوب: RISC-V والمعالجة والذاكرة المخبئية.','approved'),
('CPE441','CircuitVerse','https://circuitverse.org/','practice','محاكي دوائر منطقية رقمية أونلاين مجاني لتجربة التصاميم.','approved'),
('CPE441','MIT OCW 6.111 Introductory Digital Systems Laboratory','https://ocw.mit.edu/courses/6-111-introductory-digital-systems-laboratory-spring-2006/','course','مختبر MIT للأنظمة الرقمية مع تجارب ومشاريع.','approved'),
('CPE460','OSTEP: Operating Systems Three Easy Pieces','https://pages.cs.wisc.edu/~remzi/OSTEP/','book','كتاب مجاني ممتاز في أنظمة التشغيل: المحاكاة والتزامن والتخزين.','approved'),
('CPE460','MIT 6.1810 Operating System Engineering','https://pdos.csail.mit.edu/6.1810/2023/','course','مقرر MIT مع مختبرات عملية على نظام xv6.','approved'),
('CPE460','Operating System Concepts (Silberschatz)','https://www.os-book.com/OS10/','book','الموقع الرسمي للكتاب مع شرائح وموارد داعمة.','approved'),
('CPE460','CS:APP Computer Systems: A Programmer''s Perspective','https://csapp.cs.cmu.edu/','book','موقع الكتاب الشهير عن أنظمة الحاسوب من منظور المبرمج.','approved'),
('CPE460L','MIT 6.1810 Operating System Engineering','https://pdos.csail.mit.edu/6.1810/2023/','course','مقرر MIT مع مختبرات عملية على نظام xv6.','approved'),
('CPE460L','Linux man pages online','https://man7.org/linux/man-pages/','docs','صفحات دليل لينكس لاستدعاءات النظام والأوامر.','approved'),
('CPE460L','OverTheWire Bandit','https://overthewire.org/wargames/bandit/','practice','ألعاب تدريبية لتعلم سطر أوامر لينكس خطوة بخطوة.','approved'),
('CPE460L','OSTEP: Operating Systems Three Easy Pieces','https://pages.cs.wisc.edu/~remzi/OSTEP/','book','كتاب مجاني ممتاز في أنظمة التشغيل: المحاكاة والتزامن والتخزين.','approved'),
('CPE466','MIT OCW RES.6-007 Signals and Systems','https://ocw.mit.edu/courses/res-6-007-signals-and-systems-spring-2011/','video','محاضرات فيديو كلاسيكية للبروفيسور أوبنهايم في الإشارات والأنظمة.','approved'),
('CPE466','MIT OCW 6.003 Signals and Systems','https://ocw.mit.edu/courses/6-003-signals-and-systems-fall-2011/','course','مقرر MIT يغطي فورييه ولابلاس وتحويل Z والأنظمة الخطية.','approved'),
('CPE466','The Scientist and Engineer''s Guide to DSP','https://www.dspguide.com/','book','كتاب مجاني عملي في معالجة الإشارات الرقمية.','approved'),
('CPE466','MIT OCW RES.6-008 Digital Signal Processing','https://ocw.mit.edu/courses/res-6-008-digital-signal-processing-spring-2011/','video','محاضرات فيديو في معالجة الإشارات الرقمية.','approved'),
('CPE466L','MATLAB Onramp','https://www.mathworks.com/learn/tutorials/matlab-onramp.html','course','دورة مجانية تفاعلية لتعلم أساسيات MATLAB (الرابط يحول إلى MATLAB Academy).','approved'),
('CPE466L','SciPy Signal Processing Tutorial','https://docs.scipy.org/doc/scipy/tutorial/signal.html','docs','شرح استخدام مكتبة scipy.signal في الترشيح وتحليل الإشارات.','approved'),
('CPE466L','The Scientist and Engineer''s Guide to DSP','https://www.dspguide.com/','book','كتاب مجاني عملي في معالجة الإشارات الرقمية.','approved'),
('CPE466L','MIT OCW RES.6-007 Signals and Systems','https://ocw.mit.edu/courses/res-6-007-signals-and-systems-spring-2011/','video','محاضرات فيديو كلاسيكية للبروفيسور أوبنهايم في الإشارات والأنظمة.','approved'),
('CPE562','Kurose and Ross: Computer Networking, a Top-Down Approach','https://gaia.cs.umass.edu/kurose_ross/index.php','book','موقع الكتاب المرجعي في الشبكات مع موارد للطلاب.','approved'),
('CPE562','Kurose and Ross Online Lectures','https://gaia.cs.umass.edu/kurose_ross/online_lectures.htm','video','محاضرات فيديو مجانية تغطي فصول كتاب الشبكات.','approved'),
('CPE562','Computer Networks: A Systems Approach','https://book.systemsapproach.org/','book','كتاب مفتوح مجاني في الشبكات بمنهج الأنظمة.','approved'),
('CPE562','Cisco Networking Academy: Networking Essentials','https://www.netacad.com/courses/networking/networking-essentials','course','دورة سيسكو مجانية لتعلم أساسيات الشبكات.','approved'),
('CPE563','Wireshark User''s Guide','https://www.wireshark.org/docs/wsug_html_chunked/','docs','الدليل الرسمي لتحليل حزم الشبكة باستخدام Wireshark.','approved'),
('CPE563','Cisco Packet Tracer','https://www.netacad.com/courses/packet-tracer','practice','برنامج محاكاة شبكات مجاني من سيسكو لبناء وتجربة الشبكات.','approved'),
('CPE563','Beej''s Guide to Network Programming','https://beej.us/guide/bgnet/','book','دليل برمجة المقابس (sockets) بلغة C.','approved'),
('CPE563','Kurose and Ross Online Lectures','https://gaia.cs.umass.edu/kurose_ross/online_lectures.htm','video','محاضرات فيديو مجانية تغطي فصول كتاب الشبكات.','approved'),
('CPE576','CS50 Introduction to AI with Python','https://cs50.harvard.edu/ai/','course','مقرر هارفارد في البحث والتعلم الآلي مع مشاريع بايثون.','approved'),
('CPE576','MIT OCW 6.034 Artificial Intelligence','https://ocw.mit.edu/courses/6-034-artificial-intelligence-fall-2010/','course','مقرر MIT في الذكاء الاصطناعي مع محاضرات فيديو.','approved'),
('CPE576','AIMA: Artificial Intelligence A Modern Approach','https://aima.cs.berkeley.edu/','book','موقع الكتاب المرجعي الأول في الذكاء الاصطناعي مع شيفرات وموارد.','approved'),
('CPE576','Elements of AI','https://www.elementsofai.com/','course','دورة مجانية مبسطة لمفاهيم الذكاء الاصطناعي.','approved'),
('CPE578','OWASP Top 10','https://owasp.org/www-project-top-ten/','docs','قائمة أخطر ثغرات تطبيقات الويب من OWASP.','approved'),
('CPE578','UC Berkeley CS 161 Computer Security','https://cs161.org/','course','مقرر بيركلي في أمن الحاسوب مع ملاحظات ومحاضرات.','approved'),
('CPE578','MIT OCW 6.858 Computer Systems Security','https://ocw.mit.edu/courses/6-858-computer-systems-security-fall-2014/','course','مقرر MIT في أمن الأنظمة مع محاضرات وقراءات.','approved'),
('CPE578','Cisco: Introduction to Cybersecurity','https://www.netacad.com/courses/cybersecurity/introduction-cybersecurity','course','دورة سيسكو مجانية تمهيدية في الأمن السيبراني.','approved'),
('MATH152','MIT OCW 6.042J Mathematics for Computer Science (Fall 2010, video lectures)','https://ocw.mit.edu/courses/6-042j-mathematics-for-computer-science-fall-2010/','video','نسخة 2010 من المقرر مع محاضرات فيديو وتمارين وحلول امتحانات.','approved');

INSERT INTO forum_posts (user_id,title,content) VALUES
(2,'كيف أتحضر لامتحان البرمجة؟','شاركوا تجاربكم ونصائحكم للتحضير لامتحان البرمجة النهائي.'),
(3,'أفضل مصادر لتعلم هياكل البيانات','ما هي الكتب والمراجع التي تنصحون بها لتعلم هياكل البيانات بفعالية؟'),
(4,'نقاش حول مشروع التخرج','لنناقش أفكار مشاريع التخرج وكيفية تنفيذها بطرق مبتكرة.'),
(2,'مشاكل شائعة في لغة Python','ما هي أكثر المشاكل التي تواجهكم عند البرمجة بلغة بايثون؟'),
(3,'أفضل الطرق لتعلم الخوارزميات','ما هي استراتيجياتكم لفهم الخوارزميات بطريقة أسهل وأكثر فاعلية؟'),
(4,'تجربة العمل في مجال الأمن السيبراني','ما هي المهارات المطلوبة للدخول في مجال الأمن السيبراني؟'),
(2,'الفرق بين SQL و NoSQL','ما الفرق بين قواعد البيانات العلائقية وغير العلائقية؟ وأيها أفضل لمشروعي القادم؟'),
(3,'أفضل محررات الأكواد للبرمجة','ما هو محرر الأكواد المفضل لديك ولماذا؟');

INSERT INTO forum_replies (post_id,user_id,content) VALUES
(1,3,'ابدأ بحل الأسئلة السابقة لتحديد الأنماط الشائعة، ثم جرّب كتابة الأكواد بيدك دون IDE.'),
(2,4,'جرّبوا كتاب Open Data Structures المجاني، وهو موجود في صفحة مقرر CPE 364 هنا في الموقع.'),
(2,2,'ومحاضرات CS50 ممتازة للمفاهيم الأولى.'),
(3,1,'فكرة استخدام الذكاء الاصطناعي في تحليل البيانات مناسبة جداً لمشروع تخرج.'),
(6,2,'ابدأوا بأساسيات الشبكات وأنظمة التشغيل، ثم جرّبوا منصات CTF التعليمية.');
