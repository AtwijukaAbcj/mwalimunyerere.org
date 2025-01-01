<?php
include('header.php');
include('config.php');

// Database connection
// Same as admin.php

// Fetch data from the requisitions table with status ' Pending and belonging to the user's department
$list = dbSQL("SELECT * FROM centric_requisitions.requisitions WHERE status = 'Pending' AND department = '{$_SESSION['department']}' ORDER BY requisition_id DESC");

// Process form submission to mark requisition as prepared
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['prepare_requisition'])) {
    $requisition_id = $_POST['requisition_id'];
    
    // Get the preparer's email address from the session
    $preparer_email = $_SESSION['email']; // Assuming email is stored in the session
    
    // Update the requisition status and preparer's email in the database
    $update_query = "UPDATE centric_requisitions.requisitions SET status = 'Prepared', preparer_email = '$preparer_email' WHERE requisition_id = '$requisition_id'";
    dbSQL($update_query);
    
    // Redirect back to the same page to refresh the list
    header("Location: preparer.php");
    exit;
}

// Process form submission from the modal for updating status
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_status'])) {
    $requisition_id = $_POST['requisition_id'];
    $status = $_POST['status'];
    // Update the status in the database
    if ($status == '1') {
        // If status is 'Check', update checked_by_checker column
        $update_query = "UPDATE centric_requisitions.requisitions SET checked_by_checker = '1', status = 'Checked' WHERE requisition_id = '$requisition_id'";
    } else if ($status == 'Rejected') {
        // If status is 'Reject', update status column to 'Rejected'
        $update_query = "UPDATE centric_requisitions.requisitions SET status = 'Rejected' WHERE requisition_id = '$requisition_id'";
    }
    dbSQL($update_query);
    // Redirect back to the same page to refresh the list
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
                            <?php if(sizeof($list) > 0){ ?>
                            <table id="example1" class="table table-bordered table-hover" >
                                <thead>
                                    <tr>
                                        <th> Date </th>
                                        <th> Department </th>
                                        <th> Pay To </th>
                                        <th> Description </th>
                                        <th> Currency </th>
                                        <th> Amount Figure </th>
                                        <th> Amount Words </th>
                                        <th> Mode of Payment </th>
                                        <th> Advance Payment </th>
                                        <th> Previous Payments </th>
                                        <th> Budget Reference </th>
                                        <th> Document 1</th>
                                        <th> Document 2</th>
                                        <th> Document 3</th>
                                        <th> Document 4</th>
                                        <th> Document 5</th>
                                        <th> Status </th>
                                        <th> Edit </th>
                                        <th> Action </th>
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
                                        <td><a href="<?= $row->document1; ?>">Document 1</a></td>
                                        <td><a href="<?= $row->document2; ?>">Document 2</a></td>
                                        <td><a href="<?= $row->document3; ?>">Document 3</a></td>
                                        <td><a href="<?= $row->document4; ?>">Document 4</a></td>
                                        <td><a href="<?= $row->document5; ?>">Document 5</a></td>
                                        <td><?=$row->status;?></td>
                             
                                        <td>
                                            <a href="edit_requisition.php?requisition_id=<?=$row->requisition_id;?>" class="btn btn-success btn-sm">Edit</a>
                                        </td>
                                        <td>
                                            <?php if($row->status == 'Pending'): ?>
                                            <!-- Display the Prepare button if status is Pending -->
                                            <form method="post" action="">
                                                <input type="hidden" name="requisition_id" value="<?=$row->requisition_id;?>">
                                                <button type="submit" class="btn btn-success btn-sm" name="prepare_requisition">Prepare</button>
                                            </form>
                                            <?php else: ?>
                                            <!-- Display the Status button if status is not Pending -->
                                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#statusModal<?=$row->requisition_id;?>">Status</button>
                                            <?php endif; ?>
                                            
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
                                                                    <select class="form-control" name="status" id="status" required>
                                                                        <option value="1">Check</option>
                                                                        <option value="Rejected">Reject</option>
                                                                    </select>
                                                                </div>
                                                                <button type="submit" class="btn btn-primary" name="update_status">Submit</button>
                                                            </form>
                                                        </div>
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
