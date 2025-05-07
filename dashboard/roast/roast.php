

<?php
require_once 'config.php';
// Start the session
session_start();

// Check if the user is logged in
// if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // header('Location: ../admin.php');
    // exit;
// }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aryam Coffee Admin - Roast Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="roast.css">
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
        <p id="contactss">Aryam Coffee Admin Dashboard</p>
        <ul id="navbar1">
            <li><a class="active" href="home.php">Logout</a></li> <!-- Updated logout link -->
        </ul>
    </div>
</section>

<section id="header">
    <img src="../sf/ph1.png" id="logo" alt="">
    <div>
        <ul id="navbar">
            <li><a href="../home.php"><i class="fas fa-home"></i> HOME</a></li>
            <li><a href="../feed back/feed back.php"><i class="fas fa-comments"></i> FEEDBACK</a></li>
            <li><a href="../testimonial/testimonial.php"><i class="fas fa-quote-left"></i> TESTIMONIAL</a></li>
            <li><a class="active" href="#"><i class="fas fa-coffee"></i> ROAST</a></li>
            <li><a href="../contact us/contact us.php"><i class="fas fa-envelope"></i> CONTACT US</a></li>
            <li><a href="../menu/menu.php"><i class="fas fa-utensils"></i> MENU</a></li>
            <li><a href="../order/order.php"><i class="fas fa-shopping-cart"></i> ORDER</a></li>
            <li><a href="../reservation/reservation.php"><i class="fas fa-calendar-alt"></i> RESERVATION</a></li>
            <li><a href="../manage users/manage users.php"><i class="fas fa-users-cog"></i> MANAGE USERS</a></li>
        </ul>
    </div>
</section><br>

<div class="main-content">
    <div id="bbv">
        <p><i class="fas fa-coffee"></i> ROAST</p>
        <a href="./add.php"><button id="bbs"><i class="fas fa-plus"></i>Add Page</button></a>
    </div>

    <?php
    if (isset($_GET['delete_id'])) {
        $delete_id = $_GET['delete_id'];
        $delete_sql = "DELETE FROM tblroast WHERE id='$delete_id'";
        $conn->query($delete_sql);
    }
    
    // Fetch data from tblroast table
    $fetch_sql = "SELECT * FROM tblroast";
    $result = $conn->query($fetch_sql);
    
    if ($result->num_rows > 0) {
        echo '<table>';
        echo '<tr>
        <th>ID <i class="fas fa-id-card"></i></th>
        <th>TITLE <i class="fas fa-heading"></i></th>
        <th>DESCRIPTION <i class="fas fa-align-left"></i></th>
        <th>IMAGE <i class="fas fa-image"></i></th>
        <th>CATEGORY <i class="fas fa-tags"></i></th>
        <th>ACTION <i class="fas fa-tasks"></i></th>
      </tr>';

        while($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row['id']) . '</td>';
            echo '<td>' . htmlspecialchars($row['title']) . '</td>';
            echo '<td>' . htmlspecialchars($row['description']) . '</td>';
            echo '<td><img src="photos/' . htmlspecialchars($row['photo']) . '" alt="User Photo" width="100" height="100"></td>';
            echo '<td>' . htmlspecialchars($row['category']) . '</td>';
            echo '<td>';
            // Adding confirmation dialog to the delete button
            echo '<a href="?delete_id=' . $row['id'] . '" onclick="return confirm(\'Are you sure you want to delete this roast?\')">';
            echo '<button><i class="fas fa-trash-alt"></i>Delete</button></a>';
            echo '<a href="edit.php?id=' . $row['id'] . '"><button id="but"><i class="fas fa-edit"></i>Edit</button></a>';
            echo '</td>';
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo '<p>No records found</p>';
    }
?>

</div>

</body>
</html>
