<?php
require("inc/essentials.php");
require("inc/db_config.php");
adminLogin();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Dashboard</title>
    <?php require("inc/links.php") ?>
</head>

<body class="bg-light">
    <?php 
    
    require('inc/header.php'); 
    
    $is_shutdown = mysqli_fetch_assoc(mysqli_query($con,"SELECT `shutdown` FROM `settings`"));

    $current_bookings = mysqli_fetch_assoc(mysqli_query($con, "
    SELECT
        COUNT(CASE WHEN booking_status = 'booked' AND arrival = 0 THEN 1 END) AS `new_bookings`,
        COUNT(CASE WHEN booking_status = 'cancelled' THEN 1 END) AS `cancelled_bookings`
    FROM `booking_order`
    "));

    $unread_queries = mysqli_fetch_assoc(mysqli_query($con,"SELECT COUNT(sr_no) AS `count`
    FROM `user_queries` WHERE `seen`=0"));

    $unread_reviews = mysqli_fetch_assoc(mysqli_query($con,"SELECT COUNT(sr_no) AS `count`
    FROM `rating_review` WHERE `seen`=0"));

    $current_users = mysqli_fetch_assoc(mysqli_query($con, "
    SELECT
        COUNT(ID) AS `total`,
        COUNT(CASE WHEN `status` = 1 THEN 1 END) AS `active`,
        COUNT(CASE WHEN `status` = 0 THEN 1 END) AS `inactive`,
        COUNT(CASE WHEN `is_verified` = 0 THEN 1 END) AS `unverified`
    FROM `user_cred`
    "));

    ?>

    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">

                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h3 class=" text-light">DASHBOARD</h3>
                    <?php
                        if($is_shutdown['shutdown']){
                            echo<<<data
                            <h6 class="badge bg-danger py-2 px-3 rounded">Shutdown Mode is Active!</h6>
                            data;
                        }                   

                    ?>
                    
                </div>

                <div class="row mb-4">
                    <div class="col-md-3 mb-4">
                        <a href="new_bookings.php" class="text-decoration-none">
                            <div class="card text-center text-success p-3">
                                <h6>New Bookings</h6>
                                <h1 class="mt-2 mb-0"><?php echo $current_bookings['new_bookings'] ?></h1>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-3 mb-4">
                        <a href="user_queries.php" class="text-decoration-none">
                            <div class="card text-center text-info p-3">
                                <h6>User Queries</h6>
                                <h1 class="mt-2 mb-0"><?php echo $unread_queries['count'] ?></h1>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-3 mb-4">
                        <a href="rating_review.php" class="text-decoration-none">
                            <div class="card text-center text-info p-3">
                                <h6>Rating & Review</h6>
                                <h1 class="mt-2 mb-0"><?php echo $unread_reviews['count'] ?></h1>
                            </div>
                        </a>

                    </div>

                </div>

                <!-- BOOKING ANALYTICS -->

                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h5 class=" text-light">BOOKING ANALYTICS</h5>
                    <select class="form-select shadow-none bg-light w-auto" onchange="booking_analytics(this.value)">
                        <option value="1">Past 30 Days</option>
                        <option value="2">Past 90 Days</option>
                        <option value="3">Past 1 Year</option>
                        <option value="4">All time</option>
                    </select>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3 mb-4">
                        <div class="card text-center text-primary p-3">
                            <h6>Total Bookings</h6>
                            <h1 class="mt-2 mb-0" id="total_bookings">0</h1>
                            <h4 class="mt-2 mb-0" id="total_amt">₹0</h4>
                        </div>
                    </div>

                    <div class="col-md-3 mb-4">
                        <div class="card text-center text-success p-3">
                            <h6>Active Bookings</h6>
                            <h1 class="mt-2 mb-0" id="active_bookings">0</h1>
                            <h4 class="mt-2 mb-0" id="active_amt">₹0</h4>
                        </div>
                    </div>

                    <div class="col-md-3 mb-4">
                        <div class="card text-center text-danger p-3">
                            <h6>Cancelled Bookings</h6>
                            <h1 class="mt-2 mb-0" id="cancelled_bookings">0</h1>
                            <h4 class="mt-2 mb-0" id="cancelled_amt">₹0</h4>
                        </div>
                    </div>

                </div>

                <!-- User, Queries, Reviews Analytics-->

                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h5 class=" text-light">USERS, QUERIES AND REVIEWS ANALYTICS</h5>
                    <select class="form-select shadow-none bg-light w-auto" onchange="user_analytics(this.value)">
                        <option value="1">Past 30 Days</option>
                        <option value="2">Past 90 Days</option>
                        <option value="3">Past 1 Year</option>
                        <option value="4">All time</option>
                    </select>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3 mb-4">
                        <div class="card text-center text-success p-3">
                            <h6>New Registration</h6>
                            <h1 class="mt-2 mb-0" id="total_new_reg">0</h1>
                        </div>
                    </div>

                    <div class="col-md-3 mb-4">
                        <div class="card text-center text-primary p-3">
                            <h6>Queries</h6>
                            <h1 class="mt-2 mb-0" id="total_queries">0</h1>
                        </div>
                    </div>

                    <div class="col-md-3 mb-4">
                        <div class="card text-center text-primary p-3">
                            <h6>Reviews</h6>
                            <h1 class="mt-2 mb-0" id="total_review">0</h1>
                        </div>
                    </div>

                </div>

                <!-- Users -->
                <h5 class=" text-light mb-4">USERS</h5>
                <div class="row mb-3">
                    <div class="col-md-3 mb-4">
                        <div class="card text-center text-info p-3">
                            <h6>Total</h6>
                            <h1 class="mt-2 mb-0"><?php echo $current_users['total']?></h1>
                        </div>
                    </div>

                    <div class="col-md-3 mb-4">
                        <div class="card text-center text-success p-3">
                            <h6>Active</h6>
                            <h1 class="mt-2 mb-0"><?php echo $current_users['active']?></h1>

                        </div>
                    </div>

                    <div class="col-md-3 mb-4">
                        <div class="card text-center text-warning p-3">
                            <h6>Inactive</h6>
                            <h1 class="mt-2 mb-0"><?php echo $current_users['inactive']?></h1>
                        </div>
                    </div>

                    <div class="col-md-3 mb-4">
                        <div class="card text-center text-danger p-3">
                            <h6>Unverified</h6>
                            <h1 class="mt-2 mb-0"><?php echo $current_users['unverified']?></h1>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <?php require("inc/scripts.php"); ?>

    <script src="scripts/dashboard.js"></script>


</body>

</html>