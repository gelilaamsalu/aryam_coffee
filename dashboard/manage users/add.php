<?php
require "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  // Sanitize input
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  
  // Hash the password
  $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Use PASSWORD_DEFAULT or a stronger algorithm if needed

  // Insert data into the database
  $stmt = $conn->prepare("INSERT INTO tblmanageusers (username, email, password) VALUES (?, ?, ?)");
  $stmt->bind_param("sss", $username, $email, $hashed_password);

  if ($stmt->execute()) {
      echo 'User registered successfully.<br>';
  } else {
      echo 'Error registering user: ' . $stmt->error . '<br>';
  }

  // Close the statement and connection
  $stmt->close();
  $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin</title>
    <link rel="stylesheet" href="add.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
<style>
        #but{
           background-color:green;
        }
        #navbar1 {
           
        }
        #navbar i {
            letter-spacing: 10px;
            color: #e4d2ab;
        }
    </style>
    <section id="head">
        
        
            
    <div>
                <p id="contactss">Aryam Coffee Admin Dashboard</p ><br>
                <ul id="navbar1">
                    
                    <li><a class="active" href="../home.php">Logout</a></li><br><br>
                    
                   
                </ul>
                
                </div>
                
            </div>
    </section>
    <section id="header">
        
        <img src="./sf/ph1.png" id="logo" alt="">
        <div>
        <ul id="navbar">
                <li><a  href="../user.php"><i class="fas fa-home"> </i> HOME</a></li>
                <li><a href="../feed back/feed back.php"><i class="fas fa-comments"> </i> FEEDBACK</a></li>
                <li><a href="../testimonial/testimonial.php"><i class="fas fa-quote-left"> </i> TESTIMONIAL</a></li>
                <li><a href="../roast/roast.php"><i class="fas fa-coffee"></i> ROAST</a></li>
                <li><a href="../contact us/contact us.php"><i class="fas fa-envelope"></i> CONTACT US</a></li>
                <li><a href="../menu/menu.php"><i class="fas fa-utensils"></i> MENU</a></li>
                <li><a href="../order/order.php"><i class="fas fa-shopping-cart"></i> ORDER</a></li>
                <li><a href="../reservation/reservation.php"><i class="fas fa-calendar-alt"></i> RESERVATION</a></li>
                <li><a class="active" href="../manage users/manage users.php"><i class="fas fa-users-cog"></i> MANAGE USERS</a></li>
            </ul>
        </div>
    </section><br>
    <div id="bbv">
    <!-- Adding a user icon next to the 'Manage Users' text -->
    <p><i class="fas fa-users"></i> MANAGE USERS</p>
   
</div>

    <!--  -->
    <form action="" method="POST" enctype="multipart/form-data">
        <h4 class="text-warning text-center pt-5">Add Page</h4>

        
        
        <label>
          <input
            type="text"
            class="input"
            name="username" autocomplete="off" required
            placeholder="USERNAME"
          />
          <div class="line-box">
            <div class="line"></div>
          </div>
        </label>
        <label>
          <input
            type="email"
            class="input"
            name="email" autocomplete="off" optional
            placeholder="EMAIL"
          />
          <div class="line-box">
            <div class="line"></div>
          </div>
       
</label>

        <label>
          <input
            type="password"
            class="input"
            name="password" autocomplete="off" required
            placeholder="PASSWORD"
          />
          <div class="line-box">
            <div class="line"></div>
          </div>
</label>
          
            
 
              


        <button type="submit">Add</button>
      </form><br><br><br>
    
</body>
</html>