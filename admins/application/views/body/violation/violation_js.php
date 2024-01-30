<!-- ================== BEGIN PAGE LEVEL JS ================== -->
<script src="<?php echo base_url('assets/plugins/DataTables/media/js/jquery.dataTables.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/DataTables/media/js/dataTables.bootstrap.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/DataTables/extensions/Scroller/js/dataTables.scroller.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/DataTables/extensions/Responsive/js/dataTables.responsive.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/demo/table-manage-default.demo.min.js'); ?>"></script>

<!-- ================== END PAGE LEVEL JS ================== -->

<script type="text/javascript">
		
	$(document).ready(function() {

		$.post("<?php echo site_url('dataTable_script'); ?>", { request:"dataTable" }, function(data, status){
		    
		    $("head").append(data);
		});

		var first_cutoff = $("input[name = 'first_cutoff']").val();
		var dataTable = $('#dt_dtr').DataTable({

			"destroy" : true,
	        "ajax": {  
	            url: "<?php echo site_url('display_cutoff'); ?>",  
	            type: "POST",
	            data: { cutoff:first_cutoff },
	        },  
	        "order": [[ 0, "desc" ]],
	        "columnDefs":[  
	            {  
	                 "targets":[0, 1, 2],  
	                 "orderable":false, 
	                 "className": "text-center" 
	            }
	        ]
		});

		$("a.cutoff").click(function() {

			var id = this.id.split("_");
			var cutOff = id[1].trim();

			$("a.cutoff").removeClass('btn-danger').addClass('btn-info');
			$("a#cutoff_"+cutOff).removeClass('btn-info').addClass("btn-danger");

			var dataTable = $('#dt_dtr').DataTable({

				"destroy" : true,
		        "ajax": {  
		            url: "<?php echo site_url('display_cutoff'); ?>",  
		            type: "POST",
		            data: { cutoff:cutOff },
		        },  
		        "order": [[ 0, "desc" ]],
		        "columnDefs":[  
		            {  
		                 "targets":[0, 1, 2],  
		                 "orderable":false,
		                 "className": "text-center"  
		            },  
		        ]
			});
		});

		$('#dt_dtr').on('click', 'a.record', function(){
			
		    if ( !$(this).parents('tr').hasClass('selected') ) {

		        $('tr.selected').removeClass('selected success');
		        $(this).parents('tr').addClass('selected success');
		    }
		    
		    var id = this.id;
		    var cutoff 	= $("input#cutoff_"+id).val();
		    var cut 	= $("input#cut_"+id).val();
		    var dateFrom= $("input#dateFrom_"+id).val();
		    var dateTo 	= $("input#dateTo_"+id).val();

		    $("#view_employee").modal({
		        backdrop: 'static', 
		        keyboard: false
		    });

		    $("#view_employee").modal("show");

		    $("span#emp_cutoff").html('');
		    $("div.view_employee").html('<center><img src="<?php echo base_url('assets/img/gif/loader_seq.gif'); ?>"></center>');
		    $.ajax({
		        type : "POST",
		        url  : "<?php echo site_url('cutoff'); ?>",
		        data : { dateFrom:dateFrom, dateTo:dateTo },
		        success : function(data){

		            $("span#emp_cutoff").html(data);

		            $.ajax({
						type : "POST",	
		                url  : "<?php echo site_url('company_list'); ?>",
						data : { cutoff:cutoff, cut:cut, dateFrom:dateFrom, dateTo:dateTo },
						beforeSend: function(){

	                        $("div.view_employee").html('<center><img src="<?php echo base_url('assets/img/gif/loader_seq.gif'); ?>"></center>');
	                    },
		                success : function(data){

		                    $("div.view_employee").html(data);
		                }
		            });
		        }
		    });   
		});

		$("form#upload_pv").submit(function(e) {

			e.preventDefault();
			$("button.upload_violation").prop("disabled", true);
			var formData = new FormData(this);
			var request = XMLHttpRequest();

			var values = $(this).serializeArray();
			request.open("POST", "<?php echo site_url('upload_violation'); ?>");
			request.onreadystatechange = function() {
			    if (this.readyState == 4 && this.status == 200) {
			      
			      	if(this.responseText == "success") {

			      		Swal({
		  		 		  	title: 'Success!',
		  		 		  	text: 'Promo Violation has successfully uploaded!',
		  		 		  	type: 'success',
		  		 		  	allowOutsideClick: false
		  		 		}).then((result) => {

		  		 			$("button.upload_violation").prop("disabled", false);
		  		 			$("div#upload_violation").modal("hide");

		  		 			company_list(values[0].value, values[4].value, values[1].value, values[2].value);
		  		 		});
			      	}
			    } 
			};
			request.send(formData);
		
		});

		$("form#delete_pv").submit(function(e) {

			e.preventDefault();
			$("button.delete_violation").prop("disabled", true);

			var formData = $(this).serialize();
			var values = $(this).serializeArray();
			console.log(values);

			Swal({
			  	title: 'Are you sure?',
			  	text: "You won't be able to revert this!",
			  	type: 'warning',
			  	showCancelButton: true,
			  	confirmButtonColor: '#3085d6',
			  	cancelButtonColor: '#d33',
			  	confirmButtonText: 'Yes, delete it!'
			}).then((result) => {

			  	if (result.value) {
			  	  	
	  	  			$.ajax({
	  	  	            type : "POST",
	  	  	            url  : "<?php echo site_url('delete_violation'); ?>",
	  	  	            data : formData,
	  	  	            success : function(data){

	  	  	                Swal({
	  	  	  		 		  	title: 'Deleted!',
	  	  	  		 		  	text: 'Promo Violation has been deleted!',
	  	  	  		 		  	type: 'success',
	  	  	  		 		  	allowOutsideClick: false
	  	  	  		 		}).then((result) => {

	  	  	  		 			$("button.delete_violation").prop("disabled", false);
	  	  	  		 			if (data > 0) {

	  	  	  		 				$.ajax({
	  	  	  		 				    type : "POST",
	  	  	  		 				    url  : "<?php echo site_url('view_violation'); ?>",
	  	  	  		 				    data : { empId:values[0].value, dateFrom:values[3].value, dateTo:values[4].value, server:values[2].value, cutoff:values[1].value },
	  	  	  		 				    success : function(data){

	  	  	  		 				        $("div.view_violation").html(data);
	  	  	  		 				    }
	  	  	  		 				});

	  	  	  		 			} else {

	  	  	  		 				$("div#view_violation").modal("hide");

		  	  	  		 			company_list(values[1].value, values[2].value, values[3].value, values[4].value);
	  	  	  		 			}
	  	  	  		 		});
	  	  	            }
	  	  	        });
			  	} else {
	
			  		$("button.delete_violation").prop("disabled", false);
			  	}
			});
		});

		$('div#upload_violation').on('hidden.bs.modal', function (e) {

		    $('body').addClass('modal-open');
		});

		$('div#view_violation').on('hidden.bs.modal', function (e) {

		    $('body').addClass('modal-open');
		});

	});

	function employee_list(cutoff, server, dateFrom, dateTo) {

		var dataTable = $('#dt_emp_list').DataTable({

			"destroy" : true,
			stateSave: true,
	        "ajax": {  
	            url: "<?php echo site_url('view_employee_list'); ?>",  
	            type: "POST",
	            data: { cutoff:cutoff, server:server, dateFrom:dateFrom, dateTo:dateTo },
	        },  
	        "order": [[ 0, "asc" ]],
	        "columnDefs":[  
	            {  
	                "targets":[5],  
	                "orderable":false, 
	                "width": "12%",
	                "className": "text-center" 
	            }, 
	            {
	            	"targets":[0, 1],
	            	"orderable":false,  
	                "width": "20%"
	            },
	            {
	            	"targets":[2, 3, 4],
	            	"orderable":false
	            }
	        ]
		});

		$('#dt_emp_list').off('click', 'a.upload_violation').on('click', 'a.upload_violation', function(){
			
		    if ( !$(this).parents('tr').hasClass('selected') ) {

		        dataTable.$('tr.selected').removeClass('selected success');
		        $(this).parents('tr').addClass('selected success');
		    }
		    
		    $("#upload_violation").modal({
		        backdrop: 'static', 
		        keyboard: false
		    });

		    $("#upload_violation").modal("show");

		    var empId = this.id.split('_')[1];
		    var dateFrom= $("input[name = 'dateFrom']").val();
		    var dateTo 	= $("input[name = 'dateTo']").val();
		    var cut 	= $("input[name = 'cut']").val();
		    var server  = $("input[name = 'server']").val();
		    var cutoff  = $("input[name = 'cutoff']").val();

		    $("span#emp_cutoff").html('');
		    $("div.upload_violation").html('<center><img src="<?php echo base_url('assets/img/gif/loader_seq.gif'); ?>"></center>');
			$.ajax({
			    type : "POST",
			    url  : "<?php echo site_url('cutoff'); ?>",
			    data : { dateFrom:dateFrom, dateTo:dateTo },
			    success : function(data){

			        $("span#emp_cutoff").html(data);

			        $.ajax({
			            type : "POST",
			            url  : "<?php echo site_url('upload_violation_form'); ?>",
			            data : { empId:empId, dateFrom:dateFrom, dateTo:dateTo, cut:cut, server:server, cutoff:cutoff },
			            success : function(data){

			                $("div.upload_violation").html(data);
			            }
			        });
			    }
			});   
		});

		$('#dt_emp_list').off('click', 'a.view_violation').on('click', 'a.view_violation', function(){
			
		    if ( !$(this).parents('tr').hasClass('selected') ) {

		        dataTable.$('tr.selected').removeClass('selected success');
		        $(this).parents('tr').addClass('selected success');
		    }
		    
		    $("#view_violation").modal({
		        backdrop: 'static', 
		        keyboard: false
		    });

		    $("#view_violation").modal("show");

		    var empId = this.id.split('_')[1];
		    var dateFrom= $("input[name = 'dateFrom']").val();
		    var dateTo 	= $("input[name = 'dateTo']").val();
		    var server  = $("input[name = 'server']").val();
		    var cutoff  = $("input[name = 'cutoff']").val();

		    $("span#emp_cutoff").html('');
		    $("div.view_violation").html('<center><img src="<?php echo base_url('assets/img/gif/loader_seq.gif'); ?>"></center>');
			$.ajax({
			    type : "POST",
			    url  : "<?php echo site_url('cutoff'); ?>",
			    data : { dateFrom:dateFrom, dateTo:dateTo },
			    success : function(data){

			        $("span#emp_cutoff").html(data);

			        $.ajax({
			            type : "POST",
			            url  : "<?php echo site_url('view_violation'); ?>",
			            data : { empId:empId, dateFrom:dateFrom, dateTo:dateTo, server:server, cutoff:cutoff },
			            success : function(data){

			                $("div.view_violation").html(data);
			            }
			        });
			    }
			});   
		});
	}

	function company_list(cutoff, server, dateFrom, dateTo) {

		var dataTable = $('#dt_sup_violation_list').DataTable({

			"destroy" : true,
			stateSave: true,
	        "ajax": {  
	            url: "<?php echo site_url('view_company_list'); ?>",  
	            type: "POST",
	            data: { cutoff:cutoff, server:server, dateFrom:dateFrom, dateTo:dateTo },
	        },  
	        "order": [[ 0, "asc" ]],
	        "columnDefs":[  
	            {  
	                "targets":[1],  
	                "orderable":false, 
	                "width": "12%",
	                "className": "text-center" 
	            }, 
	            {
	            	"targets":[0],
	            	"orderable":false,  
	                "width": "20%"
	            }
	        ]
		});

		$('#dt_sup_violation_list').off('click', 'a.upload_violation').on('click', 'a.upload_violation', function(){
			
		    if ( !$(this).parents('tr').hasClass('selected') ) {

		        dataTable.$('tr.selected').removeClass('selected success');
		        $(this).parents('tr').addClass('selected success');
		    }
		    
		    $("#upload_violation").modal({
		        backdrop: 'static', 
		        keyboard: false
		    });

		    $("#upload_violation").modal("show");

		    var pc_code = this.id.split('_')[1];
		    var dateFrom= $("input[name = 'dateFrom']").val();
		    var dateTo 	= $("input[name = 'dateTo']").val();
		    var cut 	= $("input[name = 'cut']").val();
		    var server  = $("input[name = 'server']").val();
		    var cutoff  = $("input[name = 'cutoff']").val();

		    $("span#emp_cutoff").html('');
		    $("div.upload_violation").html('<center><img src="<?php echo base_url('assets/img/gif/loader_seq.gif'); ?>"></center>');
			$.ajax({
			    type : "POST",
			    url  : "<?php echo site_url('cutoff'); ?>",
			    data : { dateFrom:dateFrom, dateTo:dateTo },
			    success : function(data){

			        $("span#emp_cutoff").html(data);

			        $.ajax({
			            type : "POST",
			            url  : "<?php echo site_url('upload_violation_form'); ?>",
			            data : { pc_code:pc_code, dateFrom:dateFrom, dateTo:dateTo, cut:cut, server:server, cutoff:cutoff },
			            success : function(data){

			                $("div.upload_violation").html(data);
			            }
			        });
			    }
			});   
		});

		$('#dt_sup_violation_list').off('click', 'a.view_violation').on('click', 'a.view_violation', function(){
			
		    if ( !$(this).parents('tr').hasClass('selected') ) {

		        dataTable.$('tr.selected').removeClass('selected success');
		        $(this).parents('tr').addClass('selected success');
		    }
		    
		    $("#view_violation").modal({
		        backdrop: 'static', 
		        keyboard: false
		    });

		    $("#view_violation").modal("show");

		    var pc_code = this.id.split('_')[1];
		    var dateFrom= $("input[name = 'dateFrom']").val();
		    var dateTo 	= $("input[name = 'dateTo']").val();
		    var server  = $("input[name = 'server']").val();
		    var cutoff  = $("input[name = 'cutoff']").val();

		    $("span#emp_cutoff").html('');
		    $("div.view_violation").html('<center><img src="<?php echo base_url('assets/img/gif/loader_seq.gif'); ?>"></center>');
			$.ajax({
			    type : "POST",
			    url  : "<?php echo site_url('cutoff'); ?>",
			    data : { dateFrom:dateFrom, dateTo:dateTo },
			    success : function(data){

			        $("span#emp_cutoff").html(data);

			        $.ajax({
			            type : "POST",
			            url  : "<?php echo site_url('view_violation'); ?>",
			            data : { pc_code:pc_code, dateFrom:dateFrom, dateTo:dateTo, server:server, cutoff:cutoff },
			            success : function(data){

			                $("div.view_violation").html(data);
			            }
			        });
			    }
			});   
		});
	}

	function view_image(id) {

		$.ajax({
            type : "GET",
            url  : "<?php echo site_url('view_image'); ?>",
            data : { id:id },
            success : function(data){

            	var img = JSON.parse(data);

                $("div.violation_uploaded").html('<label>Date Uploaded: <strong>'+img[0].created_at+'</strong>');
                $("div.violation").html('<img src="<?php echo base_url(); ?>'+img[0].image_path+'" loading="lazy" width="100%">');
            }
        });
	}
</script>