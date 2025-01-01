<?php
include 'config.php'; // Include the navigation menu
include 'header.php'; 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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

// Initialize message variable
$message = '';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get requisition details from the form
    // $date = isset($_POST["date"]) ? $_POST["date"] : date("Y-m-d");
    $department = $_POST["department"];
    $pay_to = $_POST["pay_to"];
    $description = $_POST["description"];
    $tik_currency = isset($_POST["currency"]) ? implode(",", $_POST["currency"]) : ''; // Convert array to comma-separated string
    $amount_figure = $_POST["amount_figure"];
    $amount_words = $_POST["amount_words"];
    $mode_of_payment = isset($_POST["mode_of_payment"]) ? implode(",", $_POST["mode_of_payment"]) : ''; // Convert array to comma-separated string
    $advance_payment = isset($_POST["advance_payment"]) ? $_POST["advance_payment"] : 'No'; // Check if checkbox is checked
    $previous_payments = $_POST["previous_payments"];
    $budget_reference = $_POST["budget_reference"];
    //  getting userid session
    
    $userID = $_SESSION['userid'];
    
    // New fields
    $budgeted_amount = $_POST['budgeted_amount'];
    $running_total = $_POST['running_total'];
    $running_balance = $_POST['running_balance'];
    
// Handle file uploads for documents
$uploadsDir = 'uploads/'; // Directory where files will be uploaded
$document1File = $_FILES['document1_file']['tmp_name'];
$document2File = $_FILES['document2_file']['tmp_name'];
$document3File = $_FILES['document3_file']['tmp_name'];
$document4File = isset($_FILES['document4_file']['tmp_name']) ? $_FILES['document4_file']['tmp_name'] : null; // Check if document4 is uploaded
$document5File = isset($_FILES['document5_file']['tmp_name']) ? $_FILES['document5_file']['tmp_name'] : null; // Check if document5 is uploaded

// Move uploaded files only if they are not empty
$document1Path = !empty($document1File) ? $uploadsDir . uniqid('document1_') . '.jpg' : null;
$document2Path = !empty($document2File) ? $uploadsDir . uniqid('document2_') . '.jpg' : null;
$document3Path = !empty($document3File) ? $uploadsDir . uniqid('document3_') . '.jpg' : null;
$document4Path = !empty($document4File) ? $uploadsDir . uniqid('document4_') . '.jpg' : null;
$document5Path = !empty($document5File) ? $uploadsDir . uniqid('document5_') . '.jpg' : null;

// Move the files only if they are not empty
// Count the number of uploaded documents
$uploadedDocuments = 0;
if (!empty($document1Path)) {
    $uploadedDocuments++;
}
if (!empty($document2Path)) {
    $uploadedDocuments++;
}
if (!empty($document3Path)) {
    $uploadedDocuments++;
}
if (!empty($document4Path)) {
    $uploadedDocuments++;
}
if (!empty($document5Path)) {
    $uploadedDocuments++;
}

// Check if at least two documents are uploaded
if ($uploadedDocuments < 2) {
    $message = "Please upload at least two documents.";
} else {
    // Proceed with the insertion into the database
    // Insert data into requisitions table
    $sql = "INSERT INTO requisitions (department, pay_to, description, tik_currency, amount_figure, amount_words, mode_of_payment, advance_payment, previous_payments, budget_reference, budgeted_amount, running_total, running_balance, document1, document2, document3, document4, document5, userid) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Error preparing statement: " . $conn->error);
    }

    // Bind parameters
    $stmt->bind_param("sssssssssssssssssss", $department, $pay_to, $description, $tik_currency, $amount_figure, $amount_words, $mode_of_payment, $advance_payment, $previous_payments, $budget_reference, $budgeted_amount, $running_total, $running_balance, $document1Path, $document2Path, $document3Path, $document4Path, $document5Path, $userID);

    // Execute the statement
    if ($stmt->execute()) {
        $message = 'Requisition submitted successfully.';
    } else {
        $message = 'Error submitting requisition: ' . $conn->error;
    }
}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Requisitions</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  

</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2">
            
            </div>
            <div class="col-md-10" style="padding-left: 80px;">
                <div class="container">
                    <h1>Edit Requisitions</h1>
                    <?php if (!empty($message)): ?>
                        <div class="alert alert-<?php echo ($message === 'Requisition submitted successfully.') ? 'success' : 'danger'; ?>" role="alert">
                            <?php echo $message; ?>
                        </div>
                    <?php endif; ?>
                    <div class="card mb-4 info">
                        <div class="card-header">
                            <i class="fas fa-list mr-1"></i>
                            <b>Add New Requisition</b>
                        </div>
                        <div class="card-body">
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data"> <!-- Add enctype attribute -->
                                    <!--<div class="form-group">-->
                                    <!--    <label for="date">Date:</label>-->
                                    <!--    <input type="date" id="date" name="date" class="form-control" required>-->
                                    <!--</div>-->
                                <div class="form-group">
                                    <label for="department">Department:</label>
                                    <select name="department" class="form-control">
                                        <option value=""> -- Select -- </option>
                                        <?php
                                        // Fetch departments from the database
                                        $sql = "SELECT * FROM departments";
                                        $result = $conn->query($sql);
                                        if ($result->num_rows > 0) {
                                            while($row = $result->fetch_assoc()) {
                                                echo "<option value='" . $row["dname"] . "'>" . $row["dname"] . "</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="pay_to">Pay To:</label>
                                    <input type="text" id="pay_to" name="pay_to" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="description">Description:</label>
                                    <textarea id="description" name="description" rows="5" class="form-control" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="tik_currency">Tick Currency:</label>
                                    <div id="tik_currency" class="form-group">
                                        <label class="font-weight-normal">Select Currency:</label><br>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="currency_ugx" name="currency[]" value="UGX">
                                            <label class="form-check-label" for="currency_ugx">UGX</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="currency_usd" name="currency[]" value="USD">
                                            <label class="form-check-label" for="currency_usd">USD</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="currency_gbp" name="currency[]" value="GBP">
                                            <label class="form-check-label" for="currency_gbp">GBP</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="amount_figure">Amount (Figure):</label>
                                    <input type="text" id="amount_figure" name="amount_figure" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="amount_words">Amount (Words):</label>
                                    <input type="text" id="amount_words" name="amount_words" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="mode_of_payment">Mode of Payment:</label><br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="payment_check" name="mode_of_payment[]" value="CHECK">
                                        <label class="form-check-label" for="payment_check">Check</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="payment_cash" name="mode_of_payment[]" value="CASH">
                                        <label class="form-check-label" for="payment_cash">Cash</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="advance_payment">Mention if any Advance Payment:</label>
                                    <br>
                                    <input type="checkbox" id="advance_payment" name="advance_payment" value="Yes"> Yes
                                </div>
                                <div class="form-group">
                                    <label for="previous_payments">Previous Payment(s):</label>
                                    <input type="text" id="previous_payments" name="previous_payments" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="budget_reference">Budget reference number:</label>
                                    <input type="text" id="budget_reference" name="budget_reference" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="budgeted_amount">Budgeted Amount:</label>
                                    <input type="text" id="budgeted_amount" name="budgeted_amount" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="running_total">Running Total:</label>
                                    <input type="text" id="running_total" name="running_total" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="running_balance">Running Balance:</label>
                                    <input type="text" id="running_balance" name="running_balance" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="document1_file">document 1:</label>
                                    <input type="file" id="document1_file" name="document1_file" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="document2_file">document 2:</label>
                                    <input type="file" id="document2_file" name="document2_file" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="document3_file">document 3:</label>
                                    <input type="file" id="document3_file" name="document3_file" class="form-control">
                                </div>
                                <div id="additional_documents"></div> <!-- Container for additional document fields -->
                                <button type="button" class="btn btn-secondary" id="add_document">Add More documents</button> <!-- Button to add more fields -->
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- jQuery to add more file input fields -->
    <!-- jQuery to add more file input fields -->
<script>
    $(document).ready(function(){
        let documentCounter = 4; // Start counter for additional documents
        $('#add_document').click(function(){ // Corrected ID
            if (documentCounter <= 5) { // Limit to a maximum of 5 document fields (3 original + 2 additional)
                $('#additional_documents').append(`
                    <div class="form-group">
                        <label for="document${documentCounter}_file">document ${documentCounter}:</label>
                        <input type="file" id="document${documentCounter}_file" name="document${documentCounter}_file" class="form-control">
                    </div>
                `);
                documentCounter++;
            } else {
                alert("You can add only up to 2 additional documents.");
            }
        });
    });
</script>

</body>
</html>
