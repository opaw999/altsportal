<script type="text/javascript">
	
	$(function() {

		$("form#data_username").submit(function(e) {

			e.preventDefault();
			var formData = $(this).serialize();

			$.ajax({
				url:"<?php echo site_url('submit_username'); ?>",
				type: "POST", 
				data: formData, 
				success: function(data){

					var response = data.trim();
					if (response == "success") {

						Swal({
		  		 		  	title: 'Success!',
		  		 		  	html: 'You have successfully change your username!<br> The system will logout and kindly log in again.<br> Thank You!',
		  		 		  	type: 'success',
		  		 		  	allowOutsideClick: false
		  		 		}).then((result) => {
		  		 		
		  		 			if (result.value) {

		  		 				window.location = "<?php echo site_url('logout'); ?>";
		  		 			}
		  		 		});
					} else if (response == "exist"){

						Swal(
		    			  	'Warning',
		    			  	'Username is already taken. Please use another username.',
		    			  	'warning'
		    			);
					} else if (response == "mismatch") {

						Swal({
	    				  	title: 'Warning!',
	    				  	text: 'Your current password inputed does not match with your current password!',
	    				  	type: 'warning',
	    				  	allowOutsideClick: false,
	    				  	customClass: 'animated tada'
	    				});
					} else {

						console.log(response);
					}
				}
			});
		});

		$("form#data_password").submit(function(e) {

			e.preventDefault();
			var formData = $(this).serialize();

			$.ajax({
				url:"<?php echo site_url('submit_password'); ?>",
				type: "POST", 
				data: formData, 
				success: function(data){

					var response = data.trim();
					if (response == "success") {

						Swal({
		  		 		  	title: 'Success!',
		  		 		  	html: 'You have successfully change your password!<br> The system will logout and kindly log in again.<br> Thank You!',
		  		 		  	type: 'success',
		  		 		  	allowOutsideClick: false
		  		 		}).then((result) => {
		  		 		
		  		 			if (result.value) {

		  		 				window.location = "<?php echo site_url('logout'); ?>";
		  		 			}
		  		 		});
					} else if (response == "mismatch") {

						Swal({
	    				  	title: 'Warning!',
	    				  	text: 'Your current password inputed does not match with your current password!',
	    				  	type: 'warning',
	    				  	allowOutsideClick: false,
	    				  	customClass: 'animated tada'
	    				});
					} else {

						console.log(response);
					}
				}
			});
		});
	});
</script>