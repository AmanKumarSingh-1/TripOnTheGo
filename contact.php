<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TripOnTheGo-CONTACT</title>

    <?php require('inc/links.php'); ?>

</head>

<body class="bg-light">

    <?php require('inc/header.php'); ?>

    <div class="mg-5 px-4">
        <br>
        <br>
        <h2 class="fw-bold h-font text-center">CONTACT US</h2>
        <div class="h-line bg-dark"></div>
        <p class="text-center mt-3">Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorum quae, odit possimus incidunt harum facilis libero vel voluptates voluptate labore nemo esse obcaecati error magni ipsum porro aliquid distinctio id?
        </p>
    </div>



    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 mb-5 px-4">
                <div class="bg-white rounded shadow p-4">
                    <iframe class="w-100 rounded mb-4" src="<?php echo $contact_r['iframe'] ?>" height="320" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

                    <h5>Address</h5>
                    <a href="<?php echo $contact_r['gmap'] ?>" target="blank" class="d-inline-block text-decoration-none text-dark" mb-4>
                        <i class="bi bi-geo-alt-fill"></i> <?php echo $contact_r['address'] ?>
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
                    <form>
                        <h5>Send a message</h5>
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control shadow-none">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control shadow-none">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Subject</label>
                            <input type="text" class="form-control shadow-none">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Message</label>
                            <textarea class="form-control shadow-none" rows="5" style="resize : none;"></textarea>
                        </div>
                        <button type="submit" class="btn btn-dark shadow-none">SEND</button>
                    </form>
                </div>
            </div>


            <?php require('inc/footer.php') ?>

</body>

</html>
