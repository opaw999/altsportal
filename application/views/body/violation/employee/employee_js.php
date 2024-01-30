<script type="text/javascript">
	
	$(document).ready(function() {

		var first_cutoff = $("input[name = 'first_cutoff']").val();
		var dataTable = $('#dt_dtr').DataTable({

			"destroy" : true,
	        "ajax": {  
	            url: "<?php echo site_url('violation/display_cutoff'); ?>",  
	            type: "POST",
	            data: { cutoff:first_cutoff },
	        },  
	        "order": [[ 0, "desc" ]],
	        "columnDefs":[  
	            {  
	                "targets":[0, 1, 2],  
	                "orderable":false, 
	                "className": "text-center" 
	            },  
	        ],
	        "bPaginate": true,
            "bLengthChange": false,
            "bFilter": false,
            "bInfo": true,
            "bAutoWidth": true 
		});

		$("a.cutoff").click(function() {

			var id = this.id.split("_");
			var cutOff = id[1].trim();

			$("a.cutoff").removeClass('btn-danger').addClass('btn-primary');
			$("a#cutoff_"+cutOff).addClass("btn-danger");

			var dataTable = $('#dt_dtr').DataTable({

				"destroy" : true,
		        "ajax": {  
		            url: "<?php echo site_url('violation/display_cutoff'); ?>",  
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
		        ],
				"bPaginate": true,
	            "bLengthChange": false,
	            "bFilter": false,
	            "bInfo": true,
	            "bAutoWidth": true 
			});
		});

		$('#dt_dtr').on('click', 'a.record', function(){
			
		    if ( !$(this).parents('tr').hasClass('selected') ) {

		        $('tr.selected').removeClass('selected success');
		        $(this).parents('tr').addClass('selected success');
		    }
		    
		    var id = this.id;
		    var cutoff 	= $("input#cutoff_"+id).val();
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
		                url  : "<?php echo site_url('emp_violation_list'); ?>",
						data : { cutoff:cutoff, dateFrom:dateFrom, dateTo:dateTo },
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

		$('div#view_violation').on('hidden.bs.modal', function (e) {

		    $('body').addClass('modal-open');
		});

	});

	function employee_list(cutoff, server, dateFrom, dateTo) {

		var dataTable = $('#dt_emp_violation_list').DataTable({

			"destroy" : true,
			stateSave: true,
	        "ajax": {  
	            url: "<?php echo site_url('violation/view_employee_list'); ?>",  
	            type: "POST",
	            data: { cutoff:cutoff, server:server, dateFrom:dateFrom, dateTo:dateTo },
	        },  
	        "order": [[ 0, "asc" ]],
	        "columnDefs":[  
	            {  
	                "targets":[5],  
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

		$('#dt_emp_violation_list').off('click', 'a.view_emp_violation').on('click', 'a.view_emp_violation', function(){
			
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

	function view_image(id) {

		var server = $("input[name ='server']").val();

		$.ajax({
            type : "GET",
            url  : "<?php echo site_url('view_image'); ?>",
            data : { id:id, server:server },
            success : function(data){

            	var img = JSON.parse(data);

                $("div.violation_uploaded").html('<label>Date Uploaded: <strong>'+img[0].created_at+'</strong>');
                $("div.violation").html('<img src="<?php echo base_url(); ?>admins/'+img[0].image_path+'" loading="lazy" width="100%">');
            }
        });
	}

</script>