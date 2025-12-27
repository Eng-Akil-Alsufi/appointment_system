<?php
session_start();
if (!isset($_SESSION['patient_id'])) {
    header("Location: login.php");
    exit();
}

include "../config/db.php";

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $patient_id = $_SESSION['patient_id'];

    $check = $conn->query("SELECT id FROM appointments WHERE id=$id AND patient_id=$patient_id");

    if ($check->num_rows == 1) {
        $conn->query("UPDATE appointments SET status='Cancelled' WHERE id=$id");
    }
}

$conn->close();
header("Location: dashboard.php");
exit();
?>
