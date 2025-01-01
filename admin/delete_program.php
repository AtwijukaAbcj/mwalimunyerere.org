<?php
require_once('root/config.php');

// Check if program ID is passed
if (!isset($_GET['id']) || !filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
    die("Invalid program ID.");
}

$program_id = intval($_GET['id']);

// Prepare the delete statement
$stmt = $con->prepare("DELETE FROM programs WHERE id = ?");
$stmt->bind_param("i", $program_id);

if ($stmt->execute()) {
    $_SESSION['msg'] = 'Program deleted successfully.';
} else {
    $_SESSION['msg'] = 'Failed to delete program.';
}

$stmt->close();
header("Location: manage_programs.php");
exit();
?>
