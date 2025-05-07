<?php
require "config.php"
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin</title>
    <link rel="stylesheet" href="menu.css">
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
                <li><a  class="active" href="#"><i class="fas fa-utensils"></i> MENU</a></li>
                <li><a href="../order/order.php"><i class="fas fa-shopping-cart"></i> ORDER</a></li>
                <li><a href="../reservation/reservation.php"><i class="fas fa-calendar-alt"></i> RESERVATION</a></li>
                <li><a href="../manage users/manage users.php"><i class="fas fa-users-cog"></i> MANAGE USERS</a></li>
                
            </ul>
            </div>
            
        </div>
        

    </section><br>
    <div id="bbv">
        <p><i class="fas fa-utensils"></i>MENU</p>
    <a href="./add.php"><button id="bbs"><i class="fas fa-plus"></i>Add Page</button></a>
</div>

    <!--  -->


   
    <?php

if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_sql = "DELETE FROM tblmenu WHERE id='$delete_id'";
    $conn->query($delete_sql);
}

// Fetch data from tblmenu table
$fetch_sql = "SELECT * FROM tblmenu";
$result = $conn->query($fetch_sql);

if ($result->num_rows > 0) {
    echo '<table>';
    echo '<tr>
        <th><i class="fas fa-image"></i> IMAGE</th>
        <th><i class="fas fa-heading"></i> TITLE</th>
        <th><i class="fas fa-dollar-sign"></i> PRICE</th>
        <th><i class="fas fa-percentage"></i> DISCOUNT</th>
        <th><i class="fas fa-info-circle"></i> DESCRIPTION</th>
        <th><i class="fas fa-tasks"></i> ACTION</th>
      </tr>';

    while($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td><img src="photos/' . htmlspecialchars($row['photo']) . '" alt="User Photo" width="100" height="100"></td>';
        echo '<td>' . htmlspecialchars($row['title']) . '</td>';
        echo '<td>' . htmlspecialchars($row['price']) . '</td>';
        echo '<td>' . htmlspecialchars($row['discount']) . '</td>';
        echo '<td>' . htmlspecialchars($row['description']) . '</td>';
        echo '<td>';
        
        // Add a confirmation dialog to the delete button
        echo '<a href="?delete_id=' . $row['id'] . '" onclick="return confirm(\'Are you sure you want to delete this menu item?\')">';
        echo '<button><i class="fas fa-trash-alt"></i>Delete</button></a>';
        
        echo '<a href="edit.php?id=' . $row['id'] . '"><button id="but"><i class="fas fa-edit"></i>Edit</button></a>';
        echo '</td>';
        echo '</tr>';
    }

    echo '</table>';
} else {
    echo 'No records found';
}
?>

  
    
       
    
   




    
</body>
</html>