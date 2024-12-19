<?php
// Database configuration
$servername = "localhost";
$username = "root";  // Your database username
$password = "";      // Your database password (empty by default in XAMPP)
$dbname = "contact_us_db";  // Your shared database name

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize input data
    $username = htmlspecialchars(trim($_POST['username']));
    $password = htmlspecialchars(trim($_POST['password']));

    // Prepare the SQL query to check if the user exists in the database
    $stmt = $conn->prepare("SELECT * FROM login_tb WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the user exists
    if ($result->num_rows > 0) {
        // Fetch the user's details from the result
        $user = $result->fetch_assoc();

        // Directly compare the password
        if ($password === $user['password']) {
            // Successful login
            echo "<script>alert('Login successful!'); window.location.href = 'index.html';</script>";
        } else {
            // Invalid password
            echo "<script>alert('Incorrect password.'); window.location.href = 'login.html';</script>";
        }
    } else {
        // User not found
        echo "<script>alert('User not found. Please check your username.'); window.location.href = 'login.html';</script>";
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>
