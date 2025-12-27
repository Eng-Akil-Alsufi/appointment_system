<?php
session_start();
$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "../config/db.php";
    
    $name = trim(mysqli_real_escape_string($conn, $_POST['name']));
    $email = trim(mysqli_real_escape_string($conn, $_POST['email']));
    $phone = trim(mysqli_real_escape_string($conn, $_POST['phone']));
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    if (empty($name) || empty($email) || empty($phone) || empty($password)) {
        $error = "جميع الحقول مطلوبة";
    } elseif ($password !== $confirm_password) {
        $error = "كلمات المرور غير متطابقة";
    } elseif (strlen($password) < 6) {
        $error = "كلمة المرور يجب أن تكون 6 أحرف على الأقل";
    } else {
        // Check if email exists
        $check = $conn->query("SELECT id FROM patients WHERE email='$email'");
        if ($check->num_rows > 0) {
            $error = "البريد الإلكتروني موجود بالفعل";
        } else {
            $hashed_password = $password;
            $sql = "INSERT INTO patients (name, email, password, phone) VALUES ('$name', '$email', '$hashed_password', '$phone')";
            
            if ($conn->query($sql) === TRUE) {
                $success = "تم التسجيل بنجاح! <a href='login.php'>قم بتسجيل الدخول</a>";
            } else {
                $error = "خطأ في التسجيل. الرجاء المحاولة لاحقاً";
            }
        }
    }
    
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <title>التسجيل - نظام حجز المواعيد</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="login-page">
    <div class="login-container">
        <div class="login-box">
            <h2>تسجيل حساب جديد</h2>
            <?php if ($error): ?>
                <div class="error-message"><?php echo $error; ?></div>
            <?php endif; ?>
            <?php if ($success): ?>
                <div class="success-message"><?php echo $success; ?></div>
            <?php endif; ?>
            <form method="POST">
                <div class="form-group">
                    <label for="name">الاسم الكامل:</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="email">البريد الإلكتروني:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="phone">رقم الهاتف:</label>
                    <input type="tel" id="phone" name="phone" required>
                </div>
                <div class="form-group">
                    <label for="password">كلمة المرور:</label>
                    <div class="password-container">
                        <input type="password" id="password" name="password" required>
                        <span class="toggle-password" onclick="togglePassword('password', this)">
                            <i class="fas fa-eye"></i>
                        </span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="confirm_password">تأكيد كلمة المرور:</label>
                    <div class="password-container">
                        <input type="password" id="confirm_password" name="confirm_password" required>
                        <span class="toggle-password" onclick="togglePassword('confirm_password', this)">
                            <i class="fas fa-eye"></i>
                        </span>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">تسجيل</button>
                <p class="form-link">هل لديك حساب؟ <a href="login.php">قم بتسجيل الدخول</a></p>
            </form>
            <script>
                function togglePassword(id, icon) {
                    const input = document.getElementById(id);
                    const iconElement = icon.querySelector('i'); 

                    if (input.type === "password") {
                        input.type = "text";
                        iconElement.classList.remove('fa-eye');
                        iconElement.classList.add('fa-eye-slash');
                    } else {
                        input.type = "password";
                        iconElement.classList.remove('fa-eye-slash');
                        iconElement.classList.add('fa-eye');
                    }
                }
            </script>
        </div>
    </div>
</body>
</html>
