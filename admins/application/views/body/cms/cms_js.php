<!-- ================== BEGIN PAGE LEVEL JS ================== -->
<script src="<?php echo base_url('assets/plugins/DataTables/media/js/jquery.dataTables.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/DataTables/media/js/dataTables.bootstrap.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/DataTables/extensions/Scroller/js/dataTables.scroller.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/DataTables/extensions/Responsive/js/dataTables.responsive.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/demo/table-manage-default.demo.min.js'); ?>"></script>

<!-- ================== END PAGE LEVEL JS ================== -->

<script type="text/javascript">
	$(document).ready(function() {

		$('[data-toggle="tooltip"]').tooltip();

		$.post("<?php echo site_url('dataTable_script'); ?>", {
			request: "dataTable"
		}, function(data, status) {

			$("head").append(data);
		});

		var dt_userAccount = $("table#dt_userAccount").DataTable({

			"destroy": true,
			"ajax": {
				url: "<?php echo site_url('fetch_user_account'); ?>",
				type: "post"
			},
			"columns": [{
					"className": 'details-control',
					"orderable": false,
					"data": null,
					"defaultContent": ''
				},
				{
					"data": "0"
				},
				{
					"data": "1"
				},
				{
					"data": "2"
				},
				{
					"data": "3"
				},
				{
					"className": 'text-center',
					"data": "4"
				},
				{
					"className": 'text-center',
					"data": "5"
				},
				{
					"className": 'text-center',
					"data": "6"
				}
			],
			"order": [
				[1, 'asc']
			]
		});

		// Add event listener for opening and closing details
		$('table#dt_userAccount tbody').on('click', 'td.details-control', function() {

			var tr = $(this).closest('tr');
			var row = dt_userAccount.row(tr);

			if (row.child.isShown()) {
				// This row is already open - close it
				row.child.hide();
				tr.removeClass('shown');
			} else {
				// Open this row
				row.child(format(row.data())).show();
				tr.addClass('shown');
			}
		});

		var dt_vis          = $("table#dt_vis").DataTable({

			"destroy": true,
			"ajax": {
				url: "<?php echo site_url('fetch_vis'); ?>"
			},
			columnDefs: [{

					"targets": [5],
					"orderable": false,
					"className": "text-center"
				},
				{
					"targets": [3],
					"className": "text-center"
				}
			],
			"paging": true,
			"fnDrawCallback": function(oSettings) {
				$('table#dt_users tbody').on('mouseover', 'i.action', function() {
					var sTitle;

					sTitle = "<i>Reset password!</i>";

					this.setAttribute('rel', 'tooltip');
					$(this).tooltip({
						html: true
					});
				});
			}
		});
		
		var dt_cas          = $("table#dt_cas").DataTable({

			"destroy": true,
			"ajax": {
				url: "<?php echo site_url('fetch_cas'); ?>"
			},
			columnDefs: [{

					"targets": [5],
					"orderable": false,
					"className": "text-center"
				},
				{
					"targets": [3],
					"className": "text-center"
				}
			],
			"paging": true,
			"fnDrawCallback": function(oSettings) {
				$('table#dt_users tbody').on('mouseover', 'i.action', function() {
					var sTitle;

					sTitle = "<i>Reset password!</i>";

					this.setAttribute('rel', 'tooltip');
					$(this).tooltip({
						html: true
					});
				});
			}
		});
		
		var dt_po           = $("table#dt_po").DataTable({

			"destroy": true,
			"ajax": {
				url: "<?php echo site_url('fetch_po'); ?>"
			},
			columnDefs: [{

					"targets": [5],
					"orderable": false,
					"className": "text-center"
				},
				{
					"targets": [3],
					"className": "text-center"
				}
			],
			"paging": true,
			"fnDrawCallback": function(oSettings) {
				$('table#dt_users tbody').on('mouseover', 'i.action', function() {
					var sTitle;

					sTitle = "<i>Reset password!</i>";

					this.setAttribute('rel', 'tooltip');
					$(this).tooltip({
						html: true
					});
				});
			}
		});
		
		var dt_deduction    = $("table#dt_deduction").DataTable({

			"destroy": true,
			"ajax": {
				url: "<?php echo site_url('fetch_deduction'); ?>"
			},
			columnDefs: [{

					"targets": [5],
					"orderable": false,
					"className": "text-center"
				},
				{
					"targets": [3],
					"className": "text-center"
				}
			],
			"paging": true,
			"fnDrawCallback": function(oSettings) {
				$('table#dt_users tbody').on('mouseover', 'i.action', function() {
					var sTitle;

					sTitle = "<i>Reset password!</i>";

					this.setAttribute('rel', 'tooltip');
					$(this).tooltip({
						html: true
					});
				});
			}
		});
        
		var dt_items        = $("table#dt_items").DataTable({

			"destroy": true,
			"ajax": {
				url: "<?php echo site_url('fetch_items'); ?>"
			},
			columnDefs: [{

					"targets": [5],
					"orderable": false,
					"className": "text-center"
				},
				{
					"targets": [3],
					"className": "text-center"
				}
			],
			"paging": true,
			"fnDrawCallback": function(oSettings) {
				$('table#dt_users tbody').on('mouseover', 'i.action', function() {
					var sTitle;

					sTitle = "<i>Reset password!</i>";

					this.setAttribute('rel', 'tooltip');
					$(this).tooltip({
						html: true
					});
				});
			}
		});
		
		var dt_checkvoucher = $("table#dt_checkvoucher").DataTable({

			"destroy": true,
			"ajax": {
				url: "<?php echo site_url('fetch_check_voucher'); ?>"
			},
			columnDefs: [{

					"targets": [4],
					"orderable": false,
					"className": "text-center"
				},
				{
					"targets": [3],
					"className": "text-center"
				}
			],
			"paging": true,
			"fnDrawCallback": function(oSettings) {
				$('table#dt_users tbody').on('mouseover', 'i.action', function() {
					var sTitle;

					sTitle = "<i>Reset password!</i>";

					this.setAttribute('rel', 'tooltip');
					$(this).tooltip({
						html: true
					});
				});
			}
		});
		
		var dt_checkdetails = $("table#dt_checkdetails").DataTable({

			"destroy": true,
			"ajax": {
				url: "<?php echo site_url('fetch_check_details'); ?>"
			},
			columnDefs: [{

					"targets": [5],
					"orderable": false,
					"className": "text-center"
				},
				{
					"targets": [4],
					"className": "text-center"
				}
			],
			"paging": true,
			"fnDrawCallback": function(oSettings) {
				$('table#dt_users tbody').on('mouseover', 'i.action', function() {
					var sTitle;

					sTitle = "<i>Reset password!</i>";

					this.setAttribute('rel', 'tooltip');
					$(this).tooltip({
						html: true
					});
				});
			}
		});
		
		var dt_checks       = $("table#dt_checks").DataTable({

			"destroy": true,
			"ajax": {
				url: "<?php echo site_url('fetch_check_monitoring'); ?>"
			},
			columnDefs: [{

					"targets": [4],
					"orderable": false,
					"className": "text-center"
				},
				{
					"targets": [3],
					"className": "text-center"
				}
			],
			"paging": true,
			"fnDrawCallback": function(oSettings) {
				$('table#dt_users tbody').on('mouseover', 'i.action', function() {
					var sTitle;

					sTitle = "<i>Reset password!</i>";

					this.setAttribute('rel', 'tooltip');
					$(this).tooltip({
						html: true
					});
				});
			}
		});
		
		var dt_sales        = $("table#dt_sales").DataTable({

			"destroy": true,
			"ajax": {
				url: "<?php echo site_url('fetch_sales'); ?>"
			},
			columnDefs: [{

					"targets": [7],
					"orderable": false,
					"className": "text-center"
				},
				{
					"targets": [6],
					"className": "text-center"
				}
			],
			"paging": true,
			"fnDrawCallback": function(oSettings) {
				$('table#dt_users tbody').on('mouseover', 'i.action', function() {
					var sTitle;

					sTitle = "<i>Reset password!</i>";

					this.setAttribute('rel', 'tooltip');
					$(this).tooltip({
						html: true
					});
				});
			}
		});
		
		var dt_sales_uploaded = $("table#dt_sales_uploaded").DataTable({

			"destroy": true,
			"ajax": {
				url: "<?php echo site_url('fetch_sales_uploaded'); ?>"
			},
			columnDefs: [{

					"targets": [4],
					"orderable": false,
					"className": "text-center"
				},
				{
					"targets": [3],
					"className": "text-center"
				}
			],
			"paging": true,
			"fnDrawCallback": function(oSettings) {
				$('table#dt_users tbody').on('mouseover', 'i.action', function() {
					var sTitle;

					sTitle = "<i>Reset password!</i>";

					this.setAttribute('rel', 'tooltip');
					$(this).tooltip({
						html: true
					});
				});
			}
		});
		
		var dt_sales_summary  = $("table#dt_sales_summary").DataTable({

			"destroy": true,
			"ajax": {
				url: "<?php echo site_url('fetch_sales_summary'); ?>"
			},
			columnDefs: [{

					"targets": [4],
					"orderable": false,
					"className": "text-center"
				},
				{
					"targets": [3],
					"className": "text-center"
				}
			],
			"paging": true,
			"fnDrawCallback": function(oSettings) {
				$('table#dt_users tbody').on('mouseover', 'i.action', function() {
					var sTitle;

					sTitle = "<i>Reset password!</i>";

					this.setAttribute('rel', 'tooltip');
					$(this).tooltip({
						html: true
					});
				});
			}
		});

	});
</script>