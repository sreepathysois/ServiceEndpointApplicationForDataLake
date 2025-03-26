<?php
session_start();

// Check if the user is not logged in, redirect to login page
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
?>

<!DOCTYPE html>
<html>
<head>
    <title>Welcome to Data Lake Services</title>
    <style>
        /* Your CSS styles here */

        /* Style for service containers */
        .service-container {
            display: inline-block;
            text-align: center;
            margin: 20px;
        }

        /* Style for service images */
        .service-container img {
            max-width: 200px;
            height: auto;
        }
    </style>
</head>
<body>
    <!-- Centered Welcome Header and Image -->
    <div style="text-align: center;">
        <h1>Welcome to Data Lake Services</h1>
        <img src="Metadata_DataLake-Overview.png" alt="Data Lake Image" style="max-width: 100%; height: auto;">
        <p>This is the default landing page for Data Lake Services.</p>
    </div>

    <!-- List of Services in Two Columns -->
    <div style="text-align: center;">
        <h2>Services</h2>
        <?php if ($role == 'data_owner' || $role == 'administrator') : ?>
        <div class="service-container">
            <img src="data_lake_ingestion.png" alt="Data Ingestion Service">
            <p>Data Ingestion Service</p>
            <a href="http://172.16.18.235:8501">Access Service</a>
        </div>
        <?php endif; ?>
        <?php if ($role == 'data_owner' || $role == 'administrator') : ?>
        <div class="service-container">
            <img src="metadata_extraction.jpg" alt="Metadata Extraction Service">
            <p>Metadata Extraction Service</p>
            <a href="http://172.16.18.235:8502">Access Service</a>
        </div>
        <?php endif; ?>
        <?php if ($role == 'data_steward' || $role == 'data_analyst' || $role == 'data_scientist' || $role == 'data_engineer' || $role == 'administrator') : ?>
        <div class="service-container">
            <img src="DataCatalog.png" alt="Data Catalog Service">
            <p>Data Catalog Service for Data Lake</p>
            <a href="http://172.16.18.235:5601">Access Service</a>
        </div>
        <?php endif; ?>
        <?php if ($role == 'data_steward' || $role == 'administrator') : ?>
        <div class="service-container">
            <img src="data_layers.png" alt="Data Lake Raw and Process Zone Service">
            <p>Data Lake Raw Zone Service</p>
            <a href="http://172.16.51.28:9000">Access Service</a>
        </div>
        <?php endif; ?>
        <?php if ($role == 'data_analyst' || $role == 'data_scientist' || $role == 'data_engineer' || $role == 'administrator') : ?>
        <div class="service-container">
            <img src="Data_Discovery_Architectural_diagram.png" alt="Data Discovery Encrypted Approach Service">
            <p>Data Discovery Service Encrypted Approach</p>
            <a href="http://172.16.51.77:8050">Access Service</a>
        </div>
        <?php endif; ?>
        <?php if ($role == 'data_analyst' || $role == 'data_scientist' || $role == 'data_engineer' || $role == 'administrator') : ?>
        <div class="service-container">
            <img src="Data_Discovery_Architectural_diagram.png" alt="Data Discovery Pre Computed Views Approach">
            <p>Data Discovery pre Computed Views Approach</p>
            <a href="http://172.16.51.72:8050">Access Service</a>
        </div>
        <?php endif; ?>
    </div>

    <!-- Logout Button -->
    <div style="text-align: center;">
        <form action="logout.php" method="post">
            <button type="submit">Log Out</button>
        </form>
    </div>
</body>
</html>

