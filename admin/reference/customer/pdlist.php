<?php 
include('header.php');
$users = dbSQL("SELECT * FROM products order by product_name");
?>
<div class="row">
	<div class="col-lg-12">
		<h3 class="page-header">Dashboard / Products </h3>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-info">
			<div class="panel-heading">
				Products
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<?php if(sizeof($users) > 0){?>
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover" id="dataTables-example">
						<thead>
							<tr>
								<th> Name </th>
								<th> Quantity </th>
								<th> Price(UGX) </th>
								<th> Action </th>
							</tr>
						</thead>
						<tbody>
							
							<?php foreach($users as $row):?>
								<tr class="odd gradeX">
									  <td> <?=$row->product_name;?> </td>
									  <td> <?=$row->quantity;?> </td>
									  <td> <?=number_format($row->price);?> </td>
									  <td> <a href="root/proc.inc.php?prdel=<?=$row->prd_number;?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?');"> Delete </td>
								</tr>
							<?php endforeach;?>
						</tbody>
					</table>
				</div>
				<?php }else{
					echo '<div class="alert alert-danger alert-dismissable">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					No product registered </div>';
				}?>
			</div>
		</div>
	</div>
</div>
<?php include('footer.php');?>
  