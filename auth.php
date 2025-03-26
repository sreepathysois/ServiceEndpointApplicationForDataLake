<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Replace 'your_mysql_hostname', 'your_mysql_username', 'your_mysql_password', and 'your_mysql_dbname'
// with your actual MySQL database credentials
$connection = mysqli_connect('localhost', 'msis', 'Msis@123', 'datalake');
if ($connection) {
    $username = $_SESSION['username'];
    $query = "SELECT role FROM users WHERE username = '$username'";
    $result = mysqli_query($connection, $query);
    if ($result && mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        $role = $row['role'];
    }
    mysqli_close($connection);
} else {
    echo "Error: Unable to connect to the database.";
    exit();
}

// Redirect based on the user's role
/*
switch ($role) {
    case 'data_owner':
        header("Location: http://172.16.18.235:8501");
        header("Location: http://172.16.18.235:8502");
        exit();
    case 'data_steward':
        header("Location: http://172.16.51.28:9000");
        exit();
    case 'data_analyst':
    case 'data_scientist':
    case 'data_engineer':
        header("Location: http://172.16.51.77:8050");
        header("Location: http://172.16.51.72:8050");
        exit();
    case 'administrator':
        #header("Location: index.php");
        header("Location: http://172.16.18.235:8501");
        header("Location: http://172.16.18.235:8502");
        header("Location: http://172.16.51.77:8050");
        header("Location: http://172.16.51.72:8050");
        header("Location: http://172.16.51.28:9000");
        exit();
    default:
        echo "Error: Unknown role.";
}
exit();
?>

*/

switch ($role) {
    case 'data_owner':
        header("Location: http://172.16.18.235:8501");
        exit();
    case 'data_steward':
        header("Location: http://172.16.51.28:9000");
        header("Location: http://172.16.18.235:5601");
        exit();
    case 'data_analyst':
    case 'data_scientist':
    case 'data_engineer':
        header("Location: http://172.16.51.77:8050");
        header("Location: http://172.16.51.72:8050");
        header("Location: http://172.16.18.235:5601");
        exit();
    case 'administrator':
        // HTML content for displaying links and images for all services
        echo '<!DOCTYPE html>
            <html>
            <head>
                <title>Data Lake Services - Administrator</title>
            </head>
            <body>
                <h2>Welcome, Administrator!</h2>
                <p>Here are the links to all services:</p>
                <ul>
                    <li><a href="http://172.16.18.235:8501">Data Ingestion Service</a></li>
                    <li><a href="http://172.16.18.235:5601">Data Catalog Service</a></li>
                    <li><a href="http://172.16.18.235:8502">Metadata Extraction Service</a></li>
                    <li><a href="http://172.16.51.77:8050">Data Discovery Service Encrypted Approach </a></li>
                    <li><a href="http://172.16.51.72:8050">Data Discovery Service Pre Computed Approach</a></li>
                    <li><a href="http://172.16.51.28:9000">Data Lake Raw and Process Zone Service</a></li>
                </ul>
            </body>
            </html>';
        exit();
    default:
        echo "Error: Unknown role.";
}
exit();
?>
