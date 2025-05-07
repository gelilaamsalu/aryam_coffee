<?php
require "config.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="testimonial.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin=""/>
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
            <p id="contactss">Aryam Coffee Admin Dashboard</p><br>
            <ul id="navbar1">
                <li><a class="active" href="../home.php">Logout</a></li><br><br>
            </ul>
        </div>
    </section>

    <section id="header">
        <img src="../sf/ph1.png" id="logo" alt="">
        <ul id="navbar">
                <li><a  href="../user.php"><i class="fas fa-home"> </i> HOME</a></li>
                <li><a href="../feed back/feed back.php"><i class="fas fa-comments"> </i> FEEDBACK</a></li>
                <li><a class="active" href="#"><i class="fas fa-quote-left"> </i> TESTIMONIAL</a></li>
                <li><a href="../roast/roast.php"><i class="fas fa-coffee"></i> ROAST</a></li>
                <li><a href="../contact us/contact us.php"><i class="fas fa-envelope"></i> CONTACT US</a></li>
                <li><a href="../menu/menu.php"><i class="fas fa-utensils"></i> MENU</a></li>
                <li><a href="../order/order.php"><i class="fas fa-shopping-cart"></i> ORDER</a></li>
                <li><a href="../reservation/reservation.php"><i class="fas fa-calendar-alt"></i> RESERVATION</a></li>
                <li><a href="../manage users/manage users.php"><i class="fas fa-users-cog"></i> MANAGE USERS</a></li>
                
            </ul>
    </section><br>

    <div id="bbv">
        <p><i class="fas fa-quote-left"> </i>TESTIMONIALS</p>
        
    </div>

    <!-- Fetch and display testimonials -->
    <?php
    // Handle delete request
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // Use a prepared statement to prevent SQL injection
    $delete_sql = "DELETE FROM tbltestimonial WHERE id = ?";
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

    // Fetch data from tblfeedback table
    $fetch_sql = "SELECT * FROM tbltestimonial";
    $result = $conn->query($fetch_sql);

    if ($result->num_rows > 0) {
        echo '<table>';
        echo '<tr>
        <th>ID <i class="fas fa-id-badge"></i></th>
        <th>IMAGE <i class="fas fa-image"></i></th>
        <th>NAME <i class="fas fa-user"></i></th>
        <th>FEEDBACK <i class="fas fa-comments"></i></th>
        <th>RATE <i class="fas fa-star"></i></th>
        <th>ACTION <i class="fas fa-tasks"></i></th>
      </tr>';


        while($row = $result->fetch_assoc()) {
            $rating = (int)$row['rate']; // Ensure rate is treated as an integer
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row['id']) . '</td>';
            echo '<td><img src="../feed back/photos/' . htmlspecialchars($row['photo']) . '" alt="User Photo" width="100" height="100"></td>';
            echo '<td>' . htmlspecialchars($row['name']) . '</td>';
            echo '<td>' . htmlspecialchars($row['feedback']) . '</td>';
            echo '<td>';

            // Display stars based on rating
            for ($i = 1; $i <= 5; $i++) {
                if ($i <= $rating) {
                    echo '<i class="fa fa-star checked"></i>';
                } else {
                    echo '<i class="fa fa-star"></i>';
                }
            } 

            echo '</td>';
            echo '<td>';
            echo '<a href="?delete_id=' . $row['id'] . '" onclick="return confirm(\'Are you sure you want to delete this record?\')">';
        echo '<button><i class="fas fa-trash-alt"></i> Delete</button></a>';
        echo '</td>';
            echo '</tr>';
        }

        echo '</table>';
    } else {
        echo 'No records found';
    }
    ?>
    
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://smtpjs.com/v3/smtp.js"></script> 
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>  
    <script src="project.js"></script>
</body>
</html>
