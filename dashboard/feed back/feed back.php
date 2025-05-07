<?php

require "config.php";


  
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="feed back.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin=""/>
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
                <li><a class="active" href="#"><i class="fas fa-comments"> </i> FEEDBACK</a></li>
                <li><a href="../testimonial/testimonial.php"><i class="fas fa-quote-left"> </i> TESTIMONIAL</a></li>
                <li><a href="../roast/roast.php"><i class="fas fa-coffee"></i> ROAST</a></li>
                <li><a href="../contact us/contact us.php"><i class="fas fa-envelope"></i> CONTACT US</a></li>
                <li><a href="../menu/menu.php"><i class="fas fa-utensils"></i> MENU</a></li>
                <li><a href="../order/order.php"><i class="fas fa-shopping-cart"></i> ORDER</a></li>
                <li><a href="../reservation/reservation.php"><i class="fas fa-calendar-alt"></i> RESERVATION</a></li>
                <li><a href="../manage users/manage users.php"><i class="fas fa-users-cog"></i> MANAGE USERS</a></li>
            </ul>
    </section><br>

    <div id="bbv">
        <p><i class="fas fa-comments"> </i>FEEDBACK</p>
        
    </div>

    <!-- Fetch and display testimonials -->
    <?php
require "config.php"; // Ensure this includes your database connection code

// Handle deletion of feedback from `tblfeedback`
if (isset($_GET['delete_id'])) {
    $delete_id = filter_var($_GET['delete_id'], FILTER_SANITIZE_NUMBER_INT);
    if ($delete_id) {
        $delete_sql = "DELETE FROM tblfeedback WHERE id=?";
        $stmt = $conn->prepare($delete_sql);
        $stmt->bind_param("i", $delete_id); // 'i' for integer
        if ($stmt->execute()) {
            header("Location: feed back.php?message=deleted");
            exit();
        } else {
            echo "Error deleting feed back: " . $stmt->error;
        }
    }
}

// Handle the approval process: move from `tblfeedback` to `tbltestimonial`
if (isset($_GET['approve_id'])) {
    $approve_id = filter_var($_GET['approve_id'], FILTER_SANITIZE_NUMBER_INT);
    if ($approve_id) {
        // Fetch the feedback from `tblfeedback` by id
        $fetch_feedback_sql = "SELECT * FROM tblfeedback WHERE id=?";
        $stmt = $conn->prepare($fetch_feedback_sql);
        $stmt->bind_param("i", $approve_id); // 'i' for integer
        $stmt->execute();
        $feedback_result = $stmt->get_result();
    
        if ($feedback_result->num_rows > 0) {
            // Fetch the data
            $feedback_row = $feedback_result->fetch_assoc();
            $name = $feedback_row['name'];
            $feedback = $feedback_row['feedback'];
            $rate = $feedback_row['rate'];
            $photo = $feedback_row['photo']; // Ensure this includes the correct path
    
            // Insert the feedback into `tbltestimonial`
            $insert_sql = "INSERT INTO tbltestimonial (name, feedback, rate, photo) VALUES (?, ?, ?, ?)";
            $insert_stmt = $conn->prepare($insert_sql);
            $insert_stmt->bind_param("ssis", $name, $feedback, $rate, $photo); // 's' for string, 'i' for integer (rate)
            
            if ($insert_stmt->execute()) {
                // Optional: Delete the approved feedback from `tblfeedback`
                $delete_sql = "DELETE FROM tblfeedback WHERE id=?";
                $delete_stmt = $conn->prepare($delete_sql);
                $delete_stmt->bind_param("i", $approve_id);
                $delete_stmt->execute();

                // Redirect to avoid accidental resubmission
                header("Location: feed back.php?message=approved");
                exit();
            } else {
                echo 'Error approving feed back: ' . $insert_stmt->error;
            }

            $insert_stmt->close();
        }
    }
}

// Fetch data from `tblfeedback`
$fetch_sql = "SELECT * FROM tblfeedback";
$result = $conn->query($fetch_sql);

if ($result->num_rows > 0) {
    echo '<table>';
    echo '<tr>
    <th><i class="fas fa-id-badge"></i>ID</th>
    <th><i class="fas fa-image"></i>IMAGE</th>
    <th><i class="fas fa-user"></i>NAME</th>
    <th><i class="fas fa-comments"></i>FEEDBACK</th>
    <th><i class="fas fa-star"></i>RATE</th>
    <th><i class="fas fa-tasks"></i>ACTION</th>
    </tr>';

    while ($row = $result->fetch_assoc()) {
        $rating = (int)$row['rate']; // Ensure rate is treated as an integer
        echo '<tr>';
        echo '<td>' . htmlspecialchars($row['id']) . '</td>';
        echo '<td><img src="photos/' . htmlspecialchars($row['photo']) . '" alt="User Photo" width="100" height="100"></td>';
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
        // Add an onclick event to the delete button with a confirmation dialog
        echo '<a href="?delete_id=' . htmlspecialchars($row['id']) . '" onclick="return confirm(\'Are you sure you want to delete this feedback?\')">';
        echo '<button><i class="fas fa-trash-alt"></i> Delete</button></a>';
        
        // Add an onclick event to the approve button with a confirmation dialog
        echo '<a href="?approve_id=' . htmlspecialchars($row['id']) . '" onclick="return confirm(\'Are you sure you want to approve this feedback?\')">';
        echo '<button id="bf"><i class="fas fa-check"></i> Approve</button></a>';
        
        echo '</td>';
        echo '</tr>';
    }

    echo '</table>';
} else {
    echo 'No records found';
}

$conn->close(); // Close the database connection
?>







    
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://smtpjs.com/v3/smtp.js"></script> 
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>  
    <script src="project.js"></script>
</body>
</html>
