<script type="text/javascript">

	$(document).ready(function() {

		setTimeout(function () {
			scrollToLatestMessage();
		}, 500);
		email_list();

		/*$('div.chat_list').click(function() {
			$('.chat_list.active_chat').removeClass('active_chat');
			$(this).addClass('active_chat');
			$('p.sender_msg').removeClass('thick');

			id = this.id.trim();
			view_supplier_messages(id);
			$('i#sign_'+id).hide();

			setTimeout(function () {
				scrollToLatestMessage();
			}, 100);
		});*/

		$('input.write_msg').keyup(function(event) {
		    if (event.keyCode === 13) {
		        $("button.msg_send_btn").click();
		    }
		});

		$("button.msg_send_btn").click(function() {
		  	
		  	var feedback = $('input.write_msg').val();
		  	var cc = $('input[name = "cc"]').val();
		
  	    	$.ajax({
  				method : 'post',
  				url: "<?php echo site_url('send_feedback'); ?>", 
  				data : { feedback:feedback, cc:cc },
  				success: function(result) {
  			    	
  			    	$('input.write_msg').val('');
  			    	email_list();
  			    	setTimeout(function () {
  			    		scrollToLatestMessage();
  			    	}, 500);
  				}
  			});
		});
	});
	function chat_list(id) {
		
		$('.chat_list.active_chat').removeClass('active_chat');
		$('#'+id).addClass('active_chat');
		$('p.sender_msg').removeClass('thick');

		updateActiveChat(id);
		view_supplier_messages(id);
		$('i#sign_'+id).hide();

		setTimeout(function () {
			scrollToLatestMessage();
		}, 100);
	}

	function scrollToLatestMessage() {

      	var messages = document.getElementById('msg_history')

      	setTimeout(function() {
			messages.scrollTop = messages.scrollHeight
		}, 500)
    }

    function email_list() {

    	$.ajax({
			method : 'get',
			url: "<?php echo site_url('supplier_chat_messages'); ?>",
			success: function(result) {
		    	$(".inbox_chat").html(result);
		    	var userId = $('.chat_list.active_chat').attr('id');
		    	view_supplier_messages(userId);
		    	scrollToLatestMessage();
			}
		});
    }

    function view_supplier_messages(id) {
    	if (id != null) {

	    	$.ajax({
				method : 'post',
				url: "<?php echo site_url('view_supplier_messages'); ?>", 
				data : { id:id },
				success: function(result) {
			    	$("div#msg_history").html(result);
				}
			});
		}
    }

    function updateActiveChat(id) {

    	$.ajax({
			method : 'post',
			url: "<?php echo site_url('update_active_chat'); ?>", 
			data : { id:id }
		});
    }
</script>