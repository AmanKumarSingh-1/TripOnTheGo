<?php
require('admin/inc/db_config.php');
require('admin/inc/essentials.php');

date_default_timezone_set('Asia/Kolkata');
session_start();

if (!(isset($_SESSION['login']) && $_SESSION['login']==true)) {
    redirect('index.php');
}

if(isset($_POST['pay_now'])) {
    $frm_data = filteration($_POST);
    
    // Generate order ID
    $ORDER_ID = 'ORD_'.$_SESSION['uId'].random_int(11111, 999999999);
    $CUST_ID = $_SESSION['uId'];
    $TXN_AMOUNT = $_SESSION['room']['payment'];
    
    // Insert booking data
    // In pay_now.php
    $query1 = "INSERT INTO `booking_order`(`user_id`, `room_id`, `check_in`, `check_out`, `order_id`, `booking_status`, `trans_status`, `trans_resp_msg`, `trans_amt`) 
            VALUES (?, ?, ?, ?, ?, 'booked', 'TXN_SUCCESS', 'Booking confirmed', ?)";

    insert($query1, [
        $CUST_ID, 
        $_SESSION['room']['id'], 
        $frm_data['check_in'], 
        $frm_data['check_out'], 
        $ORDER_ID,
        $TXN_AMOUNT  
    ], 'issssi');  

    $booking_id = mysqli_insert_id($con);

    $query2 = "INSERT INTO `booking_details`(`booking_id`, `room_name`, `room_no`, `price`, `total_pay`, `user_name`, `phonenum`, `address`) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    insert($query2, [
        $booking_id, 
        $_SESSION['room']['name'], 
        $_SESSION['room']['room_no'], 
        $_SESSION['room']['price'], 
        $TXN_AMOUNT, 
        $frm_data['name'], 
        $frm_data['phonenum'], 
        $frm_data['address']
    ], 'isssdsss');  

    // Redirect to booking status page
    redirect('pay_status.php?order='.$ORDER_ID);
}
?>