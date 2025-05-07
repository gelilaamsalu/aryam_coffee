<?php
require "config.php"
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin</title>
    <link rel="stylesheet" href="contact us.css">
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
                <li><a class="active" href="#"><i class="fas fa-envelope"></i> CONTACT US</a></li>
                <li><a href="../menu/menu.php"><i class="fas fa-utensils"></i> MENU</a></li>
                <li><a href="../order/order.php"><i class="fas fa-shopping-cart"></i> ORDER</a></li>
                <li><a href="../reservation/reservation.php"><i class="fas fa-calendar-alt"></i> RESERVATION</a></li>
                <li><a href="../manage users/manage users.php"><i class="fas fa-users-cog"></i> MANAGE USERS</a></li>
            </ul>
            </div>
            
        </div>
        

    </section><br>
    <div id="bbv">
        <p><i class="fas fa-envelope"></i>CONTACT US</p>
</div>

    <!--  -->
   <?php
   
    echo '<table>';
    echo '<tr>
    <th><i class="fas fa-user"></i>NAME</th>
    <th><i class="fas fa-envelope"></i>EMAIL</th>
    <th><i class="fas fa-phone"></i>PNUMBER</th>
    <th><i class="fas fa-comment"></i>SUBJECT</th>
    <th><i class="fas fa-message"></i>MESSAGE</th>
    <th><i class="fas fa-tasks"></i>ACTION</th>
    </tr>';
  
    
       
    
   

// Handle delete request
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // Use a prepared statement to prevent SQL injection
    $delete_sql = "DELETE FROM tblcontact WHERE id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $delete_id); // "i" indicates that the parameter is an integer
    $stmt->execute();
    
    if ($stmt->affected_rows > 0) {
        echo "Record deleted successfully.";
    } else {
        echo "Error deleting record.";
    }
    
    $stmt->close();
    header("Location: " . $_SERVER['PHP_SELF']); // Redirect to the same page to refresh the list
    exit;
}

// Fetch data from tblreservation table
$fetch_sql = "SELECT * FROM tblcontact";
$result = $conn->query($fetch_sql);

// Check if there are rows in the result
if ($result->num_rows > 0) {
    
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td><i class="fas fa-user"></i>' . htmlspecialchars($row['name']) . '</td>';
        echo '<td><i class="fas fa-envelope"></i>' . htmlspecialchars($row['email']) . '</td>';
        echo '<td><i class="fas fa-phone"></i>' . htmlspecialchars($row['pnumber']) . '</td>';
        echo '<td><i class="fas fa-comment"></i>' . htmlspecialchars($row['subject']) . '</td>';
        echo '<td><i class="fas fa-message"></i>' . htmlspecialchars($row['message']) . '</td>';
        echo '<td>';

        echo '<a href="?delete_id=' . $row['id'] . '" onclick="return confirm(\'Are you sure you want to delete this record?\')">';
        echo '<button><i class="fas fa-trash-alt"></i> Delete</button></a>';
        echo '</td>';
        echo '</tr>';
    }
    echo '</table>';
} 

?>
    
</body>
</html>