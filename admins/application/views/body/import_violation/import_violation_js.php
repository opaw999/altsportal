<script type="text/javascript">
	
	$("form#data_import_violation").submit(function(e) {

		e.preventDefault();
		$("button.import_btn").hide();
		$("button.loading_btn").show();


		var formData = new FormData(this);
		var values = $(this).serializeArray();
		
		var request = XMLHttpRequest();
		
		request.open("POST", "<?php echo site_url('import_violation_data'); ?>");
		request.onreadystatechange = function() {
		    if (this.readyState == 4 && this.status == 200) {
		      
		      	if(this.responseText == "success") {

		      		Swal({
	  		 		  	title: 'Success!',
	  		 		  	text: 'Data has been imported',
	  		 		  	type: 'success',
	  		 		  	allowOutsideClick: false
	  		 		}).then((result) => {

	  		 			$("button.import_btn").show();
						$("button.loading_btn").hide();
	  		 		});
		      	}
		    } else {

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
		    }
		};
		request.send(formData);
	
	});
</script>