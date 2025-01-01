<?php 
include('header.php');?>
<div class="row">
	<div class="col-lg-12">
		<h3 class="page-header">Dashboard / Add Sales Agent </h3>
	</div>
</div>
 <div class="row">
	<div class="col-lg-12">
		<div class="panel panel-info">
			<div class="panel-heading">
				Add Sales Agent
			</div>
			<div class="panel-body">
				<form role="form" method="post" action="root/proc.inc.php" name="user">
				<input type="hidden" name="role" value="Sales Agent" />
				<?php if(!empty($_SESSION['msg'])) echo log_message(); ?>
				<!--- main content starts here -->
							<div class="row">
							<div class="col-sm-3">
                                <div class="form-group">
								    <span> <b> Name: </b> </span>
                                    <input class="form-control" name="fname" title="Start with capital letter  & use only alphabets" pattern="^[A-Z][a-z]+(?:[ ]+[a-zA-Z][a-z]+)*$" type="text" value="<?=!empty($_REQUEST['fname'])?$_REQUEST['fname']:NULL;?>" required>
                                </div>
							</div>
							<div class="col-sm-3">
								<div class="form-group">
								 <span> <b> Email: </b> </span>
                                    <input class="form-control"  name="email" type="email" value="<?=!empty($_REQUEST['email'])?$_REQUEST['email']:NULL;?>" required>
                                </div>
							</div>
							<div class="col-md-3">
									 <div class="form-group">
									 <span> <b> Password: </b> </span>
										<input class="form-control" name="password" type="password" value="<?=!empty($_REQUEST['password'])?$_REQUEST['password']:NULL;?>" required />
									</div>
							</div>
						
							<div class="col-md-3">
									<div class="form-group">
									<span> <b> Phone Number: </b> </span>
									<input class="form-control"  name="contact"  maxlength="13" type="text" value="<?=!empty($_REQUEST['contact'])?$_REQUEST['contact']:NULL;?>" placeholder="e.g +211 123 456 789" />
									</div>
							</div>
							<div class="col-md-3">
									<div class="form-group">
									<span> <b> Commmission(%): </b> </span>
									<input class="form-control"  name="commission" type="number" placeholder="e.g 5" required />
									</div>
							</div>
								<div class="col-sm-3">
								<span>&nbsp; </span>
								<br/>
									<input type="submit" name="add_user" value="Submit" class="btn btn-success"/>
								</div>
							
							</div>
                        </form>
                    </div>
			</div>
	</div>
</div>
 <?php include('footer.php');?>
  