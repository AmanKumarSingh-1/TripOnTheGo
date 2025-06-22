<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require('inc/links.php'); ?>
    <title><?php echo $settings_r['site_title'] ?> - Booking Status</title>
</head>

<body class="bg-light">
    <?php require('inc/header.php'); ?>

    <div class="container">
        <div class="row">
            <div class="col-12 my-5 mb-3 px-4">
                <h2 class="fw-bold">Booking Status</h2>
            </div>  
            
            <?php
            

            $frm_data = filteration($_GET);

            if(!(isset($_SESSION['login']) && $_SESSION['login'] == true)){
                redirect('index.php');
            }

            $booking_q = "SELECT bo.*, bd.* FROM `booking_order` bo 
            INNER JOIN `booking_details` bd ON bo.booking_id = bd.booking_id 
            WHERE bo.order_id = ? AND bo.user_id = ?";

            $booking_res = select($booking_q, [$frm_data['order'], $_SESSION['uId']], 'si');

            if(mysqli_num_rows($booking_res) == 0){
                redirect('index.php');
            }

            $booking_fetch = mysqli_fetch_assoc($booking_res);

            if($booking_fetch['trans_status'] == "TXN_SUCCESS") {
                echo<<<data
                <div class="col-12 px-4">
                    <div class="card shadow-sm rounded-3">
                        <div class="card-body text-center">
                            <i class="bi bi-check-circle-fill text-success fs-1 mb-3"></i>
                            <h3 class="fw-bold mb-3">Booking Confirmed!</h3>
                            <p class="mb-2"><strong>Order ID:</strong> $booking_fetch[order_id]</p>
                            <p class="mb-2"><strong>Hotel:</strong> $booking_fetch[room_name]</p>
                            <p class="mb-2"><strong>Check-in:</strong> $booking_fetch[check_in]</p>
                            <p class="mb-2"><strong>Check-out:</strong> $booking_fetch[check_out]</p>
                            <p class="mb-4"><strong>Amount:</strong> ₹$booking_fetch[total_pay]</p>
                            <a href='booking.php' class='btn btn-primary'>View My Bookings</a>
                        </div>
                    </div>
                </div>
                data;
            } 
            else {
                echo<<<data
                <div class="col-12 px-4">
                    <div class="alert alert-danger text-center" role="alert">
                        <p class="fw-bold">
                            <i class="bi bi-x-circle-fill"></i>
                            Booking Failed! $booking_fetch[trans_resp_msg]
                            </br></br>
                            <a href='booking.php'>Go to Bookings</a>
                        </p>
                    </div>
                </div>
                data;
            }
            ?>
        </div>
    </div>

    <?php require('inc/footer.php') ?>
</body>
</html>