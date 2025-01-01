<?php
include('header.php');
include('config.php');

// Database connection
// Same as admin.php

// Fetch data from the requisitions table with status as 'sanctioned'
$list = dbSQL("SELECT * FROM centric_requisitions.requisitions WHERE status = 'Confirmed' ORDER BY requisition_id DESC");

// Process form submission from the modal for updating status
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_status'])) {
    $requisition_id = $_POST['requisition_id'];
    $status = $_POST['status'];
    
    // Initialize Sanction comment variable
    $sanctioner_comment = "";
    
    // If status is 'Sanctioned', get the Sanction comment from the form
    if ($status == 'Sanctioned') {
        $sanctioner_comment = $_POST['sanctioner_comment'];
    }
    
    // Update the status in the database
    if ($status == 'Sanctioned') {
        // If status is 'Sanctioned', update status column to 'Sanctioned' and include Sanction comment
        $update_query = "UPDATE centric_requisitions.requisitions SET status = 'Sanctioned', sanctioner_comment = '$sanctioner_comment' WHERE requisition_id = '$requisition_id'";
    } else if ($status == 'DisSanctioned') {
        // If status is 'DisSanctioned', update status column to 'DisSanctioned' and include reason for rejection
        $reason_for_rejection = $_POST['reason_for_rejection'];
        $update_query = "UPDATE centric_requisitions.requisitions SET status = 'DisSanctioned', reason_for_rejection = '$reason_for_rejection' WHERE requisition_id = '$requisition_id'";
    }
    dbSQL($update_query);
    // Redirect back to the same page to refresh the list
    header("Location: sanctioner.php");
    exit;
}
?>

<!-- Your HTML code here -->



<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="<?=HOME_URL;?>">Home</a></li>
                        <li class="breadcrumb-item active">List of Verified Requisitions</li>
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
                            <h3 class="card-title"> <b> <i class="fa fa-database"> </i> List of Verified Requisitions </b> </h3>
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
                                        <th> Status </th>
                                        <th> Verify </th>
                                        <th> Deny </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($list as $row): ?>
                                    <tr>
                                        <td><?=$row->date;?></td>
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
                                        <td><?=$row->status;?></td>
                                        <!--<td>-->
                                        <!--    <form method="post" action="">-->
                                        <!--        <input type="hidden" name="requisition_id" value="<?=$row->requisition_id;?>">-->
                                        <!--        <input type="hidden" name="status" value="Sanctioned">-->
                                        <!--        <button type="submit" class="btn btn-success btn-sm" name="update_status">Sanctioned</button>-->
                                        <!--    </form>-->
                                        <!--</td>-->
                                        
                                             <td>
                                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#sanctionModal<?=$row->requisition_id;?>">Sanction</button>
                                            <!-- Sanction Modal -->
                                            <div class="modal fade" id="sanctionModal<?=$row->requisition_id;?>" tabindex="-1" role="dialog" aria-labelledby="sanctionModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="sanctionModalLabel">Sanction Comment</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <!-- Form to update status to 'Sanction' and add verifier comment -->
                                                            <form method="post" action="">
                                                                <input type="hidden" name="requisition_id" value="<?=$row->requisition_id;?>">
                                                                <input type="hidden" name="status" value="Sanctioned">
                                                                <div class="form-group">
                                                                    <label for="sanctioner_comment">Sanction Comment</label>
                                                                    <textarea class="form-control" id="sanctioner_comment" name="sanctioner_comment" required></textarea>
                                                                </div>
                                                                <button type="submit" class="btn btn-success" name="update_status">Sanction</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td> 
                                        
                                        <td>
                                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#rejectionModal<?=$row->requisition_id;?>">DisSanctioned</button>
                                            <!-- Rejection Modal -->
                                            <div class="modal fade" id="rejectionModal<?=$row->requisition_id;?>" tabindex="-1" role="dialog" aria-labelledby="rejectionModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="rejectionModalLabel">Reason for Disapproval</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <!-- Form to update status to 'DisSanctioned' and add reason for rejection -->
                                                            <form method="post" action="">
                                                                <input type="hidden" name="requisition_id" value="<?=$row->requisition_id;?>">
                                                                <input type="hidden" name="status" value="Unsanctioned">
                                                                <div class="form-group">
                                                                    <label for="reason_for_rejection">Reason for Disapproval</label>
                                                                    <textarea class="form-control" id="reason_for_rejection" name="reason_for_rejection" required></textarea>
                                                                </div>
                                                                <button type="submit" class="btn btn-danger" name="update_status">DisSanctioned</button>
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
                                echo '<b style="color:red"> No verified requisitions available in the system </b>';
                            } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include('footer.php'); ?>
