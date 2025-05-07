<?php
require "config.php"
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin</title>
    <link rel="stylesheet" href="order.css">
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
                <li><a class="active" href="#"><i class="fas fa-shopping-cart"></i> ORDER</a></li>
                <li><a href="../reservation/reservation.php"><i class="fas fa-calendar-alt"></i> RESERVATION</a></li>
                <li><a href="../manage users/manage users.php"><i class="fas fa-users-cog"></i> MANAGE USERS</a></li>
            </ul>
            </div>
            
        </div>
        

    </section><br>
    <div id="bbv">
        <p><i class="fas fa-shopping-cart"></i>ORDER</p>
    
</div>

    <!--  -->
    <?php
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_sql = "DELETE FROM tblorder WHERE id='$delete_id'";
    $conn->query($delete_sql);
}

// Fetch data from tblorder table
$fetch_sql = "SELECT * FROM tblorder";
$result = $conn->query($fetch_sql);

if ($result->num_rows > 0) {
    echo '<table>';
    echo '<tr>
        <th><i class="fas fa-id-badge"></i> ID</th>
        <th><i class="fas fa-box"></i> PRODUCT</th>
        <th><i class="fas fa-cubes"></i> QUANTITY</th>
        <th><i class="fas fa-dollar-sign"></i> PRICE</th>
        <th><i class="fas fa-calculator"></i> TOTAL PRICE</th>
        <th><i class="fas fa-user"></i> FNAME</th>
        <th><i class="fas fa-user"></i> LNAME</th>
        <th><i class="fas fa-flag"></i> COUNTRY</th>
        <th><i class="fas fa-city"></i> TOWN</th>
        <th><i class="fas fa-home"></i> HOME NO</th>
        <th><i class="fas fa-phone"></i> PNUMBER</th>
        <th><i class="fas fa-envelope"></i> EMAIL</th>
        <th><i class="fas fa-info-circle"></i> ADDITIONAL INFORMATION</th>
        <th><i class="fas fa-tasks"></i> ACTION</th>
      </tr>';

    while($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($row['id']) . '</td>';
        echo '<td>' . htmlspecialchars($row['pname']) . '</td>';
        echo '<td>' . htmlspecialchars($row['quantity']) . '</td>';
        echo '<td>' . htmlspecialchars($row['price']) . '</td>';
        echo '<td>' . htmlspecialchars($row['totalprice']) . '</td>';
        echo '<td>' . htmlspecialchars($row['fname']) . '</td>';
        echo '<td>' . htmlspecialchars($row['lname']) . '</td>';
        echo '<td>' . htmlspecialchars($row['country']) . '</td>';
        echo '<td>' . htmlspecialchars($row['town']) . '</td>';
        echo '<td>' . htmlspecialchars($row['homeno']) . '</td>';
        echo '<td>' . htmlspecialchars($row['pnumber']) . '</td>';
        echo '<td>' . htmlspecialchars($row['email']) . '</td>';
        echo '<td>' . htmlspecialchars($row['additional']) . '</td>';
        echo '<td>';
        
        // Add a confirmation dialog to the delete button
        echo '<a href="?delete_id=' . $row['id'] . '" onclick="return confirm(\'Are you sure you want to delete this order?\')">';
        echo '<button><i class="fas fa-trash-alt"></i>Delete</button></a>';
        
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