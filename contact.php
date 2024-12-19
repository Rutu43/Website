<?php
// Database configuration
$servername = "localhost";
$username = "root";  // Your database username
$password = "";      // Your database password
$dbname = "contact_us_db";  // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize input data
    $name = htmlspecialchars(trim($_POST['myname']));
    $email = htmlspecialchars(trim($_POST['email']));
    $phone = htmlspecialchars(trim($_POST['phone']));
    $subject = htmlspecialchars(trim($_POST['subject']));
    $message = htmlspecialchars(trim($_POST['message']));
    
    // SQL query to insert the form data into the table
    $sql = "INSERT INTO contacts (name, email, phone, subject, message) 
            VALUES ('$name', '$email', '$phone', '$subject', '$message')";

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('we will contact you soon!'); window.location.href = 'contact.html';</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "'); window.location.href = 'contact.html';</script>";
    }
}

// Close the database connection
$conn->close();
?>
