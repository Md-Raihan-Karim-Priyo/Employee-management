<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Employee";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    // Fetch the employee details
    $sql = "SELECT * FROM Employee_details WHERE Email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Your original string
        $originalString = $row['Full_Name'];

        // Split the string into an array using space as the delimiter
        $parts = explode(" ", $originalString);

        // Store the separated strings in two variables
        $firstName = $parts[0];
        $lastName = $parts[1];
        echo json_encode([
            'first_name' => $firstName ,
            'last_name' => $lastName,
            'email' => $row['Email'],
            'mobile' => $row['Mobile'],
            'dob' => $row['Date_of_Birth']
        ]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Employee not found']);
    }

    $conn->close();
}
?>
