<?php
session_start();
if (!isset($_SESSION['patient_id'])) {
    header("Location: login.php");
    exit();
}

include "../config/db.php";

$success = "";
$error = "";
$patient_id = $_SESSION['patient_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $doctor_id = intval($_POST['doctor_id']);
    $appointment_date = trim(mysqli_real_escape_string($conn, $_POST['appointment_date']));
    $appointment_time = trim(mysqli_real_escape_string($conn, $_POST['appointment_time']));
    
    $today = date('Y-m-d');
    if ($appointment_date < $today) {
        $error = "الرجاء اختيار تاريخ في المستقبل";
    } else {
        // Check if appointment slot is available
        $check = $conn->query("SELECT id FROM appointments WHERE doctor_id=$doctor_id AND appointment_date='$appointment_date' AND appointment_time='$appointment_time' AND status != 'Cancelled'");
        
        if ($check->num_rows > 0) {
            $error = "هذا الموعد محجوز بالفعل، الرجاء اختيار موعد آخر";
        } else {
            $sql = "INSERT INTO appointments (patient_id, doctor_id, appointment_date, appointment_time, status) 
                    VALUES ($patient_id, $doctor_id, '$appointment_date', '$appointment_time', 'Pending')";
            
            if ($conn->query($sql) === TRUE) {
                $success = "تم حجز الموعد بنجاح! سيتم إشعارك عند الموافقة عليه.";
            } else {
                $error = "خطأ في حجز الموعد. الرجاء المحاولة لاحقاً";
            }
        }
    }
}

$doctors = $conn->query("SELECT id, name, specialization FROM doctors ORDER BY name");
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>حجز موعد - نظام حجز المواعيد</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <a href="book_appointment.php" style="text-decoration: none; display: flex; align-items: center;">
            <img src="../public/medical_appointment_logo.png" alt="   " style="height: 40px; margin-left: 10px;">
            <h1 style="margin: 0; color: #ffffffff; font-size: 1.5em;">نظام حجز المواعيد - لوحة التحكم</h1>
            </a>
            <div class="nav-links">
                <a href="dashboard.php">المواعيد الخاصة بي</a>
                <a href="book_appointment.php" class="btn-primary">حجز موعد جديد</a>
                <a href="logout.php" class="btn-logout">تسجيل الخروج</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="booking-form-container">
            <h2>حجز موعد جديد</h2>
            
            <?php if ($success): ?>
                <div class="success-message"><?php echo $success; ?></div>
            <?php endif; ?>
            <?php if ($error): ?>
                <div class="error-message"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <form method="POST" class="booking-form">
                <div class="form-group">
                    <label for="doctor_id">اختر الطبيب:</label>
                    <select id="doctor_id" name="doctor_id" required>
                        <option value=""> اختر الطبيب </option>
                        <?php while ($row = $doctors->fetch_assoc()): ?>
                            <option value="<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['name']); ?> (<?php echo htmlspecialchars($row['specialization']); ?>)</option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="appointment_date">تاريخ الموعد:</label>
                    <input type="date" id="appointment_date" name="appointment_date" min="<?php echo date('Y-m-d'); ?>" required>
                </div>
                <div class="form-group">
                    <label for="appointment_time">وقت الموعد:</label>
                    <input type="time" id="appointment_time" name="appointment_time" required>
                </div>
                <button type="submit" class="btn btn-primary">حجز الموعد</button>
                <a href="dashboard.php" class="btn btn-secondary">إلغاء</a>
            </form>
        </div>
    </div>
</body>
</html>
