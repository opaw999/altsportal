<script type="text/javascript">
 	
 	$(document).ready(function() {

		view_message();
		setTimeout(function () {
			scrollToLatestMessage();
		}, 500);

		$("button.msg_send_btn").click(function() {
		  	
		  	var message = $('textarea.write_msg').val();
		
  	    	$.ajax({
  				method : 'post',
  				url: "<?php echo site_url('send_message'); ?>", 
  				data : { message:message },
  				success: function(result) {
  			    	console.log(result);
  			    	$('textarea.write_msg').val('');
	    			view_message();
  			    	setTimeout(function () {
	    				scrollToLatestMessage();
	    			}, 500);
  				}
  			});
		});
 	});
	
	function scrollToLatestMessage() {

      	var messages = document.getElementById('msg_history')

      	setTimeout(function() {
			messages.scrollTop = messages.scrollHeight
		}, 500)
    }

    async function view_message() {
        
        const count = await $.ajax({
			method : 'post',
			url: "<?php echo site_url('read_all_messages'); ?>"
		});
	
	    $("span.total").html('0');
		
    	
    	$.ajax({
			method : 'post',
			url: "<?php echo site_url('view_message'); ?>", 
			success: function(result) {
		    	$("div#msg_history").html(result);
			}
		});

		scrollToLatestMessage();
    }
</script>