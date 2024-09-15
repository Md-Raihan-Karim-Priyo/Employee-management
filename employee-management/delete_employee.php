<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Employee";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}// your connection file


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

 
    // SQL to delete the employee
    $sql = "DELETE FROM Employee_details WHERE Email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete employee']);
    }

    $stmt->close();
    $conn->close();

}



?>
