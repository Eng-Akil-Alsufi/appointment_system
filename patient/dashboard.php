<?php
session_start();
if (!isset($_SESSION['patient_id'])) {
    header("Location: login.php");
    exit();
}

include "../config/db.php";

$patient_id = $_SESSION['patient_id'];
$appointments = $conn->query("SELECT a.*, d.name as doctor_name, d.specialization FROM appointments a 
    JOIN doctors d ON a.doctor_id = d.id 
    WHERE a.patient_id = $patient_id 
    ORDER BY a.appointment_date DESC");

$conn->close();
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة المريض - نظام حجز المواعيد</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <a href="dashboard.php" style="text-decoration: none; display: flex; align-items: center;">
            <img src="../public/medical_appointment_logo.png" alt="   " style="height: 40px; margin-left: 10px;">
            <h1 style="margin: 0; color: #ffffffff; font-size: 1.5em;">نظام حجز المواعيد - لوحة المريض</h1>
            <div class="nav-links">
                <a href="dashboard.php">المواعيد الخاصة بي</a>
                <a href="book_appointment.php" class="btn btn-primary">حجز موعد جديد</a>
                <a href="logout.php" class="btn-logout">تسجيل الخروج</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="patient-dashboard">
            <h2>أهلاً <?php echo htmlspecialchars($_SESSION['patient_name']); ?></h2>
            <p>فيما يلي قائمة مواعيدك:</p>
            
            <div class="appointments-list">
                <?php if ($appointments->num_rows == 0): ?>
                    <p class="no-data">لم تقم بحجز أي موعد بعد. <a href="book_appointment.php">احجز موعد الآن</a></p>
                <?php else: ?>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>اسم الطبيب</th>
                                <th>التخصص</th>
                                <th>التاريخ</th>
                                <th>الوقت</th>
                                <th>الحالة</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $appointments->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['doctor_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['specialization']); ?></td>
                                <td><?php echo htmlspecialchars($row['appointment_date']); ?></td>
                                <td><?php echo htmlspecialchars($row['appointment_time']); ?></td>
                                <td><span class="status-<?php echo strtolower($row['status']); ?>"><?php echo htmlspecialchars($row['status']); ?></span></td>
                                <td>
                                    <?php if ($row['status'] == 'Pending'): ?>
                                        <a href="cancel_appointment.php?id=<?php echo $row['id']; ?>" class="btn btn-delete" onclick="return confirm('هل أنت متأكد من الإلغاء؟')">إلغاء</a>
                                    <?php else: ?>
                                        <span class="status-text">محفوظ</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>