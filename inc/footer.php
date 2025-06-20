<div class="container-fluid bg-white mt-5">
    <div class="row">
        <div class="col-lg-4">
            <h3 class="h-font fw-bold fs-3 mb-2"><?php echo $settings_r['site_title'] ?></h3>
            <p>
                <?php echo $settings_r['site_about'] ?>
            </p>
        </div>
        <div class="col-lg-4">
            <h5 class="mb-3">Links</h5>
            <a href="index.php" class="d-inline-block mb-2 text-dark text-decoration-none">Home</a><br>
            <a href="rooms.php" class="d-inline-block mb-2 text-dark text-decoration-none">Rooms</a><br>
            <a href="facilities.php" class="d-inline-block mb-2 text-dark text-decoration-none">Facilities</a><br>
            <a href="contact.php" class="d-inline-block mb-2 text-dark text-decoration-none">Contact us</a><br>
            <a href="about.php" class="d-inline-block mb-2 text-dark text-decoration-none">About</a>
        </div>
        <div class="col-lg-4">
            <h5 class="mb-3">Follow us</h5>
            <?php
            if ($contact_r['facebook'] != '') {
                echo <<<data
                <a class="d-inline-block mb-2 text-dark text-decoration-none" href="$contact_r[facebook]"> <i class="bi bi-facebook"></i> Facebook</a>
                data;
            }
            ?>
            <br>
            <a class="d-inline-block mb-2 text-dark text-decoration-none" href="<?php echo $contact_r['facebook'] ?>"> <i class="bi bi-instagram"></i> Instagram</a><br>
            <a class="d-inline-block text-dark text-decoration-none" href="<?php echo $contact_r['twitter'] ?>"> <i class="bi bi-twitter-x"></i> <i class="bi bi-twitter-x"></i> Twitter</a><br>
        </div>
    </div>
</div>

<h6 class="text-center bg-dark text-white p-3 m-0">
    Designed and Developed by 
    <a href="https://github.com/aman-kumar-official" class="text-light">Aman</a>, 
    <a href="https://github.com/kgaurav-02" class="text-light">Gaurav</a>, 
    <a href="https://github.com/Sagar-6203620715" class="text-light">Sagar</a> and 
    <a href="https://github.com/simamahato" class="text-light">Sima</a>
</h6>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<script>
    function alert(type, msg, position = 'body') {
        let bs_class = (type == 'success') ? 'alert-success' : 'alert-danger';
        let element = document.createElement('div');
        element.innerHTML = `
        <div class="alert ${bs_class} alert-dismissible fade show" role="alert">
            <strong class="mt-3">${msg}</strong>.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        `;

        if (position == 'body') {
            document.body.append(element);
            element.classList.add('custom-alert');
        } else {
            document.getElementById(position).appendChild(element);
        }

        setTimeout(remAlert, 8000);
    }

    function remAlert() {
        document.getElementsByClassName('alert')[0].remove();
    }

    function setActive() {
        let navbar = document.getElementById('nav-bar');
        let a_tags = navbar.getElementsByTagName('a');

        for (let i = 0; i < a_tags.length; i++) {
            let file = a_tags[i].href.split('/').pop();
            let file_name = file.split('.')[0];

            if (document.location.href.indexOf(file_name) >= 0) {
                a_tags[i].classList.add('active');
            }
        }
    }

    let register_form = document.getElementById('register-form');

    register_form.addEventListener('submit', (e) => {
        e.preventDefault();

        let data = new FormData();

        data.append('name', register_form.elements['name'].value);
        data.append('email', register_form.elements['email'].value);
        data.append('phonenum', register_form.elements['phonenum'].value);
        data.append('address', register_form.elements['address'].value);
        data.append('pincode', register_form.elements['pincode'].value);
        data.append('dob', register_form.elements['dob'].value);
        data.append('pass', register_form.elements['pass'].value);
        data.append('cpass', register_form.elements['cpass'].value);
        data.append('profile', register_form.elements['profile'].files[0]);
        data.append('register', '1'); 

        for (let [key, value] of data.entries()) {
            console.log(`${key}:`, value);
        }

        var myModal = document.getElementById('registerModal');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/login_register.php", true);

        xhr.onload = function () {
            console.log("Server response:", this.responseText); 

            if (this.responseText.trim() === 'pass_mismatch') {
                alert('error', "Password Mismatched!");
            } else if (this.responseText.trim() === 'email_already') {
                alert('error', "Email is already registered!");
            } else if (this.responseText.trim() === 'phone_already') {
                alert('error', "Phone Number is already registered!");
            } else if (this.responseText.trim() === 'inv_img') { 
                alert('error', "Only JPG, WEBP, PNG Images are allowed!");
            } else if (this.responseText.trim() === 'upd_failed') {
                alert('error', "Image Upload Failed!");
            } else if (this.responseText.trim() === 'mail_failed') {
                alert('error', "Cannot send confirmation mail! Server down!");
            } else if (this.responseText.trim().startsWith('ins_failed')) {
                alert('error', "Registration failed! Server down! " + this.responseText);
            } else if (this.responseText.trim() === '1') {
                alert('success', "Registration successful. Confirmation link sent to email!");
                register_form.reset();
            } else {
                alert('error', "Unexpected response: " + this.responseText);
            }
        };

        xhr.onerror = function () {
            console.error("AJAX request failed");
            alert('error', "Something went wrong during registration request.");
        };

        xhr.send(data);
    });


    let login_form = document.getElementById('login-form');

    login_form.addEventListener('submit', (e) => {
        e.preventDefault();

        let data = new FormData();

        data.append('email_mob', login_form.elements['email_mob'].value);   
        data.append('pass', login_form.elements['pass'].value);
        data.append('login', '');  
        
        for (let [key, value] of data.entries()) {
            console.log(`${key}:`, value);
        }

        var myModal = document.getElementById('loginModal');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/login_register.php", true);

        xhr.onload = function () {
            if (this.responseText == 'inv_email_mob') {
                alert('error', "Invalid Email or Mobile Number! ");
            } 
            
            else if (this.responseText == 'not_verified') {
                alert('error', "Email is not verified! ");
            } 
            else if (this.responseText == 'inactive') {  
                alert('error', "Account Suspended! Please contact Admin.!");
            } 
            else if (this.responseText == 'inv_pass') {
                alert('error', "Incorrect Password!");
            }
            else {
                window.location = window.location.pathname;
            }
        }

        
        xhr.send(data);
    });


    let forgot_form = document.getElementById('forgot-form');

    forgot_form.addEventListener('submit', (e) => {
        e.preventDefault();

        let data = new FormData();
        data.append('email', forgot_form.elements['email'].value);  
        data.append('forgot_pass', '');

        var myModal = document.getElementById('forgotModal');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/login_register.php", true);

        xhr.onload = function () {
            if (this.responseText == 'inv_email') {
                alert('error', "Invalid Email!");
            } else if (this.responseText == 'not_verified') {
                alert('error', "Email is not verified! Please contact Admin.");
            } else if (this.responseText == 'inactive') {
                alert('error', "Account Suspended! Please contact Admin.");
            } else if (this.responseText == 'mail_failed') {
                alert('error', "Cannot send email. Server Down!");
            } else if (this.responseText == 'upd_failed') {
                alert('error', "Account recovery failed. Server Down!");
            } else {
                alert('success', "Reset link sent to email!");
                forgot_form.reset();
            }
        }

        xhr.send(data);
    });

    setActive();
</script>
