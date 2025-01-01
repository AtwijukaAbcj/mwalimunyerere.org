<footer class="main-footer">
<strong>Copyright &copy; <?php echo date('Y');?> &middot; Mwalimu Nyerere web Admin &middot; All Rights Reserved</strong>
<div class="float-right d-none d-sm-inline-block"> <b> V-1.0 </b> </div>
 </footer>
  <!-- Control Sidebar -->
 <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<script src="plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<script src="dist/js/toastr.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparklines/sparkline.js"></script>
<!-- jQuery Knob Chart -->
<script src="dist/js/bootstrap.min.js"></script>
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
<?php if(get_url() == 'reports' || get_url() == 'ptlist'){?>
	<script src="plugins/datatables/jquery.dataTables.min.js"></script>
	<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
	<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
	<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
	<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
	<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
	<script src="plugins/jszip/jszip.min.js"></script>
	<script src="plugins/pdfmake/pdfmake.min.js"></script>
	<script src="plugins/pdfmake/vfs_fonts.js"></script>
	<script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
	<script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
	<script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
	<link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>
    <script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
    <link href="bootstrap-editable/css/bootstrap-editable.css" rel="stylesheet">
<script src="bootstrap-editable/js/bootstrap-editable.js"></script>
	<script>
<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">
<script src="http://code.jquery.com/jquery-2.0.3.min.js"></script> 
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
<script>
  $(document).ready(function () {
    var dataTable = $('#example1').DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["csv", "excel", "pdf", "print"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
$('#example3').DataTable({
		"processing": true,
		"serverSide": true,
		"order":[],
		"ajax":{
			url:"fetch.php",
			type:"POST",
		},

	});

	
  });
 
</script>

<script type="text/javascript" language="javascript">

// $(document).ready(function() {
//     $('#status').editable();
    
//  }); 
//  $.fn.editable.defaults.mode = 'inline';

// $('#username').editable({
//     type: 'text',
//     pk: 1,
//     url: '/post',
//     title: 'Enter username'
// });




// 	$('#status').editable({
// 		container:'body',
// 		selector:'td.status',
// 		url:'fetch.php',
// 		title:'status',
// 		type:'POST',
// 		datatype:'json',
// 		source:[{value: "Male", text: "Male"}, {value: "Female", text: "Female"}],
// 		validate:function(value){
// 			if($.trim(value) == '')
// 			{
// 				return 'This field is required';
// 			}
// 		}
// 	});
// 	$.fn.editable.defaults.mode = 'inline';


</script>


<?php }else{?>
	<script src="dist/js/jquery.dataTables.min.js" ></script>
	<script src="dist/js/dataTables.bootstrap4.min.js" ></script>	
<?php }?>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<script src="dist/js/pages/dashboard.js"></script>
<script src="dist/js/canvasjs.min.js"></script>
<script>
     CKEDITOR.replace('editor' );
      $("form").submit( function(e) {
            var messageLength = CKEDITOR.instances['editor'].getData().replace(/<[^>]*>/gi, '').length;
            if( !messageLength ) {
                alert('Please fill the description field');
                e.preventDefault();
            }
     });
</script>
<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
		
		$('#examples').DataTable({
			responsive: true
        });
		
    });
	$(function () {
		$('[data-toggle="tooltip"]').tooltip()
	})
</script>
<script type="text/javascript">
        jQuery(document).ready(function($)
        {
                var opts = {
                    "closeButton": true,
                    "debug": false,
                    "positionClass": "toast-top-right",
                    "onclick": null,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "3000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                };
				<?php if(!empty($_SESSION['success'])){?>
                toastr.success("<?php echo $_SESSION['success'];?>", "", opts);
				<?php }
				unset($_SESSION['success']);?>
        });
</script> 


<script>
    
</script>
</body>
</html>
