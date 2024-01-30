<script type="text/javascript">
	
	$("form#data_import").submit(function(e) {

		e.preventDefault();
		var formData = new FormData(this);

		var ext = $("input[name = 'imported_data']").val().split('.').pop().toLowerCase();
		if($.inArray(ext, ['zip','rar']) == -1) {
		    
	 		Swal({
	 		  	title: 'Warning!',
	 		  	text: 'Zip file is only allowed!',
	 		  	type: 'warning',
	 		  	allowOutsideClick: false
	 		}).then((result) => {
	 		
	 			if (result.value) {

	 				$("input[name = 'imported_data']").val('');
	 			}
	 		});
		} else {

			$("button.loading_").removeClass("btn-primary").addClass("btn-white");
			$("button.loading_").html('<img src="<?php echo base_url('assets/img/gif/PleaseWait.gif'); ?>" width="20" height="20"></img> Importing data...');

			$.ajax({
                url: "<?php echo site_url('import_data'); ?>",
                type: 'POST',
                data: formData,
                success: function (data) {

                	var response = data.trim();
                	if (response == "failure") {

		    			Swal({
		  		 		  	title: 'Warning!',
		  		 		  	text: 'Data has not imported :(.',
		  		 		  	type: 'warning',
		  		 		  	allowOutsideClick: false
		  		 		}).then((result) => {
		  		 		
		  		 			if (result.value) {

		  		 				location.reload();
		  		 			}
		  		 		});
		  		 		
                	} else {

	                	$("button.loading_").removeClass("btn-white").addClass("btn-primary");
	                	$("button.loading_").html("Import Data");
	                	$("input[name = 'imported_data']").val('');
	                	
			    		Swal(
		    			  	'Success',
		    			  	'Data has been imported',
		    			  	'success'
		    			);
	                }          
                },
                cache: false,
                contentType: false,
                processData: false
            });
		}
	});
</script>