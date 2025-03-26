<!-- login.php -->
<?php
session_start();

// Check if the user is already logged in
if (isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Replace 'your_mysql_hostname', 'your_mysql_username', 'your_mysql_password', and 'your_mysql_dbname'
    // with your actual MySQL database credentials
    $connection = mysqli_connect('localhost', 'msis', 'Msis@123', 'datalake');
    if ($connection) {
        // Retrieve the user's hashed password from the database based on their username
        $query = "SELECT * FROM users WHERE username = '$username'";
        $result = mysqli_query($connection, $query);
        if ($result && mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            $hashed_password = $row['password'];
            $role = $row['role'];

            // Verify the password
            if (password_verify($password, $hashed_password)) {
                // Set the session variables to indicate that the user is authenticated
                $_SESSION['username'] = $username;
                $_SESSION['role'] = $role;

                // Redirect based on the user's role
                switch ($role) {
                    case 'data_owner':
                        header("Location: data_ingestion.php");
                        break;
                    case 'data_steward':
                        header("Location: raw_zone.php");
                        break;
                    case 'data_analyst':
                    case 'data_scientist':
                    case 'data_engineer':
                        header("Location: data_discovery.php");
                        break;
                    case 'administrator':
                        header("Location: metadata_extraction.php");
                        break;
                    default:
                        echo "Unknown role.";
                }
                exit();
            } else {
                echo "Invalid username or password. Please try again.";
            }
        } else {
            echo "Invalid username or password. Please try again.";
        }
        mysqli_close($connection);
    } else {
        echo "Error: Unable to connect to the database.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Lake Services - Login</title>
    <!-- Add Bootstrap CDN link here -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="mb-4">Login</h2>
                <form action="login.php" method="post">
                    <div class="form-group">
                        <input type="text" class="form-control" name="username" placeholder="Username" required>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password" placeholder="Password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Log In</button>
                </form>
                <p class="mt-3">Don't have an account? <a href="signup.php">Sign Up</a></p>
            </div>
        </div>
    </div>
</body>
</html>

