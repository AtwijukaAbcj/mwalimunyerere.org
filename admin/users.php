<?php 
include('header.php');?>
<div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <ol class="breadcrumb float-sm-left">
              <li class="breadcrumb-item"><a href="<?=HOME_URL;?>">Home</a></li>
              <li class="breadcrumb-item active">Add Users </li>
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
						<b> Add User </b>
				</div>
            <div class="card-body">
				<form role="form" method="post" action="root/proc.inc.php" name="user">
							<div class="row">
							<div class="col-sm-4">
                                <div class="form-group">
								    <span> <b> Name: </b> </span>
                                    <input class="form-control" name="fname" title="Start with capital letter  & use only alphabets" pattern="^[A-Z][a-z]+(?:[ ]+[a-zA-Z][a-z]+)*$" type="text" value="<?=!empty($_REQUEST['fname'])?$_REQUEST['fname']:NULL;?>" required>
                                </div>
							</div>
							<div class="col-sm-4">
								<div class="form-group">
								 <span> <b> Email: </b> </span>
                                    <input class="form-control"  name="email" type="email" value="<?=!empty($_REQUEST['email'])?$_REQUEST['email']:NULL;?>" required>
                                </div>
							</div>
							<div class="col-md-4">
									 <div class="form-group">
									 <span> <b> Password: </b> </span>
										<input class="form-control" name="password" type="password" value="<?=!empty($_REQUEST['password'])?$_REQUEST['password']:NULL;?>" required />
									</div>
							</div>
							</div>
							<div class="row">
							<div class="col-md-4">
									<div class="form-group">
									<span> <b> Phone Number: </b> </span>
									<input class="form-control"  name="contact"  maxlength="13" type="text" value="<?=!empty($_REQUEST['contact'])?$_REQUEST['contact']:NULL;?>" placeholder="e.g +211 123 456 789" />
									</div>
							</div>
								<div class="col-md-4">
									<div class="form-group">
									 <span><b> Country: </b></span>
										<input type="text" class="form-control" name="country" list="country" placeholder="e.g Uganda" required >
										<datalist id="country">
										<?php foreach(get_countries($countries) as $val){?>
											<option value="<?=$val;?>" <?=($val == 'Uganda')?'selected':'';?>> <?=$val;?> </option>
										<?php }?>
										</datalist>
									</div>
								</div>
								<div class="col-md-4">
										 <div class="form-group">
										 <span> <b> User Role: </b> </span>
										 <select name="role" class="form-control" required >
										 <?php 
										 if(!empty($_REQUEST['role'])){
											foreach($uc_list as $val){?>
											<option value="<?=$val;?>" <?=($_REQUEST['role'] == $val)?'selected':'';?>> <?=$val;?> </option>
											<?php }
										 }else{?>
											<option value="" > --- Select --- </option>
											<?php foreach($uc_list as $val){?>
											<option value="<?=$val;?>"> <?=$val;?> </option>
											<?php } 
										}?>
										 </select>
										</div>
								</div>
								
							</div>
							<div class="row">
								<div class="col-sm-3">
								<span>&nbsp; </span>
								<br/>
									<input type="submit" name="add_user" value="Submit" class="btn btn-success"/>
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
  