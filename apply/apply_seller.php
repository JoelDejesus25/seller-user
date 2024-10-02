<?php
// Database configuration
$servername = "localhost"; // Change if your database server is different
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "apply"; // Your database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $business_name = $_POST['business-name'];
    $business_address = $_POST['business-address'];
    $business_description = $_POST['business-description'];
    
    // Handle file upload
    if (isset($_FILES['valid-id']) && $_FILES['valid-id']['error'] == 0) {
        $valid_id_name = $_FILES['valid-id']['name'];
        $valid_id_tmp = $_FILES['valid-id']['tmp_name'];
        
        // Move uploaded file to a directory
        $upload_dir = 'uploads/';
        $upload_file = $upload_dir . basename($valid_id_name);
        
        // Check if uploads directory exists and is writable
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        // Attempt to move the uploaded file
        if (move_uploaded_file($valid_id_tmp, $upload_file)) {
            // Prepare the SQL statement
            $stmt = $conn->prepare("INSERT INTO sellerapplication (name, email, phone, business_name, business_address, business_description, valid_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssss", $name, $email, $phone, $business_name, $business_address, $business_description, $upload_file);
            
            // Execute the statement
            if ($stmt->execute()) {
                echo "Application submitted successfully!";
            } else {
                echo "Error executing query: " . $stmt->error; // Output SQL error
            }

            // Close the statement
            $stmt->close();
        } else {
            echo "Error moving uploaded file.";
        }
    } else {
        echo "Error uploading valid ID: " . $_FILES['valid-id']['error'];
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply as Seller</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="apply.css">
</head>
<body>

<div class="seller-form-container">
    <h2>Seller Application Form</h2>
    <form action="#" method="POST" enctype="multipart/form-data">
        <!-- Personal Information -->
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" placeholder="Enter your full name" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" placeholder="Enter your email" required>

        <label for="phone">Phone Number:</label>
        <input type="tel" id="phone" name="phone" placeholder="Enter your phone number" required>

        <!-- Business Information -->
        <label for="business-name">Business Name:</label>
        <input type="text" id="business-name" name="business-name" placeholder="Enter your business name" required>

        <label for="business-address">Business Address:</label>
        <input type="text" id="business-address" name="business-address" placeholder="Enter your business address" required>

        <label for="business-description">Business Description:</label>
        <textarea id="business-description" name="business-description" placeholder="Briefly describe your business" rows="4" required></textarea>

        <!-- Identification -->
        <label for="valid-id">Upload Valid ID (Passport, Driver's License, etc.):</label>
        <input type="file" id="valid-id" name="valid-id" accept=".jpg, .jpeg, .png, .pdf" required>

        <!-- Submission -->
        <button type="submit">Apply as Seller</button>
    </form>
</div>

</body>
</html>
