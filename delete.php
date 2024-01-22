<?php

if (isset($_GET['employeeID']) && isset($_GET['projectID'])) {
    $employeeID = $_GET['employeeID'];
    $projectID = $_GET['projectID'];

    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("DELETE FROM EmployeeProjects WHERE EmployeeID = ? AND ProjectID = ?");
    $stmt->bind_param("ss", $employeeID, $projectID);

    if ($stmt->execute()) {
        echo "Record deleted successfully.";
    } else {
        echo "Error deleting record: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>