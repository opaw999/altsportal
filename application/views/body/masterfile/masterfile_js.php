<script type="text/javascript">
	
	$(document).ready(function() {

		var dataTable = $('#dt_masterfile').DataTable({

			"destroy" : true,
	        "ajax": {  
	            url: "<?php echo site_url('view_masterfile'); ?>",  
	            type: "POST",
	            data: { server:"tagbilaran" },
	        },  
	        "order": [[ 0, "asc" ]],
	        "columnDefs":[  
	            {  
	                "targets":[4, 6],  
	                "orderable":false, 
	                "className": "text-center" 
	            }, 
	            {
		         	"targets":[5],  
		            "orderable":false, 
		            "className": "text-center",
		            "width": "12%"
		        },
	            {
	            	"targets":[0, 1],
	            	"orderable":false,  
	                "width": "20%"
	            },
	            {
	            	"targets":[2, 3],
	            	"orderable":false
	            }
	        ],
    		"autoWidth" : true
		});

		$("a.server").click(function() {

			var id = $(this).attr('id');
			$("div.step").removeClass('active');
			$("div.step_"+id).addClass('active');
			$("input[name = 'server']").val(id);

			var dataTable = $('#dt_masterfile').DataTable({

				"destroy" : true,
		        "ajax": {  
		            url: "<?php echo site_url('view_masterfile'); ?>",  
		            type: "POST",
		            data: { server:id },
		        },  
		        "order": [[ 0, "asc" ]],
		        "columnDefs":[  
		            {  
		                "targets":[4, 6],  
		                "orderable":false, 
		                "className": "text-center" 
		            }, 
		            {
		            	"targets":[5],  
		                "orderable":false, 
		                "className": "text-center",
		                "width": "12%"
		            },
		            {
		            	"targets":[0, 1],
		            	"orderable":false,  
		                "width": "20%"
		            },
		            {
		            	"targets":[2, 3],
		            	"orderable":false
		            }
		        ],
	    		"autoWidth" : true
			});
		});

		$('#dt_masterfile').on('click', 'a.schedule', function(){
			
		    // var emp_type = dataTable.row($(this).parents('tr')).data()[4].toLowerCase();
		    if ( !$(this).parents('tr').hasClass('selected') ) {

		        $('tr.selected').removeClass('selected success');
		        $(this).parents('tr').addClass('selected success');
		    }
		
		    var id = this.id;
		    var month 	= $("input[name = 'month']").val();
			var year	= $("input[name = 'year']").val();
			var server	= $("input[name = 'server']").val();

			// $("input[name = 'emp_type']").val(emp_type);
			$("input[name = 'emp_id']").val(id);

		    $("#view_schedule").modal({
		        backdrop: 'static', 
		        keyboard: false
		    });

		    $("#view_schedule").modal("show");
		    $("div.view_schedule").html('<center><img src="<?php echo base_url('assets/img/gif/loader_seq.gif'); ?>"></center>');
		    $.ajax({
		        type : "POST",
		        url  : "<?php echo site_url('view_schedule'); ?>",
		        data : { emp_id:id, month:month, year:year, server:server },
		        beforeSend: function(){

                    $("div.view_employee").html('<center><img src="<?php echo base_url('assets/img/gif/loader_seq.gif'); ?>"></center>');
                },
		        success : function(data){

		            $("div.view_schedule").html(data);
		        }
		    });
		});
	});

	function view_sched2(month, year) {

		var empId 	= $("input[name = 'emp_id']").val();
		var server 	= $("input[name = 'server']").val();
		// var emp_type= $("input[name = 'emp_type']").val();

		$.ajax({
		    type : "POST",
		    url  : "<?php echo site_url('view_schedule'); ?>",
		    data : { emp_id:empId, month:month, year:year, server:server },
		    // data : { emp_id:empId, emp_type:emp_type, month:month, year:year, server:server },
		    success : function(data){

		        $("div.view_schedule").html(data);
		    }
		});
	}

	function view_sched(month, year){

		var empId 	= $("input[name = 'emp_id']").val();
		var server 	= $("input[name = 'server']").val();
		var emp_type= $("input[name = 'emp_type']").val();

		$("all_sched").html('<center><img src="<?php echo base_url('assets/img/gif/loader_seq.gif'); ?>"></center>');
        $.ajax({
            type:"POST",
            url:"<?php echo site_url('view_sched'); ?>",
            data : { empId:empId, month:month, year:year, server:server, emp_type:emp_type },
            beforeSend: function(){

                $(".all_sched").html('<center><img src="<?php echo base_url('assets/img/gif/loader_seq.gif'); ?>"></center>');
            },
            success:function(data){
                 
                 data = data.trim(); 
                 $(".all_sched").html(data);
            }
        
        });
	}

	function month_n(){

		var m_ = $("select[name = 'month_']").val();
		var y_ = $("select[name = 'year_']").val();
		view_sched2(m_,y_);
	}			

	function year_n(){

		var m_ = $("select[name = 'month_']").val();
		var y_ = $("select[name = 'year_']").val();
		view_sched2(m_,y_);
	}
	
</script>