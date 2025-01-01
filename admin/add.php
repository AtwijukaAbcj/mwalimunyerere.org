<?php 
include('header.php');
include('config.php');

// Check if the form submission was successful
if(isset($_SESSION['success'])) {
    echo '<div class="alert alert-success">Form submitted successfully!</div>';
    unset($_SESSION['success']); // Remove the success message from session to avoid displaying it again on page refresh
}
?>

<div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <ol class="breadcrumb float-sm-left">
              <li class="breadcrumb-item"><a href="<?=HOME_URL;?>">Home</a></li>
              <li class="breadcrumb-item active"><?php if(isset($_REQUEST['edit'])){ echo 'Edit Requisition'; }else { echo 'Add Requisition';} ?> </li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <section class="content">
      <div class="container-fluid" ng-app="myApp" ng-controller="ctrl">
	  <?php if(!empty($_SESSION['msg'])) echo log_message(); 
		if(isset($_REQUEST['edit'])){
			$rx = dbRow("SELECT * FROM requisitions WHERE requisition_id ='".$_REQUEST['edit']."' ");
			?>
			
			
			<div class="card mb-4 info">
				<div class="card-header">
					 <i class="fas fa-user mr-1"> </i>
						<b> Edit Requisition </b>
				</div>
				
            <div class="card-body">
				<form role="form" method="post" action="root/proc.inc.php" name="user">
					  <input type="hidden" name="identity" value="<?=$rx->requisition_id;?>" />
							<div class="row">
								<div class="col-sm-4">
									<div class="form-group">
										<span style="font-weight:600"> Requisition ID: </span>
										<input class="form-control" name="requisition_id" type="text" value="<?=$rx->requisition_id;?>"  readonly />
									</div>
								</div>
								<!-- Rest of your form fields -->
							</div>
							<div class="row">
                                <div class="col-sm-4">
                                    <input type="submit" name="edit_requisition" value="Submit" class="btn btn-primary"/>
                                </div>
                            </div>
						</form>
				</div>
			</div>
		<?php }else{?>
			<div class="card mb-4 info">
				<div class="card-header">
					 <i class="fas fa-user mr-1"> </i>
						<b> Add Requisition </b>
				</div>
				<div class="card-body">
					<form role="form" method="post" action="root/proc.inc.php" name="user">
						<div class="row">
							<div class="col-sm-4">
								<div class="form-group">
									<span style="font-weight:600"> Department: </span>
									<input class="form-control" name="department" type="text" required />
								</div>
							</div>
							<!-- Rest of your form fields -->
						</div>
						<div class="row">
                            <div class="col-sm-4">
                                <input type="submit" name="add_requisition" value="Submit" class="btn btn-primary"/>
                            </div>
                        </div>
					</form>
				</div>
			</div>
		<?php }?>
      </div>
    </section>
  </div>
 <?php include('footer.php');?>
