<?php
session_start(); // Start the session

// Destroy all session data
session_unset();
session_destroy();

// Redirect to the login page or home page after logout
header("Location: login.php"); // Change to your login page or desired redirect page
exit();
