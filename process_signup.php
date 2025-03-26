<?php
// Start session
session_start();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Replace 'your_mysql_hostname', 'your_mysql_username', 'your_mysql_password', and 'your_mysql_dbname'
    // with your actual MySQL database credentials
    $connection = mysqli_connect('localhost', 'msis', 'Msis@123', 'datalake');
    if ($connection) {
        // Check if the username already exists
        $check_query = "SELECT * FROM users WHERE username = '$username'";
        $check_result = mysqli_query($connection, $check_query);
        if ($check_result && mysqli_num_rows($check_result) > 0) {
            echo "Username already exists. Please choose a different username.";
        } else {
            // Insert new user data into the database
            $insert_query = "INSERT INTO users (username, password, role) VALUES ('$username', '$hashed_password', '$role')";
            $insert_result = mysqli_query($connection, $insert_query);
            if ($insert_result) {
                echo "User created successfully. You can now <a href='login.php'>log in</a>.";
            } else {
                echo "Error: Unable to create user.";
            }
        }
        mysqli_close($connection);
    } else {
        echo "Error: Unable to connect to the database.";
    }
} else {
    // Redirect to the signup page if the form is not submitted
    header("Location: signup.php");
    exit();
}
?>

