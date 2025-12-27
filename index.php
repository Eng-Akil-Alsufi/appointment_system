<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <title>نظام حجز المواعيد الطبية</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <a href="index.php" style="text-decoration: none; display: flex; align-items: center;">
                <img src="../appointment_system/public/medical_appointment_logo.png" alt="   " style="height: 40px; margin-left: 10px;">
                <h1 style="margin: 0; color: #ffffffff; font-size: 1.5em;">نظام حجز المواعيد الطبية</h1>
            </a>
            <div class="nav-links">
                <?php if (isset($_SESSION['patient_id'])): ?>
                    <span>مرحباً <?php echo htmlspecialchars($_SESSION['patient_name']); ?></span>
                    <a href="patient/dashboard.php" class="btn btn-primary">لوحة التحكم</a>
                    <a href="patient/logout.php" class="btn-logout">تسجيل الخروج</a>
                <?php elseif (isset($_SESSION['admin_id'])): ?>
                    <span>مرحباً بك أيها المسؤول</span>
                    <a href="admin/dashboard.php" class="btn btn-primary">لوحة التحكم</a>
                    <a href="admin/logout.php" class="btn-logout">تسجيل الخروج</a>
                <?php else: ?>
                    <a href="patient/login.php" class="btn btn-primary">دخول المريض</a>
                    <a href="patient/register.php" class="btn btn-secondary">تسجيل مريض</a>
                    <a href="admin/login.php" class="btn-admin">دخول المسؤول</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <main class="hero">
        <div class="container">
            <div class="hero-content">
                <h2>مرحباً بك في نظام حجز المواعيد الطبية</h2>
                <p>احجز موعدك مع أفضل الأطباء بكل سهولة وسرعة</p>
                <?php if (!isset($_SESSION['patient_id']) && !isset($_SESSION['admin_id'])): ?>
                    <div class="hero-buttons">
                        <a href="patient/register.php" class="btn btn-primary btn-large">اذا كنت مريض جديد</a>
                        <a href="patient/login.php" class="btn btn-secondary btn-large">دخول المريض</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <footer class="footer">
        <div class="container">
            <p>&copy; 2025 نظام حجز المواعيد الطبية. جميع الحقوق محفوظة.</p>
        </div>
    </footer>
</body>
</html>
