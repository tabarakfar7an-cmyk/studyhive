
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تفاصيل المقرر</title>
    <link rel="stylesheet" href="./assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <main class="main-content container my-4 p-4 bg-white rounded shadow">
        <h1 id="course-title"></h1>
        <p id="course-description"></p>

        <h2>📄 مستندات الشرح:</h2>
        <ul id="course-docs"></ul>

        <h2>🎥 فيديوهات الشرح:</h2>
        <ul id="course-videos"></ul>

        <a href="home.php" class="btn">🔙 العودة إلى الصفحة الرئيسية</a>
    </main>

    <script>
        const courses = {
            "معمارية الحاسوب": {
                description: "يتناول هذا المقرر تصميم وهيكلة الحاسوب من الداخل وكيفية عمل المعالجات والذاكرة.",
                docs: [
                    { name: "محاضرة 1 - مقدمة", link: "#" },
                    { name: "محاضرة 2 - وحدة المعالجة المركزية", link: "#" }
                ],
                videos: [
                    { name: "مقدمة في معمارية الحاسوب", link: "#" },
                    { name: "كيفية عمل المعالجات", link: "#" }
                ]
            },
            "أنظمة التشغيل": {
                description: "مقدمة في أساسيات أنظمة التشغيل وكيفية إدارتها للموارد.",
                docs: [
                    { name: "محاضرة 1 - تعريف أنظمة التشغيل", link: "#" },
                    { name: "محاضرة 2 - إدارة العمليات", link: "#" }
                ],
                videos: [
                    { name: "أساسيات أنظمة التشغيل", link: "#" },
                    { name: "إدارة الذاكرة في الأنظمة", link: "#" }
                ]
            }
        };

        const urlParams = new URLSearchParams(window.location.search);
        const courseName = urlParams.get("course");

        if (courses[courseName]) {
            document.getElementById("course-title").textContent = courseName;
            document.getElementById("course-description").textContent = courses[courseName].description;

            const docsList = document.getElementById("course-docs");
            courses[courseName].docs.forEach(doc => {
                let li = document.createElement("li");
                li.innerHTML = `<a href="${doc.link}" target="_blank">${doc.name}</a>`;
                docsList.appendChild(li);
            });

            const videosList = document.getElementById("course-videos");
            courses[courseName].videos.forEach(video => {
                let li = document.createElement("li");
                li.innerHTML = `<a href="${video.link}" target="_blank">${video.name}</a>`;
                videosList.appendChild(li);
            });
        } else {
            document.getElementById("course-title").textContent = "المقرر غير موجود";
            document.getElementById("course-description").textContent = "عذرًا، لا توجد معلومات متاحة لهذا المقرر حاليًا.";
        }
    </script>
</body>

