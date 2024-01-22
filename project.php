<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Management</title>
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

    <h2>Project Management</h2>

    <!-- Create Project Form -->
    <h3>Create Project</h3>

    <form method="post">
        <label for="projectName">Project Name:</label>
        <input type="text" name="projectName" required>

        <label for="startDate">Start Date:</label>
        <input type="date" name="startDate" required>

        <label for="endDate">End Date:</label>
        <input type="date" name="endDate" required>

        <label for="budget">Budget:</label>
        <input type="number" name="budget" required>

        <label for="status">Status:</label>
        <input type="text" name="status" required>

        <label for="facilityID">Facility ID:</label>
        <input type="number" name="facilityID" required>

        <button type="submit" name="createProject">Create Project</button>
    </form>

    <?php
    
    include("conn.php");

    // Create Project
    if (isset($_POST['createProject'])) {
        $projectName = mysqli_real_escape_string($conn, $_POST['projectName']);
        $startDate = mysqli_real_escape_string($conn, $_POST['startDate']);
        $endDate = mysqli_real_escape_string($conn, $_POST['endDate']);
        $budget = mysqli_real_escape_string($conn, $_POST['budget']);
        $status = mysqli_real_escape_string($conn, $_POST['status']);
        $facilityID = mysqli_real_escape_string($conn, $_POST['facilityID']);

        // Using prepared statement to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO Projects (ProjectName, StartDate, EndDate, Budget, Status, FacilityID) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $projectName, $startDate, $endDate, $budget, $status, $facilityID);

        if ($stmt->execute()) {
            echo "<p>Project created successfully!</p>";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close statement
        $stmt->close();
    }

    // Fetch and display projects
    $sqlFetchProjects = "SELECT * FROM Projects";
    $resultProjects = $conn->query($sqlFetchProjects);

    if ($resultProjects->num_rows > 0) {
        echo "<h3>Project Dashboard</h3>";
        echo "<table>";
        echo "<tr><th>Project ID</th><th>Project Name</th><th>Start Date</th><th>End Date</th><th>Budget</th><th>Status</th><th>Facility ID</th></tr>";

        while ($row = $resultProjects->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['ProjectID']}</td>";
            echo "<td>{$row['ProjectName']}</td>";
            echo "<td>{$row['StartDate']}</td>";
            echo "<td>{$row['EndDate']}</td>";
            echo "<td>{$row['Budget']}</td>";
            echo "<td>{$row['Status']}</td>";
            echo "<td>{$row['FacilityID']}</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "<p>No projects found.</p>";
    }

    // Close connection
    $conn->close();
    ?>

</body>

</html>