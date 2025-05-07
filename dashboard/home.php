<?php
require 'config.php';


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    

    <section class="section1">
        <div class="header">
            <img src="../sf/ph1.png" alt="">
        </div>  

    </section>
    <h1 id="contactss">Aryam Coffee Admin Page</h1><br>
<form id="contact_form" action="login_handler.php" method="POST"> <!-- Changed to POST method -->
    <div class="col">
        <input type="email" id="email" class="form-input w-100" name="email" placeholder="Email" required>
        <input type="password" id="password" class="form-input w-100" name="password" placeholder="Password" required><br>
        <button class="btn-grad w-100 text-uppercase" id="su" type="submit">Login</button>
    </div>
</form>

<!-- footer -->
<footer><br><br><br><br>
    <div id="col">
        <div id="wave1">
            <div id="wave">
              <img  src="./sf/ph1.png">
              
            </div>
            <div id="social">
                <p>Connect with Us Across Social Media Platforms.</p>
                <a id="pol" href=""><ion-icon name="logo-instagram" id="sos"></ion-icon></a>
                <a id="pol" href=""><ion-icon name="logo-tiktok" id="sos"></ion-icon></a>
            </div>
        </div>
        <div id="col2">
            <div>
                <div>
                   <h5>USEFUL LINKS</h5>
                </div>
                <div>
                <a href="../index.php">HOME</a><br>
                
                <a href="../order.php">MENU</a><br>
                <a id="pol" href="../contact us.php">CONTACT US</a><br>
                <a href="../reservation.php">RESERVATION</a><br>
                </div>
            </div>
            <div>
                
            <div>
                <div>
                   <h5>CONTACT US</h5>
                </div>
                <div id="con">
                   <p>Addis Ababa <br>
                    Ethiopia</p><br>
                   <p><b>Phone:</b>0999999999</p>
                   <p><b>E-mail:</b>aryamcoffee@gmail.com</p>
                </div>
            </div>
        </div><br><br>
    </div>
   
</footer><br>


<p id="me">© Copyright <b>Aryam Coffee</b> 2024. All Rights Reserved</p>    
<p id="me"> Developed by Gelila</p>



<!-- js -->
<script src="project.js"></script>
<script src="project.js"></script>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    
</body>
</html>
