<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

include "../config/db.php";

// Delete patient
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM patients WHERE id=$id");
    header("Location: manage_patients.php");
    exit();
}

$patients = $conn->query("SELECT * FROM patients ORDER BY name");
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة المرضى - نظام حجز المواعيد</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <a href="manage_patients.php" style="text-decoration: none; display: flex; align-items: center;">
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
            <h2>إدارة المرضى</h2>
            
            <?php if ($patients->num_rows == 0): ?>
                <p class="no-data">لا يوجد مرضى مسجلين</p>
            <?php else: ?>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>الاسم</th>
                            <th>البريد الإلكتروني</th>
                            <th>رقم الهاتف</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $patients->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['phone']); ?></td>
                            <td>
                                <a href="edit_patient.php?id=<?php echo $row['id']; ?>" class="btn btn-edit">تعديل</a>
                                <a href="manage_patients.php?delete=<?php echo $row['id']; ?>" class="btn btn-delete" onclick="return confirm('هل أنت متأكد؟')">حذف</a>
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
