<?php
session_start();

// ตรวจสอบว่า user ได้เข้าสู่ระบบแล้วหรือไม่
if ($_SESSION['role'] !== 'user') {
    // ถ้าไม่ใช่ user ให้รีไดเร็กต์ไปยังหน้า login
    header("Location: login.php");
    exit();
}

// ไปที่หน้า rooms.php
header("Location: rooms.php");
exit();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>User Dashboard</h2>
        <p>Welcome, <?= $_SESSION['username'] ?>! You have user access.</p>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>