<?php
// Disable error reporting to avoid PHP errors being shown in the browser
error_reporting(0);  // Disable error reporting
ini_set('display_errors', 0);  // Hide errors


// Include SweetAlert2 library from CDN (above your script)
echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.10/dist/sweetalert2.all.min.js"></script>';

// Database connection (replace with your actual connection details)
$host = 'localhost'; // Database host

$username = 'root';  // Database username
$password = '';  // Database password
$dbname = 'skilledu_dummy';    // Your database name

 // Your database name

$conn = new mysqli($host, $username, $password, $dbname);

// Check for connection errors
if ($conn->connect_error) {
    // Show SweetAlert2 error message and stop execution
    echo '<script>
            window.onload = function() {
                Swal.fire({
                    icon: "error",
                    title: "Database Connection Failed",
                    text: "Failed to connect to the database. Please try again later.",
                    showConfirmButton: false,
                    timer: 1500
                }).then(function() {
                    window.location.href = "certificate-form.html"; // Redirect to the form page
                });
            }
          </script>';
    exit(); // Stop further execution after showing the alert
}

// Handle the form data after it's posted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize input to prevent SQL injection
    $certificate_number = mysqli_real_escape_string($conn, $_POST['certificate_number']);

    // Handle file upload
    if (isset($_FILES['certificate']) && $_FILES['certificate']['error'] == 0) {
        $file_name = $_FILES['certificate']['name   '];
        $file_tmp = $_FILES['certificate']['tmp_name'];
        $file_size = $_FILES['certificate']['size'];
        $file_error = $_FILES['certificate']['error'];

        // Specify the directory to store uploaded files
        $upload_dir = 'uploads/';  // Relative path to the uploads folder
        $upload_path = $upload_dir . basename($file_name);

        // Check if the upload directory exists
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);  // Create the directory if it doesn't exist
        }

        // Check file type and size (optional)
        $allowed_types = ['application/pdf'];
        $file_type = mime_content_type($file_tmp);
        if (!in_array($file_type, $allowed_types)) {
            // Show SweetAlert2 error message and stop execution
            echo '<script>
                    window.onload = function() {
                        Swal.fire({
                            icon: "error",
                            title: "Invalid File Type",
                            text: "Only PDF files are allowed.",
                            showConfirmButton: false,
                            timer: 1500
                        }).then(function() {
                            window.location.href = "certificate-form.html"; // Redirect to the form page
                        });
                    }
                  </script>';
            exit(); // Stop further execution after showing the alert
        }

        // Move the uploaded file to the desired directory
        if (move_uploaded_file($file_tmp, $upload_path)) {
            // Only store the relative path (e.g., 'uploads/filename.pdf')
            $relative_path = $upload_path;

            // Prepare the SQL query to insert the data (certificate_number and file path)
            $sql = "INSERT INTO certifications (pdf, certificate_id, status)
                    VALUES ('$relative_path', '$certificate_number', 1)";

            // Execute the query and check for success
            if ($conn->query($sql) === TRUE) {
                // Success: Show SweetAlert2 success message and redirect
                echo '<script>
                        window.onload = function() {
                            Swal.fire({
                                icon: "success",
                                title: "Certification Created Successfully",
                                text: "Your certificate has been uploaded and saved.",
                                showConfirmButton: false,
                                timer: 1500
                            }).then(function() {
                                window.location.href = "certificate-form.html"; // Redirect to another page or the same form page
                            });
                        }
                      </script>';
                exit(); // Stop further execution after showing the alert
            } else {
                // SQL error: Show SweetAlert2 error message and stop execution
                echo '<script>
                        window.onload = function() {
                            Swal.fire({
                                icon: "error",
                                title: "Database Error",
                                text: "' . $conn->error . '",
                                showConfirmButton: false,
                                timer: 1500
                            }).then(function() {
                                window.location.href = "certificate-form.html"; // Redirect to the form page
                            });
                        }
                      </script>';
                exit(); // Stop further execution after showing the alert
            }
        } else {
            // File upload failed: Show SweetAlert2 error message and stop execution
            echo '<script>
                    window.onload = function() {
                        Swal.fire({
                            icon: "error",
                            title: "File Upload Failed",
                            text: "There was an issue uploading your file. Please try again.",
                            showConfirmButton: false,
                            timer: 1500
                        }).then(function() {
                            window.location.href = "certificate-form.html"; // Redirect to the form page
                        });
                    }
                  </script>';
            exit(); // Stop further execution after showing the alert
        }
    } else {
        // No file uploaded or file error: Show SweetAlert2 error message and stop execution
        echo '<script>
                window.onload = function() {
                    Swal.fire({
                        icon: "error",
                        title: "No File Uploaded",
                        text: "Please upload a certificate file.",
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function() {
                        window.location.href = "certificate-form.html"; // Redirect to the form page
                    });
                }
              </script>';
        exit(); // Stop further execution after showing the alert
    }
}

// Close the database connection
$conn->close();
?>
