<?php
require 'config.php'; // Include the database configuration file

session_start(); // Start a session for authentication

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form input
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare SQL to get user data
    $stmt = $conn->prepare("SELECT id, username, password FROM tblmanageusers WHERE email = ?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // If a user is found with the given email
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Verify the entered password with the stored hashed password
        if (password_verify($password, $user['password'])) {
            // Set session variables upon successful login
            $_SESSION['admin_id'] = $user['id'];
            $_SESSION['admin_username'] = $user['username'];

            // Redirect to the admin dashboard or manage users page
            header('Location: user.php');
            exit();
        } else {
            echo 'Invalid password.';
        }
    } else {
        echo 'User not found.';
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
