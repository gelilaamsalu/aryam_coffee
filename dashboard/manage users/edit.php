<?php
require "config.php";
$errorMsg = '';
$successMsg = '';

// Fetch the current data for the record being edited (based on ID passed via GET)
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $fetch_sql = "SELECT * FROM tblmanageusers WHERE id = ?";
    $stmt = $conn->prepare($fetch_sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $current_username = $row['username'];
        $current_email = $row['email'];
        $current_password = $row['password'];
    } else {
        $errorMsg = 'Record not found.';
    }
} else {
    $errorMsg = 'Invalid request. No ID specified.';
}

// Handle form submission for updating user
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Hash the password before storing it
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    if (empty($errorMsg)) {
        // Update data in the tblmanageusers table
        $update_sql = "UPDATE tblmanageusers SET username = ?, email = ?, password = ? WHERE id = ?";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param("sssi", $username, $email, $hashed_password, $id);

        if ($stmt->execute()) {
            $successMsg = 'User updated successfully!';
        } else {
            $errorMsg = 'Error updating user: ' . $stmt->error;
        }
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
    <title>Edit User</title>
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
            <p id="contactss">Aryam Coffee Admin Dashboard</p><br>
            <ul id="navbar1">
                <li><a class="active" href="../home.php">Logout</a></li><br><br>
            </ul>
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

    <!-- Form for editing user -->
    <form action="" method="POST">
        <h4 class="text-warning text-center pt-5">Edit User</h4>

        <!-- Display error or success message -->
        <?php if (!empty($errorMsg)): ?>
            <div class="error"><?php echo $errorMsg; ?></div>
        <?php elseif (!empty($successMsg)): ?>
            <div class="success"><?php echo $successMsg; ?></div>
        <?php endif; ?>

        <label>
          <input
            type="text"
            class="input"
            name="username" value="<?php echo isset($current_username) ? $current_username : ''; ?>" required
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
            name="email" value="<?php echo isset($current_email) ? $current_email : ''; ?>" required
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
            name="password" required
            placeholder="PASSWORD"
          />
          <div class="line-box">
            <div class="line"></div>
          </div>
        </label>

        <button type="submit">Edit</button>
    </form><br><br><br>

</body>
</html>
