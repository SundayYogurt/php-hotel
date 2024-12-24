<?php
session_start();

// ตรวจสอบว่า user กำลังออกจากระบบหรือไม่
if (isset($_GET['logout'])) {
    session_destroy(); // ล้างข้อมูลเซสชั่น
    header("Location: login.php"); // เปลี่ยนเส้นทางไปยังหน้า login
    exit(); // หยุดการทำงานของสคริปต์ต่อจากนี้
}

// Database connection (replace with your credentials)
$conn = new mysqli("localhost", "root", "", "hotel");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch rooms
$sql = "SELECT * FROM rooms";
$result = $conn->query($sql);

// Close the connection after usage
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Rooms</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* กำหนดขนาดของรูปภาพให้เท่ากัน */
        .room-image {
            width: 100px;
            height: 100px;
            object-fit: cover; /* เพื่อให้รูปภาพไม่ผิดสัดส่วน */
            transition: transform 0.3s ease; /* เพิ่มการเปลี่ยนแปลงขนาดรูปเมื่อ hover */
        }

        /* เมื่อ hover ให้ขยายรูป */
        .room-image:hover {
            transform: scale(1.5); /* ขยายรูปภาพ */
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Hotel Management</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="rooms.php">Booking</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="manage_rooms.php">dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="?logout=true">Logout</a>  <!-- Logout Button -->
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2>Manage Rooms</h2>
        <a href="add_room.php" class="btn btn-success mb-3">Add New Room</a>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Room Name</th>
                        <th>Room Type</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Image</th> <!-- New column for image -->
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?= $row['room_name'] ?></td>
                            <td><?= $row['room_type'] ?></td>
                            <td>$<?= number_format($row['price'], 2) ?></td>
                            <td><?= $row['status'] ?></td>
                            <td>
                                <?php if (!empty($row['image_url'])) { ?>
                                    <img src="<?= $row['image_url'] ?>" alt="<?= $row['room_name'] ?>" class="room-image">
                                <?php } else { ?>
                                    No Image
                                <?php } ?>
                            </td>
                            <td>
                                <a href="edit_room.php?id=<?= $row['room_id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="delete_room.php?id=<?= $row['room_id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this room?')">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
