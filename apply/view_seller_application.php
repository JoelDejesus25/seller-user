<?php
include 'conn.php'; // Assuming this file connects to the database

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch sellers from the database
$sql = "SELECT * FROM sellerapplication";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Seller Applications</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css"> <!-- Ensure this is the correct path to your CSS file -->
    <style>
        /* Modal styles */
        .modal {
            display: none; 
            position: fixed; 
            z-index: 1000; 
            left: 0;
            top: 0;
            width: 100%; 
            height: 100%; 
            overflow: auto; 
            background-color: rgba(0, 0, 0, 0.8);
        }
        .modal-content {
            margin: auto; 
            padding: 20px;
            width: 90%; 
            height: 90%; 
            max-width: 1200px; 
            max-height: 900px; 
            text-align: center;
            position: relative;
        }
        .close {
            color: white;
            position: absolute;
            top: 15px;
            right: 25px;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: #bbb;
            text-decoration: none;
            cursor: pointer;
        }
        img {
            max-width: 100%; 
            max-height: 100%; /* Ensure the image fits within the modal */
            object-fit: contain; /* Maintain aspect ratio */
        }
    </style>
</head>
<body>

<div class="seller-list-container">
    <h2>Seller Applicants</h2>

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
            <th>Business Description</th>
            <th>Valid ID</th>
            <th>Application Date</th>
            <th>Status</th> <!-- New header for status -->
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
                echo "<td>" . htmlspecialchars($row['business_description']) . "</td>";
                
                // Make the valid ID image open the modal
                echo "<td><img src='" . htmlspecialchars($row['valid_id']) . "' alt='Valid ID' style='width: 100px; height: auto;' onclick='openModal(\"" . htmlspecialchars($row['valid_id']) . "\")'></td>";
                
                echo "<td>" . htmlspecialchars($row['application_date']) . "</td>";
                echo "<td>" . htmlspecialchars($row['status']) . "</td>"; // Display status here
                
                // Check if status is 'pending' to display action buttons
                echo "<td>";
                if (htmlspecialchars($row['status']) === 'pending') {
                    echo "<form action='accept_reject.php' method='POST' style='display:inline;'>
                            <input type='hidden' name='seller_id' value='" . htmlspecialchars($row['id']) . "'>
                            <div class='action-buttons'>
                                <button type='submit' name='action' value='accept' class='accept-button'>Accept</button>
                                <button type='submit' name='action' value='reject' class='reject-button'>Reject</button>
                            </div>
                          </form>";
                }
                echo "</td>";
                
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='10'>No applications found.</td></tr>"; // Adjust colspan for the new column
        }
        ?>
    </table>
</div>

<!-- Modal for viewing valid ID -->
<div id="myModal" class="modal">
    <span class="close" onclick="closeModal()">&times;</span>
    <div class="modal-content">
        <img id="modalImage" src="" alt="Valid ID">
    </div>
</div>

<script>
    // Function to open the modal
    function openModal(imageSrc) {
        document.getElementById("modalImage").src = imageSrc;
        document.getElementById("myModal").style.display = "block";

        // Optional: make modal fullscreen
        if (document.documentElement.requestFullscreen) {
            document.documentElement.requestFullscreen();
        } else if (document.documentElement.mozRequestFullScreen) { // Firefox
            document.documentElement.mozRequestFullScreen();
        } else if (document.documentElement.webkitRequestFullscreen) { // Chrome, Safari, and Opera
            document.documentElement.webkitRequestFullscreen();
        } else if (document.documentElement.msRequestFullscreen) { // IE/Edge
            document.documentElement.msRequestFullscreen();
        }
    }

    // Function to close the modal
    function closeModal() {
        document.getElementById("myModal").style.display = "none";
        
        // Exit fullscreen if it was triggered
        if (document.exitFullscreen) {
            document.exitFullscreen();
        } else if (document.mozCancelFullScreen) { // Firefox
            document.mozCancelFullScreen();
        } else if (document.webkitExitFullscreen) { // Chrome, Safari, and Opera
            document.webkitExitFullscreen();
        } else if (document.msExitFullscreen) { // IE/Edge
            document.msExitFullscreen();
        }
    }

    // Close the modal when the user clicks anywhere outside of it
    window.onclick = function(event) {
        var modal = document.getElementById("myModal");
        if (event.target == modal) {
            closeModal();
        }
    }
</script>

</body>
</html>

<?php
// Close the connection
$conn->close();
?>
