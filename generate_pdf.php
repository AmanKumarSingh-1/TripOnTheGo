<?php

    require("admin/inc/essentials.php");
    require("admin/inc/db_config.php");
    require("admin/inc/mpdf/vendor/autoload.php");
    
    session_start();

    if(!(isset($_SESSION['login']) && $_SESSION['login'] == true)){
        redirect('index.php');
    }

    if(isset($_GET['gen_pdf']) && isset($_GET['id'])) {
        $frm_data = filteration($_GET);
        

        $query = "SELECT bo.*, bd.*, uc.email FROM `booking_order` bo 
                  INNER JOIN `booking_details` bd ON bo.booking_id = bd.booking_id INNER JOIN `user_cred` uc on bo.user_id = uc.id
                  WHERE ((bo.booking_status = 'booked' AND bo.arrival = 1) OR (bo.booking_status = 'cancelled')) AND bo.booking_id = '$frm_data[id]'";

        $res = mysqli_query($con, $query);

        $total_rows = mysqli_num_rows($res);

        if($total_rows == 0) {
            header('location: dashboard.php');
            exit;
        }
        $data = mysqli_fetch_assoc($res);
        $date = date("d-m-Y", strtotime($data['datentime']));
        $checkin = date("d-m-Y", strtotime($data['check_in']));
        $checkout = date("d-m-Y", strtotime($data['check_out']));

        $table_data = "
            <div style='font-family: \"Segoe UI\", Tahoma, Geneva, Verdana, sans-serif; color: #333;'>
                <h2 style='text-align:center; color:#1A5276; margin-bottom: 20px;'> Booking Receipt</h2>

                <table style='width:100%; border-collapse: collapse; box-shadow: 0 2px 10px rgba(0,0,0,0.1);'>
                    <tr style='background-color: #D6EAF8; font-weight: bold; font-size: 16px;'>
                        <td colspan='2' style='padding: 12px; border: 1px solid #ccc;'>Order ID: {$data['order_id']}</td>
                    </tr>
                    <tr>
                        <td style='padding: 10px; border: 1px solid #ccc;'><strong>Booking Date:</strong> {$date}</td>
                        <td style='padding: 10px; border: 1px solid #ccc;'><strong>Status:</strong> {$data['booking_status']}</td>
                    </tr>
                    <tr>
                        <td style='padding: 10px; border: 1px solid #ccc;'><strong>Name:</strong> {$data['user_name']}</td>
                        <td style='padding: 10px; border: 1px solid #ccc;'><strong>Email:</strong> {$data['email']}</td>
                    </tr>
                    <tr>
                        <td style='padding: 10px; border: 1px solid #ccc;'><strong>Phone No.:</strong> {$data['phonenum']}</td>
                        <td style='padding: 10px; border: 1px solid #ccc;'><strong>Address:</strong> {$data['address']}</td>
                    </tr>
                    <tr style='background-color: #F9F9F9;'>
                        <td style='padding: 10px; border: 1px solid #ccc;'><strong>Room Name:</strong> {$data['room_name']}</td>
                        <td style='padding: 10px; border: 1px solid #ccc;'><strong>Cost:</strong> ₹{$data['price']} per night</td>
                    </tr>
                    <tr>
                        <td style='padding: 10px; border: 1px solid #ccc;'><strong>Check-in:</strong> {$checkin}</td>
                        <td style='padding: 10px; border: 1px solid #ccc;'><strong>Check-out:</strong> {$checkout}</td>
                    </tr>
                ";



        if($data['booking_status'] == 'cancelled') {
            $table_data.="
                <tr>
                    <td style='padding: 10px; border: 1px solid #ccc;'><strong>Amount to be paid: </strong> ₹$data[trans_amt]</td>
                </tr>
            ";

        }
        else {
            $table_data.="
                <tr>
                    <td style='padding: 10px; border: 1px solid #ccc;'><strong>Room Number: </strong> $data[room_no]</td>
                    <td style='padding: 10px; border: 1px solid #ccc;'><strong>Amount to be paid: </strong> ₹$data[trans_amt]</td>
                </tr>
            ";
        }

        $table_data.="
            </table>
            <p style='text-align: center; font-size: 12px; color: #888; margin-top: 20px;'>Thank you for booking with us!</p>
        </div>
        ";

        $mpdf = new \Mpdf\Mpdf();

        $mpdf->WriteHTML($table_data);

        $mpdf->Output($data['order_id'].'.pdf', 'D');
    }
    else {
        header('location: dashboard.php');
    }

?>