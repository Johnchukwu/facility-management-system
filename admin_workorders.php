<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Work Orders Dashboard</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f6f5f7;
        margin: 0;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100vh;
    }

    h2 {
        text-align: center;
        color: #333;
        margin-top: -40%;

    }

    /* Form Styles */
    form {
        max-width: 600px;
        margin: 10px;
        padding: 20px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        margin-left: -200px;

    }

    label {
        display: block;
        margin-top: 10px;
    }

    input {
        width: 100%;
        padding: 10px;
        margin-top: 5px;
        margin-bottom: 15px;
        box-sizing: border-box;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    a {
        background-color: #4caf50;
        color: #fff;
        padding: 10px 15px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    button {
        background-color: #4caf50;
        color: white;
        padding: 14px 20px;
        margin: 8px 0;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    button:hover {
        background-color: #45a049;
    }

    /* Table Styles */
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    table,
    th,
    td {
        border: 1px solid #ddd;
        text-align: left;
    }

    th,
    td {
        padding: 12px;
    }

    th {
        background-color: #f2f2f2;
    }
    </style>
</head>

<body>

    <h2>Welcome to the Admin Work Orders Dashboard!</h2>

    <!-- Create Work Order Form -->
    <form method="post">
        <label for="description">Description:</label>
        <input type="text" name="description" required>

        <label for="status">Status:</label>
        <input type="text" name="status" required>

        <label for="date">Date:</label>
        <input type="date" name="date" required>

        <label for="projectID">Project ID:</label>
        <input type="number" name="projectID" required>

        <label for="equipmentID">Equipment ID:</label>
        <input type="number" name="equipmentID" required>

        <button type="submit" name="createWorkOrder">Create Work Order</button>
        <a href="admin_page.php">Back</a>
    </form>

    <?php
    
  include("conn.php");

    // Create Work Order
    if (isset($_POST['createWorkOrder'])) {
        // Validate and sanitize user inputs
        $description = $_POST['description'];
        $status = $_POST['status'];
        $date = $_POST['date']; // Date doesn't need sanitization
        $projectID = $_POST['projectID'];
        $equipmentID = $_POST['equipmentID'];

        // Check if all inputs are valid
        if ($description && $status && $date && $projectID !== false && $equipmentID !== false) {
            // Using prepared statement to prevent SQL injection
            $stmt = $conn->prepare("INSERT INTO WorkOrders (Description, Status, Date, ProjectID, EquipmentID) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssi", $description, $status, $date, $projectID, $equipmentID);

            if ($stmt->execute()) {
                echo "<p>Work Order created successfully!</p>";
            } else {
                echo "Error: " . $stmt->error;
            }

            // Close statement
            $stmt->close();
        } else {
            echo "<p>Invalid input. Please check your inputs and try again.</p>";
        }
    }

    // Delete Work Order
    if (isset($_GET['deleteWorkOrder'])) {
        $workOrderIDToDelete = $_GET['deleteWorkOrder'];

        // Using prepared statement to prevent SQL injection
        $stmtDelete = $conn->prepare("DELETE FROM WorkOrders WHERE WorkOrderID = ?");
        $stmtDelete->bind_param("i", $workOrderIDToDelete);

        if ($stmtDelete->execute()) {
            echo "<p>Work Order deleted successfully!</p>";
        } else {
            echo "Error: " . $stmtDelete->error;
        }

        // Close statement
        $stmtDelete->close();
    }

    // Fetch and display work orders
    $sqlFetchWorkOrders = "SELECT * FROM WorkOrders";
    $resultWorkOrders = $conn->query($sqlFetchWorkOrders);

    if ($resultWorkOrders->num_rows > 0) {
        echo "<h3>Work Orders Dashboard</h3>";
        echo "<table>";
        echo "<tr><th>Work Order ID</th><th>Description</th><th>Status</th><th>Date</th><th>Project ID</th><th>Equipment ID</th><th>Action</th></tr>";

        while ($row = $resultWorkOrders->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['WorkOrderID']}</td>";
            echo "<td>{$row['Description']}</td>";
            echo "<td>{$row['Status']}</td>";
            echo "<td>{$row['Date']}</td>";
            echo "<td>{$row['ProjectID']}</td>";
            echo "<td>{$row['EquipmentID']}</td>";
            echo "<td><a href='admin_workorders.php?deleteWorkOrder={$row['WorkOrderID']}'>Delete</a></td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "<p>No work orders found.</p>";
    }

    // Close connection
    $conn->close();
    ?>

</body>

</html>