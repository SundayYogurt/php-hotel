<?php
// Retrieve reservation details
$room_id = $_POST['room_id'];
$check_in = $_POST['check_in'];
$check_out = $_POST['check_out'];

// Database connection
$conn = new mysqli("localhost", "root", "", "hotel");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM rooms WHERE room_id=$room_id";
$result = $conn->query($sql);
$room = $result->fetch_assoc();

$amount = $room['price']; // Example: price per night, you can calculate based on dates
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2>Payment for <?= $room['room_name'] ?></h2>
        <p>Check-in: <?= $check_in ?></p>
        <p>Check-out: <?= $check_out ?></p>
        <p>Total Amount: $<?= number_format($amount, 2) ?></p>

        <form method="POST" action="confirmation.php">
            <div class="mb-3">
                <label for="payment_method" class="form-label">Payment Method</label>
                <select class="form-select" id="payment_method" name="payment_method" required>
                    <option value="Credit Card">Credit Card</option>
                    <option value="Bank Transfer">Bank Transfer</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Confirm Payment</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<?php $conn->close(); ?>