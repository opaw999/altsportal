<script type="text/javascript">
	
	show_cas = function(casid)
	{		
		$.ajax({	    	
			url  : "<?php echo site_url('view_cas'); ?>",
            type: 'POST',
            data: { casid:casid },   
            success: function (data) { 				
            	$("#casdetails").html(data);
			},
	    });
	}
    
	$("a.vcodes").click(function() {
	    var id = this.id.split("_");
		var vcode = id[1].trim();
	
	    $.ajax({	    	
			url  : "<?php echo site_url('view_cas'); ?>",
            type: 'POST',
            data: { vcode:vcode },   
            success: function (data){ 	
            	$("#div_cas").html(data);
			},
	    });
	});
	
</script>