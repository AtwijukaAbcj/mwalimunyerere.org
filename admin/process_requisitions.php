<?php
// Assuming your database connection is established and named $dbConnection

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $date = $_POST['date'];
    $department = $_POST['department'];
    $pay_to = $_POST['pay_to'];
    $description = $_POST['description'];
    $amount_figure = $_POST['amount_figure'];
    $amount_words = $_POST['amount_words'];
    $mode_of_payment = implode(",", $_POST['mode_of_payment']); // Convert array to comma-separated string
    $advance_payment = isset($_POST['advance_payment']) ? $_POST['advance_payment'] : 'No'; // Check if checkbox is checked
    $previous_payments = $_POST['previous_payments'];
    $budget_reference = $_POST['budget_reference'];

    // Insert data into requisitions table
    $query = "INSERT INTO requisitions (date, department, pay_to, description, amount_figure, amount_words, mode_of_payment, advance_payment, previous_payments, budget_reference) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $dbConnection->prepare($query);
    
    // Bind parameters
    $stmt->bind_param("ssssssssss", $date, $department, $pay_to, $description, $amount_figure, $amount_words, $mode_of_payment, $advance_payment, $previous_payments, $budget_reference);
    
    // Execute the statement
    $stmt->execute();
    
    // Check if the insertion was successful
    if ($stmt->affected_rows > 0) {
        // Redirect back to the form page with success message
        header("Location: form_page.php?success=1");
        exit();
    } else {
        // Redirect back to the form page with error message
        header("Location: form_page.php?error=1");
        exit();
    }

    // Close statement
    $stmt->close();
} else {
    // Redirect back to the form page if accessed directly
    header("Location: form_page.php");
    exit();
}
?>
