<?php
include 'conn.php'; // Connect to the database

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch total users
$user_sql = "SELECT COUNT(*) as total_users FROM users";
$user_result = $conn->query($user_sql);
$total_users = ($user_result->num_rows > 0) ? $user_result->fetch_assoc()['total_users'] : 0;

// Fetch total seller applications
$seller_sql = "SELECT COUNT(*) as total_applications FROM sellerapplication";
$seller_result = $conn->query($seller_sql);
$total_applications = ($seller_result->num_rows > 0) ? $seller_result->fetch_assoc()['total_applications'] : 0;

// Check if a button is clicked to include a specific file
$content_to_include = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['view_applications'])) {
        $content_to_include = 'view_seller_application.php'; // Set the file to include
    } elseif (isset($_POST['manage_users'])) {
        $content_to_include = 'reported.php'; // Set the file to include
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css"> <!-- Ensure this is the correct path to your CSS file -->
</head>
<body>

<div class="dashboard-container">
    <nav class="navbar">
        <h2>Admin Dashboard</h2>
        <ul class="nav-items">
            <li><a href="dash.php">Home</a></li>
            <li>
                <form action="" method="POST" style="display:inline;">
                    <button type="submit" name="view_applications" class="nav-button">View Applications</button>
                </form>
            </li>
            <li>
                <form action="" method="POST" style="display:inline;">
                    <button type="submit" name="manage_users" class="nav-button">Manage Users</button>
                </form>
            </li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <div class="overview">
        <h3>Overview</h3>
        <div class="stats">
            <div class="stat">
                <h4>Total Seller Applications</h4>
                <p><?php echo $total_applications; ?></p>
            </div>
            <div class="stat">
                <h4>Total Users</h4>
                <p><?php echo $total_users; ?></p>
            </div>
        </div>
    </div>

    <div class="main-content">
        <?php 
        // Include the content based on the button clicked
        if (!empty($content_to_include)) {
            include $content_to_include; // Include the selected file
        }
        ?>
    </div>

</div>

</body>
</html>
