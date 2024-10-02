<?php
include 'conn.php'; // Connect to the database

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch accepted seller applications from the database
$sql = "SELECT id, name, email, phone, business_name, business_address FROM sellerapplication WHERE status = 'accepted'";
$result = $conn->query($sql);

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'report') {
    // Sanitize input
    $seller_id = (int)$_POST['seller_id']; // Cast to integer for safety
    $report_reason = trim($_POST['report_reason']); // Remove excess whitespace

    // Insert the report into the database
    $sql = "UPDATE sellerapplication SET status = 'reported', reason_report = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $report_reason, $seller_id);

    if ($stmt->execute()) {
        header("Location: view_accepted_sellers.php?message=Report submitted successfully");
        exit(); // Ensure script stops after redirect
    } else {
        header("Location: view_accepted_sellers.php?message=Error submitting report");
        exit(); // Ensure script stops after redirect
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Accepted Seller Applications</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css"> <!-- Ensure this is the correct path to your CSS file -->
    <style>
        /* Basic Modal Styles */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        }
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto; /* 15% from the top and centered */
            padding: 20px;
            border: 1px solid #888;
            width: 80%; /* Could be more or less, depending on screen size */
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="seller-list-container">
    <h2>Accepted Seller Applicants</h2>

    <!-- Display the success or error message -->
    <?php if (isset($_GET['message'])): ?>
        <p class="message"><?php echo htmlspecialchars($_GET['message']); ?></p>
    <?php endif; ?>

    <table>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Business Name</th>
            <th>Business Address</th>
            <th>Action</th> <!-- Header for action buttons -->
        </tr>
        <?php
        if ($result->num_rows > 0) {
            // Output data for each row
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                echo "<td>" . htmlspecialchars($row['phone']) . "</td>";
                echo "<td>" . htmlspecialchars($row['business_name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['business_address']) . "</td>";
                
                echo "<td>";
                // Add the Report form with reason input
                echo "<form action='' method='POST' style='display:inline;'> 
                        <input type='hidden' name='seller_id' value='" . htmlspecialchars($row['id']) . "'>
                        <textarea name='report_reason' placeholder='Enter reason for reporting' required></textarea>
                        <button type='submit' name='action' value='report' class='report-button'>Report</button>
                      </form>";
                echo "</td>";
                
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No accepted applications found.</td></tr>"; // Adjust colspan for the new column
        }
        ?>
    </table>
</div>

<!-- Modal HTML -->
<div id="reportModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <p id="reportMessage"></p>
    </div>
</div>

<script>
// Get modal element
var modal = document.getElementById('reportModal');
var message = document.getElementById('reportMessage');

// If there's a message in the URL, show the modal
<?php if (isset($_GET['message'])): ?>
    message.innerText = "<?php echo htmlspecialchars($_GET['message']); ?>";
    modal.style.display = "block";
<?php endif; ?>

// Close the modal when the user clicks on <span> (x)
document.getElementsByClassName("close")[0].onclick = function() {
    modal.style.display = "none";
}

// Close the modal when clicking anywhere outside of it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>

</body>
</html>
