<?php
require "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  // Sanitize input
  $title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
  $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
  $category = filter_var($_POST['category'], FILTER_SANITIZE_STRING);
  
  $fileName = '';

  // Handle file upload
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

          if (move_uploaded_file($fileTmpPath, $dest_path)) {
              echo 'File uploaded successfully.<br>';
          } else {
              echo 'There was an error moving the uploaded file.<br>';
              $fileName = ''; // Reset fileName on error
          }
      } else {
          echo 'Upload failed. Allowed file types: ' . implode(', ', $allowedExts) . '<br>';
          $fileName = ''; // Reset fileName on invalid file type
      }
  } else {
      echo 'No file uploaded or there was an upload error.<br>';
  }

  // Insert data into the database
  $stmt = $conn->prepare("INSERT INTO tblroast (title, description, photo, category) VALUES (?, ?, ?,?)");
  $stmt->bind_param("ssss", $title, $description, $fileName,$category);

  if ($stmt->execute()) {
      echo 'Feedback submitted successfully.<br>';
  } else {
      echo 'Error submitting feedback: ' . $stmt->error . '<br>';
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
    <title>admin</title>
    <link rel="stylesheet" href="add.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
<style>
        #but{
           background-color:green;
        }
        #head {
            padding-bottom: 2.8%;
        }
        #navbar1 {
            margin-top: 18px;
        }
        #navbar i {
            letter-spacing: 10px;
            color: #e4d2ab;
        }
    </style>
    <section id="head">
        
        
            
        <div>
                    <p id="contactss">Aryam Coffee Admin Dashboard</p >
                    <ul id="navbar1">
                        
                        <li><a class="active" href="../home.php">Logout</a></li>
                        
                       
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
        <h4 class="text-warning text-center pt-5">Add Page</h4>

        

        <label>
          <input
            type="text"
            class="input"
            name="title" autocomplete="off" required
            placeholder="TITLE"
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
          />
          <div class="line-box">
            <div class="line"></div>
          </div>
       
            <label>
                <input 
                
                 
                  type="file"
                  class="input"
                  name="photo"
                  placeholder="Upload  Photo" autocomplete="off" required
                />
                <div class="line-box">
                  <div class="line"></div>
                </div>
              </label>
  
</label>
 <label>
          
          
          
            
          <p id="ca">CATEGORY</p>
          <select id="category" name="category"  class="input" required>
            <option value="light">LIGHT</option>
            <option value="medium">MEDIUM</option>
            <option value="hard">HARD</option>
            <option value="blends">BLENDS</option>
          </select>
          <div class="line-box">
            <div class="line"></div>
          </div>
       
</label>
              


        <button type="submit">Add</button>
      </form><br><br><br>
    
</body>
</html>