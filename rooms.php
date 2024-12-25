<?php
session_start();

// Database connection (replace with your credentials)
$conn = new mysqli("localhost", "root", "", "hotel");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM rooms WHERE status='available'";
$result = $conn->query($sql);

// Logout action
if (isset($_GET['logout'])) {
    session_destroy(); // Destroy the session
    header("Location: login.php"); // Redirect to login page
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Selection</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Ensuring all room images have the same size */
        .card-img-top {
            height: 200px;
            object-fit: cover;
            /* Keeps aspect ratio intact, crops excess */
        }

        /* Styling the footer */
        footer {
            background-color: #f8f9fa;
            padding: 20px 0;
            position: relative;
            bottom: 0;
            width: 100%;
        }

        footer p {
            margin: 0;
            font-size: 14px;
        }

        /* Styling the card layout */
        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border: none;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .card-body {
            text-align: center;
        }

        .card-title {
            font-size: 1.2rem;
            font-weight: bold;
        }

        .card-text {
            font-size: 1rem;
            color: #555;
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

                    <!-- Check if user is admin to show Manage Rooms button -->
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="manage_rooms.php">Manage Rooms</a>
                        </li>
                    <?php } ?>
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="?logout=true">Logout</a> <!-- Logout Button -->
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2>Available Rooms</h2>
        <div class="row">
            <?php while ($row = $result->fetch_assoc()) { ?>
                <div class="col-md-4">
                    <div class="card mb-3">
                        <!-- Check if the image URL is available -->
                        <img src="<?= $row['image_url'] ? $row['image_url'] : 'https://via.placeholder.com/150' ?>" class="card-img-top" alt="Room Image">
                        <div class="card-body">
                            <h5 class="card-title"><?= $row['room_name'] ?></h5>
                            <p class="card-text"><?= $row['room_type'] ?> - $<?= number_format($row['price'], 2) ?></p>
                            <a href="reservation.php?room_id=<?= $row['room_id'] ?>" class="btn btn-primary">Book Now</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="container text-center">
            <p class="mb-0">© 2024 Hotel Management. All Rights Reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php $conn->close(); ?>