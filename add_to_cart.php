<?php
include 'root/config.php';

// Check if cause_id is passed via GET or POST
if (isset($_POST['cause_id']) || isset($_GET['id'])) {
    $cause_id = isset($_POST['cause_id']) ? intval($_POST['cause_id']) : intval($_GET['id']);

    // Check if the cause exists
    $check_cause_sql = "SELECT id FROM causes WHERE id = ?";
    $stmt_check = $conn->prepare($check_cause_sql);
    $stmt_check->bind_param('i', $cause_id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows === 0) {
        echo "Invalid cause ID.";
        exit();
    }

    // Add or update the cart
    $sql = "INSERT INTO cart (cause_id, quantity) VALUES (?, 1)
            ON DUPLICATE KEY UPDATE quantity = quantity + 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $cause_id);

    if ($stmt->execute()) {
        header("Location: cart.php"); // Redirect to the cart page
        exit();
    } else {
        echo "Failed to add to cart.";
    }
} else {
    echo "Cause ID not provided.";
    exit();
}
?>
