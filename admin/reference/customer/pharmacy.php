<?php 
include('header.php');?>
<div class="row">
	<div class="col-lg-12">
		<h3 class="page-header">Dashboard / Add Pharmacy </h3>
	</div>
</div>
 <div class="row">
	<div class="col-lg-12">
		<div class="panel panel-info">
			<div class="panel-heading">
				Add Pharmacy
			</div>
			<div class="panel-body">
				<form role="form" method="post" action="root/proc.inc.php" name="user">
				<?php if(!empty($_SESSION['msg'])) echo log_message(); ?>
							<div class="row">
								<div class="col-sm-4">
									<div class="form-group">
										<span> <b> Name: </b> </span>
										<input class="form-control" name="name" type="text" value="<?=!empty($_REQUEST['name'])?$_REQUEST['name']:NULL;?>" required>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
									 <span> <b> Description: </b> </span>
										<input class="form-control"  name="description" type="text"  value="<?=!empty($_REQUEST['description'])?$_REQUEST['description']:NULL;?>" required>
									</div>
								</div>
								<div class="col-md-4">
										 <div class="form-group">
										 <span> <b> Location: </b> </span>
											<input class="form-control" name="location" type="text" value="<?=!empty($_REQUEST['location'])?$_REQUEST['location']:NULL;?>"  required />
										</div>
								</div>
									<div class="col-sm-4">
									<span>&nbsp; </span>
									<br/>
										<input type="submit" name="add_pharm" value="Submit" class="btn btn-success"/>
									</div>
							</div>
                        </form>
                    </div>
			</div>
	</div>
</div>
 <?php include('footer.php');?>
  