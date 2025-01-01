<?php
include('header.php');
include('config.php');

// Fetch data from the requisitions table
$list = dbSQL("SELECT * FROM centric_requisitions.requisitions WHERE status = 'Prepared' ORDER BY requisition_id DESC");

// Process form submission to mark requisition as checked
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['check_requisition'])) {
    $requisition_id = $_POST['requisition_id'];
    $update_query = $dbh->prepare("UPDATE centric_requisitions.requisitions SET checked_by_checker = '1', status = 'Checked' WHERE requisition_id = :requisition_id");
    $update_query->bindParam(':requisition_id', $requisition_id, PDO::PARAM_INT);
    $update_query->execute();
}

// Process form submission from the modal for updating status
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_status'])) {
    $requisition_id = $_POST['requisition_id'];
    $status = $_POST['status'];
    $reason = isset($_POST['reason']) ? $_POST['reason'] : ''; // Get the reason for rejection if provided
    $checker_comment = isset($_POST['checker_comment']) ? $_POST['checker_comment'] : ''; // Get checker comment if provided

    if ($status == '1') {
        // If status is 'Check', update checked_by_checker column
        $update_query = $dbh->prepare("UPDATE centric_requisitions.requisitions SET checked_by_checker = '1', status = 'Checked', checker_comment = :checker_comment WHERE requisition_id = :requisition_id");
        $update_query->bindParam(':checker_comment', $checker_comment, PDO::PARAM_STR);
    } else if ($status == 'Rejected') {
        // If status is 'Reject', update status column to 'Rejected' and reason_for_rejection
        $update_query = $dbh->prepare("UPDATE centric_requisitions.requisitions SET status = 'Rejected', reason_for_rejection = :reason WHERE requisition_id = :requisition_id");
        $update_query->bindParam(':reason', $reason, PDO::PARAM_STR);
    }
    $update_query->bindParam(':requisition_id', $requisition_id, PDO::PARAM_INT);
    $update_query->execute();

    // Redirect back to the same page to refresh the list
    header("Location: checker.php");
    exit;
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
            <?php if(!empty($_SESSION['msg'])) echo log_message(); ?>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"> <b> <i class="fa fa-database"> </i> List of Requisitions </b> </h3>
                        </div>
                        <div class="card-body table-responsive">
                            <?php if(sizeof($list) > 0) { ?>
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
                                        <th>document 1</th>
                                        <th>document 2</th>
                                        <th>document 3</th>
                                        <th>Status</th>
                                        <th>Check</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($list as $row): ?>
                                    <tr>
                                        <td><?=$row->created_at;?></td>
                                        <td><?=$row->department;?></td>
                                        <td><?=$row->pay_to;?></td>
                                        <td><?=$row->description;?></td>
                                        <td><?=$row->tik_currency;?></td>
                                        <td><?=$row->amount_figure;?></td>
                                        <td><?=$row->amount_words;?></td>
                                        <td><?=$row->mode_of_payment;?></td>
                                        <td><?=$row->advance_payment;?></td>
                                        <td><?=$row->previous_payments;?></td>
                                        <td><?=$row->budget_reference;?></td>
                                        <td><a href="<?= $row->document1; ?>">document 1</a></td>
                                        <td><a href="<?= $row->document2; ?>">document 2</a></td>
                                        <td><a href="<?= $row->document3; ?>">document 3</a></td>
                                        <td><?=$row->status;?></td>
                                        <td>
                                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#statusModal<?=$row->requisition_id;?>">Check</button>
                                            
                                            <!-- Status Modal -->
                                            <div class="modal fade" id="statusModal<?=$row->requisition_id;?>" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="statusModalLabel">Update Status</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <!-- Form to update status -->
                                                            <form method="post" action="">
                                                                <input type="hidden" name="requisition_id" value="<?=$row->requisition_id;?>">
                                                                <div class="form-group">
                                                                    <label for="status">Status</label>
                                                                    <select class="form-control" name="status" id="status<?=$row->requisition_id;?>" required>
                                                                        <option value="">Select action </option>
                                                                        <option value="1">Check</option>
                                                                        <option value="Rejected">Reject</option>
                                                                    </select>
                                                                </div>
                                                                                                                                <!-- Reason for rejection input -->
                                                                <div id="reasonInput<?=$row->requisition_id;?>" style="display: none;">
                                                                    <div class="form-group">
                                                                        <label for="reason">Reason for Rejection</label>
                                                                        <input type="text" class="form-control" id="reason" name="reason" placeholder="Enter reason for rejection">
                                                                    </div>
                                                                </div>
                                                                <!-- Checker comment input -->
                                                                <div id="checkerComment<?=$row->requisition_id;?>" style="display: none;">
                                                                    <div class="form-group">
                                                                        <label for="checker_comment">Checker Comment</label>
                                                                        <input type="text" class="form-control" id="checker_comment" name="checker_comment" placeholder="Enter checker comment">
                                                                    </div>
                                                                </div>
                                                                <button type="submit" class="btn btn-primary" name="update_status">Submit</button>
                                                            </form>
                                                        </div>
                                                        <script>
                                                            document.getElementById('status<?=$row->requisition_id;?>').addEventListener('change', function() {
                                                                var status = this.value;
                                                                var reasonInput = document.getElementById('reasonInput<?=$row->requisition_id;?>');
                                                                var checkerComment = document.getElementById('checkerComment<?=$row->requisition_id;?>');
                                                                
                                                                if (status === 'Rejected') {
                                                                    reasonInput.style.display = 'block';
                                                                    checkerComment.style.display = 'none';
                                                                } else if (status === '1') {
                                                                    reasonInput.style.display = 'none';
                                                                    checkerComment.style.display = 'block';
                                                                } else {
                                                                    reasonInput.style.display = 'none';
                                                                    checkerComment.style.display = 'none';
                                                                }
                                                            });
                                                        </script>
                                                    </div>
                                                </div>
                                            </div>
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
