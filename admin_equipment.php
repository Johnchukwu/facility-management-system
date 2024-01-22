<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Equipment Dashboard</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f6f6f6;
        margin: 0;
        padding: 0;
    }

    h2 {
        text-align: center;
        color: #333;
    }

    form {
        width: 50%;
        margin: 20px auto;
        background-color: #fff;
        padding: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    label {
        display: block;
        margin-bottom: 8px;
        color: #333;
    }

    input {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        box-sizing: border-box;
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
        color: #fff;
        padding: 10px 15px;
        border: none;
        cursor: pointer;
        font-size: 16px;
    }

    button:hover {
        background-color: #45a049;
    }

    table {
        border-collapse: collapse;
        width: 80%;
        margin: 20px auto;
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    th,
    td {
        border: 1px solid #ddd;
        padding: 10px;
        text-align: left;
    }

    th {
        background-color: #4caf50;
        color: #fff;
    }
    </style>
</head>

<body>

    <h2>Admin Equipment Dashboard</h2>

    <form method="post">
        <label for="equipmentID">EquipmentID:</label>
        <input type="text" name="equipmentID" required>

        <label for="type">Type:</label>
        <input type="text" name="type" required>

        <label for="condition">Condition:</label>
        <input type="text" name="condition" required>

        <label for="maintenanceHistory">Maintenance History:</label>
        <input type="text" name="maintenanceHistory" required>

        <button type="submit" name="submit">Submit</button>
        <a href="admin_page.php">Back</a>
    </form>

    <?php
     
      include("conn.php");

    if (isset($_POST['submit'])) {
        $equipmentID = $_POST['equipmentID'];
        $type = $_POST['type'];
        $condition = $_POST['condition'];
        $maintenanceHistory = $_POST['maintenanceHistory'];

        // Use prepared statement to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO equipment(EquipmentID, Type, Condition, MaintenanceHistory) 
                                VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $equipmentID, $type, $condition, $maintenanceHistory);

        if ($stmt->execute()) {
            echo "Data inserted successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }

    // SQL query to retrieve equipment data from Equipment table
     $sqlSelect = "SELECT * FROM equipment";
    $result = $conn->query($sqlSelect);

    if ($result->num_rows > 0) {
        // Output data in a table
        echo "<table>
                <tr>
                    <th>EquipmentID</th>
                    <th>Type</th>
                    <th>Condition</th>
                    <th>Maintenance History</th>
                </tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row["EquipmentID"] . "</td>
                    <td>" . $row["Type"] . "</td>
                    <td>" . $row["Condition"] . "</td>
                    <td>" . $row["MaintenanceHistory"] . "</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "0 results";
    }

    $conn->close();
    ?>

</body>

</html>