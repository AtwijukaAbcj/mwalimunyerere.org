<?php 
include('header.php');
$users = dbSQL("SELECT * FROM pharmacy order by name");
?>
<div class="row">
	<div class="col-lg-12">
		<h3 class="page-header">Dashboard / Pharmacies</h3>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-info">
			<div class="panel-heading">
				Pharmacies
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<?php if(sizeof($users) > 0){?>
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover" id="dataTables-example">
						<thead>
							<tr>
								<th> Name </th>
								<th> Description </th>
								<th> Location </th>
								<th> Action </th>
							</tr>
						</thead>
						<tbody>
							
							<?php foreach($users as $row):?>
								<tr class="odd gradeX">
									  <td> <?=$row->name;?> </td>
									  <td> <?=$row->description;?> </td>
									  <td> <?=$row->location;?> </td>
									  <td> <a href="root/proc.inc.php?pxdel=<?=$row->pid;?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this record?');"> Delete </td>
								</tr>
							<?php endforeach;?>
						</tbody>
					</table>
				</div>
				<?php }else{
					echo '<div class="alert alert-danger alert-dismissable">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					No pharmacy registered </div>';
				}?>
			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->
	</div>
	<!-- /.col-lg-12 -->
</div>
 <?php include('footer.php');?>
  