<?php

$servername = "localhost";
$root_username = "root";
$root_password = "";
$central_db = "central_users_db";

// Create connection 
$conn = new mysqli($servername, $root_username, $root_password, $central_db);

// Check connection 
if ($conn->connect_error) {
    die("Connection to central database failed: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    // Check if user exists 
    $sql = "SELECT * FROM users WHERE username = '$username' AND email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $user['password'])) {
            //  store user information
            session_start();
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_db'] = $user['user_db'];

            //  welcome page
            header("Location: welcome.php");
            exit();
        } else {
            echo "Invalid password!";
        }
    } else {
        echo "No user found with the given username and email!";
    }

    $conn->close();
}
?>
