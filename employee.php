<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Dashboard</title>
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
        margin-top: 5%;
    }

    form {
        width: 50%;
        margin: 20px auto;
        background-color: #fff;
        padding: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        margin-top: 3%;
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
    </style>
</head>

<body>

    <h2>Employee Form</h2>

    <form method="post">
        <label for="employeeID">EmployeeID:</label>
        <input type="text" name="employeeID" required>

        <label for="name">Name:</label>
        <input type="text" name="name" required>

        <label for="position">Position:</label>
        <input type="text" name="position" required>

        <label for="contactInformation">Contact Information:</label>
        <input type="text" name="contactInformation" required>

        <label for="roleInProjects">Role in Projects:</label>
        <input type="text" name="roleInProjects" required>

        <button type="submit" name="submit">Submit</button>
    </form>

    <?php
 include("conn.php");

 
    if (isset($_POST['submit'])) {
        $employeeID = $_POST['employeeID'];
        $name = $_POST['name'];
        $position = $_POST['position'];
        $contactInformation = $_POST['contactInformation'];
        $roleInProjects = $_POST['roleInProjects'];

        // Use prepared statement to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO Employees (EmployeeID, Name, Position, ContactInformation, RoleInProjects) 
                                VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $employeeID, $name, $position, $contactInformation, $roleInProjects);

        if ($stmt->execute()) {
            echo "Data inserted successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }

    // SQL query to retrieve employee data from Employees table
    $sqlSelect = "SELECT EmployeeID, Name, Position, ContactInformation, RoleInProjects FROM Employees";
    $result = $conn->query($sqlSelect);

    if ($result->num_rows > 0) {
        // Output data in a table
        echo "<table>
                <tr>
                    <th>EmployeeID</th>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Contact Information</th>
                    <th>Role in Projects</th>
                </tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row["EmployeeID"] . "</td>
                    <td>" . $row["Name"] . "</td>
                    <td>" . $row["Position"] . "</td>
                    <td>" . $row["ContactInformation"] . "</td>
                    <td>" . $row["RoleInProjects"] . "</td>
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