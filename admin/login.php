<?php
session_start();
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "../config/db.php";
    
    $username = trim(mysqli_real_escape_string($conn, $_POST['username']));
    $password = $_POST['password'];
    
    $sql = "SELECT id, username, password FROM admin WHERE username='$username'";
    $result = $conn->query($sql);
    
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if ($password === $row['password']) {
            $_SESSION['admin_id'] = $row['id'];
            $_SESSION['admin_username'] = $row['username'];
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "كلمة المرور غير صحيحة";
        }
    } else {
        $error = "المستخدم غير موجود";
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
    <title>دخول المسؤول - نظام حجز المواعيد</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="login-page">
    <div class="login-container">
        <div class="login-box">
            <h2>دخول المسؤول</h2>
            <?php if ($error): ?>
                <div class="error-message"><?php echo $error; ?></div>
            <?php endif; ?>
            <form method="POST">
                <div class="form-group">
                    <label for="username">اسم المستخدم:</label>
                    <input type="text" id="username" name="username" required>
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
                <button type="submit" class="btn btn-primary">دخول</button>
                <p class="form-link"><a href="../index.php">العودة للرئيسية</a></p>
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
            <!-- <div class="info-box">
                <p><strong>بيانات الدخول الافتراضية:</strong></p>
                <p>اسم المستخدم: admin</p>
                <p>كلمة المرور: admin123</p>
            </div> -->
        </div>
    </div>
</body>
</html>
