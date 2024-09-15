<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Employee";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$fullName = $firstName . ' ' . $lastName;
$email = $_POST['email'];
$mobile = $_POST['mobile'];
$dob = $_POST['dob'];

// Handle image upload
if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
    $photoTmpPath = $_FILES['photo']['tmp_name'];
    $photoData = file_get_contents($photoTmpPath);
    $photoEscaped = $conn->real_escape_string($photoData);
    
    // Insert into database
    $sql = "INSERT INTO Employee_details (Photo, Full_Name, Email, Mobile, Date_of_Birth) 
            VALUES ('$photoEscaped', '$fullName', '$email', '$mobile', '$dob')";

    if ($conn->query($sql) === TRUE) {
        echo "New employee added successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "Error uploading photo.";
}

$conn->close();
?>
