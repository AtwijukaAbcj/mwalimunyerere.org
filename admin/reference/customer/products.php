<?php 
include('header.php');?>
<div class="row">
	<div class="col-lg-12">
		<h3 class="page-header">Dashboard / Add Product </h3>
	</div>
</div>
 <div class="row">
	<div class="col-lg-12">
		<div class="panel panel-info">
			<div class="panel-heading">
				Add Product
			</div>
			<div class="panel-body">
				<form role="form" method="post" action="root/proc.inc.php" name="user">
				<?php if(!empty($_SESSION['msg'])) echo log_message(); ?>
							<div class="row">
								<div class="col-sm-4">
									<div class="form-group">
										<span> <b> Name: </b> </span>
										<input class="form-control" name="product_name" type="text" value="<?=!empty($_REQUEST['product_name'])?$_REQUEST['product_name']:NULL;?>" required>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
									 <span> <b> Quantity: </b> </span>
										<input class="form-control"  name="quantity" type="number"  value="<?=!empty($_REQUEST['quantity'])?$_REQUEST['quantity']:NULL;?>" required>
									</div>
								</div>
								<div class="col-md-4">
										 <div class="form-group">
										 <span> <b> Price: </b> </span>
											<input class="form-control" name="price" type="number" value="<?=!empty($_REQUEST['price'])?$_REQUEST['price']:NULL;?>"  required />
										</div>
								</div>
									<div class="col-sm-4">
									<span>&nbsp; </span>
									<br/>
										<input type="submit" name="add_product" value="Submit" class="btn btn-success"/>
									</div>
							</div>
                        </form>
                    </div>
			</div>
	</div>
</div>
 <?php include('footer.php');?>
  