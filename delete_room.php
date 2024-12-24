<?php
// Database connection (replace with your credentials)
$conn = new mysqli("localhost", "root", "", "hotel");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get room ID from URL
$room_id = $_GET['id'];

// Delete room from database
$sql = "DELETE FROM rooms WHERE room_id = $room_id";

if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Room deleted successfully'); window.location.href='manage_rooms.php';</script>";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
