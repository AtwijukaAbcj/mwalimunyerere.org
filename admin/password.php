<?php 
include('header.php');?>
<div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <ol class="breadcrumb float-sm-left">
              <li class="breadcrumb-item"><a href="<?=HOME_URL;?>">Home</a></li>
              <li class="breadcrumb-item active"> Change Password </li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <section class="content">
      <div class="container-fluid" ng-app="myApp" ng-controller="ctrl">
	  <?php if(!empty($_SESSION['msg'])) echo log_message(); ?>
        <!--- main content starts here -->
		<div class="card mb-4 info">
				<div class="card-header">
					 <i class="fas fa-lock mr-1"> </i>
						<b> Change Password </b>
				</div>
            <div class="card-body">
             <form role="form" method="post" action="root/proc.inc.php" name="user">
				<input type="hidden" name="user" value="<?=$userid;?>" />
							<div class="row">
							<div class="col-sm-4">
                                <div class="form-group">
								    <span> <b> Old Password: </b> </span>
                                    <input class="form-control" name="old_pass" type="password" required />
                                </div>
							</div>
							<div class="col-sm-4">
                                <div class="form-group">
								    <span> <b> New Password: </b> </span>
                                    <input class="form-control" name="new_pass" type="password" required />
                                </div>
							</div>
								<div class="col-sm-4">
								<span>&nbsp; </span>
								<br/>
									<input type="submit" name="change_password" value="Update" class="btn btn-primary"/>
								</div>
							</div>
                        </form>
                    </div>
			</div>
		<!--- main content ends here --> 
      </div>
    </section>
  </div>
 <?php include('footer.php');?>
  