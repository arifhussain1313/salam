<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['username']) || !isset($_SESSION['user_db'])) {
    echo "You need to log in first!";
    exit();
}

$username = $_SESSION['username'];
$user_db = $_SESSION['user_db'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
</head>
<body>
    <h2>Welcome, <?php echo htmlspecialchars($username); ?>!</h2>

    <!-- Button to change the username to "Arif" -->
    <form action="change_name.php" method="post">
        <input type="submit" value="Change Username to Arif">
    </form>

    <!-- Button to delete the user's database -->
    <form action="delete_db.php" method="post">
        <input type="submit" value="Delete My Database and Table">
    </form>
</body>
</html>
