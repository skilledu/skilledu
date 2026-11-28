<?php
// Start the session
session_start();

// Destroy the session by clearing all session variables and destroying the session itself
session_unset();  // Removes all session variables
session_destroy();  // Destroys the session

// Immediately redirect the user to the login page (stays on the same page but with a logout effect)
echo '<script>
        window.location.href = "login.php";  // Replace with your login page URL
      </script>';
exit();
?>
