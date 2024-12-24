<?php
// Database connection (replace with your credentials)
$conn = new mysqli("localhost", "root", "", "hotel");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get room ID from URL
$room_id = $_GET['id'];

// Fetch room data
$sql = "SELECT * FROM rooms WHERE room_id = $room_id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $room_name = $_POST['room_name'];
    $room_type = $_POST['room_type'];
    $price = $_POST['price'];
    $status = $_POST['status'];

    // Get image URL from form input
    $image_url = $_POST['image_url'];

    // Update room data in the database
    $sql = "UPDATE rooms SET room_name='$room_name', room_type='$room_type', price='$price', status='$status', image_url='$image_url' WHERE room_id=$room_id";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Room updated successfully'); window.location.href='manage_rooms.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Room</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Edit Room</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="room_name" class="form-label">Room Name</label>
                <input type="text" class="form-control" id="room_name" name="room_name" value="<?= $row['room_name'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="room_type" class="form-label">Room Type</label>
                <input type="text" class="form-control" id="room_type" name="room_type" value="<?= $row['room_type'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" class="form-control" id="price" name="price" value="<?= $row['price'] ?>" step="0.01" required>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status" required>
                    <option value="available" <?= $row['status'] == 'available' ? 'selected' : '' ?>>Available</option>
                    <option value="maintenance" <?= $row['status'] == 'maintenance' ? 'selected' : '' ?>>Maintenance</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="image_url" class="form-label">Room Image URL</label>
                <input type="url" class="form-control" id="image_url" name="image_url" value="<?= $row['image_url'] ?>" placeholder="Enter image URL" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Room</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
