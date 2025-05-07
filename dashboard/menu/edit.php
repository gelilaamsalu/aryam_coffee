<?php
require "config.php";
$errorMsg = '';
$successMsg = '';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the current record from tblmenu
    $fetch_sql = "SELECT * FROM tblmenu WHERE id = ?";
    $stmt = $conn->prepare($fetch_sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $current_title = $row['title'];
        $current_description = $row['description'];
        $current_discount = $row['discount'];
        $current_photo = $row['photo'];
        $current_price = $row['price'];
    } else {
        $errorMsg = 'Record not found.';
    }
} else {
    $errorMsg = 'Invalid request. No ID specified.';
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Sanitize input
    $title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
    $price = filter_var($_POST['price'], FILTER_SANITIZE_STRING);
    $discount = filter_var($_POST['discount'], FILTER_SANITIZE_STRING);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);

    // Validate the inputs
    if (empty($title) || empty($description) || empty($price)) {
        $errorMsg = "Please fill in all required fields.";
    }

    $fileName = $current_photo; // Keep the current photo unless a new one is uploaded

    // Handle file upload if a new file is uploaded
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['photo']['tmp_name'];
        $fileName = $_FILES['photo']['name'];
        $fileSize = $_FILES['photo']['size'];
        $fileType = $_FILES['photo']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Allowed file extensions
        $allowedExts = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($fileExtension, $allowedExts)) {
            $uploadFileDir = 'photos/';
            $dest_path = $uploadFileDir . $fileName;

            // Ensure directory exists
            if (!is_dir($uploadFileDir)) {
                mkdir($uploadFileDir, 0777, true);
            }

            // Move the uploaded file to the target directory
            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $successMsg = 'File uploaded successfully.<br>';
            } else {
                $errorMsg = 'There was an error moving the uploaded file.<br>';
                $fileName = $current_photo; // Keep current photo if upload fails
            }
        } else {
            $errorMsg = 'Upload failed. Allowed file types: ' . implode(', ', $allowedExts) . '<br>';
            $fileName = $current_photo; // Keep current photo on invalid file type
        }
    }

    // If no errors, proceed to update the record
    if (empty($errorMsg)) {
        $update_sql = "UPDATE tblmenu SET title = ?, description = ?, discount = ?, photo = ?, price = ? WHERE id = ?";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param("sssssi", $title, $description, $discount, $fileName, $price, $id);

        if ($stmt->execute()) {
            $successMsg = 'Record updated successfully!';
        } else {
            $errorMsg = 'Error updating record: ' . $stmt->error;
        }
    }
    
    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
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
                <li><a  class="active" href="../menu/menu.php"><i class="fas fa-utensils"></i> MENU</a></li>
                <li><a href="../order/order.php"><i class="fas fa-shopping-cart"></i> ORDER</a></li>
                <li><a href="../reservation/reservation.php"><i class="fas fa-calendar-alt"></i> RESERVATION</a></li>
                <li><a href="../manage users/manage users.php"><i class="fas fa-users-cog"></i> MANAGE USERS</a></li>
                
            </ul>
            </div>
            
        </div>
        

    </section><br>
    <div id="bbv">
    <p><i class="fas fa-utensils"></i>MENU</p>
    </div>

    <!-- Display error or success messages -->
    <?php if (!empty($errorMsg)): ?>
        <div class="error-message"><?php echo $errorMsg; ?></div>
    <?php endif; ?>

    <?php if (!empty($successMsg)): ?>
        <div class="success-message"><?php echo $successMsg; ?></div>
    <?php endif; ?>

    <!-- Edit Form -->
    <form action="" method="POST" enctype="multipart/form-data">
        <h4 class="text-warning text-center pt-5">Edit Page</h4>

        <!-- Display current photo -->
        <?php if (!empty($current_photo)): ?>
            <div>
                <img id="sa" src="photos/<?php echo $current_photo; ?>" alt="Current Photo" width="150">
                
            </div>
        <?php endif; ?>

        <!-- File Upload -->
        <label>
            <input type="file" class="input" name="photo" placeholder="Upload Photo" />
            <div class="line-box">
                <div class="line"></div>
            </div>
        </label>

        <!-- Title Input -->
        <label>
            <input type="text" class="input" name="title" autocomplete="off" required placeholder="TITLE" value="<?php echo htmlspecialchars($current_title); ?>" />
            <div class="line-box">
                <div class="line"></div>
            </div>
        </label>

        <!-- Price Input -->
        <label>
            <input type="text" class="input" name="price" autocomplete="off" required placeholder="PRICE" value="<?php echo htmlspecialchars($current_price); ?>" />
            <div class="line-box">
                <div class="line"></div>
            </div>
        </label>

        <!-- Discount Input (Optional) -->
        <label>
            <input type="text" class="input" name="discount" placeholder="DISCOUNT (optional)" value="<?php echo htmlspecialchars($current_discount); ?>" />
            <div class="line-box">
                <div class="line"></div>
            </div>
        </label>

        <!-- Description Input -->
        <label>
            <input type="text" class="input" name="description" autocomplete="off" required placeholder="DESCRIPTION" value="<?php echo htmlspecialchars($current_description); ?>" />
            <div class="line-box">
                <div class="line"></div>
            </div>
        </label>

        <!-- Submit Button -->
        <button type="submit">Update</button>
    </form><br><br><br>

</body>
</html>
