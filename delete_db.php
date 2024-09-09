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

// Create connection to MySQL 
$conn = new mysqli($servername, $root_username, $root_password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$drop_db_sql = "DROP DATABASE `$user_db`";
if ($conn->query($drop_db_sql) === TRUE) {
    echo "Database $user_db deleted successfully.<br>";
    
    
    $central_db = "central_users_db";
    $conn->select_db($central_db);
    $delete_user_sql = "DELETE FROM users WHERE username = '" . $_SESSION['username'] . "'";
    if ($conn->query($delete_user_sql) === TRUE) {
        echo "User removed from central database.<br>";
    } else {
        echo "Error deleting user from central database: " . $conn->error;
    }
    
    // End the session 
    session_destroy();
    echo "<a href='signin.php'>Sign in again</a>";
} else {
    echo "Error deleting database: " . $conn->error;
}

$conn->close();
?>
