<?php
include 'conn.php'; // Make sure 'conn.php' contains the database connection details

// Check if form submission is valid
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $seller_id = $_POST['seller_id'];
    $action = $_POST['action'];

    // Validate the seller ID and action (accept or reject)
    if (!empty($seller_id) && ($action == 'accept' || $action == 'reject')) {
        // Determine the status to update based on action
        $status = ($action == 'accept') ? 'accepted' : 'rejected';
        
        // Prepare the SQL update query
        $stmt = $conn->prepare("UPDATE sellerapplication SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $seller_id);
        
        // Execute the query and check if successful
        if ($stmt->execute()) {
            // Redirect back to the view_sellers.php with a success message
            header("Location: dash.php");
            exit;
        } else {
            // Output an error message if the query fails
            echo "Error updating the application: " . $conn->error;
        }

        // Close the prepared statement
        $stmt->close();
    } else {
        echo "Invalid request.";
    }
}

// Close the database connection
$conn->close();
?>
