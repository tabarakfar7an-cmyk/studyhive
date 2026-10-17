# StudyHive - دليل التشغيل

## التشغيل (XAMPP)
1. انسخ مجلد `StudyHive` إلى `C:\xampp\htdocs\`.
2. شغّل Apache و MySQL ثم افتح http://localhost/StudyHive/install.php واضغط «تثبيت الآن» (أو استورد `studyhive.sql` من phpMyAdmin). احذف install.php بعد التثبيت.
3. افتح: http://localhost/StudyHive/
4. إذا كانت بيانات MySQL مختلفة عدّلها في `models/Database.php` أو عبر متغيرات البيئة `DB_HOST, DB_NAME, DB_USER, DB_PASS`.

> المتطلبات: PHP 8.0+ مع PDO MySQL.

## حساب المشرف
- البريد: `admin@studyhive.com`
- كلمة المرور: `StudyHive@2026`  ← **غيّرها بعد أول دخول** من صفحة الملف الشخصي.

(حسابات salah / heba / yusuf القديمة محفوظة بكلمات مرورها السابقة؛ الحسابات ذات البيانات التالفة والفارغة حُذفت.)

## ما الذي تغيّر؟
- إصلاح تسجيل الدخول (كان يقرأ أسماء أعمدة خاطئة)، حماية CSRF، تشفير كلمات المرور، تنظيف المدخلات.
- قاعدة بيانات جديدة بمفاتيح أساسية وعلاقات: users, courses, saved_courses, resources, forum_posts, forum_replies, support_requests.
- المنتدى والدعم يحفظان في القاعدة فعلاً (مواضيع، ردود، حذف للمالك/المشرف).
- صفحة مقرر مستقلة (الخطة + المصادر + حفظ المقرر + اقتراح مصدر)، وبحث وتصنيف حقيقيان.
- ملف شخصي حقيقي: المقررات المحفوظة، منشوراتي، تعديل المعلومات، تغيير كلمة المرور، تسجيل خروج فعلي.
- لوحة إدارة: المقررات، المصادر، الموافقة على اقتراحات الطلاب، وطلبات الدعم.
- صفحتا 404 و403، تصميم موحّد متجاوب (Bootstrap RTL واحد بدل نسخ متعارضة)، وروابط نسبية تعمل من أي مجلد.
- استبدال روابط `example.com` الوهمية بـ 105 مصادر حقيقية (أدناه).

## المصادر المضافة
### MATH101
- [MIT OCW 18.01SC Single Variable Calculus](https://ocw.mit.edu/courses/18-01sc-single-variable-calculus-fall-2010/)
- [Khan Academy: Calculus 1](https://www.khanacademy.org/math/calculus-1)
- [Paul's Online Math Notes: Calculus I](https://tutorial.math.lamar.edu/Classes/CalcI/CalcI.aspx)
- [OpenStax Calculus Volume 1](https://openstax.org/details/books/calculus-volume-1)

### MATH102
- [Khan Academy: Integral Calculus](https://www.khanacademy.org/math/integral-calculus)
- [Paul's Online Math Notes: Calculus II](https://tutorial.math.lamar.edu/Classes/CalcII/CalcII.aspx)
- [OpenStax Calculus Volume 2](https://openstax.org/details/books/calculus-volume-2)
- [MIT OCW 18.02SC Multivariable Calculus](https://ocw.mit.edu/courses/18-02sc-multivariable-calculus-fall-2010/)

### MATH152
- [MIT OCW 6.042J Mathematics for Computer Science](https://ocw.mit.edu/courses/6-042j-mathematics-for-computer-science-spring-2015/)
- [Discrete Mathematics: An Open Introduction](https://discrete.openmathbooks.org/dmoi3.html)
- [MIT OCW 6.042J Mathematics for Computer Science (Fall 2010, video lectures)](https://ocw.mit.edu/courses/6-042j-mathematics-for-computer-science-fall-2010/)

### MATH205
- [Paul's Online Math Notes: Differential Equations](https://tutorial.math.lamar.edu/Classes/DE/DE.aspx)
- [MIT OCW 18.03SC Differential Equations](https://ocw.mit.edu/courses/18-03sc-differential-equations-fall-2011/)
- [Khan Academy: Differential Equations](https://www.khanacademy.org/math/differential-equations)
- [OpenStax Calculus Volume 3](https://openstax.org/details/books/calculus-volume-3)

### CHEM101E
- [OpenStax Chemistry 2e](https://openstax.org/details/books/chemistry-2e)
- [MIT OCW 5.111SC Principles of Chemical Science](https://ocw.mit.edu/courses/5-111sc-principles-of-chemical-science-fall-2014/)
- [Khan Academy: Chemistry](https://www.khanacademy.org/science/chemistry)
- [PhET Chemistry Simulations](https://phet.colorado.edu/en/simulations/category/chemistry)

### PHYS101
- [OpenStax University Physics Volume 1](https://openstax.org/details/books/university-physics-volume-1)
- [MIT OCW 8.01SC Classical Mechanics](https://ocw.mit.edu/courses/8-01sc-classical-mechanics-fall-2016/)
- [Khan Academy: Physics](https://www.khanacademy.org/science/physics)
- [PhET Physics Simulations](https://phet.colorado.edu/en/simulations/category/physics)

### PHYS102
- [OpenStax University Physics Volume 2](https://openstax.org/details/books/university-physics-volume-2)
- [MIT OCW 8.02 Electricity and Magnetism](https://ocw.mit.edu/courses/8-02-physics-ii-electricity-and-magnetism-spring-2007/)
- [Khan Academy: Physics](https://www.khanacademy.org/science/physics)
- [PhET Physics Simulations](https://phet.colorado.edu/en/simulations/category/physics)

### PHYS105
- [PhET Physics Simulations](https://phet.colorado.edu/en/simulations/category/physics)
- [MIT OCW 8.01SC Classical Mechanics](https://ocw.mit.edu/courses/8-01sc-classical-mechanics-fall-2016/)
- [OpenStax University Physics Volume 1](https://openstax.org/details/books/university-physics-volume-1)

### PHYS106
- [PhET Physics Simulations](https://phet.colorado.edu/en/simulations/category/physics)
- [MIT OCW 8.02 Electricity and Magnetism](https://ocw.mit.edu/courses/8-02-physics-ii-electricity-and-magnetism-spring-2007/)
- [OpenStax University Physics Volume 2](https://openstax.org/details/books/university-physics-volume-2)

### CPE150
- [learncpp.com](https://www.learncpp.com/)
- [cppreference.com C++ Reference](https://en.cppreference.com/w/cpp)
- [cplusplus.com Tutorial](https://cplusplus.com/doc/tutorial/)
- [Get Started with C++ (isocpp.org)](https://isocpp.org/get-started)

### CPE150L
- [Compiler Explorer](https://godbolt.org/)
- [Exercism C++ Track](https://www.exercism.org/tracks/cpp)
- [HackerRank C++ Practice](https://www.hackerrank.com/domains/cpp)
- [learncpp.com](https://www.learncpp.com/)

### CPE230
- [Nand2Tetris](https://www.nand2tetris.org/)
- [MIT OCW 6.004 Computation Structures](https://ocw.mit.edu/courses/6-004-computation-structures-spring-2017/)
- [Wikibooks: Digital Circuits](https://en.wikibooks.org/wiki/Digital_Circuits)
- [CircuitVerse](https://circuitverse.org/)

### CPE231
- [CircuitVerse](https://circuitverse.org/)
- [Falstad Circuit Simulator](https://www.falstad.com/circuit/)
- [Tinkercad Circuits](https://www.tinkercad.com/circuits)
- [MIT OCW 6.111 Introductory Digital Systems Laboratory](https://ocw.mit.edu/courses/6-111-introductory-digital-systems-laboratory-spring-2006/)

### CPE344
- [Guide to x86 Assembly (UVA)](https://www.cs.virginia.edu/~evans/cs216/guides/x86.html)
- [x86 and AMD64 Instruction Reference](https://www.felixcloutier.com/x86/)
- [Arduino Documentation: Learn](https://docs.arduino.cc/learn/)
- [MIT OCW 6.004 Computation Structures](https://ocw.mit.edu/courses/6-004-computation-structures-spring-2017/)

### CPE345
- [Arduino Documentation: Learn](https://docs.arduino.cc/learn/)
- [Tinkercad Circuits](https://www.tinkercad.com/circuits)
- [Guide to x86 Assembly (UVA)](https://www.cs.virginia.edu/~evans/cs216/guides/x86.html)
- [x86 and AMD64 Instruction Reference](https://www.felixcloutier.com/x86/)

### CPE364
- [Open Data Structures](https://opendatastructures.org/)
- [MIT OCW 6.006 Introduction to Algorithms](https://ocw.mit.edu/courses/6-006-introduction-to-algorithms-spring-2020/)
- [VisuAlgo](https://visualgo.net/en)
- [Data Structure Visualizations (USFCA)](https://www.cs.usfca.edu/~galles/visualization/Algorithms.html)

### CPE354L
- [VisuAlgo](https://visualgo.net/en)
- [Data Structure Visualizations (USFCA)](https://www.cs.usfca.edu/~galles/visualization/Algorithms.html)
- [HackerRank C++ Practice](https://www.hackerrank.com/domains/cpp)
- [Exercism C++ Track](https://www.exercism.org/tracks/cpp)

### CPE440
- [UC Berkeley CS61C](https://cs61c.org/)
- [MIT OCW 6.823 Computer System Architecture](https://ocw.mit.edu/courses/6-823-computer-system-architecture-fall-2005/)
- [CS:APP Computer Systems: A Programmer's Perspective](https://csapp.cs.cmu.edu/)
- [MIT OCW 6.004 Computation Structures](https://ocw.mit.edu/courses/6-004-computation-structures-spring-2017/)

### CPE441
- [Nand2Tetris](https://www.nand2tetris.org/)
- [UC Berkeley CS61C](https://cs61c.org/)
- [CircuitVerse](https://circuitverse.org/)
- [MIT OCW 6.111 Introductory Digital Systems Laboratory](https://ocw.mit.edu/courses/6-111-introductory-digital-systems-laboratory-spring-2006/)

### CPE460
- [OSTEP: Operating Systems Three Easy Pieces](https://pages.cs.wisc.edu/~remzi/OSTEP/)
- [MIT 6.1810 Operating System Engineering](https://pdos.csail.mit.edu/6.1810/2023/)
- [Operating System Concepts (Silberschatz)](https://www.os-book.com/OS10/)
- [CS:APP Computer Systems: A Programmer's Perspective](https://csapp.cs.cmu.edu/)

### CPE460L
- [MIT 6.1810 Operating System Engineering](https://pdos.csail.mit.edu/6.1810/2023/)
- [Linux man pages online](https://man7.org/linux/man-pages/)
- [OverTheWire Bandit](https://overthewire.org/wargames/bandit/)
- [OSTEP: Operating Systems Three Easy Pieces](https://pages.cs.wisc.edu/~remzi/OSTEP/)

### CPE466
- [MIT OCW RES.6-007 Signals and Systems](https://ocw.mit.edu/courses/res-6-007-signals-and-systems-spring-2011/)
- [MIT OCW 6.003 Signals and Systems](https://ocw.mit.edu/courses/6-003-signals-and-systems-fall-2011/)
- [The Scientist and Engineer's Guide to DSP](https://www.dspguide.com/)
- [MIT OCW RES.6-008 Digital Signal Processing](https://ocw.mit.edu/courses/res-6-008-digital-signal-processing-spring-2011/)

### CPE466L
- [MATLAB Onramp](https://www.mathworks.com/learn/tutorials/matlab-onramp.html)
- [SciPy Signal Processing Tutorial](https://docs.scipy.org/doc/scipy/tutorial/signal.html)
- [The Scientist and Engineer's Guide to DSP](https://www.dspguide.com/)
- [MIT OCW RES.6-007 Signals and Systems](https://ocw.mit.edu/courses/res-6-007-signals-and-systems-spring-2011/)

### CPE562
- [Kurose and Ross: Computer Networking, a Top-Down Approach](https://gaia.cs.umass.edu/kurose_ross/index.php)
- [Kurose and Ross Online Lectures](https://gaia.cs.umass.edu/kurose_ross/online_lectures.htm)
- [Computer Networks: A Systems Approach](https://book.systemsapproach.org/)
- [Cisco Networking Academy: Networking Essentials](https://www.netacad.com/courses/networking/networking-essentials)

### CPE563
- [Wireshark User's Guide](https://www.wireshark.org/docs/wsug_html_chunked/)
- [Cisco Packet Tracer](https://www.netacad.com/courses/packet-tracer)
- [Beej's Guide to Network Programming](https://beej.us/guide/bgnet/)
- [Kurose and Ross Online Lectures](https://gaia.cs.umass.edu/kurose_ross/online_lectures.htm)

### CPE576
- [CS50 Introduction to AI with Python](https://cs50.harvard.edu/ai/)
- [MIT OCW 6.034 Artificial Intelligence](https://ocw.mit.edu/courses/6-034-artificial-intelligence-fall-2010/)
- [AIMA: Artificial Intelligence A Modern Approach](https://aima.cs.berkeley.edu/)
- [Elements of AI](https://www.elementsofai.com/)

### CPE578
- [OWASP Top 10](https://owasp.org/www-project-top-ten/)
- [UC Berkeley CS 161 Computer Security](https://cs161.org/)
- [MIT OCW 6.858 Computer Systems Security](https://ocw.mit.edu/courses/6-858-computer-systems-security-fall-2014/)
- [Cisco: Introduction to Cybersecurity](https://www.netacad.com/courses/cybersecurity/introduction-cybersecurity)

> الروابط فُتحت وتم التحقق منها بتاريخ 2026-10-17. المواقع الخارجية قد تتغير؛ يمكن للمشرف تعديل المصادر من لوحة الإدارة.
