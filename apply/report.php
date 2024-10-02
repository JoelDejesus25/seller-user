<?php
include 'conn.php'; // Assuming this file connects to the database

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the report form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $seller_id = $_POST['seller_id'];
    $reason_report = $_POST['reason']; // Get the report reason from the form

    // Prepare and bind the SQL statement to update the status to 'reported' and store the reason
    $stmt = $conn->prepare("UPDATE sellerapplication SET status = 'reported', reason_report = ? WHERE id = ?");
    $stmt->bind_param("si", $reason_report, $seller_id); // Bind parameters for both reason and seller ID

    // Execute the statement
    if ($stmt->execute()) {
        // Redirect back with a success message
        header("Location: view_accepted_sellers.php?message=Report submitted successfully.");
        exit();
    } else {
        // Redirect back with an error message
        header("Location: view_accepted_sellers.php?message=Error submitting report.");
        exit();
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>
