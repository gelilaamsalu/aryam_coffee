<?php
require 'config.php';
session_start(); // Start the session

// Check if the admin is logged in, otherwise redirect to login page
if (!isset($_SESSION['admin_id'])) {
    header('Location: /admin.php');
    exit();
}



// Code to manage users...

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin</title>
    <link rel="stylesheet" href="manage users.css">
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
        
        <img src="../sf/ph1.png" id="logo" alt="">
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
                <li><a class="active" href="#"><i class="fas fa-users-cog"></i> MANAGE USERS</a></li>
            </ul>
        </div>
    </section><br>
    <div id="bbv">
    <!-- Adding a user icon next to the 'Manage Users' text -->
    <p><i class="fas fa-users"></i> MANAGE USERS</p>

    <a href="./add.php"><button id="bbs"><i class="fas fa-plus"></i> Add Page</button></a>
</div>

<?php
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_sql = "DELETE FROM tblmanageusers WHERE id='$delete_id'";
    $conn->query($delete_sql);
}

// Fetch data from tblmanageusers table
$fetch_sql = "SELECT * FROM tblmanageusers";
$result = $conn->query($fetch_sql);

if ($result->num_rows > 0) {
    echo '<table>';
    echo '<tr>';
    echo '<th><i class="fas fa-id-badge"></i> ID</th>';
    echo '<th><i class="fas fa-user"></i> USERNAME</th>';
    echo '<th><i class="fas fa-envelope"></i> EMAIL</th>';
    echo '<th><i class="fas fa-tasks"></i> ACTION</th>';
    echo '</tr>';

    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td><i class="fas fa-id-card"></i> ' . htmlspecialchars($row['id']) . '</td>';
        echo '<td><i class="fas fa-user"></i> ' . htmlspecialchars($row['username']) . '</td>';
        echo '<td><i class="fas fa-envelope"></i> ' . htmlspecialchars($row['email']) . '</td>';

        echo '<td>';
        echo '<a href="?delete_id=' . $row['id'] . '" onclick="return confirm(\'Are you sure you want to delete this user?\')"><button><i class="fas fa-trash-alt"></i> Delete</button></a> ';
        echo '<a href="edit.php?id=' . $row['id'] . '"><button id="but"><i class="fas fa-edit"></i> Edit</button></a>';
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