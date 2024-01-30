	<!-- ================== BEGIN BASE JS ================== -->
	<script src="<?php echo base_url('assets/plugins/jquery/jquery-3.3.1.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/plugins/jquery-ui/jquery-ui.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/plugins/bootstrap/4.1.3/js/bootstrap.bundle.min.js'); ?>"></script>
	
	<script src="<?php echo base_url('assets/plugins/slimscroll/jquery.slimscroll.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/plugins/js-cookie/js.cookie.js'); ?>"></script>
	<script src="<?php echo base_url('assets/js/theme/default.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/js/apps.min.js'); ?>"></script>
	<!-- ================== END BASE JS ================== -->
	
	<!-- ================== BEGIN PAGE LEVEL JS ================== -->
	<script src="<?php echo base_url('assets/js/demo/login-v2.demo.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/plugins/parsley/dist/parsley.js'); ?>"></script>
	<script src="<?php echo base_url('assets/plugins/highlight/highlight.common.js'); ?>"></script>
	<script src="<?php echo base_url('assets/js/demo/render.highlight.js'); ?>"></script>
	<script src="<?php echo base_url('assets/plugins/gritter/js/jquery.gritter.js'); ?>"></script>
	<!-- InputMask -->
	<script src="<?php echo base_url('assets/plugins/input-mask/jquery.inputmask.js'); ?>"></script>
	<script src="<?php echo base_url('assets/plugins/input-mask/jquery.inputmask.date.extensions.js'); ?>"></script>
	<script src="<?php echo base_url('assets/plugins/input-mask/jquery.inputmask.extensions.js'); ?>"></script>
	<script src="<?php echo base_url('assets/js/demo/email-inbox.demo.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/plugins/bootstrap-sweetalert/sweetalert2.all.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/plugins/bootstrap-sweetalert/polyfill.min.js'); ?>"></script>
	<!-- ================== END PAGE LEVEL JS ================== -->

	<script>
		$(document).ready(function() {
			App.init();
			LoginV2.init();
			Highlight.init();
			InboxV2.init();
		});
	</script>
	<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
  	<script>

    	// Enable pusher logging - don't include this in production
   		Pusher.logToConsole = true;

   		var pusher = new Pusher('b49163b6de1bae4c1c2f', {
   		  	cluster: 'ap1'
   		});

   		var channel = pusher.subscribe('supplier-channel');
   		channel.bind('supplier-event', function(data) {
   		  	
   		  	$.ajax({
			    url: "<?php echo site_url('count_unread_msg'); ?>",
			    type: 'GET',
			    success: function (data) {

			    	$("span.count_unread_msg").html(data);
			    	email_list();
			    }
			});

   		});
  	</script>
