<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="DriverInterface.css">
    <script src="script.js"></script>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            font: 1em sans-serif;
            padding: 12px;
            text-align: left;
            border-bottom: 5px solid #ddd;
        }

        th {
            background-color: rgb(255, 221, 0);
        }

        td {
            background-attachment: fixed;
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ffffff;
        }
    </style>
</head>
<body>
<div class="main-container">
        <header class="header">
            <a href="#" id="logo"><img src="images/yellow-logo.jpg" alt="" width="20%" height="20%"></a>
            <nav class="navbar">
            <a href="index.html">Home</a>
                    <a href="review.php">Reviews</a>
                    <a href="index.html #About">About</a>
                    <a href="Contact Us.html">Contact Us</a>
            </nav>
            <nav class="Login">
                <a href="Login.html">Sign In</a> /
                <a href="Sign up.html">Sign Up</a>
            </nav>
        </header>
    </div>
    <div class="drivertable">
        <div class="driverInterface">
            <h2>Confirm a customer trip...</h2>
            <table border = "3" width="75%" hight="200%" bgcolor="#f2f2f2">;
         <tr><th>B_Id</th><th>Start</th><th>Destination</th><th>Date</th><th>Time</th><th>Action</th></tr>;
                

        <?php
        include_once 'includes/dbh.inc.php';

        if (isset($_POST['cancel'])) {
            $bookingId = $_POST['cancel'];
        
            // Delete associated records in the handle table
            $handleSql = "DELETE FROM handle WHERE B_Id = ?";
            $handleStmt = $conn->prepare($handleSql);
            $handleStmt->bind_param("i", $bookingId);
            $handleStmt->execute();
        
            // Delete associated records in the Make table
            $handleSql = "DELETE FROM Make WHERE B_Id = ?";
            $handleStmt = $conn->prepare($handleSql);
            $handleStmt->bind_param("i", $bookingId);
            $handleStmt->execute();

            // Delete associated records in the Payment table
            $handleSql = "DELETE FROM Payment WHERE B_Id = ?";
            $handleStmt = $conn->prepare($handleSql);
            $handleStmt->bind_param("i", $bookingId);
            $handleStmt->execute();

            // Delete the booking
            $bookingSql = "DELETE FROM booking WHERE B_Id = ?";
            $bookingStmt = $conn->prepare($bookingSql);
            $bookingStmt->bind_param("i", $bookingId);
        
            if ($bookingStmt->execute()) {
                if ($bookingStmt->affected_rows > 0) {
                    header("Location: Driverinterface.php");
                    exit();
                } else {
                    echo "Error: Failed to cancel the booking.";
                }
            } else {
                echo "Error executing the delete query: " . $bookingStmt->error;
            }
        }

        $sql = "SELECT * FROM booking";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) { 
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["B_Id"] . "</td>";
                echo "<td>" . $row["Start"] . "</td>";
                echo "<td>" . $row["Destination"] . "</td>";
                echo "<td>" . $row["Date"] . "</td>";
                echo "<td>" . $row["Time"] . "</td>";
                echo '<td><form method="POST" action="DriverInterface.php">';
                echo '<button type="submit" id="confirmbutton"> Confirm </button>&nbsp;';
                echo '<button type="submit" name="cancel" value="' . $row["B_Id"] . '">Cancel</button>';
                echo '</form></td>';
                echo "</tr>";
            }

            echo '</table>';
        } else {
            echo "No trips found.";
        }

        $conn->close();

    
        ?>
        
    </table>
    <script>
        var button = document.getElementById('confirmbutton');
        button.addEventListener('click', function() {
        alert('Trip confirm!')
        });
    </script>
    
</body>
</html>