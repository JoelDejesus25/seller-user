<?php
include 'conn.php'; // Connect to the database

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch reported sellers from the database, including the report reason
$sql = "SELECT * FROM sellerapplication WHERE status = 'reported'"; // Adjust based on your database structure
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reported Sellers</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css"> <!-- Ensure this is the correct path to your CSS file -->
    <style>
        /* Modal styles */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            background-color: rgba(0, 0, 0, 0.4); /* Black w/ opacity */
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

<div class="reported-seller-list-container">
    <h2>Reported Sellers</h2>

    <!-- Display success or error message -->
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
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                echo "<td>" . htmlspecialchars($row['phone']) . "</td>";
                echo "<td>" . htmlspecialchars($row['business_name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['business_address']) . "</td>";

                echo "<td>";
                // Review button with report reason
                // Ensure reason_report is the correct column name in your database
                echo "<button type='button' class='review-button' onclick='openModal(\"" . htmlspecialchars($row['reason_report']) . "\")'>Review</button>";
                echo "</td>";

                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No reported sellers found.</td></tr>"; // Adjust colspan for the new column
        }
        ?>
    </table>
</div>

<!-- Modal for reviewing report reason -->
<div id="reportReasonModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Report Reason</h2>
        <p id="reportReasonText"></p>
    </div>
</div>

<script>
function openModal(reason) {
    console.log("Opening modal with reason:", reason); // Debugging log
    document.getElementById("reportReasonText").innerText = reason; // Set the reason text
    document.getElementById("reportReasonModal").style.display = "block"; // Show the modal
}

// Get the modal
var modal = document.getElementById("reportReasonModal");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>

<?php
// Close the connection
$conn->close();
?>

</body>
</html>
