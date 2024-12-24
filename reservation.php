<?php
// Get room ID from URL
$room_id = $_GET['room_id'];

// Database connection
$conn = new mysqli("localhost", "root", "", "hotel");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM rooms WHERE room_id=$room_id";
$result = $conn->query($sql);
$room = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Reservation for <?= $room['room_name'] ?></h2>
        <form method="POST" action="payment.php">
            <input type="hidden" name="room_id" value="<?= $room_id ?>">
            <div class="mb-3">
                <label for="check_in" class="form-label">Check-in Date</label>
                <input type="date" class="form-control" id="check_in" name="check_in" required>
            </div>
            <div class="mb-3">
                <label for="check_out" class="form-label">Check-out Date</label>
                <input type="date" class="form-control" id="check_out" name="check_out" required>
            </div>
            <button type="submit" class="btn btn-primary">Proceed to Payment</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php $conn->close(); ?>
