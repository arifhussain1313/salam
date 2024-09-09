<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['username']) || !isset($_SESSION['user_db'])) {
    echo "You need to log in first!";
    exit();
}

$servername = "localhost";
$root_username = "root";
$root_password = "";
$user_db = $_SESSION['user_db'];

// Create connection to the user's database
$conn = new mysqli($servername, $root_username, $root_password, $user_db);

// Check connection to user's database
if ($conn->connect_error) {
    die("Connection to user's database failed: " . $conn->connect_error);
}

// Update the username to 'Arif'
$update_sql = "UPDATE user_data SET username = 'Arif' WHERE username = '" . $_SESSION['username'] . "'";
if ($conn->query($update_sql) === TRUE) {
    echo "Username changed to Arif!<br>";
    
    // Update session variable
    $_SESSION['username'] = 'Arif';
    
    echo "<a href='welcome.php'>Go back to welcome page</a>";
} else {
    echo "Error updating username: " . $conn->error;
}

$conn->close();
?>
