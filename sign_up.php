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
    $email = htmlspecialchars(trim($_POST['email']));
    $fullname = htmlspecialchars(trim($_POST['fullname']));
    $username = htmlspecialchars(trim($_POST['username']));
    $password = htmlspecialchars(trim($_POST['password']));

    // Prepare statement to check if the username or email already exists
    $checkUserQuery = $conn->prepare("SELECT * FROM signup_tb WHERE username = ? OR email = ?");
    if ($checkUserQuery === false) {
        die("Error preparing statement: " . $conn->error);
    }
    
    $checkUserQuery->bind_param("ss", $username, $email);
    $checkUserQuery->execute();
    $checkResult = $checkUserQuery->get_result();

    if ($checkResult->num_rows > 0) {
        // Username or email already exists
        echo "<script>alert('Username or Email already taken. Please choose another.'); window.location.href = 'signup.html';</script>";
    } else {
        // Hash the password for security
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Prepare SQL query to insert the new user
        $stmt = $conn->prepare("INSERT INTO signup_tb (email, fullname, username, password) VALUES (?, ?, ?, ?)");
        if ($stmt === false) {
            die("Error preparing statement: " . $conn->error);
        }
        
        $stmt->bind_param("ssss", $email, $fullname, $username, $hashedPassword);

        if ($stmt->execute()) {
            // Signup successful
            header("Location: login.html");
            exit(); // Ensure the script stops executing after the redirect
        } else {
            // Signup failed
            echo "<script>alert('Signup failed. Please try again.'); window.location.href = 'signup.html';</script>";
        }

        // Close the statement
        $stmt->close();
    }

    // Close the check query
    $checkUserQuery->close();
}

// Close the database connection
$conn->close();
?>