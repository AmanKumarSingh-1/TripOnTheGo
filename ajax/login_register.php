<?php 
require(__DIR__ . "/../admin/inc/db_config.php");
require(__DIR__ . "/../admin/inc/essentials.php");
require("../inc/sendgrid/sendgrid-php.php");

function send_mail($uemail,$name,$token)
{
    $email = new \SendGrid\Mail\Mail(); 
    $email->setFrom("gauravsinha944@gmail.com", "TripOnTheGo");
    $email->setSubject("Account Verification Link");

    $email->addTo($uemail, $name);

    $email->addContent(
        "text/html", 
        " 
               Click the link upabove to verify your account and confirm your email <br>
               <a href='".SITE_URL."email_confirm.php?email_confirmation&email=$uemail&token=$token"."'>
                 Click me
                </a>
               "
    );
    try{
    $sendgrid = new \SendGrid(SENDGRID_API_KEY);
      if($sendgrid->send($email)){
        return 1;
      }
      else{
        return 0;
      }
    }
    catch(Exception $e){
        return 0;
    }
}

if (isset($_POST['register'])) {
    // Debugging aid
    file_put_contents("log.txt", "Received registration request\n", FILE_APPEND);

    $data = filteration($_POST);

    // Match password and confirm password
    if ($data['pass'] != $data['cpass']) {
        echo 'pass_mismatch';
        exit;
    }

    // Check if user already exists
    $u_exist = select("SELECT * FROM `user_cred` WHERE `email` = ? OR `phonenum` = ? LIMIT 1", 
                      [$data['email'], $data['phonenum']], "ss");

    if (mysqli_num_rows($u_exist) != 0) {
        $u_exist_fetch = mysqli_fetch_assoc($u_exist);
        echo ($u_exist_fetch['email'] == $data['email']) ? 'email_already' : 'phone_already';
        exit;
    }

    // Upload user profile image
    $img = uploadUserImage($_FILES['profile']);

    if ($img == 'inv_img') {
        echo 'inv_img';
        exit;
    } elseif ($img == 'upd_failed') {
        echo 'upd_failed';
        exit;
    }

    // Send confirmation link to user's email
    $token = bin2hex(random_bytes(16));
    if (!send_mail($data['email'], $data['name'], $token)) {
        echo 'mail_failed';
        exit;
    }

    // Encrypt password
    $enc_pass = password_hash($data['pass'], PASSWORD_BCRYPT);

    // Insert into database
    $query = "INSERT INTO `user_cred` (`name`, `email`, `address`, `phonenum`, `pincode`, `dob`, `profile`, `password`, `token`) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $values = [
        $data['name'], $data['email'], $data['address'], $data['phonenum'], 
        $data['pincode'], $data['dob'], $img, $enc_pass, $token
    ];

    if (insert($query, $values, 'sssssssss')) {
        echo 1;
    } else {
        global $con;
        echo 'ins_failed: ' . mysqli_error($con);
    }
}
?>