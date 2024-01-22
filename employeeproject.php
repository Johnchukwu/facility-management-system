<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Project Dashboard</title>
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
        padding: 50px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        margin-top: 10%;
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

    a {
        color: #4caf50;
        text-decoration: none;
    }

    a:hover {
        text-decoration: underline;
    }
    </style>
</head>

<body>

    <h2>Employee Project Dashboard</h2>

    <form method="post">
        <label for="employeeID">EmployeeID:</label>
        <input type="text" name="employeeID" required>

        <label for="projectID">ProjectID:</label>
        <input type="text" name="projectID" required>

        <button type="submit" name="submit">Submit</button>
    </form>

    <?php
    
    include("conn.php");

    if (isset($_POST['submit'])) {
        $employeeID = $_POST['employeeID'];
        $projectID = $_POST['projectID'];

        // Use prepared statement to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO EmployeeProjects (EmployeeID, ProjectID) VALUES (?, ?)");
        $stmt->bind_param("ss", $employeeID, $projectID);

        if ($stmt->execute()) {
            echo "Data inserted successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }

    $sqlSelect = "SELECT EmployeeID, ProjectID FROM EmployeeProjects";
    $result = $conn->query($sqlSelect);

    if ($result->num_rows > 0) {
        echo "<table>
                <tr>
                    <th>EmployeeID</th>
                    <th>ProjectID</th>
                    <th>Action</th>
                </tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row["EmployeeID"] . "</td>
                    <td>" . $row["ProjectID"] . "</td>
                    <td><a href='delete.php?employeeID=" . $row["EmployeeID"] . "&projectID=" . $row["ProjectID"] . "'>Delete</a></td>
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