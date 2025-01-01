<?php
// session_start();
require_once 'root/config.php'; // Adjust path if needed

if (empty($_SESSION['userid'])) {
    redirect_page(SITE_URL);
} else {
    $email = $_SESSION['email'];
    $userid = $_SESSION['userid'];
    $interface = $_SESSION['interface'];
    $fname = $_SESSION['first'];

    if ($interface == 'admin') {
        $role = 'Administrator';
    } else {
        $role = ucfirst($interface);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="dist/css/logo.ico" type="images/x-icon" />
  <meta name="description" content="" />
  <meta name="keywords" content="" />
  <title> Requisitions Management System:: <?=(get_url() == 'dash')?'Dashboard':ucfirst(get_url());?> </title>
  <link href="https://fonts.googleapis.com/css?family=Karla:400,700&display=swap" rel="stylesheet"> 
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="plugins/toastr/toastr.min.css">
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
  <link rel="stylesheet" href="dist/css/toastr.css">
  <link rel="stylesheet" href="dist/css/style.css">
  <?php if(get_url() == 'reports' || get_url() == 'ptlist'){?>
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <?php }else{?>
   <link href="dist/css/dataTables.bootstrap4.min.css" rel="stylesheet"  />
  <?php }?>
    <link href="dist/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <script src="dist/js/angular.min.js"></script>
	<script type="text/javascript" src="//cdn.jsdelivr.net/jquery/1/jquery.min.js"></script>
    <script src="//cdn.ckeditor.com/4.5.9/standard/ckeditor.js"></script>
      <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  
  <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"> </script>
  
      
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    
      <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

    <script>
	var app = angular.module("myApp",[]);
	app.controller("ctrl",function($scope){
	});
	</script>
	<script type="text/javascript">
       // JavaScript function for printing using div element
        function PrintContent(el){
            var restorepage = document.body.innerHTML;
            var printcontent = document.getElementById(el).innerHTML;
            document.body.innerHTML = printcontent;
            window.print();
            document.body.innerHTML = restorepage;
        }
    </script>
<script type="text/javascript">
//script for auto refreshing parts of the page 
   var autoLoad = setInterval(
   function ()
   {
      $('#notid').load('notify.php').fadeIn("slow");
	  $('#inbox').load('counter.php').fadeIn("slow");
   }, 100); // refresh page every 10 seconds
  
</script>
	<style type="text/css">
		.ng-show{
			color:red;
			font-size:11px;
			position:fixed;
		}
		.canvasjs-chart-credit{
			display:none;
			visibility:hidden;
        }
        /*.form-select{*/
        /*    height:30px;*/
        /*    width:110px;*/
        /*}*/

        .main-sidebar {
            background-color: white;
        }

	</style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

<?php include 'header.php'; ?>
</div>
</body>
</html>
