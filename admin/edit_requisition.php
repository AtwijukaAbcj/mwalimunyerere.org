<?php
include('header.php');
include('config.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "localhost";
$username = "centric_brendan";
$password = "Admin@2022";
$dbname = "centric_requisitions";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check if requisition ID is provided in the URL
if (isset($_GET['requisition_id'])) {
    $requisition_id = $_GET['requisition_id'];
    
    // Fetch requisition details from the database
    $requisition = dbRow("SELECT * FROM centric_requisitions.requisitions WHERE requisition_id = '$requisition_id'");
    
    // Check if requisition exists
    if (!$requisition) {
        // Redirect to error page or display error message
        header("Location: prepare.php");
        exit;
    }
} else {
    // Redirect to error page or display error message
    header("Location: error.php");
    exit;
}

// Process form submission to update requisition
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_requisition'])) {
    // Retrieve form data
    $department = $_POST['department'];
    $pay_to = $_POST['pay_to'];
    $description = $_POST['description'];
    $tik_currency = $_POST['tik_currency'];
    $amount_figure = $_POST['amount_figure'];
    $amount_words = $_POST['amount_words'];
    $mode_of_payment = $_POST['mode_of_payment'];
    $advance_payment = $_POST['advance_payment'];
    $previous_payments = $_POST['previous_payments'];
    $budget_reference = $_POST['budget_reference'];
    
    // New columns
    $budgeted_amount = $_POST['budgeted_amount'];
    $running_total = $_POST['running_total'];
    $running_balance = $_POST['running_balance'];
    
    // Update requisition in the database
    $update_query = "UPDATE centric_requisitions.requisitions 
                    SET budgeted_amount = '$budgeted_amount', 
                        running_total = '$running_total', 
                        running_balance = '$running_balance'
                    WHERE requisition_id = '$requisition_id'";
    dbSQL($update_query);

    // Redirect to the list of requisitions page
    header("Location: preparer.php");
    exit;
}
?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="<?=HOME_URL;?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="list_requisitions.php">List of Requisitions</a></li>
                        <li class="breadcrumb-item active">Edit Requisition</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">    
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"> <b> <i class="fa fa-pencil"> </i> Edit Requisition </b> </h3>
                        </div>
                        <div class="card-body">
                            <form method="post" enctype="multipart/form-data">

                                <div class="form-group">
                                    <label for="budgeted_amount">Budgeted Amount</label>
                                    <input type="text" class="form-control" id="budgeted_amount" name="budgeted_amount" value="<?= $requisition->budgeted_amount; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="running_total">Running Total</label>
                                    <input type="text" class="form-control" id="running_total" name="running_total" value="<?= $requisition->running_total; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="running_balance">Running Balance</label>
                                    <input type="text" class="form-control" id="running_balance" name="running_balance" value="<?= $requisition->running_balance; ?>" required>
                                </div>

                                <button type="submit" class="btn btn-primary" name="update_requisition">Update Requisition</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include('footer.php'); ?>
