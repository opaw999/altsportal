	<script type="text/javascript">
		
		$(document).ready(function() {

			$("form[name = 'contact_us_form']").submit(function(e) {

				e.preventDefault();
				var formData = new FormData(this);

				$("button#submit_btn").prop("disabled",true);
			    $.ajax({
			        url: "<?php echo site_url('submit_message'); ?>",
			        type: 'POST',
			        data: formData,
			        success: function (data) {

			            response = data.trim();
			            if(response == "success"){
			                
		                  	swal({
		                  	  	title: "Submitted!",
		                  	  	text: "Message was successfully submitted!",
		                  	  	type: "success",
		                  	  	confirmButtonClass: 'btn-success',
		                  	  	confirmButtonText: 'Success',
		                  	  	closeOnConfirm: false
		                  	},
		                  	function(isConfirm){
		                  	  	if (isConfirm){
		                  	  	  	
		                  	  	  	location.reload();
		                  	  	}
		                  	});
			            } else {

			            	alert(response);
			            }
			        },
			        async: false,
			        cache: false,
			        contentType: false,
			        processData: false
			    });
			});
		});
	</script>
</body>

</html>