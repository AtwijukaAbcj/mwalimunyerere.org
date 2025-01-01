<?php 
include('header.php');
$users = dbSQL("SELECT * FROM users WHERE role = 'Sales Agent'");
?>
<div class="row">
	<div class="col-lg-12">
		<h3 class="page-header">Dashboard / Sales Agents </h3>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-info">
			<div class="panel-heading">
				Sales Agents
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<?php if(sizeof($users) > 0){?>
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover" id="dataTables-example">
						<thead>
							<tr>
								<th> Name </th>
								<th> Email </th>
								<th> Phone Number </th>
								<th> Reference Code </th>
								<th> Commission (%)
								<th> Action </th>
							</tr>
						</thead>
						<tbody>
							
							<?php foreach($users as $row):?>
								<tr class="odd gradeX">
									  <td> <?=$row->firstName;?> </td>
									  <td> <?=$row->email;?> </td>
									  <td> <?=$row->contact;?> </td>
									  <td> <?=$row->reference;?> </td>
									  <td> <?=$row->commission;?> </td>
									  <td> <a href="root/proc.inc.php?udelete=<?=$row->userID;?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?');"> Delete </td>
								</tr>
							<?php endforeach;?>
						</tbody>
					</table>
				</div>
				<?php }else{
					echo '<div class="alert alert-danger alert-dismissable">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					No agents registered </div>';
				}?>
			</div>
		</div>
	</div>
</div>
<?php include('footer.php');?>
  