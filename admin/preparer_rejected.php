<?php
include('header.php');
include('config.php');

// Database connection
// Same as admin.php

// Fetch the logged-in user's email from the session
$logged_in_email = $_SESSION['email'];

// Fetch data from the requisitions table with status 'Rejected' and belong to the logged-in preparer
$list = dbSQL("SELECT r.* FROM centric_requisitions.requisitions r 
               INNER JOIN users u ON r.preparer_email = u.email 
               WHERE r.status = 'Rejected' AND u.email = '$logged_in_email' 
               ORDER BY r.requisition_id DESC");
?>


<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="<?=HOME_URL;?>">Home</a></li>
                        <li class="breadcrumb-item active">List of Rejected Requisitions</li>
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
                            <h3 class="card-title"> <b> <i class="fa fa-database"> </i> List of Rejected Requisitions </b> </h3>
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
                                        <th> Reason for Rejection </th>
                                        <!--<th> Edit </th>-->
                                        <th> Action </th>
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
                                        <td><?=$row->reason_for_rejection;?></td>
                                        <!--<td>-->
                                        <!--    <a href="edit_requisition.php?requisition_id=<?=$row->requisition_id;?>" class="btn btn-success btn-sm">Edit</a>-->
                                        <!--</td>-->
                                        <td>
                                            <!-- Resubmit button and modal -->
                                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#resubmitModal<?=$row->requisition_id;?>">Resubmit</button>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <?php } else {
                                echo '<b style="color:red"> No rejected requisitions available for the logged-in preparer </b>';
                            } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal for Resubmit -->
<?php foreach($list as $row): ?>
<div class="modal fade" id="resubmitModal<?=$row->requisition_id;?>" tabindex="-1" role="dialog" aria-labelledby="resubmitModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="resubmitModalLabel">Resubmit Requisition</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form to resubmit requisition -->
                <form method="post" action="resubmit.php">
                    <input type="hidden" name="requisition_id" value="<?=$row->requisition_id;?>">
                    <!-- Prefill form fields with requisition data -->
                    <div class="form-group">
                        <label for="date">Date:</label>
                        <input type="date" id="date" name="date" class="form-control" value="<?=$row->date;?>" required>
                    </div>
                    <!-- Add other form fields and prefilled values -->
                    <div class="form-group">
                    <label for="pay_to">Pay To:</label>
                    <input type="text" id="pay_to" name="pay_to" class="form-control" value="<?=$row->pay_to;?>" required>
                </div>
                
                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea id="description" name="description" rows="5" class="form-control" required><?=$row->description;?></textarea>
                </div>
                <div class="form-group">
                    <label for="mode_of_payment">Mode of Payment:</label><br>
                    <!-- Checkboxes for modes of payment -->
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="payment_check" name="mode_of_payment[]" value="CHECK" <?php if (in_array('CHECK', explode(',', $row->mode_of_payment))) echo 'checked'; ?>>
                        <label class="form-check-label" for="payment_check">Check</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="payment_cash" name="mode_of_payment[]" value="CASH" <?php if (in_array('CASH', explode(',', $row->mode_of_payment))) echo 'checked'; ?>>
                        <label class="form-check-label" for="payment_cash">Cash</label>
                    </div>
                    <!-- You can add more checkboxes or use a dropdown menu -->
                </div>
                <div class="form-group">
                    <label for="advance_payment">Mention if any Advance Payment:</label>
                    <br>
                    <input type="checkbox" id="advance_payment" name="advance_payment" value="Yes" <?php if ($row->advance_payment == 'Yes') echo 'checked'; ?>> Yes
                </div>
                <div class="form-group">
                    <label for="previous_payments">Previous Payment(s):</label>
                    <input type="text" id="previous_payments" name="previous_payments" class="form-control" value="<?=$row->previous_payments;?>">
                </div>
                <div class="form-group">
                    <label for="budget_reference">Budget reference number:</label>
                    <input type="text" id="budget_reference" name="budget_reference" class="form-control" value="<?=$row->budget_reference;?>">
                </div>

                    <!-- Remember to update values accordingly -->
                    <button type="update" class="btn btn-primary">update</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>

<?php include('footer.php'); ?>
