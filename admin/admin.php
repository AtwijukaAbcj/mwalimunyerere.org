<?php
// Include header and configuration files
include('header.php');
include('config.php');

// Check connection
// (Assuming the database connection code is the same for all roles)
$servername = "localhost";
$username = "centric_brendan";
$password = "Admin@2022";
$dbname = "centric_requisitions";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from the requisitions table
$list = dbSQL("SELECT * FROM centric_requisitions.requisitions ORDER BY requisition_id DESC");

// Fetch data from the status table
$st = dbSQL("SELECT * FROM status ORDER BY id");

// Process form submission to mark requisition as checked
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['check_requisition'])) {
    $requisition_id = $_POST['requisition_id'];
    // Update the checked_by_checker column in the database for the selected requisition
    $update_query = "UPDATE centric_requisitions.requisitions SET checked_by_checker = '1' WHERE requisition_id = '$requisition_id'";
    dbSQL($update_query); // Execute the update query
    // Optionally, you can add a success message or redirect the user to a different page after marking the requisition as checked
}
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="<?= HOME_URL; ?>">Home</a></li>
                        <li class="breadcrumb-item active">List of Requisitions</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <?php if (!empty($_SESSION['msg'])) echo log_message(); ?>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><b><i class="fa fa-database"></i> List of Requisitions</b></h3>
                        </div>
                        <div class="card-body table-responsive">
                            <?php if (sizeof($list) > 0) { ?>
                                <table id="example1" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Department</th>
                                            <th>Pay To</th>
                                            <th>Description</th>
                                            <th>Currency</th>
                                            <th>Amount Figure</th>
                                            <th>Amount Words</th>
                                            <th>Mode of Payment</th>
                                            <th>Advance Payment</th>
                                            <th>Previous Payments</th>
                                            <th>Budget Reference</th>
                                            <th> Status </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($list as $row) : ?>
                                            <tr>
                                                <td><?= $row->date; ?></td>
                                                <td><?= $row->department; ?></td>
                                                <td><?= $row->pay_to; ?></td>
                                                <td><?= $row->description; ?></td>
                                                <td><?= $row->tik_currency; ?></td>
                                                <td><?= $row->amount_figure; ?></td>
                                                <td><?= $row->amount_words; ?></td>
                                                <td><?= $row->mode_of_payment; ?></td>
                                                <td><?= $row->advance_payment; ?></td>
                                                <td><?= $row->previous_payments; ?></td>
                                                <td><?= $row->budget_reference; ?></td>
                                                <td><?= $row->status; ?></td>
                                                <td>
                                                    <?php if ($_SESSION['role'] == 'Checker' && $row->checked_by_checker != '1') { ?>
                                                        <form method="post">
                                                            <input type="hidden" name="requisition_id" value="<?= $row->requisition_id; ?>">
                                                            <button type="submit" name="check_requisition" class="btn btn-primary">Check</button>
                                                        </form>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php } else {
                                echo '<b style="color:red"> No requisitions available in the system </b>';
                            } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include('footer.php'); ?>
