<?php
// Database configuration
$servername = "localhost"; // Change this if your database server is different
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "apply"; // Your database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Do not close the connection here
?>
