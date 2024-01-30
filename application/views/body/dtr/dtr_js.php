<script type="text/javascript">
	$(document).ready(function() {

		var first_cutoff = $("input[name = 'first_cutoff']").val();
		var dataTable = $('#dt_dtr').DataTable({

			"destroy": true,
			"ajax": {
				url: "<?php echo site_url('display_cutoff'); ?>",
				type: "POST",
				data: {
					cutoff: first_cutoff
				},
			},
			"order": [
				[0, "desc"]
			],
			"columnDefs": [{
				"targets": [0, 1, 2],
				"orderable": false,
				"className": "text-center"
			}, ],
			"bPaginate": true,
			"bLengthChange": false,
			"bFilter": false,
			"bInfo": true,
			"bAutoWidth": true
		});

		$("button#view_employee_btn").click(function() {

			$("#view_employee").modal({
				backdrop: 'static',
				keyboard: false
			});

			$("#view_employee").modal("show");

			var dateFrom = $("input[name = 'dateFrom']").val();
			var dateTo = $("input[name = 'dateTo']").val();

			$("span#emp_cutoff").html('');
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('cutoff'); ?>",
				data: {
					dateFrom: dateFrom,
					dateTo: dateTo
				},
				success: function(data) {

					$("span#emp_cutoff").html(data);

					$.ajax({
						url: "<?php echo site_url('employee_list'); ?>",
						success: function(data) {

							$("div.view_employee").html(data);
						}
					});
				}
			});

		});

		$("a.cutoff").click(function() {

			var id = this.id.split("_");
			var cutOff = id[1].trim();

			$("a.cutoff").removeClass('btn-danger').addClass('btn-primary');
			$("a#cutoff_" + cutOff).addClass("btn-danger");

			var dataTable = $('#dt_dtr').DataTable({

				"destroy": true,
				"ajax": {
					url: "<?php echo site_url('display_cutoff'); ?>",
					type: "POST",
					data: {
						cutoff: cutOff
					},
				},
				"order": [
					[0, "desc"]
				],
				"columnDefs": [{
					"targets": [0, 1, 2],
					"orderable": false,
					"className": "text-center"
				}, ],
				"bPaginate": true,
				"bLengthChange": false,
				"bFilter": false,
				"bInfo": true,
				"bAutoWidth": true
			});
		});

		$('#dt_dtr').on('click', 'a.record', function() {

			if (!$(this).parents('tr').hasClass('selected')) {

				$('tr.selected').removeClass('selected success');
				$(this).parents('tr').addClass('selected success');
			}

			var id = this.id;
			var cutoff = $("input#cutoff_" + id).val();
			var cut = $("input#cut_" + id).val();
			var dateFrom = $("input#dateFrom_" + id).val();
			var dateTo = $("input#dateTo_" + id).val();

			$("#view_employee").modal({
				backdrop: 'static',
				keyboard: false
			});

			$("#view_employee").modal("show");

			$("span#emp_cutoff").html('');
			$("div.view_employee").html('<center><img src="<?php echo base_url('assets/img/gif/loader_seq.gif'); ?>"></center>');
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('cutoff'); ?>",
				data: {
					dateFrom: dateFrom,
					dateTo: dateTo
				},
				success: function(data) {

					$("span#emp_cutoff").html(data);
					$.ajax({
						type: "POST",
						url: "<?php echo site_url('employee_list'); ?>",
						data: {
							cutoff: cutoff,
							cut: cut,
							dateFrom: dateFrom,
							dateTo: dateTo
						},
						beforeSend: function() {

							$("div.view_employee").html('<center><img src="<?php echo base_url('assets/img/gif/loader_seq.gif'); ?>"></center>');
						},
						success: function(data) {

							$("div.view_employee").html(data);
						}
					});
				}
			});
		});

		$('div#view_dtr').on('hidden.bs.modal', function(e) {

			$('body').addClass('modal-open');
		});

		$('div#show-entry').on('hidden.bs.modal', function(e) {

			$('body').addClass('modal-open');
		});
	});

	function chk(cut) {

		if (cut == 0) {

			if ($(".chk_" + 0).is(':checked')) {

				$(".chkC").prop("checked", true);
				$("button#print_dtr").prop("disabled", false);
			} else {

				$(".chkC").prop("checked", false);
				$("button#print_dtr").prop("disabled", true);
			}

		} else {

			if ($(".chk_" + cut).is(':checked')) {

				$("button#print_dtr").prop("disabled", false);
			} else {

				$("button#print_dtr").prop("disabled", true);
			}
		}
	}

	function employee_list(cutoff, server, dateFrom, dateTo) {

		setTimeout(() => {

			var dataTable = $('#dt_emp_list').DataTable({

				"destroy": true,
				"ajax": {
					url: "<?php echo site_url('view_employee_list'); ?>",
					type: "POST",
					data: {
						cutoff,
						server,
						dateFrom,
						dateTo
					},
				},
				"order": [
					[0, "asc"]
				],
				"columnDefs": [{
						"targets": [3, 4, 5, 6],
						"orderable": false,
						"className": "text-center"
					},
					{
						"targets": [0, 1],
						"orderable": false,
						"width": "20%"
					},
					{
						"targets": [2],
						"orderable": false
					}
				],
				"autoWidth": true,
				"paging": false,
				"scrollY": '51vh',
				"scrollCollapse": true
			});

			$('#dt_emp_list').off('click', 'a.print_dtr').on('click', 'a.print_dtr', function() {

				if (!$(this).parents('tr').hasClass('selected')) {

					dataTable.$('tr.selected').removeClass('selected success');
					$(this).parents('tr').addClass('selected success');
				}

				$("#view_dtr").modal({
					backdrop: 'static',
					keyboard: false
				});

				$("#view_dtr").modal("show");

				var empId = this.id;
				var dateFrom = $("input[name = 'dateFrom']").val();
				var dateTo = $("input[name = 'dateTo']").val();
				var cut = $("input[name = 'cut']").val();
				var server = $("input[name = 'server']").val();
				var cutoff = $("input[name = 'cutoff']").val();

				$("span#emp_cutoff").html('');
				$("div.view_dtr").html('<center><img src="<?php echo base_url('assets/img/gif/loader_seq.gif'); ?>"></center>');
				$.ajax({
					type: "POST",
					url: "<?php echo site_url('cutoff'); ?>",
					data: {
						dateFrom: dateFrom,
						dateTo: dateTo
					},
					success: function(data) {

						$("span#emp_cutoff").html(data);

						$.ajax({
							type: "POST",
							url: "<?php echo site_url('view_dtr'); ?>",
							data: {
								empId: empId,
								dateFrom: dateFrom,
								dateTo: dateTo,
								cut: cut,
								server: server,
								cutoff: cutoff
							},
							beforeSend: function() {

								$("div.view_dtr").html('<center><img src="<?php echo base_url('assets/img/gif/loader_seq.gif'); ?>"></center>');
							},
							success: function(data) {

								$("div.view_dtr").html(data);
							}
						});
					}
				});
			});

		}, "500")
	}

	function viewTime(server, empId, dateRendered) {

		$("#show-entry").modal("show");

		$.ajax({
			type: "POST",
			url: "<?php echo site_url('vTEntry'); ?>",
			data: {
				server: server,
				empId: empId,
				dateRendered: dateRendered
			},
			beforeSend: function() {

				$("div.show-entry").html('<img src="<?php echo base_url('assets/img/gif/PleaseWait.gif'); ?>"> Please Wait...');
			},
			success: function(data) {

				$("div.show-entry").html(data);
			}
		});
	}
</script>