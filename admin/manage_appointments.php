<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

include "../config/db.php";

// Update appointment status
if (isset($_GET['status']) && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $status = mysqli_real_escape_string($conn, $_GET['status']);
    if (in_array($status, ['Pending', 'Approved', 'Cancelled'])) {
        $conn->query("UPDATE appointments SET status='$status' WHERE id=$id");
    }
    header("Location: manage_appointments.php");
    exit();
}

// Delete appointment
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM appointments WHERE id=$id");
    header("Location: manage_appointments.php");
    exit();
}

$appointments = $conn->query("SELECT a.*, p.name as patient_name, d.name as doctor_name FROM appointments a 
    JOIN patients p ON a.patient_id = p.id 
    JOIN doctors d ON a.doctor_id = d.id 
    ORDER BY a.appointment_date DESC, a.appointment_time DESC");
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة المواعيد - نظام حجز المواعيد</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <a href="manage_appointments.php" style="text-decoration: none; display: flex; align-items: center;">
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
        <div class="manage-content">
            <h2>إدارة المواعيد</h2>
            
            <?php if ($appointments->num_rows == 0): ?>
                <p class="no-data">لا توجد مواعيد مسجلة</p>
            <?php else: ?>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>اسم المريض</th>
                            <th>اسم الطبيب</th>
                            <th>التاريخ</th>
                            <th>الوقت</th>
                            <th>الحالة</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $appointments->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo htmlspecialchars($row['patient_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['doctor_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['appointment_date']); ?></td>
                            <td><?php echo htmlspecialchars($row['appointment_time']); ?></td>
                            <td><span class="status-<?php echo strtolower($row['status']); ?>"><?php echo htmlspecialchars($row['status']); ?></span></td>
                            <td>
                                <?php if ($row['status'] == 'Pending'): ?>
                                    <a href="manage_appointments.php?id=<?php echo $row['id']; ?>&status=Approved" class="btn btn-success">موافقة</a>
                                    <a href="manage_appointments.php?id=<?php echo $row['id']; ?>&status=Cancelled" class="btn btn-warning">إلغاء</a>
                                <?php endif; ?>
                                <a href="manage_appointments.php?delete=<?php echo $row['id']; ?>" class="btn btn-delete" onclick="return confirm('هل أنت متأكد؟')">حذف</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
