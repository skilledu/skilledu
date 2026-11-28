<?php
header('Content-Type: application/json');

$host = 'localhost';

$username = 'root';  // Database username
$password = '';  // Database password
$dbname = 'skilledu_dummy';    // Your database name


$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed']);
    exit;
}

$certificate_id = '';
$certificate_data = null;
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $certificate_id = mysqli_real_escape_string($conn, $_POST['certificate_id']);

    if (!empty($certificate_id)) {
        $sql = "SELECT * FROM certifications WHERE certificate_id = '$certificate_id'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $certificate_data = $result->fetch_assoc();
        } else {
            $error_message = "No certificate found with ID: $certificate_id";
        }
    } else {
        $error_message = "Please enter a certificate ID.";
    }
} else {
    $certificate_data = ['pdf' => 'defaultt/default-certificate.pdf'];
}

$conn->close();

// ✅ Final JSON Response
if ($certificate_data) {
    echo json_encode(['status' => 'success', 'data' => $certificate_data]);
} else {
    echo json_encode(['status' => 'error', 'message' => $error_message]);
}
?>
