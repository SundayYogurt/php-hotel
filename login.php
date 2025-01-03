<?php
session_start();

// เชื่อมต่อกับฐานข้อมูล
$conn = new mysqli("localhost", "root", "", "hotel");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // ตรวจสอบข้อมูลผู้ใช้จากฐานข้อมูล
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // ตรวจสอบรหัสผ่านที่ถูกแฮช
        if (password_verify($password, $user['password'])) {
            // รหัสผ่านถูกต้อง
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role']; // เก็บ role ไว้ใน session

            // ตรวจสอบ role และไปที่หน้า dashboard ที่เหมาะสม
            if ($_SESSION['role'] == 'admin') {
                header("Location: admin_dashboard.php");
            } else {
                header("Location: index.php");
            }
            exit();
        } else {
            $error_message = "Invalid login credentials!";
        }
    } else {
        $error_message = "Invalid login credentials!";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f7f7f7;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .card {
            width: 100%;
            max-width: 400px;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .card-header {
            font-size: 1.5rem;
            text-align: center;
            background-color: #f8f9fa;
            border-bottom: 1px solid #ddd;
        }

        .form-label {
            font-weight: bold;
        }

        .btn-primary {
            width: 100%;
        }

        .alert {
            font-size: 0.9rem;
        }

        .registerbtn {
            text-align: center;
            margin-top: 20px;
        }

        .registerbtn a {
            text-decoration: none;
        }

        .registerbtn button {
            padding: 10px 20px;
            font-size: 1rem;
            color: #fff;
            background-color: #6c757d;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .registerbtn button:hover {
            background-color: #5a6268;
        }
    </style>
</head>

<body>
    <div class="card">
        <div class="card-header">
            <h4>Login</h4>
        </div>
        <form method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <?php
            if (isset($error_message)) {
                echo '<div class="alert alert-danger">' . $error_message . '</div>';
            }
            ?>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
        <div class="registerbtn">
            <a href="./register.php">
                <button type="button">Register</button>
            </a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>