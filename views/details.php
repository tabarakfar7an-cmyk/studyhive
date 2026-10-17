<?php
$courseTitle = isset($_GET['card-title']) ? $_GET['card-title'] : 'عنوان غير متاح';
$courseDescription = isset($_GET['description']) ? $_GET['description'] : 'وصف غير متاح';
$coursePlan = isset($_GET['plan']) ? $_GET['plan'] : 'خطة غير متاحة';
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تفاصيل المقرر</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <header class="bg-dark text-white text-center py-3">
        <h1>تفاصيل المقرر - StudyHive</h1>
    </header>

    <main class="container mt-5">
        <h2 class="text-center mb-4"><?php echo $courseTitle; ?></h2>

        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">وصف المقرر</h5>
                        <p class="card-text"><?php echo $courseDescription; ?></p>
                        
                        <h5 class="card-title mt-3">الخطة المقترحة</h5>
                        <p class="card-text"><?php echo $coursePlan; ?></p>

                        <a href="index.php?page=courses" class="btn btn-outline-primary mt-3">العودة إلى الصفحة الرئيسية</a>
                    </div>
                </div>
            </div>
        </div>
    </main>

   

    
   
</body>
</html>
