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
	<!-- ================== END PAGE LEVEL JS ================== -->

	<script>
		$(document).ready(function() {
			App.init();
			LoginV2.init();
			Highlight.init();
		});
	</script>
