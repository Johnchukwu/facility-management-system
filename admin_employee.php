<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Management</title>
    <style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f6f5f7;
        margin: 0;
        padding: 0;
    }

    h2,
    h3 {
        color: #333;
        text-align: center;
    }

    form {
        max-width: 400px;
        margin: 20px auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    label {
        display: block;
        margin-bottom: 8px;
    }

    input {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

    button {
        background-color: #4caf50;
        color: #fff;
        padding: 10px 15px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    a {
        background-color: #4caf50;
        color: #fff;
        padding: 10px 15px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    table {
        width: 100%;
        margin-top: 20px;
        border-collapse: collapse;
    }

    th,
    td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #4caf50;
        color: #fff;
    }

    .delete-btn {
        background-color: #f44336;
        color: #fff;
        padding: 6px 10px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }
    </style>
</head>

<body>

    <h2>Employee Management</h2>

    <!-- Create Employee Form -->
    <h3>Create Employee</h3>

    <form method="post">
        <label for="name">Name:</label>
        <input type="text" name="name" required>

        <label for="position">Position:</label>
        <input type="text" name="position" required>

        <label for="contactInformation">Contact Information:</label>
        <input type="text" name="contactInformation" required>

        <label for="roleInProjects">Role In Projects:</label>
        <input type="text" name="roleInProjects" required>

        <button type="submit" name="createEmployee">Create Employee</button>
        <a href="admin_page.php">Back</a>
    </form>

    <?php
    include("conn.php");
    
    if (isset($_POST['createEmployee'])) {
        // Validate and sanitize inputs
        $name = validateInput($_POST['name']);
        $position = validateInput($_POST['position']);
        $ContactInformation = validateInput($_POST['contactInformation']);
        $roleInProjects = validateInput($_POST['roleInProjects']);

        // Use prepared statement to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO employees (Name, Position, ContactInformation, RoleInProjects) 
                                VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $position, $ContactInformation, $roleInProjects);

        if ($stmt->execute()) {
            echo "Employee created successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }

    // Display existing employees in a table
    $sqlSelectEmployees = "SELECT EmployeeID, Name, Position, ContactInformation, RoleInProjects FROM employees";
    $resultEmployees = $conn->query($sqlSelectEmployees);

    displayTable($resultEmployees, ['EmployeeID', 'Name', 'Position', 'ContactInformation', 'RoleInProjects']);

    $conn->close();
    ?>

    <?php
    function validateInput($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function displayTable($result, $columns) {
        global $conn;

        if ($result->num_rows > 0) {
            // Output data in a table
            echo "<h3>Employee Dashboard</h3>";
            echo "<table>
                    <tr>";
            foreach ($columns as $column) {
                echo "<th>" . $column . "</th>";
            }
            echo "<th>Action</th>
                    </tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                foreach ($columns as $column) {
                    echo "<td>" . $row[$column] . "</td>";
                }
                echo "<td>
                        <form method='post'>
                            <input type='hidden' name='IDToDelete' value='" . $row[$columns[0]] . "'>
                            <button type='submit' class='delete-btn' name='delete'>Delete</button>
                        </form>
                      </td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "0 results";
        }

        if (isset($_POST['delete'])) {
            // Handle deletion
            $IDToDelete = validateInput($_POST['IDToDelete']);
            $stmtDelete = $conn->prepare("DELETE FROM employees WHERE EmployeeID = ?");
            $stmtDelete->bind_param("s", $IDToDelete);

            if ($stmtDelete->execute()) {
                echo "Record deleted successfully.";
            } else {
                echo "Error deleting record: " . $stmtDelete->error;
            }

            $stmtDelete->close();
        }
    }
    ?>

</body>

</html>