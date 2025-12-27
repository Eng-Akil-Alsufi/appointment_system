<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

include "../config/db.php";

$id = intval($_GET['id']);
$doctor = $conn->query("SELECT * FROM doctors WHERE id=$id")->fetch_assoc();

if (!$doctor) {
    header("Location: manage_doctors.php");
    exit();
}

$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim(mysqli_real_escape_string($conn, $_POST['name']));
    $specialization = trim(mysqli_real_escape_string($conn, $_POST['specialization']));
    
    if (empty($name) || empty($specialization)) {
        $error = "جميع الحقول مطلوبة";
    } else {
        $sql = "UPDATE doctors SET name='$name', specialization='$specialization' WHERE id=$id";
        if ($conn->query($sql) === TRUE) {
            $success = "تم تحديث بيانات الطبيب بنجاح";
        } else {
            $error = "خطأ: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تعديل الطبيب - نظام حجز المواعيد</title>
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
            <h2>تعديل بيانات الطبيب</h2>
            
            <?php if ($success): ?>
                <div class="success-message"><?php echo $success; ?></div>
            <?php endif; ?>
            <?php if ($error): ?>
                <div class="error-message"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <form method="POST" class="edit-form">
                <div class="form-group">
                    <label for="name">اسم الطبيب:</label>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($doctor['name']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="specialization">التخصص:</label>
                    <input type="text" id="specialization" name="specialization" value="<?php echo htmlspecialchars($doctor['specialization']); ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                <a href="manage_doctors.php" class="btn btn-secondary">إلغاء</a>
            </form>
        </div>
    </div>
</body>
</html>
