<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Employee";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $mobile = $_POST['mobile'];
    $dob = $_POST['dob'];
    $photo = $_FILES['photo']['name'];

    // Handle photo upload if exists
    if ($photo) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($photo);
        move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file);
    }

    // Update the employee details
    $sql = "UPDATE Employee_details SET Full_Name = '$first_name $last_name', Mobile = '$mobile', Date_of_Birth = '$dob'";
    if ($photo) {
        $sql .= ", Photo = '$photo'";
    }
    $sql .= " WHERE Email = '$email'";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Update failed']);
    }

    $conn->close();
}
?>
