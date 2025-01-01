<?php
// Ensure database configuration file is included only once
require_once('root/config.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if a session is already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Initialize the database connection
if (!isset($conn)) {
    $conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
    if ($conn->connect_error) {
        die("Database connection failed: " . $conn->connect_error);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['userID'])) {
    $userID = trim($_POST['userID']);
    $firstName = trim($_POST['firstName']);
    $email = trim($_POST['email']);
    $contact = trim($_POST['contact']);
    $country = trim($_POST['country']);
    $role = trim($_POST['role']);

    // Validate the input
    if (empty($firstName) || empty($email) || empty($contact) || empty($country) || empty($role)) {
        $_SESSION['msg'] = '<div class="alert alert-danger">All fields are required.</div>';
        header('Location: list_users.php');
        exit();
    }

    // Update the user details in the database
    $query = "UPDATE users SET firstName = ?, email = ?, contact = ?, country = ?, role = ? WHERE userID = ?";
    $stmt = $conn->prepare($query);

    if ($stmt === false) {
        error_log('Prepare failed: ' . $conn->error);
        $_SESSION['msg'] = '<div class="alert alert-danger">Prepare failed: ' . $conn->error . '</div>';
        header('Location: list_users.php');
        exit();
    }

    $stmt->bind_param("sssssi", $firstName, $email, $contact, $country, $role, $userID);

    if ($stmt->execute()) {
        $_SESSION['msg'] = '<div class="alert alert-success">User details updated successfully.</div>';
    } else {
        error_log('Execute failed: ' . $stmt->error);
        $_SESSION['msg'] = '<div class="alert alert-danger">Failed to update user details: ' . $stmt->error . '</div>';
    }

    $stmt->close();
    $conn->close();

    // Redirect to the user list page
    header('Location: list_users.php');
    exit();
} else {
    $_SESSION['msg'] = '<div class="alert alert-danger">Invalid request.</div>';
    header('Location: list_users.php');
    exit();
}
?>
