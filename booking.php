<?php
// Database connection settings
$servername = "localhost";
$username = "root"; // default username for XAMPP
$password = ""; // default password for XAMPP (usually empty)
$dbname = "book"; // replace with your actual database name

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capture form data and sanitize inputs
    $firstname = htmlspecialchars(trim($_POST['firstname']));
    $lastname = htmlspecialchars(trim($_POST['lastname']));
    $email = htmlspecialchars(trim($_POST['email']));
    $phone = htmlspecialchars(trim($_POST['phone']));
    $checkin = htmlspecialchars(trim($_POST['check-in-date']));
    $checkout = htmlspecialchars(trim($_POST['check-out-date']));
    $additional = htmlspecialchars(trim($_POST['additional']));

    // Validate required fields
    if (empty($firstname) || empty($lastname) || empty($email) || empty($phone) || empty($checkin) || empty($checkout)) {
        echo "All fields marked with * are required.";
        exit;
    }

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO bookings (firstname, lastname, email, phone, checkin_date, checkout_date, additional_requests) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $firstname, $lastname, $email, $phone, $checkin, $checkout, $additional);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Booked successfully!<br>";
        echo "First Name: $firstname<br>";
        echo "Last Name: $lastname<br>";
        echo "Email: $email<br>";
        echo "Phone: $phone<br>";
        echo "Check-in Date: $checkin<br>";
        echo "Check-out Date: $checkout<br>";
        echo "Additional Requests: $additional<br>";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    // Redirect to the form if the request method is not POST
    header("Location: booking.html");
    exit;
}
?>
