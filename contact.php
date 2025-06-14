<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TripOnTheGo - CONTACT</title>

    <?php require('inc/links.php'); ?>

</head>

<body class="bg-light">

    <?php require('inc/header.php'); ?>

    <div class="my-5 px-4">
        <h2 class="fw-bold h-font text-center">CONTACT US</h2>
        <div class="h-line bg-dark"></div>
        <p class="text-center mt-3">Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorum quae, odit possimus incidunt harum facilis libero vel voluptates voluptate labore nemo esse obcaecati error magni ipsum porro aliquid distinctio id?
        </p>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 mb-5 px-4">
                <div class="bg-white rounded shadow p-4">
                    <iframe class="w-100 rounded mb-4" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d117711.79652321864!2d86.09336889558041!3d22.784165518854753!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39f5e31989f0e2b5%3A0xeeec8e81ce9b344!2sJamshedpur%2C%20Jharkhand!5e0!3m2!1sen!2sin!4v1749109966243!5m2!1sen!2sin" height="320" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    <h5>Address</h5>
                    <a href="https://maps.app.goo.gl/zrGTS44hNgUrE9ke9" target="blank" class="d-inline-block text-decoration-none text-dark" mb-4>
                        <i class="bi bi-geo-alt-fill"></i> XYZ, Prayagraj, Uttar Pradesh
                    </a>

                    <!-- CALL US -->

                    <h5 class="mt-4">Call Us</h5>
                    <a href="tel: +<?php echo $contact_r['pn1'] ?>" class="d-inline-block mb-2 text-decoration-none text-dark">
                        <i class="bi bi-telephone-fill"></i> +<?php echo $contact_r['pn1'] ?>
                    </a>
                    <br>

                    <?php
                    if ($contact_r['pn2'] != '') {
                        echo <<<data
                            <a href="tel: +$contact_r[pn2]" class="d-inline-block mb-2 text-decoration-none text-dark">
                            <i class="bi bi-telephone-fill"></i> +$contact_r[pn2]
                            </a>    
                            data;
                    }
                    ?>


                    <h5 class="mt-4">Email</h5>
                    <a href="mail to : <?php echo $contact_r['email'] ?>" class="d-inline-block mb-2 text-decoration-none text-dark">
                        <i class="bi bi-envelope-fill"></i> <?php echo $contact_r['email'] ?> </a>

                    <h5 class="mt-4">Follow Us</h5>

                    <?php
                    if ($contact_r['twitter'] != '') {
                        echo <<<data
                        
                        <a href="$contact_r[twitter]" class="d-inline-block text-dark fs-5">
                        <i class="bi bi-twitter"></i>
                        </a>
                        
                        data;
                    } ?>

                    <?php
                    if ($contact_r['twitter'] != '') {
                        echo <<<data
                        
                        <a href="$contact_r[facebook]" class="d-inline-block text-dark fs-5 me-2">
                        <i class="bi bi-facebook"></i>
                        </a>
                        
                        data;
                    } ?>

                    <a href="#" class="d-inline-block text-dark fs-5 me-2">
                        <i class="bi bi-instagram"></i>
                    </a>

                </div>
            </div>

            <div class="col-lg-6 col-md-6 px-4">
                <div class="bg-white rounded shadow p-4">
                    <form method="POST">
                        <h5>Send a message</h5>
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                        <input name="name" required type="text" class="form-control shadow-none">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                        <input name="email" required type="email" class="form-control shadow-none">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Subject</label>
                        <input name="subject" required type="text" class="form-control shadow-none">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Message</label>
                            <textarea name="message" required class="form-control shadow-none" rows="5" style="resize : none;"></textarea>
                        </div>
                            <button type="submit" name="send" class="btn btn-dark shadow-none">SEND</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
              
    <?php 
      If(isset($_POST['send']))
      {
        $frm_data = filteration($_POST);

        $q = "INSERT INTO `user_queries`(`name`, `email`, `subject`, `message`) VALUES (?,?,?,?)";
        $values = [$frm_data['name'],$frm_data['email'],$frm_data['subject'],$frm_data['message']];

        $res = insert($q, $values,'ssss');
        if($res==1){
            alert('success','Mail Sent');
        }
        else{
            alert('error','Server Down Try Again Later');
        }
      }
    ?>

            <?php require('inc/footer.php') ?>

</body>

</html>