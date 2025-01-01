<?php 
include('header.php');
$requisitions = dbSQL("SELECT * FROM requisitions WHERE status = 'Sanctioned'");
?>
<div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <ol class="breadcrumb float-sm-left">
              <li class="breadcrumb-item"><a href="<?=HOME_URL;?>">Home</a></li>
              <li class="breadcrumb-item active">List of Sanctioned Requisitions</li>
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
                            <h3 class="card-title"><b><i class="fa fa-list"></i> List of Sanctioned Requisitions</b></h3>
                            <ul class="nav nav-tabs">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#listRequisitions" data-toggle="tab">List of Requisitions</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#createLPO" data-toggle="tab">Create LPO</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="listRequisitions">
                                    <?php if(sizeof($requisitions) > 0): ?>
                                    <div class="accordion" id="accordionExample">
                                        <?php foreach($requisitions as $index => $row): ?>
                                        <div class="card">
                                            <div class="card-header" id="heading<?=$index;?>">
                                                <h2 class="mb-0">
                                                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse<?=$index;?>" aria-expanded="true" aria-controls="collapse<?=$index;?>">
                                                        Requisition ID: <?=$row->requisition_id;?> - <?=$row->date;?>
                                                    </button>
                                                </h2>
                                            </div>
                                            <div id="collapse<?=$index;?>" class="collapse" aria-labelledby="heading<?=$index;?>" data-parent="#accordionExample">
                                                <div class="card-body">
                                                    <p><strong>Department:</strong> <?=$row->department;?></p>
                                                    <p><strong>Pay To:</strong> <?=$row->pay_to;?></p>
                                                    <p><strong>Description:</strong> <?=$row->description;?></p>
                                                    <p><strong>Currency:</strong> <?=$row->tik_currency;?></p>
                                                    <p><strong>Amount:</strong> <?=$row->amount_figure;?></p>
                                                    <p><strong>Mode of Payment:</strong> <?=$row->mode_of_payment;?></p>
                                                    <p><strong>Advance Payment:</strong> <?=$row->advance_payment;?></p>
                                                    <p><strong>Previous Payments:</strong> <?=$row->previous_payments;?></p>
                                                    <p><strong>Budget Reference:</strong> <?=$row->budget_reference;?></p>
                                                    <p><strong>Status:</strong> <?=$row->status;?></p>
                                                    <p><strong>Created At:</strong> <?=$row->created_at;?></p>
                                                    <p><strong>Updated At:</strong> <?=$row->updated_at;?></p>
                                                    <p><strong>Checked by Checker:</strong> <?=$row->checked_by_checker;?></p>
                                                    <p><strong>Budgeted Amount:</strong> <?=$row->budgeted_amount;?></p>
                                                    <p><strong>Running Total:</strong> <?=$row->running_total;?></p>
                                                    <p><strong>Running Balance:</strong> <?=$row->running_balance;?></p>
                                                    <p><strong>Checked by Verifier:</strong> <?=$row->checked_by_verifier2;?></p>
                                                    <p><strong>Reason for Rejection:</strong> <?=$row->reason_for_rejection;?></p>
                                                    <p><strong>Preparer Email:</strong> <?=$row->preparer_email;?></p>
                                                    <p><strong>User ID:</strong> <?=$row->userID;?></p>
                                                    <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#createLPOModal<?=$row->requisition_id;?>">Create LPO</button>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Create LPO Modal -->
                                        <div class="modal fade" id="createLPOModal<?=$row->requisition_id;?>" tabindex="-1" role="dialog" aria-labelledby="createLPOModalLabel<?=$row->requisition_id;?>" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="createLPOModalLabel<?=$row->requisition_id;?>">Create Local Purchase Order</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="header">
                                                            <h1>Victoria University</h1>
                                                            <h2>Local Purchase Order</h2>
                                                        </div>
                                                        <div class="details">
                                                            <h3>Date: <?=date('Y-m-d');?></h3>
                                                            <h3>Address: [University Address]</h3>
                                                            <h3>To: <?=$row->pay_to;?></h3>
                                                        </div>
                                                        <div class="items">
                                                            <h3>Description of the Item:</h3>
                                                            <p><?=$row->description;?></p>
                                                            <h3>Amount (Figures):</h3>
                                                            <p><?=$row->amount_figure;?></p>
                                                        </div>
                                                        <div class="signature">
                                                            <div>
                                                                <p>________________________</p>
                                                                <p>Finance Signature</p>
                                                            </div>
                                                            <div>
                                                                <p>________________________</p>
                                                                <p>CFO Signature</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        <button type="button" class="btn btn-primary" onclick="createLPO(<?=$row->requisition_id;?>, '<?=$row->preparer_email;?>')">Create LPO</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endforeach;?>
                                    </div>
                                    <?php else: ?>
                                    <b style="color:red"> No Sanctioned requisitions found </b>
                                    <?php endif;?>
                                </div>
                                <div class="tab-pane" id="createLPO">
                                    <!-- Content for Create LPO -->
                                    <?php include('create_lpo.php'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</div>
<?php include('footer.php');?>
<script>
    function createLPO(requisitionId, preparerEmail) {
    $.ajax({
        type: "POST",
        url: "insert_lpo.php", // Replace with the actual path to your PHP script
        data: { requisition_id: requisitionId, preparer_email: preparerEmail },
        dataType: "json",
        success: function(response) {
            if (response.success) {
                alert(response.message);
            } else {
                alert("Failed to create LPO");
            }
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error:", status, error);
            alert("An error occurred while creating LPO");
        }
    });
}
</script>