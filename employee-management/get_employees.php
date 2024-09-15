<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Employee";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = isset($_GET['per_page']) ? (int)$_GET['per_page'] : 10;
$offset = ($page - 1) * $perPage;

$sortColumn = isset($_GET['sort_column']) ? $_GET['sort_column'] : 'Full_Name';
$sortOrder = isset($_GET['sort_order']) && $_GET['sort_order'] === 'desc' ? 'DESC' : 'ASC';

// Filtering options
$name = isset($_GET['name']) ? $_GET['name'] : '';
$dob = isset($_GET['dob']) ? $_GET['dob'] : '';
$email = isset($_GET['email']) ? $_GET['email'] : '';
$mobile = isset($_GET['mobile']) ? $_GET['mobile'] : '';

// SQL query with sorting and pagination
$sql = "SELECT * FROM Employee_details 
        WHERE Full_Name LIKE '%$name%' 
        AND Date_of_Birth LIKE '%$dob%' 
        AND Email LIKE '%$email%' 
        AND Mobile LIKE '%$mobile%' 
        ORDER BY $sortColumn $sortOrder 
        LIMIT $offset, $perPage";

$result = $conn->query($sql);

// Get total records for pagination
$totalResult = $conn->query("SELECT COUNT(*) as total FROM Employee_details WHERE Full_Name LIKE '%$name%' AND Date_of_Birth LIKE '%$dob%' AND Email LIKE '%$email%' AND Mobile LIKE '%$mobile%'");
$total = $totalResult->fetch_assoc()['total'];

$employees = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $employees[] = [
            'id' => $row['id'],
            'Photo' => base64_encode($row['Photo']),
            'Full_Name' => $row['Full_Name'],
            'Email' => $row['Email'],
            'Mobile' => $row['Mobile'],
            'Date_of_Birth' => $row['Date_of_Birth']
        ];
    }
}

echo json_encode([
    'employees' => $employees,
    'total' => $total
]);

$conn->close();
?>
