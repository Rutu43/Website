<?php
// Database configuration
$servername = "localhost";
$username = "root"; // Update if necessary
$password = ""; // Update if necessary
$dbname = "contact_us_db"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve bookings
$sql = "SELECT * FROM bookings ORDER BY id DESC";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>View Bookings</title>
    <link rel="stylesheet" type="text/css" href="./assets/css/style.css" />
</head>

<body>
    <div class="booking-view">
        <h1>Your Bookings</h1>

        <?php
        if ($result->num_rows > 0) {
            // Output each booking
            while ($row = $result->fetch_assoc()) {
                echo "<div class='booking-item'>";
                echo "<p><strong>Name:</strong> " . $row['firstname'] . " " . $row['lastname'] . "</p>";
                echo "<p><strong>Email:</strong> " . $row['email'] . "</p>";
                echo "<p><strong>Phone:</strong> " . $row['phone'] . "</p>";
                echo "<p><strong>Check-in Date:</strong> " . $row['checkin_date'] . "</p>";
                echo "<p><strong>Check-out Date:</strong> " . $row['checkout_date'] . "</p>";
                echo "<p><strong>Additional Requests:</strong> " . $row['additional'] . "</p>";
                echo "</div><hr>";
            }
        } else {
            echo "<p>No bookings found.</p>";
        }

        $conn->close();
        ?>

    </div>
</body>

</html>
