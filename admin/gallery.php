<?php 
include('header.php');?>
<div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <ol class="breadcrumb float-sm-left">
              <li class="breadcrumb-item"><a href="<?=HOME_URL;?>">Home</a></li>
              <li class="breadcrumb-item active">Add Photo </li>
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
					 <i class="fas fa-user mr-1"> </i>
						<b> Add Photo </b>
				</div>
            <div class="card-body">
					<form role="form" method="post" action="root/proc.inc.php" name="user" enctype="multipart/form-data">
							<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
								 <span> <b> Image: </b> </span>
                                    <input class="form-control"  name="imgfile" type="file" accept="image/*" required>
                                </div>
							</div>
							<div class="col-sm-6">
                                <div class="form-group">
								    <span> <b> Caption: </b> </span>
                                    <input class="form-control" name="caption" type="text" >
                                </div>
							</div>
							</div>
							<div class="row">
								<div class="col-sm-3">
								<span>&nbsp; </span>
								<br/>
									<input type="submit" name="add_photos" value="Submit" class="btn btn-success"/>
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
  