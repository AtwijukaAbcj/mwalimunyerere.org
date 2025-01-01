<?php
include('config.php');

// Check if the request method is POST and if requisition_id and status are set
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['requisition_id']) && isset($_POST['status'])) {
    $requisition_id = $_POST['requisition_id'];
    $status = $_POST['status'];

    // Check if status is either '1' or '0'
    if ($status == '1' || $status == '0') {
        // Update status in the database
        $update_query = "UPDATE centric_requisitions.requisitions SET checked_by_checker = '$status' WHERE requisition_id = '$requisition_id'";
        dbSQL($update_query);

        // Check if any rows were affected
        if (dbAffectedRows() > 0) {
            // Success message
            echo json_encode(array("status" => "success", "message" => "Status updated successfully"));
            exit;
        } else {
            // If no rows were affected, return an error message
            http_response_code(400);
            echo json_encode(array("status" => "error", "message" => "Failed to update status"));
            exit;
        }
    } else {
        // If status is neither '1' nor '0', return an error message
        http_response_code(400);
        echo json_encode(array("status" => "error", "message" => "Invalid status value"));
        exit;
    }
} else {
    // If the request method is not POST or requisition_id or status are not set, return an error message
    http_response_code(400);
    echo json_encode(array("status" => "error", "message" => "Invalid request"));
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
                        <li class="breadcrumb-item active">Update Status</li>
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
                            <h3 class="card-title"> <b> <i class="fa fa-pencil"> </i> Update Status </b> </h3>
                        </div>
                        <div class="card-body">
                            <form method="post">
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select class="form-control" id="status" name="status" required>
                                        <option value="">Select Status</option>
                                        <?php foreach ($st as $status_row) : ?>
                                            <option value="<?= $status_row->status; ?>"><?= $status_row->status; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary" name="update_status">Update Status</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include('footer.php'); ?>
