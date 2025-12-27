<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

include "../config/db.php";

$success = "";
$error = "";

// Add doctor
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_doctor'])) {
    $name = trim(mysqli_real_escape_string($conn, $_POST['name']));
    $specialization = trim(mysqli_real_escape_string($conn, $_POST['specialization']));
    
    if (empty($name) || empty($specialization)) {
        $error = "جميع الحقول مطلوبة";
    } else {
        $sql = "INSERT INTO doctors (name, specialization) VALUES ('$name', '$specialization')";
        if ($conn->query($sql) === TRUE) {
            $success = "تم إضافة الطبيب بنجاح";
        } else {
            $error = "خطأ: " . $conn->error;
        }
    }
}

// Delete doctor
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM doctors WHERE id=$id");
    header("Location: manage_doctors.php");
    exit();
}

// Get all doctors
$doctors = $conn->query("SELECT * FROM doctors ORDER BY name");
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة الأطباء - نظام حجز المواعيد</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <a href="manage_doctors.php" style="text-decoration: none; display: flex; align-items: center;">
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
            <h2>إدارة الأطباء</h2>
            
            <?php if ($success): ?>
                <div class="success-message"><?php echo $success; ?></div>
            <?php endif; ?>
            <?php if ($error): ?>
                <div class="error-message"><?php echo $error; ?></div>
            <?php endif; ?>

            <div class="add-form">
                <h3>إضافة طبيب جديد</h3>
                <form method="POST">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="name">اسم الطبيب:</label>
                            <input type="text" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="specialization">التخصص:</label>
                            <input type="text" id="specialization" name="specialization" required>
                        </div>
                        <button type="submit" name="add_doctor" class="btn btn-primary">إضافة</button>
                    </div>
                </form>
            </div>

            <table class="data-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>اسم الطبيب</th>
                        <th>التخصص</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $doctors->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['specialization']); ?></td>
                        <td>
                            <a href="edit_doctor.php?id=<?php echo $row['id']; ?>" class="btn btn-edit">تعديل</a>
                            <a href="manage_doctors.php?delete=<?php echo $row['id']; ?>" class="btn btn-delete" onclick="return confirm('هل أنت متأكد؟')">حذف</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
