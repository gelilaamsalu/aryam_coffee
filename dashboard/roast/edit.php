<?php
require "config.php";


// Initialize variables to store error/success messages
$errorMsg = '';
$successMsg = '';

// Fetch the current data for the record being edited (based on ID passed via GET)
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $fetch_sql = "SELECT * FROM tblroast WHERE id = ?";
    $stmt = $conn->prepare($fetch_sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $current_title = $row['title'];
        $current_description = $row['description'];
        $current_photo = $row['photo'];
        $current_category = $row['category'];
    } else {
        $errorMsg = 'Record not found.';
    }
} else {
    $errorMsg = 'Invalid request. No ID specified.';
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input
    $title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
    $category = filter_var($_POST['category'], FILTER_SANITIZE_STRING);
    
    // Validate the inputs
    if (empty($title) || empty($description) || empty($category)) {
        $errorMsg = "Please fill in all required fields.";
    }

    $fileName = $current_photo; // Default to current photo if no new one is uploaded

    // Handle file upload (optional)
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['photo']['tmp_name'];
        $fileName = $_FILES['photo']['name'];
        $fileSize = $_FILES['photo']['size'];
        $fileType = $_FILES['photo']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Set allowed file extensions
        $allowedExts = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($fileExtension, $allowedExts)) {
            // Directory to save uploaded file
            $uploadFileDir = 'photos/';
            $dest_path = $uploadFileDir . $fileName;

            // Ensure the destination directory exists
            if (!is_dir($uploadFileDir)) {
                mkdir($uploadFileDir, 0777, true);
            }

            if (!move_uploaded_file($fileTmpPath, $dest_path)) {
                $errorMsg = 'Error moving the uploaded file.';
            }
        } else {
            $errorMsg = 'Invalid file type. Allowed file types: ' . implode(', ', $allowedExts);
        }
    }

    // If no errors, proceed with database update
    if (empty($errorMsg)) {
        $update_sql = "UPDATE tblroast SET title = ?, description = ?, photo = ?, category = ? WHERE id = ?";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param("ssssi", $title, $description, $fileName, $category, $id);

        if ($stmt->execute()) {
            $successMsg = 'Record updated successfully!';
        } else {
            $errorMsg = 'Error updating record: ' . $stmt->error;
        }
    }
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
            <li><a href="../user.php"><i class="fas fa-home"></i> HOME</a></li>
            <li><a href="../feed back/feed back.php"><i class="fas fa-comments"></i> FEEDBACK</a></li>
            <li><a href="../testimonial/testimonial.php"><i class="fas fa-quote-left"></i> TESTIMONIAL</a></li>
            <li><a class="active" href="../roast/roast.php"><i class="fas fa-coffee"></i> ROAST</a></li>
            <li><a href="../contact us/contact us.php"><i class="fas fa-envelope"></i> CONTACT US</a></li>
            <li><a href="../menu/menu.php"><i class="fas fa-utensils"></i> MENU</a></li>
            <li><a href="../order/order.php"><i class="fas fa-shopping-cart"></i> ORDER</a></li>
            <li><a href="../reservation/reservation.php"><i class="fas fa-calendar-alt"></i> RESERVATION</a></li>
            <li><a href="../manage users/manage users.php"><i class="fas fa-users-cog"></i> MANAGE USERS</a></li>
        </ul>
            </div>
            
        </div>
        

    </section><br>
    <div id="bbv">
    <p><i class="fas fa-coffee"></i> ROAST</p>
   
</div>

    <!--  -->
    <form action="" method="POST" enctype="multipart/form-data">
    <h4 class="text-warning text-center pt-5">Edit Page</h4>

    <label>
        <input
            type="text"
            class="input"
            name="title" autocomplete="off" required
            placeholder="TITLE"
            value="<?php echo htmlspecialchars($current_title); ?>"
        />
        <div class="line-box">
            <div class="line"></div>
        </div>
    </label>

    <label>
        <input
            type="text"
            class="input"
            name="description" autocomplete="off" required
            placeholder="DESCRIPTION"
            value="<?php echo htmlspecialchars($current_description); ?>"
        />
        <div class="line-box">
            <div class="line"></div>
        </div>
    </label>

    <label>
        <input 
            type="file"
            class="input"
            name="photo"
            placeholder="Upload Photo" autocomplete="off"
        />
        <div class="line-box">
            <div class="line"></div>
        </div>
        <p id="sa"> <img  src="photos/<?php echo htmlspecialchars($current_photo); ?>" width="100" height="100" alt="Roast Photo"></p>
    </label>

    <label>
        <p id="ca">CATEGORY</p>
        <select id="category" name="category" class="input" required>
            <option value="light" <?php echo ($current_category == 'light') ? 'selected' : ''; ?>>LIGHT</option>
            <option value="medium" <?php echo ($current_category == 'medium') ? 'selected' : ''; ?>>MEDIUM</option>
            <option value="hard" <?php echo ($current_category == 'hard') ? 'selected' : ''; ?>>HARD</option>
            <option value="blends" <?php echo ($current_category == 'blends') ? 'selected' : ''; ?>>BLENDS</option>
        </select>
        <div class="line-box">
            <div class="line"></div>
        </div>
    </label>

    <button type="submit">Update</button>
</form>

</body>
</html>