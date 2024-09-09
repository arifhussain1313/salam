<?php

$servername = "localhost";
$root_username = "root"; // Root user
$root_password = "";
$central_db = "central_users_db";

// Create a connection to the central database
$conn = new mysqli($servername, $root_username, $root_password, $central_db);

// Check if the connection is successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = password_hash($conn->real_escape_string($_POST['password']), PASSWORD_DEFAULT);

    // Create the user's own database
    $user_db_name = $username . "_db"; // The database name is based on the username
    $create_db_sql = "CREATE DATABASE `$user_db_name`";
    
    if ($conn->query($create_db_sql) === TRUE) {
        echo "Database created successfully for $username<br>";

        // Connect to the new database and create a table for the user
        $user_conn = new mysqli($servername, $root_username, $root_password, $user_db_name);

        if ($user_conn->connect_error) {
            die("Connection to user database failed: " . $user_conn->connect_error);
        }

        // Create a table in the user's database
        $create_table_sql = "CREATE TABLE user_data (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(30) NOT NULL,
            email VARCHAR(50) NOT NULL,
            password VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";

        if ($user_conn->query($create_table_sql) === TRUE) {
            echo "Table created successfully in $user_db_name<br>";

            // Store user information in the central database
            $insert_user_sql = "INSERT INTO users (username, email, password, user_db) VALUES ('$username', '$email', '$password', '$user_db_name')";
            if ($conn->query($insert_user_sql) === TRUE) {
                echo "User registered successfully!<br>";
            } else {
                echo "Error: " . $conn->error;
            }
        } else {
            echo "Error creating table: " . $user_conn->error;
        }

        $user_conn->close();
    } else {
        echo "Error creating database: " . $conn->error;
    }
    
    $conn->close();
}
?>
