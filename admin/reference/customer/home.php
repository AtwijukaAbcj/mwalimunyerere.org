<?php 
include('header.php');?>
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Dashboard</h1>
	</div>
</div>
<div class="row">
	<div class="col-lg-3 col-md-6">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<div class="row">
					<div class="col-xs-3">
						<i class="fa fa-user fa-5x"></i>
					</div>
					<div class="col-xs-9 text-right">
						<div class="huge"><?=get_agents();?></div>
						<div><?=(get_agents() == 1)?'Sales Agent':'Sales Agents';?></div>
					</div>
				</div>
			</div>
			<a href="lists">
				<div class="panel-footer">
					<span class="pull-left">View Details</span>
					<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

					<div class="clearfix"></div>
				</div>
			</a>
		</div>
	</div>
	<div class="col-lg-3 col-md-6">
		<div class="panel panel-green">
			<div class="panel-heading">
				<div class="row">
					<div class="col-xs-3">
						<i class="fa fa-database fa-5x"></i>
					</div>
					<div class="col-xs-9 text-right">
						<div class="huge"><?=get_products();?></div>
						<div><?=(get_products() == 1)?'Product':'Products';?></div>
					</div>
				</div>
			</div>
			<a href="pdlist">
				<div class="panel-footer">
					<span class="pull-left">View Details</span>
					<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

					<div class="clearfix"></div>
				</div>
			</a>
		</div>
	</div>
	<div class="col-lg-3 col-md-6">
		<div class="panel panel-yellow">
			<div class="panel-heading">
				<div class="row">
					<div class="col-xs-3">
						<i class="fa fa-medkit fa-5x"></i>
					</div>
					<div class="col-xs-9 text-right">
						<div class="huge"><?=get_pharmacies();?></div>
						<div><?=(get_pharmacies() == 1)?'Pharmacy':'Pharmacies';?></div>
					</div>
				</div>
			</div>
			<a href="prlist">
				<div class="panel-footer">
					<span class="pull-left">View Details</span>
					<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

					<div class="clearfix"></div>
				</div>
			</a>
		</div>
	</div>
	<div class="col-lg-3 col-md-6">
		<div class="panel panel-red">
			<div class="panel-heading">
				<div class="row">
					<div class="col-xs-3">
						<i class="fa fa-users fa-5x"></i>
					</div>
					<div class="col-xs-9 text-right">
							<div class="huge"><?=get_customers();?></div>
						<div><?=(get_customers() == 1)?'Customer':'Customers';?></div>
					</div>
				</div>
			</div>
			<a href="#">
				<div class="panel-footer">
					<span class="pull-left">View Details</span>
					<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

					<div class="clearfix"></div>
				</div>
			</a>
		</div>
	</div>
</div>
<?php include('footer.php');?>