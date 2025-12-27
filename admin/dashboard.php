<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

include "../config/db.php";

$doctors_count = $conn->query("SELECT COUNT(*) as count FROM doctors")->fetch_assoc()['count'];
$patients_count = $conn->query("SELECT COUNT(*) as count FROM patients")->fetch_assoc()['count'];
$appointments_count = $conn->query("SELECT COUNT(*) as count FROM appointments")->fetch_assoc()['count'];
$pending_appointments = $conn->query("SELECT COUNT(*) as count FROM appointments WHERE status='Pending'")->fetch_assoc()['count'];

$conn->close();
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم - نظام حجز المواعيد</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <a href="dashboard.php" style="text-decoration: none; display: flex; align-items: center;">
            <img src="../public/medical_appointment_logo.png" alt="   " style="height: 40px; margin-left: 10px;">
            <h1 style="margin: 0; color: #ffffffff; font-size: 1.5em;">نظام حجز المواعيد - لوحة التحكم</h1>
            </a>
            <div class="nav-links">
                <a href="dashboard.php">لوحة التحكم</a>
                <a href="manage_doctors.php">إدارة الأطباء</a>
                <a href="manage_patients.php">إدارة المرضى</a>
                <a href="manage_appointments.php">إدارة المواعيد</a>
                <a href="logout.php" class="btn-logout">تسجيل الخروج</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="dashboard-content">
            <h2>ملخص الإحصائيات</h2>
            <div class="stats-grid">
                <div class="stat-card">
                    <h3><?php echo $doctors_count; ?></h3>
                    <p>عدد الأطباء</p>
                </div>
                <div class="stat-card">
                    <h3><?php echo $patients_count; ?></h3>
                    <p>عدد المرضى</p>
                </div>
                <div class="stat-card">
                    <h3><?php echo $appointments_count; ?></h3>
                    <p>إجمالي المواعيد</p>
                </div>
                <div class="stat-card highlight">
                    <h3><?php echo $pending_appointments; ?></h3>
                    <p>المواعيد المعلقة</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
