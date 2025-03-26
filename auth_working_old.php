<?php
session_start();

// Check if the user is logged in, otherwise redirect to the login page
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Replace 'your_mysql_hostname', 'your_mysql_username', 'your_mysql_password', and 'your_mysql_dbname'
// with your actual MySQL database credentials
$connection = mysqli_connect('localhost', 'msis', 'Msis@123', 'datalake');
if (!$connection) {
    echo "Error: Unable to connect to the database.";
    exit();
}

$username = $_SESSION['username'];
$query = "SELECT role FROM users WHERE username = '$username'";
$result = mysqli_query($connection, $query);
if (!$result || mysqli_num_rows($result) !== 1) {
    echo "Error: Unable to fetch user data from the database.";
    exit();
}

$row = mysqli_fetch_assoc($result);
$role = $row['role'];

// Determine which page to redirect the user based on their role
switch ($role) {
    case 'data_owner':
        header("Location: http://172.16.18.235:8501");
        exit();
    case 'data_steward':
        header("Location: http://172.16.51.28:9000");
        exit();
    case 'data_analyst':
    case 'data_scientist':
    case 'data_engineer':
        header("Location: http://172.16.51.77:8050");
        exit();
    case 'administrator':
        header("Location: http://172.16.18.235:8502");
        exit();
    default:
        echo "Error: Unknown role.";
        exit();
}
?>

