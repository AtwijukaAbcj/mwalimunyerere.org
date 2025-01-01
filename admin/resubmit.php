<?php
session_start();
include('config.php');

// Database connection
$servername = "localhost";
$username = "centric_brendan";
$password = "Admin@2022";
$dbname = "centric_requisitions";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $requisition_id = $_POST['requisition_id'];
    $date = $_POST['date'];
    $pay_to = $_POST['pay_to'];
    $description = $_POST['description'];
    $mode_of_payment = isset($_POST['mode_of_payment']) ? implode(",", $_POST['mode_of_payment']) : ''; // Convert array to comma-separated string
    $advance_payment = isset($_POST['advance_payment']) ? $_POST['advance_payment'] : 'No';
    $previous_payments = $_POST['previous_payments'];
    $budget_reference = $_POST['budget_reference'];

    // Update the requisition data in the database
    $update_query = "UPDATE requisitions SET 
                     date = ?, 
                     pay_to = ?, 
                     description = ?, 
                     mode_of_payment = ?, 
                     advance_payment = ?, 
                     previous_payments = ?, 
                     budget_reference = ?, 
                     status = 'Prepared'
                     WHERE requisition_id = ?";

    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("sssssssi", $date, $pay_to, $description, $mode_of_payment, $advance_payment, $previous_payments, $budget_reference, $requisition_id);

    if ($stmt->execute()) {
        $_SESSION['msg'] = 'Requisition resubmitted successfully.';
    } else {
        $_SESSION['msg'] = 'Error resubmitting requisition: ' . $stmt->error;
    }

    // Redirect back to the list of rejected requisitions
    header("Location: preparer_rejected.php");
    exit;
}

$conn->close();
?>
