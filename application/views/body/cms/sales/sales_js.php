<script type="text/javascript">

	$(document).ready(function() {
		var dataTable = $('#salesDtable').DataTable({});
	});
	
	toreview = function(compcode,date1,date2,vcode)
	{		
		$.ajax({	    	
			url  : "<?php echo site_url('view_items_sales'); ?>",
            type: 'POST',
            data: { compcode:compcode, date1:date1, date2:date2, vcode:vcode },   
            success: function (data) { 				
            	$("#modal_sales_report_details").html(data);
			},
	    });
	}
	
	
	$("a.vcodes").click(function() {
	    var id = this.id.split("_");
		var vcode = id[1].trim();
	   
	    $.ajax({	    	
			url  : "<?php echo site_url('view_sales'); ?>",
            type: 'POST',
            data: { vcode:vcode },   
            success: function (data) { 
               
            	$("#div_sales").html(data);
			},
	    });
	});

	
</script>