<?php
session_start();

// Database connection (replace with your credentials)
$conn = new mysqli("localhost", "root", "", "hotel");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch featured rooms for the homepage (3 rooms)
$sql = "SELECT * FROM rooms WHERE status='available' LIMIT 3";
$result = $conn->query($sql);

// Fetch all rooms for the 'View All Rooms' button
$sql_all_rooms = "SELECT * FROM rooms WHERE status='available'";
$result_all_rooms = $conn->query($sql_all_rooms);

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
    <title>Home | Hotel Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- SweetAlert2 -->
    <script src="https://unpkg.com/scrollreveal@4.0.0/dist/scrollreveal.min.js"></script> <!-- ScrollReveal -->
    <style>
        .card-img-top {
            width: 100%;
            height: 250px;
            /* Set a fixed height */
            object-fit: cover;
            /* Ensure the image covers the area without distortion */
        }

        footer {
            background-color: #f8f9fa;
            padding: 20px 0;
            bottom: 0;
            width: 100%;
            text-align: center;
        }

        footer p {
            margin: 0;
            font-size: 14px;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
        }

        main {
            flex: 1;
        }

        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border: none;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .btn-cta {
            background-color: #007bff;
            color: white;
            border: none;
        }

        .btn-cta:hover {
            background-color: #0056b3;
        }

        .feature-section {
            padding: 40px 0;
        }

        .hidden {
            display: none;
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
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="manage_rooms.php">Manage Rooms</a>
                        </li>
                    <?php } ?>
                    <?php if (!isset($_SESSION['user_id'])) { ?>
                        <li class="nav-item">
                            <a class="nav-link text-primary" href="login.php">Login</a>
                        </li>
                    <?php } else { ?>
                        <li class="nav-item">
                            <a class="nav-link text-danger" href="?logout=true">Logout</a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Banner Slide -->
    <div class="container-fluid p-0 ">
        <!-- Banner Slide Section -->
        <div id="bannerCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <!-- Slide 1 -->
                <div class="carousel-item active">
                    <img src="https://images.pexels.com/photos/691668/pexels-photo-691668.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" class="d-block w-100" alt="Banner 1">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Welcome to Hotel Management</h5>
                        <p>Discover the best rooms and services.</p>
                    </div>
                </div>
                <!-- Slide 2 -->
                <div class="carousel-item">
                    <img src="https://images.pexels.com/photos/2162442/pexels-photo-2162442.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" class="d-block w-100" alt="Banner 2">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Luxury & Comfort</h5>
                        <p>Experience the ultimate relaxation.</p>
                    </div>
                </div>
                <!-- Slide 3 -->
                <div class="carousel-item">
                    <img src="https://images.pexels.com/photos/1450360/pexels-photo-1450360.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" class="d-block w-100" alt="Banner 3">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Exclusive Deals</h5>
                        <p>Book now and enjoy special offers!</p>
                    </div>
                </div>
            </div>
            <!-- Carousel Controls -->
            <button class="carousel-control-prev" type="button" data-bs-target="#bannerCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#bannerCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
        <!-- 
        <?php include 'banner-slide.php'; ?> แยกโค้ดเป็นไฟล์ banner-slide.php ได้ถ้าต้องการ -->
    </div>
    <!-- Rest of the page content -->

    <!-- Feature Section -->
    <div class="container feature-section text-center fade-in">
        <h2>Our Featured Rooms</h2>
        <p class="lead">Explore our best rooms with exclusive features and stunning views.</p>
        <div class="row">
            <?php
            $counter = 0;
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $counter++;
            ?>
                    <div class="col-md-4 room-card <?= $counter > 3 ? 'hidden' : ''; ?>" id="room-<?= $counter ?>">
                        <div class="card mb-3">
                            <img src="<?= $row['image_url'] ? $row['image_url'] : 'https://via.placeholder.com/150' ?>" class="card-img-top" alt="Room Image">
                            <div class="card-body">
                                <h5 class="card-title"><?= $row['room_name'] ?></h5>
                                <p class="card-text"><?= $row['room_type'] ?> - $<?= number_format($row['price'], 2) ?></p>
                                <a href="reservation.php?room_id=<?= $row['room_id'] ?>" class="btn btn-primary">Book Now</a>
                            </div>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo "<p>No rooms available at the moment.</p>";
            }
            ?>
        </div>
        <button id="view-all-btn" class="btn btn-cta mt-4">View All Rooms</button>
    </div>

    <!-- View All Rooms Section (hidden initially) -->
    <div class="container feature-section text-center fade-in hidden" id="all-rooms-section">
        <h2>All Available Rooms</h2>
        <p class="lead">Browse all rooms available for booking.</p>
        <div class="row">
            <?php
            if ($result_all_rooms->num_rows > 0) {
                while ($row = $result_all_rooms->fetch_assoc()) {
            ?>
                    <div class="col-md-4 room-card">
                        <div class="card mb-3">
                            <img src="<?= $row['image_url'] ? $row['image_url'] : 'https://via.placeholder.com/150' ?>" class="card-img-top" alt="Room Image">
                            <div class="card-body">
                                <h5 class="card-title"><?= $row['room_name'] ?></h5>
                                <p class="card-text"><?= $row['room_type'] ?> - $<?= number_format($row['price'], 2) ?></p>
                                <a href="reservation.php?room_id=<?= $row['room_id'] ?>" class="btn btn-primary">Book Now</a>
                            </div>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo "<p>No rooms available at the moment.</p>";
            }
            ?>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="container text-center">
            <p class="mb-0">© 2024 Hotel Management. All Rights Reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Show all rooms when clicking "View All Rooms"
        document.getElementById('view-all-btn').addEventListener('click', function() {
            // Show SweetAlert popup
            Swal.fire({
                title: 'Success!',
                text: 'All rooms are now visible.',
                icon: 'success',
                confirmButtonText: 'Close'
            });

            // Show all rooms in the hidden section
            document.getElementById('all-rooms-section').classList.remove('hidden');

            // Reveal the remaining hidden room cards
            let hiddenRooms = document.querySelectorAll('.room-card.hidden');
            hiddenRooms.forEach(room => {
                room.classList.remove('hidden');
            });

            // Hide the "View All Rooms" button after it is clicked
            document.getElementById('view-all-btn').style.display = 'none';
        });

        // ScrollReveal initialization
        ScrollReveal().reveal('.feature-section', {
            delay: 200,
            origin: 'bottom',
            distance: '50px',
            opacity: 0,
            duration: 800
        });

        ScrollReveal().reveal('.room-card', {
            delay: 200,
            origin: 'bottom',
            distance: '50px',
            opacity: 0,
            duration: 800
        });
    </script>
</body>

</html>

<?php $conn->close(); ?>