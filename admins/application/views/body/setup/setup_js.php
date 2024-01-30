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

		$('table#dt_userAccount').on('click', 'i.delete_user', function() {

			var id = this.id.split("_");
			userId = id[1];

			if (!$(this).parents('tr').hasClass('selected')) {
				dt_userAccount.$('tr.selected').removeClass('selected');
				$(this).parents('tr').addClass('selected');
			}

			Swal({
				title: 'Are you sure?',
				text: "You won't be able to revert this!",
				type: 'warning',
				allowOutsideClick: false,
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Yes, delete it!'
			}).then((result) => {
				if (result.value) {

					$.post("<?php echo site_url('delete_user'); ?>", {
						userId: userId
					}, function(data, status) {

						var response = data.trim();
						if (response == "success") {

							Swal({
								title: 'Deleted!',
								text: 'User account has been deleted.',
								type: 'success',
								allowOutsideClick: false
							}).then((result) => {

								if (result.value) {

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
											}
										],
										"order": [
											[1, 'asc']
										]
									});
								}
							});
						} else {

							console.log(response);
						}
					});
				}
			});
		});

		$('table#dt_userAccount').on('click', 'i.extend_user', function() {

			var id = this.id.split("_");
			userId = id[1];

			if (!$(this).parents('tr').hasClass('selected')) {
				dt_userAccount.$('tr.selected').removeClass('selected');
				$(this).parents('tr').addClass('selected');
			}

			$("div#extend_contract").modal({
				backdrop: 'static',
				keyboard: false
			});

			$("div#extend_contract").modal("show");

			$.ajax({
				type: "POST",
				url: "<?php echo site_url('extend_contract'); ?>",
				data: {
					userId: userId
				},
				success: function(result) {

					$("div.extend_contract").html(result);
				}
			});
		});

		$("a.submit_contract").click(function() {

			var userId = $("input[name = 'userId']").val();
			var prev_dateFrom = $("input[name = 'prev_dateFrom']").val();
			var prev_dateTo = $("input[name = 'prev_dateTo']").val();
			var fromDate = $("input[name = 'fromDate']").val();
			var toDate = $("input[name = 'toDate']").val();

			if (fromDate == "" || toDate == "") {

				$.gritter.add({
					image: '<?php echo base_url('assets/plugins/gritter/images/warning.png'); ?>',
					title: 'Opsss!',
					text: 'Please fill-up required field(s)!'
				});

				if (fromDate == "") {
					$("input[name = 'fromDate']").addClass("parsley-error");
				}

				if (toDate == "") {
					$("input[name = 'toDate']").addClass("parsley-error");
				}
			} else {

				$.post("<?php echo site_url('submit_contract'); ?>", {
					userId: userId,
					prev_dateFrom: prev_dateFrom,
					prev_dateTo: prev_dateTo,
					fromDate: fromDate,
					toDate: toDate
				}, function(data, status) {

					response = data.trim();
					if (response == "success") {

						Swal({
							title: 'Success!',
							text: 'User contract has been updated.',
							type: 'success',
							allowOutsideClick: false,
							customClass: 'animated tada'
						}).then((result) => {

							if (result.value) {

								$("div#extend_contract").modal("hide");
								location.reload();
							}
						});
					} else {

						console.log(response);
					}
				});
			}
		});

		$('table#dt_userAccount').on('click', 'i.setup_cutoff', function() {

			var id = this.id.split("_");
			userId = id[1];

			if (!$(this).parents('tr').hasClass('selected')) {
				dt_userAccount.$('tr.selected').removeClass('selected');
				$(this).parents('tr').addClass('selected');
			}

			$("div#setup_cutoff").modal({
				backdrop: 'static',
				keyboard: false
			});

			$("div#setup_cutoff").modal("show");

			$.ajax({
				type: "POST",
				url: "<?php echo site_url('setup_cutoff'); ?>",
				data: {
					userId: userId
				},
				success: function(result) {

					$("div.setup_cutoff").html(result);
				}
			});
		});

		$("a.create_account_btn").click(function() {

			$("div#create_account").modal({
				backdrop: 'static',
				keyboard: false
			});

			$("div#create_account").modal("show");

			$.ajax({
				url: "<?php echo site_url('create_account'); ?>",
				success: function(result) {

					$("div.create_account").html(result);
				}
			});
		});

		$("a.submit_account").click(function() {

			var formData = $("form").serialize();

			var account_form = $("input[name = 'account_form']").val();
			var agency = $("[name = 'agency']").val();
			var company = $("[name = 'company']").val();
			var username = $("input[name = 'username']").val();
			var password = $("input[name = 'password']").val();
			var dateFrom = $("input[name = 'dateFrom']").val();
			var dateTo = $("input[name = 'dateTo']").val();

			if ((account_form == "with_agency" && agency == "") || (account_form == "no_agency" && company == "") || username == "" || password == "" || dateFrom == "" || dateTo == "") {

				Swal(
					'Warning',
					'Please fill-up required field(s) first!',
					'warning'
				);
				if ((account_form == "with_agency" && agency == "")) {

					$("select[name = 'agency']").addClass("parsley-error");
				}

				if ((account_form == "no_agency" && company == "")) {

					$("select[name = 'company']").addClass("parsley-error");
				}

				if (username == "") {

					$("input[name = 'username']").addClass("parsley-error");
				}

				if (password == "") {

					$("input[name = 'password']").addClass("parsley-error");
				}

				if (dateFrom == "") {

					$("input[name = 'dateFrom']").addClass("parsley-error");
				}

				if (dateTo == "") {

					$("input[name = 'dateTo']").addClass("parsley-error");
				}
			} else {

				$.post("<?php echo site_url('submit_account'); ?>",
					formData,
					function(data, status) {

						var response = data.trim();
						if (response == "success") {

							Swal({
								title: 'Success!',
								text: 'User account has been created!.',
								type: 'success',
								allowOutsideClick: false
							}).then((result) => {

								if (result.value) {

									$("div#create_account").modal("hide");
									location.reload();
								}
							});
						} else if (response == "exist") {

							Swal(
								'Exist',
								'Username/Password already exist. Please generate another username/password!',
								'warning'
							);
						} else {

							console.log(response);
						}
					})
			}
		});

		var dt_company = $("table#dt_company").DataTable({

			"destroy": true,
			"ajax": {
				url: "<?php echo site_url('com_for_agency'); ?>",
				type: "POST"
			},
			"order": [
				[0, "asc"],
				[1, "asc"]
			],
			"columnDefs": [{
				"targets": [2],
				"orderable": false,
				"className": "text-center",
			}]
		});

		$('table#dt_company').on('click', 'i.delete_company', function() {

			var id = this.id.split("_");
			company_code = id[1];

			if (!$(this).parents('tr').hasClass('selected')) {
				dt_company.$('tr.selected').removeClass('selected');
				$(this).parents('tr').addClass('selected');
			}

			Swal({
				title: 'Are you sure?',
				text: "You won't be able to revert this!",
				type: 'warning',
				allowOutsideClick: false,
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Yes, delete it!'
			}).then((result) => {
				if (result.value) {

					$.post("<?php echo site_url('delete_company'); ?>", {
						company_code: company_code
					}, function(data, status) {

						var response = data.trim();
						if (response == "success") {

							Swal({
								title: 'Deleted!',
								text: 'Company has been deleted.',
								type: 'success',
								allowOutsideClick: false
							}).then((result) => {

								if (result.value) {

									var agency_code = $("select[name = 'selected_agency']").val();
									var dt_company = $("table#dt_company").DataTable({

										"destroy": true,
										"ajax": {
											url: "<?php echo site_url('com_for_agency'); ?>",
											type: "POST",
											data: {
												agency_code: agency_code
											}
										},
										"order": [
											[0, "desc"]
										],
										"columnDefs": [{
											"targets": [2],
											"orderable": false,
											"className": "text-center"
										}]
									});
								}
							});
						} else {

							console.log(response);
						}
					});
				}
			});
		});

		$("a.add_agency_btn").click(function() {

			$("div#add_agency").modal({
				backdrop: 'static',
				keyboard: false
			});

			$("div#add_agency").modal("show");
		});

		$("a.submit_agency").click(function() {

			var agency_name = $("input[name = 'agency_name']").val();

			if (agency_name == "") {

				Swal(
					'Warning',
					'Please fill-up required field first!',
					'warning'
				);
				if (agency_name == "") {

					$("input[name = 'agency_name']").addClass("parsley-error");
				}
			} else {

				$.post("<?php echo site_url('submit_agency'); ?>", {
					agency_name: agency_name
				}, function(data, status) {

					var response = data.trim()
					if (response == "success") {

						Swal({
							title: 'Success!',
							text: 'Agency has been added!',
							type: 'success',
							allowOutsideClick: false
						}).then((result) => {

							if (result.value) {

								$("div#add_agency").modal("hide");
								location.reload();
							}
						});
					} else {

						console.log(response);
					}
				});
			}
		});

		$("input[name = 'agency_name']").keyup(function() {

			var agency_name = $(this).val();

			if (agency_name.trim() != "") {

				$(this).removeClass("parsley-error").addClass("parsley-success");
			} else {

				$(this).removeClass("parsley-success").addClass("parsley-error");
			}
		});

		$("a.setup_company_btn").click(function() {

			$("div#setup_company").modal({
				backdrop: 'static',
				keyboard: false
			});

			$("div#setup_company").modal("show");
		});

		$("select[name = 'setupan_agency']").change(function() {

			var setupan_agency = $(this).val();
			if (setupan_agency.trim() != "") {

				$.ajax({
					type: "POST",
					url: "<?php echo site_url('setupan_agency'); ?>",
					data: {
						setupan_agency: setupan_agency
					},
					success: function(result) {

						$("div.companies").html(result);
					}
				});
			} else {

				$("div.companies").html('');
			}
		});

		$("a.submit_company").click(function() {

			var agency_code = $("select[name = 'setupan_agency']").val();
			var chk = $("input[name = 'chkCom[]']");
			var newCHK = "";

			for (var i = 0; i < chk.length; i++) {

				if (chk[i].checked == true) {

					newCHK += chk[i].value + "|_";
				}
			}

			$.post("<?php echo site_url('insert_update_locate_company'); ?>", {
				agency_code: agency_code,
				newCHK: newCHK
			}, function(data, status) {

				var response = data.trim();
				if (response == "success") {

					Swal({
						title: 'Success!',
						text: 'Company for agency has been setup!',
						type: 'success',
						allowOutsideClick: false
					}).then((result) => {

						if (result.value) {

							$("div#setup_company").modal("hide");
							location.reload();
						}
					});
				} else {

					console.log(response);
				}
			});
		});

		var dt_agency_list = $("table#dt_agency_list").DataTable({

			"destroy": true,
			"ajax": {
				url: "<?php echo site_url('fetch_agency_list'); ?>"
			},
			columnDefs: [{

					"targets": [0, 1],
					"orderable": false
				},
				{
					"targets": [2],
					"orderable": false,
					"className": "text-center"
				}
			],
			"fnDrawCallback": function(oSettings) {
				$('table#dt_agency_list tbody').on('mouseover', 'i.action', function() {

					this.setAttribute('rel', 'tooltip');
					$(this).tooltip({
						html: true
					});
				});
			}
		});

		$('table#dt_agency_list').on('click', 'i.delete_agency', function() {

			var id = this.id.split("_");
			agency_code = id[1];

			if (!$(this).parents('tr').hasClass('selected')) {
				dt_agency_list.$('tr.selected').removeClass('selected');
				$(this).parents('tr').addClass('selected');
			}

			Swal({
				title: 'Are you sure?',
				text: "You won't be able to revert this!",
				type: 'warning',
				allowOutsideClick: false,
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Yes, delete it!'
			}).then((result) => {
				if (result.value) {

					$.post("<?php echo site_url('delete_agency'); ?>", {
						agency_code: agency_code
					}, function(data, status) {

						var response = data.trim();
						if (response == "success") {

							Swal({
								title: 'Deleted!',
								text: 'Agency has been deleted.',
								type: 'success',
								allowOutsideClick: false
							}).then((result) => {

								if (result.value) {

									location.reload();
								}
							});
						} else {

							console.log(response);
						}
					});
				}
			});
		});

		$('table#dt_agency_list').on('click', 'i.update_agency', function() {

			var id = this.id.split("_");
			agency_code = id[1];

			if (!$(this).parents('tr').hasClass('selected')) {
				dt_agency_list.$('tr.selected').removeClass('selected');
				$(this).parents('tr').addClass('selected');
			}

			$("div#update_agency").modal({
				backdrop: 'static',
				keyboard: false
			});

			$("div#update_agency").modal("show");

			$.ajax({
				type: "POST",
				url: "<?php echo site_url('update_agency'); ?>",
				data: {
					agency_code: agency_code
				},
				success: function(result) {

					$("div.update_agency").html(result);
				}
			});
		});

		$("form#updated_agency").submit(function(e) {

			e.preventDefault();
			var formData = $(this).serialize();

			var agency_name = $("[name = 'agencyName']").val();

			if (agency_name.trim() == "") {

				Swal(
					'Warning',
					'Please fill-up Agency Name first!',
					'warning'
				);
			} else {

				$.ajax({
					type: "POST",
					url: "<?php echo site_url('sub_updated_agency'); ?>",
					data: formData,
					success: function(data) {

						var response = data.trim();
						if (response == "success") {

							Swal({
								title: 'Success!',
								text: 'Agency name has been updated!',
								type: 'success',
								allowOutsideClick: false
							}).then((result) => {

								if (result.value) {

									$("div#update_agency").modal("hide");
									location.reload();
								}
							});
						} else {

							console.log(response);
						}
					}
				});
			}
		});

		var dt_company_list = $("table#dt_company_list").DataTable({

			"destroy": true,
			"ajax": {
				url: "<?php echo site_url('fetch_company_list'); ?>"
			},
			columnDefs: [{

					"targets": [0, 1],
					"orderable": false
				},
				{
					"targets": [2],
					"orderable": false,
					"className": "text-center"
				}
			],
			"order": [
				[0, "asc"]
			],
			"fnDrawCallback": function(oSettings) {
				$('table#dt_company_list tbody').on('mouseover', 'i.action', function() {

					this.setAttribute('rel', 'tooltip');
					$(this).tooltip({
						html: true
					});
				});
			}
		});

		$('table#dt_company_list').on('click', 'i.delete_company', function() {

			var id = this.id.split("_");
			pc_code = id[1];

			if (!$(this).parents('tr').hasClass('selected')) {
				dt_company_list.$('tr.selected').removeClass('selected');
				$(this).parents('tr').addClass('selected');
			}

			Swal({
				title: 'Are you sure?',
				text: "You won't be able to revert this!",
				type: 'warning',
				allowOutsideClick: false,
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Yes, delete it!'
			}).then((result) => {
				if (result.value) {

					$.post("<?php echo site_url('delete_companies'); ?>", {
						pc_code: pc_code
					}, function(data, status) {

						var response = data.trim();
						if (response == "success") {

							Swal({
								title: 'Deleted!',
								text: 'Company has been deleted.',
								type: 'success',
								allowOutsideClick: false
							}).then((result) => {

								if (result.value) {

									location.reload();
								}
							});
						} else {

							console.log(response);
						}
					});
				}
			});
		});

		$("a.add_company_btn").click(function() {

			$("div#add_companies").modal({
				backdrop: 'static',
				keyboard: false
			});

			$("div#add_companies").modal("show");
		});

		$("form#added_company").submit(function(e) {

			e.preventDefault();

			var company_name = $("[name = 'company_name']").val();

			if (company_name.trim() == "") {

				Swal(
					'Warning',
					'Please fill-up Company Name first!',
					'warning'
				);
			} else {

				$.ajax({
					type: "POST",
					url: "<?php echo site_url('sub_added_company'); ?>",
					data: {
						company_name: company_name
					},
					success: function(data) {

						var response = data.trim();
						if (response == "success") {

							Swal({
								title: 'Success!',
								text: 'Company name has been added!',
								type: 'success',
								allowOutsideClick: false
							}).then((result) => {

								if (result.value) {

									$("div#add_companies").modal("hide");
									location.reload();
								}
							});
						} else {

							console.log(response);
						}
					}
				});
			}
		});

		$('table#dt_company_list').on('click', 'i.update_company', function() {

			var id = this.id.split("_");
			pc_code = id[1];

			if (!$(this).parents('tr').hasClass('selected')) {
				dt_company_list.$('tr.selected').removeClass('selected');
				$(this).parents('tr').addClass('selected');
			}

			$("div#update_company").modal({
				backdrop: 'static',
				keyboard: false
			});

			$("div#update_company").modal("show");

			$.ajax({
				type: "POST",
				url: "<?php echo site_url('update_company'); ?>",
				data: {
					pc_code: pc_code
				},
				success: function(result) {

					$("div.update_company").html(result);
				}
			});
		});

		$("form#updated_company").submit(function(e) {

			e.preventDefault();
			var formData = $(this).serialize();

			var company_name = $("[name = 'companyName']").val();

			if (company_name.trim() == "") {

				Swal(
					'Warning',
					'Please fill-up Company Name first!',
					'warning'
				);
			} else {

				$.ajax({
					type: "POST",
					url: "<?php echo site_url('sub_updated_company'); ?>",
					data: formData,
					success: function(data) {

						var response = data.trim();
						if (response == "success") {

							Swal({
								title: 'Success!',
								text: 'Company name has been updated!',
								type: 'success',
								allowOutsideClick: false
							}).then((result) => {

								if (result.value) {

									$("div#update_company").modal("hide");
									location.reload();
								}
							});
						} else {

							console.log(response);
						}
					}
				});
			}
		});

		var dt_users = $("table#dt_users").DataTable({

			"destroy": true,
			"ajax": {
				url: "<?php echo site_url('fetch_users'); ?>"
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
			"paging": false,
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

		$('table#dt_users').on('click', 'i.action', function() {

			var id = this.id.split("_");
			var action = id[0].trim();
			var userId = id[1].trim();

			if (!$(this).parents('tr').hasClass('selected')) {
				dt_users.$('tr.selected').removeClass('selected');
				$(this).parents('tr').addClass('selected');
			}

			if (action == "reset") {

				$.post("<?php echo site_url('reset_password'); ?>", {
					userId: userId
				}, function(data, status) {

					var response = data.trim();
					if (response == "success") {

						Swal(
							'Success',
							'Password has been reseted!',
							'success'
						);
					} else {

						console.log(response);
					}
				});

			} else if (action == "update") {

				$("div#update_adminUser").modal({
					backdrop: 'static',
					keyboard: false
				});

				$("div#update_adminUser").modal("show");

				$.post("<?php echo site_url('update_adminUser'); ?>", {
					userId: userId
				}, function(data, status) {

					$("div.update_adminUser").html(data);
				});

			} else {

				$.post("<?php echo site_url('user_status'); ?>", {
					userId: userId,
					action: action
				}, function(data, status) {

					var response = data.trim();
					if (response == "success") {

						Swal({
							title: 'Success!',
							text: 'User status has been ' + action + '!',
							type: 'success',
							allowOutsideClick: false
						}).then((result) => {

							if (result.value) {

								var dt_users = $("table#dt_users").DataTable({

									"destroy": true,
									"ajax": {
										url: "<?php echo site_url('fetch_users'); ?>"
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
									"paging": false,
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
							}
						});
					} else {

						console.log(response);
					}
				});
			}
		});

		$("a.add_user_btn").click(function() {

			$("div#add_adminUser").modal({
				backdrop: 'static',
				keyboard: false
			});

			$("div#add_adminUser").modal("show");

			$.ajax({
				url: "<?php echo site_url('add_adminUser'); ?>",
				success: function(result) {

					$("div.add_adminUser").html(result);
				}
			});
		});

		$("a.submit_adminUser").click(function() {

			var fullname = $("input[name = 'fullname']").val().trim();
			var username = $("input[name = 'username']").val().trim();
			var server_loc = $("select[name = 'server_loc']").val().trim();

			if (fullname == "" || username == "" || server_loc == "") {

				Swal(
					'Warning',
					'Please fill-up required field(s) first!',
					'warning'
				);

				if (fullname == "") {

					$("input[name = 'fullname']").addClass("parsley-error");
				}

				if (username == "") {

					$("input[name = 'username']").addClass("parsley-error");
				}

				if (server_loc == "") {

					$("select[name = 'server_loc']").addClass("parsley-error");
				}
			} else {

				$.post("<?php echo site_url('submit_adminUser'); ?>", {
					fullname: fullname,
					username: username,
					server_loc: server_loc
				}, function(data, status) {

					var response = data.trim();
					if (response == "success") {

						Swal({
							title: 'Success!',
							text: 'New admin user has been added!',
							type: 'success',
							allowOutsideClick: false
						}).then((result) => {

							if (result.value) {

								$("div#add_adminUser").modal("hide");
								location.reload();
							}
						});
					} else {

						console.log(response);
					}
				});
			}
		});

		$("a.update_adminUser").click(function() {

			var user_no = $("input[name = 'user_no']").val();
			var fullname = $("input[name = 'fullname']").val().trim();
			var username = $("input[name = 'username']").val().trim();
			var server_loc = $("select[name = 'server_loc']").val().trim();

			if (fullname == "" || username == "" || server_loc == "") {

				Swal(
					'Warning',
					'Please fill-up required field(s) first!',
					'warning'
				);

				if (fullname == "") {

					$("input[name = 'fullname']").addClass("parsley-error");
				}

				if (username == "") {

					$("input[name = 'username']").addClass("parsley-error");
				}

				if (server_loc == "") {

					$("select[name = 'server_loc']").addClass("parsley-error");
				}
			} else {

				$.post("<?php echo site_url('submit_updated_userAdmin'); ?>", {
					user_no: user_no,
					fullname: fullname,
					username: username,
					server_loc: server_loc
				}, function(data, status) {

					var response = data.trim();
					if (response == "success") {

						Swal({
							title: 'Success!',
							text: 'Admin user has been updated!',
							type: 'success',
							allowOutsideClick: false
						}).then((result) => {

							if (result.value) {

								$("div#update_adminUser").modal("hide");
								location.reload();
							}
						});
					} else {

						console.log(response);
					}
				});
			}
		});

		$("button.generate_excel").click(function() {

			Swal({
				title: 'Are you sure?',
				text: "Generate Users Report!",
				type: 'warning',
				allowOutsideClick: false,
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Yes, generate it!'
			}).then((result) => {
				if (result.value) {

					window.location = "<?php echo base_url('report/users_xls'); ?>";
				}
			});
		});

		var dt_supplier = $("table#dt_supplier").DataTable({

			"destroy": true,
			stateSave: true,
			"ajax": {
				url: "<?php echo site_url('supplier_list'); ?>",
				type: "POST"
			},
			"order": [0, "asc"],
			"columnDefs": [{
				"targets": [2, 4],
				"orderable": false,
				"className": "text-center",
			}]
		});

		$('table#dt_supplier').on('click', 'i.action', function() {

			var tag = this.id.split("_");
			var action = tag[0].trim();
			var id = tag[1].trim();

			if (!$(this).parents('tr').hasClass('selected')) {
				dt_supplier.$('tr.selected').removeClass('selected');
				$(this).parents('tr').addClass('selected');
			}

			if (action == "update") {

				$("div#supplier_details").modal({
					backdrop: 'static',
					keyboard: false
				});

				$("div#supplier_details").modal("show");

				$.get("<?php echo site_url('edit_supplier_details'); ?>", {
					id: id
				}, function(data, status) {

					$("div.supplier_details").html(data);
				});

			} else {

				$.post("<?php echo site_url('supplier_status'); ?>", {
					id: id,
					action: action
				}, function(data, status) {

					var response = data.trim();
					if (response == "success") {

						Swal({
							title: 'Success!',
							text: 'Supplier status has been ' + action + '!',
							type: 'success',
							allowOutsideClick: false
						}).then((result) => {

							if (result.value) {

								var dt_supplier = $("table#dt_supplier").DataTable({

									"destroy": true,
									stateSave: true,
									"ajax": {
										url: "<?php echo site_url('supplier_list'); ?>",
										type: "POST"
									},
									"order": [0, "asc"],
									"columnDefs": [{
										"targets": [2, 4],
										"orderable": false,
										"className": "text-center",
									}]
								});
							}
						});
					} else {

						console.log(response);
					}
				});
			}
		});

		$("form#supplier_form").submit(function(event) {

			event.preventDefault();
			let formData = $(this).serialize();

			$.post("<?php echo site_url('create_update_supplier'); ?>",
				formData,
				function(data, status) {

					var response = data.trim();
					if (response == "create") {

						Swal({
							title: 'Success!',
							text: 'Supplier has been added!',
							type: 'success',
							allowOutsideClick: false
						}).then((result) => {

							if (result.value) {

								$("div#supplier_details").modal("hide");
								location.reload();
							}
						});
					} else if (response == "update") {

						Swal({
							title: 'Success!',
							text: 'Supplier has been updated!',
							type: 'success',
							allowOutsideClick: false
						}).then((result) => {

							if (result.value) {

								$("div#supplier_details").modal("hide");
								location.reload();
							}
						});
					} else if (response == "exist") {

						Swal(
							'Exist',
							'Opps! Supplier is already exist.',
							'warning'
						);
					} else {

						console.log(response);
					}
				});

		});

		var dt_supplier_account = $("table#dt_supplier_account").DataTable({

			"destroy": true,
			stateSave: true,
			"ajax": {
				url: "<?php echo site_url('supplier_account_list'); ?>",
				type: "POST"
			},
			"order": [1, "asc"],
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
					"className": 'text-center',
					"data": "3"
				},
				{
					"className": 'text-center',
					"data": "4"
				},
				{
					"className": 'text-center',
					"data": "5"
				}
			],
		});

		// Add event listener for opening and closing details
		$('table#dt_supplier_account tbody').on('click', 'td.details-control', function() {
			var tr = $(this).closest('tr');
			var row = dt_supplier_account.row(tr);

			if (row.child.isShown()) {
				// This row is already open - close it
				row.child.hide();
				tr.removeClass('shown');
			} else {
				// Open this row
				row.child(sup_format(row.data())).show();
				tr.addClass('shown');
			}
		});

		$('table#dt_supplier_account').on('click', 'i.action', function() {

			var tag = this.id.split("_");
			var action = tag[0].trim();
			var id = tag[1].trim();

			if (action !== "deactivate" && action !== "activate") {

				var supplier_id = tag[1].trim();
				var id = tag[2].trim();
			}

			if (!$(this).parents('tr').hasClass('selected')) {
				dt_supplier_account.$('tr.selected').removeClass('selected');
				$(this).parents('tr').addClass('selected');
			}

			if (action == "update") {

				$("div#edit_tag_ac").modal({
					backdrop: 'static',
					keyboard: false
				});

				$("div#edit_tag_ac").modal("show");

				$.get("<?php echo site_url('edit_tag_ac'); ?>", {
					supplier_id: supplier_id,
					id: id
				}, function(data, status) {

					$("div.edit_tag_ac").html(data);
				});

			} else if (action == "extend") {

				$("div#renew_contract").modal({
					backdrop: 'static',
					keyboard: false
				});

				$("div#renew_contract").modal("show");

				$.ajax({
					type: "POST",
					url: "<?php echo site_url('renew_contract'); ?>",
					data: {
						supplier_id: supplier_id,
						id: id
					},
					success: function(result) {

						$("div.renew_contract").html(result);
					}
				});

			} else if (action == "cutoff") {

				$("div#setup_cutoff").modal({
					backdrop: 'static',
					keyboard: false
				});

				$("div#setup_cutoff").modal("show");

				$.ajax({
					type: "POST",
					url: "<?php echo site_url('setup_cutoff'); ?>",
					data: {
						supplier_id: supplier_id
					},
					success: function(result) {

						$("div.setup_cutoff").html(result);
					}
				});
			} else if (action == "reset") {

				Swal({
					title: 'Are you sure?',
					text: "You won't be able to revert this!",
					type: 'warning',
					allowOutsideClick: false,
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Yes, reset password!'
				}).then((result) => {
					if (result.value) {
						$.post("<?php echo site_url('supplier_reset_password'); ?>", {
							id: id
						}, function(data, status) {

							var response = data.trim();
							if (response == "success") {

								Swal({
									title: 'Success!',
									text: 'User password has been ' + action + '!',
									type: 'success',
									allowOutsideClick: false
								}).then((result) => {

									if (result.value) {

										dt_supplier_account = $("table#dt_supplier_account").DataTable({

											"destroy": true,
											stateSave: true,
											"ajax": {
												url: "<?php echo site_url('supplier_account_list'); ?>",
												type: "POST"
											},
											"order": [1, "asc"],
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
													"className": 'text-center',
													"data": "3"
												},
												{
													"className": 'text-center',
													"data": "4"
												},
												{
													"className": 'text-center',
													"data": "5"
												}
											],
										});
									}
								});
							} else {

								console.log(response);
							}
						});
					}
				});
			} else {

				$.post("<?php echo site_url('supplier_user_status'); ?>", {
					id: id,
					action: action
				}, function(data, status) {

					var response = data.trim();
					if (response == "success") {

						Swal({
							title: 'Success!',
							text: 'Supplier user status has been ' + action + '!',
							type: 'success',
							allowOutsideClick: false
						}).then((result) => {

							if (result.value) {

								dt_supplier_account = $("table#dt_supplier_account").DataTable({

									"destroy": true,
									stateSave: true,
									"ajax": {
										url: "<?php echo site_url('supplier_account_list'); ?>",
										type: "POST"
									},
									"order": [1, "asc"],
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
											"className": 'text-center',
											"data": "3"
										},
										{
											"className": 'text-center',
											"data": "4"
										},
										{
											"className": 'text-center',
											"data": "5"
										}
									],
								});
							}
						});
					} else {

						console.log(response);
					}
				});
			}
		});

		var dt_consignor_account = $("table#dt_consignor_account").DataTable({

			"destroy": true,
			stateSave: true,
			"ajax": {
				url: "<?php echo site_url('consignor_account_list'); ?>",
				type: "POST"
			},
			"order": [1, "asc"],
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
					"className": 'text-center',
					"data": "3"
				},
				{
					"className": 'text-center',
					"data": "4"
				},
				{
					"className": 'text-center',
					"data": "5"
				}
			],
		});

		// Add event listener for opening and closing details
		$('table#dt_consignor_account tbody').on('click', 'td.details-control', function() {
			var tr = $(this).closest('tr');
			var row = dt_consignor_account.row(tr);

			if (row.child.isShown()) {
				// This row is already open - close it
				row.child.hide();
				tr.removeClass('shown');
			} else {
				// Open this row
				row.child(sup_format(row.data())).show();
				tr.addClass('shown');
			}
		});

		$('table#dt_consignor_account').on('click', 'i.action', function() {

			var tag = this.id.split("_");
			var action = tag[0].trim();
			var id = tag[1].trim();

			if (action !== "deactivate" && action !== "activate") {

				var supplier_id = tag[1].trim();
				var id = tag[2].trim();
			}

			if (!$(this).parents('tr').hasClass('selected')) {
				dt_consignor_account.$('tr.selected').removeClass('selected');
				$(this).parents('tr').addClass('selected');
			}

			if (action == "update") {

				$("div#edit_tag_ac").modal({
					backdrop: 'static',
					keyboard: false
				});

				$("div#edit_tag_ac").modal("show");

				$.get("<?php echo site_url('edit_tag_vendor'); ?>", {
					supplier_id: supplier_id,
					id: id
				}, function(data, status) {

					$("div.edit_tag_ac").html(data);
				});

			} else if (action == "extend") {

				$("div#renew_contract").modal({
					backdrop: 'static',
					keyboard: false
				});

				$("div#renew_contract").modal("show");

				$.ajax({
					type: "POST",
					url: "<?php echo site_url('renew_contract'); ?>",
					data: {
						supplier_id: supplier_id,
						id: id
					},
					success: function(result) {

						$("div.renew_contract").html(result);
					}
				});
	} else if (action == "reset") {

				Swal({
					title: 'Are you sure?',
					text: "You won't be able to revert this!",
					type: 'warning',
					allowOutsideClick: false,
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Yes, reset password!'
				}).then((result) => {
					if (result.value) {
						$.post("<?php echo site_url('supplier_reset_password'); ?>", {
							id: id
						}, function(data, status) {

							var response = data.trim();
							if (response == "success") {

								Swal({
									title: 'Success!',
									text: 'User password has been ' + action + '!',
									type: 'success',
									allowOutsideClick: false
								}).then((result) => {

									if (result.value) {

										dt_consignor_account = $("table#dt_consignor_account").DataTable({

											"destroy": true,
											stateSave: true,
											"ajax": {
												url: "<?php echo site_url('supplier_account_list'); ?>",
												type: "POST"
											},
											"order": [1, "asc"],
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
													"className": 'text-center',
													"data": "3"
												},
												{
													"className": 'text-center',
													"data": "4"
												},
												{
													"className": 'text-center',
													"data": "5"
												}
											],
										});
									}
								});
							} else {

								console.log(response);
							}
						});
					}
				});
			}
// 			} else {

// 				$.post("<?php echo site_url('supplier_user_status'); ?>", {
// 					id: id,
// 					action: action
// 				}, function(data, status) {

// 					var response = data.trim();
// 					if (response == "success") {

// 						Swal({
// 							title: 'Success!',
// 							text: 'Supplier user status has been ' + action + '!',
// 							type: 'success',
// 							allowOutsideClick: false
// 						}).then((result) => {

// 							if (result.value) {

// 								dt_consignor_account = $("table#dt_consignor_account").DataTable({

// 									"destroy": true,
// 									stateSave: true,
// 									"ajax": {
// 										url: "<?php echo site_url('consignor_account_list'); ?>",
// 										type: "POST"
// 									},
// 									"order": [1, "asc"],
// 									"columns": [{
// 											"className": 'details-control',
// 											"orderable": false,
// 											"data": null,
// 											"defaultContent": ''
// 										},
// 										{
// 											"data": "0"
// 										},
// 										{
// 											"data": "1"
// 										},
// 										{
// 											"data": "2"
// 										},
// 										{
// 											"className": 'text-center',
// 											"data": "3"
// 										},
// 										{
// 											"className": 'text-center',
// 											"data": "4"
// 										},
// 										{
// 											"className": 'text-center',
// 											"data": "5"
// 										}
// 									],
// 								});
// 							}
// 						});
// 					} else {

// 						console.log(response);
// 					}
// 				});
// 			}
		});

		$("form#supplier_account_form").submit(function(event) {

			event.preventDefault();
			let formData = $(this).serialize();

			let supplier_type = null,
				alturas_agency = null,
				colonnade_agency = null,
				colonnade_company = null,
				alturas_company = null;

			supplier_type = $("input[name = 'supplier_type']").val();
			if (supplier_type == 1) {

				alturas_agency = $("select[name = 'alturas_agency']").val();
				colonnade_agency = $("select[name = 'colonnade_agency']").val();

				if (alturas_agency === "" && colonnade_agency === "") {
					Swal(
						'Warning',
						'Please fill-up Agency either Bohol or Colonnade Server or both!',
						'warning'
					);

					return
				}

			} else {

				colonnade_company = $("select[name = 'colonnade_company']").val();
				alturas_company = $("select[name = 'alturas_company']").val();

				if (colonnade_company === "" && alturas_company === "") {
					Swal(
						'Warning',
						'Please fill-up Company either Bohol or Colonnade Server or both!',
						'warning'
					);

					return
				}
			}

			$.post("<?php echo site_url('create_supplier_account'); ?>",
				formData,
				function(data, status) {

					var response = data.trim();
					if (response == "created") {

						Swal({
							title: 'Success!',
							text: 'Supplier Account has been created!',
							type: 'success',
							allowOutsideClick: false
						}).then((result) => {

							if (result.value) {

								$("div#supplier_account").modal("hide");
								location.reload();
							}
						});
					} else if (response == "exist") {

						Swal(
							'Exist',
							'Username already exist. Please generate another username!',
							'warning'
						);
					} else {

						console.log(response);
					}
				});
		});

		$("form#consignor_account_form").submit(function(event) {

			event.preventDefault();
			let formData = $(this).serialize();

			var cb = $("[name = 'vendor_id[]']")
			var checkboxesChecked = [];
			// loop over them all
			for (var i = 0; i < cb.length; i++) {
				// And stick the checked ones onto an array...
				if (cb[i].checked) {
					checkboxesChecked.push(cb[i].value);
				}
			}

			if (checkboxesChecked.length === 0) {

				Swal(
					'Warning',
					'Please select atleast one vendor!',
					'warning'
				);
				return
			}

			$.post("<?php echo site_url('create_consignor_account'); ?>",
				formData,
				function(data, status) {

					var response = data.trim();
					if (response == "created") {

						Swal({
							title: 'Success!',
							text: 'Supplier Account has been created!',
							type: 'success',
							allowOutsideClick: false
						}).then((result) => {

							if (result.value) {

								$("div#supplier_account").modal("hide");
								location.reload();
							}
						});
					} else if (response == "exist") {

						Swal(
							'Exist',
							'Username already exist. Please generate another username!',
							'warning'
						);
					} else {

						console.log(response);
					}
				});
		});

		$("form#edit_tag_ac_form").submit(function(event) {

			event.preventDefault();
			let formData = $(this).serialize();

			let supplier_type = null,
				alturas_agency = null,
				colonnade_agency = null,
				colonnade_company = null,
				alturas_company = null;

			supplier_type = $("input[name = 'supplier_type']").val();
			if (supplier_type == 1) {

				alturas_agency = $("select[name = 'alturas_agency']").val();
				colonnade_agency = $("select[name = 'colonnade_agency']").val();

				if (alturas_agency === "" && colonnade_agency === "") {
					Swal(
						'Warning',
						'Please fill-up Agency either Bohol or Colonnade Server or both!',
						'warning'
					);

					return
				}

			} else {

				colonnade_company = $("select[name = 'colonnade_company']").val();
				alturas_company = $("select[name = 'alturas_company']").val();

				if (colonnade_company === "" && alturas_company === "") {
					Swal(
						'Warning',
						'Please fill-up Company either Bohol or Colonnade Server or both!',
						'warning'
					);

					return
				}
			}

			$.post("<?php echo site_url('update_supplier_account'); ?>",
				formData,
				function(data, status) {

					var response = data.trim();
					if (response == "success") {

						Swal({
							title: 'Success!',
							text: 'Supplier Account has been updated!',
							type: 'success',
							allowOutsideClick: false
						}).then((result) => {

							if (result.value) {

								$("div#edit_tag_ac").modal("hide");
								location.reload();
							}
						});

					} else {

						console.log(response);
					}
				});
		});

		$("form#edit_tag_vendor_form").submit(function(event) {

			event.preventDefault();
			let formData = $(this).serialize();

			var cb = $("[name = 'editvendor_id[]']")
			var checkboxesChecked = [];
			// loop over them all
			for (var i = 0; i < cb.length; i++) {
				// And stick the checked ones onto an array...
				if (cb[i].checked) {
					checkboxesChecked.push(cb[i].value);
				}
			}

			if (checkboxesChecked.length === 0) {

				Swal(
					'Warning',
					'Please select atleast one vendor!',
					'warning'
				);
				return
			}

			$.post("<?php echo site_url('update_consignor_account'); ?>",
				formData,
				function(data, status) {

					var response = data.trim();
					if (response == "success") {

						Swal({
							title: 'Success!',
							text: 'Supplier Account has been updated!',
							type: 'success',
							allowOutsideClick: false
						}).then((result) => {

							if (result.value) {

								$("div#edit_tag_ac").modal("hide");
								location.reload();
							}
						});

					} else {

						console.log(response);
					}
				});
		});

		$("form#renew_contract_form").submit(function(event) {

			event.preventDefault();
			let formData = $(this).serialize();

			$.post("<?php echo site_url('renew_supplier_contract'); ?>",
				formData,
				function(data, status) {

					var response = data.trim();
					if (response == "success") {

						Swal({
							title: 'Success!',
							text: 'Supplier user contract has been updated!',
							type: 'success',
							allowOutsideClick: false
						}).then((result) => {

							if (result.value) {

								$("div#renew_contract").modal("hide");
								location.reload();
							}
						});
					} else {

						console.log(response);
					}
				});
		});
	});

	/* Formatting function for row details - modify as you need */
	function sup_format(d) {
		// `d` is the original data object for the row
		return '<table class="table table-bordered" cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;" width="100%">' +
			'<tr>' +
			'<td width="25%">Address:</td>' +
			'<td>' + d[6] + '</td>' +
			'</tr>' +
			'<tr>' +
			'<td>Email Address:</td>' +
			'<td>' + d[7] + '</td>' +
			'</tr>' +
			'<tr>' +
			'<td>Telephone:</td>' +
			'<td>' + d[8] + '</td>' +
			'</tr>' +
			'<tr>' +
			'<td>Mobile Phone:</td>' +
			'<td>' + d[9] + '</td>' +
			'</tr>' +
			'</table>';
	}

	/* Formatting function for row details - modify as you need */
	function format(d) {

		// `d` is the original data object for the row
		return '<table class="table table-hover table-bordered" width="100%" cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
			'<tr>' +
			'<td>Date From:</td>' +
			'<td>' + d[7] + '</td>' +
			'<td>Address:</td>' +
			'<td>' + d[10] + '</td>' +
			'</tr>' +
			'<tr>' +
			'<td>Date To:</td>' +
			'<td>' + d[8] + '</td>' +
			'<td>Email Address:</td>' +
			'<td>' + d[11] + '</td>' +
			'</tr>' +
			'<tr>' +
			'<td>Extension:</td>' +
			'<td>' + d[9] + '</td>' +
			'<td>Contact Number:</td>' +
			'<td>' + d[12] + '</td>' +
			'</tr>' +
			'</table>';
	}

	function inputField(name) {

		if ($("[name = '" + name + "']").val().trim() != "") {

			$("[name = '" + name + "']").removeClass("parsley-error").addClass("parsley-success");
		} else {

			$("[name = '" + name + "']").removeClass("parsley-success").addClass("parsley-error");
		}
	}

	function dp_todate(name) {

		var fromDate = $("input[name = 'fromDate']").val();

		if (fromDate == "") {

			$("input[name = '" + name + "']").val('');
			Swal(
				'Warning',
				'Please select From Date field first!',
				'warning'
			);
		} else {

			$("input[name = '" + name + "']").removeClass("parsley-error").addClass("parsley-success");
		}
	}

	function chked_(x) {

		if ($("input.chk_" + x).is(':checked')) {

			$("input.chkA_" + x).prop("checked", true);
		} else {

			$("input.chkA_" + x).prop("checked", false);
		}
	}

	function chk(i) {

		// $("input[name = 'triggerAll']").val('');
		var supplier_id = $("input[name = 'supplier_id']").val();
		var trigger = $("input[name = 'trigger']").val();
		var triggerAll = $("input[name = 'triggerAll']").val();

		if (i == 0) {

			if ($("input.chk_0").is(":checked")) {

				if (trigger == "" && triggerAll == "") {

					var count = $("input.chkC").length;
					var list_co = "";

					for (var x = 1; x <= count; x++) {

						if ($("input.chk_" + x).is(":checked")) {

							// do something 
						} else {

							$("input[name = 'triggerAll']").val("true");
							$("input.chk_" + x).trigger("click"); // turn it on
							list_co += $("input.chk_" + x).val() + "|";
						}
					}

					$.post("<?php echo site_url('insertAll_com_cut'); ?>", {
						supplier_id: supplier_id,
						list_co: list_co
					}, function(data, status) {

						var response = data.trim();
						if (response == "success") {

							$("input[name = 'trigger']").val('');
							$("input[name = 'triggerAll']").val('');
							Swal(
								'Success',
								'Cut-off(s) has been saved!',
								'success'
							);
						} else {

							console.log(response);
						}
					});
				}
			} else {

				if ((trigger == "true" && triggerAll == "") || (trigger == "" && triggerAll == "")) {

					var count = $("input.chkC").length;

					for (var x = 1; x <= count; x++) {

						if ($("input.chk_" + x).is(":checked")) {

							$("input.chk_" + x).trigger("click"); // turn it off
						}
					}

					$.post("<?php echo site_url('deleteAll_com_cut'); ?>", {
						supplier_id: supplier_id
					}, function(status, data) {

						var response = data.trim();
						if (response == "success") {

							$("input[name = 'trigger']").val('');
							$("input[name = 'triggerAll']").val('');
							Swal(
								'Deleted!',
								'Cutoff(s) has been deleted.',
								'success'
							);
						} else {

							console.log(response);
						}
					});
				}
			}
		} else {

			if (triggerAll == "") {

				if ($("input.chk_" + i).is(":checked")) {

					var cutoff = $("input.chk_" + i).val();

					$.post("<?php echo site_url('insert_com_cut'); ?>", {
						supplier_id: supplier_id,
						cutoff: cutoff
					}, function(data, status) {

						var response = data.trim();
						if (response == "success") {

							Swal(
								'Success',
								'Cut-off(s) has been saved!',
								'success'
							);
						} else {

							console.log(response);
						}
					});
				} else {

					var cutoff = $("input.chk_" + i).val();
					$.post("<?php echo site_url('delete_com_cut'); ?>", {
						supplier_id: supplier_id,
						cutoff: cutoff
					}, function(data, status) {

						var response = data.trim();
						if (response == "success") {

							Swal(
								'Deleted!',
								'Cutoff(s) has been deleted.',
								'success'
							);
						} else {

							console.log(response);
						}
					});
				}
			}
		}
	}

	function random_username(str_length) {

		var text = "";
		var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

		// random string for username
		for (var i = 0; i < str_length; i++) {

			text += possible.charAt(Math.floor(Math.random() * possible.length));
		}

		return text;
	}

	function random_password(str_length) {

		var text = "";
		var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

		// random string for password
		for (var i = 0; i < str_length; i++) {

			text += possible.charAt(Math.floor(Math.random() * possible.length));
		}

		return text;
	}
</script>