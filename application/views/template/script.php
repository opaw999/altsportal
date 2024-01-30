	<!-- ================== BEGIN BASE JS ================== -->
	<script src="<?php echo base_url('assets/plugins/jquery/jquery-3.3.1.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/plugins/bootstrap/4.1.3/js/bootstrap.bundle.min.js'); ?>"></script>
	
	<script src="<?php echo base_url('assets/plugins/js-cookie/js.cookie.js'); ?>"></script>
	<script src="<?php echo base_url('assets/plugins/paroller/jquery.paroller.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/js/e-commerce/apps.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/plugins/dataTables/datatables.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/plugins/parsley/dist/parsley.js'); ?>"></script>
	<script src="<?php echo base_url('assets/plugins/sweetalert/sweetalert.js'); ?>"></script>
	<!-- ================== END BASE JS ================== -->
	
	<script>
		$(document).ready(function() {
			App.init();
		});
	</script>
	<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
	<script>

    	// Enable pusher logging - don't include this in production
   		Pusher.logToConsole = true;

   		var pusher = new Pusher('b49163b6de1bae4c1c2f', {
   		  	cluster: 'ap1',
   		  	authEndpoint: "<?php echo base_url().'pusher/auth'; ?>",
   		});

   		var channel = pusher.subscribe("<?php echo 'private-admin-channel-'.$_SESSION['supplier_id']; ?>");
   		channel.bind('admin-event', function(data) {
 
		$.ajax({
		    url: "<?php echo site_url('count_unread_msg'); ?>",
		    type: 'GET',
		    success: function (data) {

		    	$("span.total").html(data);
		    	if (window.location.href == "https://altsportal.com/page/menu/message") {

		    		view_message();
		    	}
		    }
		});

   		});
  	</script>
</body>

</html>