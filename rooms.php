<?php
session_start();

// Redirect if not logged in
// if (!isset($_SESSION['username'])) {
//     header("Location: login.php");
//     exit();
// }

// Booking handler
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['book_room'])) {
    echo "<script>alert('Room booked successfully!');</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TripOnTheGo - Home</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css"/>
    <?php require('inc/links.php');?> <!-- Connects to your existing style -->
    <style>
        .room-category {
            margin: 30px auto;
            max-width: 1200px;
            padding: 20px;
        }
        .room-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
        .room-card {
            flex: 1 1 calc(33.333% - 20px);
            border: 1px solid #ccc;
            border-radius: 12px;
            overflow: hidden;
            background-color: #f8f8f8;
            font-family: inherit;
        }
        .room-card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }
        .room-card h3 {
            margin: 10px;
            font-size: 20px;
        }
        .room-card p {
            margin: 10px;
            font-size: 14px;
        }
        .room-card form {
            margin: 10px;
            text-align: right;
        }
        .room-card button {
            padding: 8px 16px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
        .room-card button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<?php require('inc/header.php');?> <!-- ✅ Fixed include path -->

<div class="room-category">
    <h2>Explore Our Rooms</h2>

    <div class="room-grid">
        <!-- Room 1 -->
        <div class="room-card">
            <img src="images/rooms/1.jpg" alt="Standard Room">
            <h3>Standard Room</h3>
            <p>Simple yet comfortable with all basic amenities for solo travelers.</p>
            <form method="POST">
                <button type="submit" name="book_room" value="standard">Book Now</button>
            </form>
        </div>

        <!-- Room 2 -->
        <div class="room-card">
            <img src="images/rooms/IMG_11892.png" alt="Deluxe Room">
            <h3>Deluxe Room</h3>
            <p>Spacious room with modern furniture and attached bathroom.</p>
            <form method="POST">
                <button type="submit" name="book_room" value="deluxe">Book Now</button>
            </form>
        </div>

        <!-- Room 3 -->
        <div class="room-card">
            <img src="images/rooms/IMG_78809.png" alt="Family Suite">
            <h3>Family Suite</h3>
            <p>Perfect for families: two beds, sitting area, and extra comfort.</p>
            <form method="POST">
                <button type="submit" name="book_room" value="family">Book Now</button>
            </form>
        </div>
    </div>
</div>

<?php require('inc/footer.php') ?> <!-- ✅ Keeps footer as is -->

</body>
</html>
