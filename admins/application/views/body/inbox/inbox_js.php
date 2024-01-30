<script type="text/javascript">
	
	$(document).ready(function() {

		$("div.view_message").show();
		$("div.view_message_detail").addClass("hide");
		var previous = $("input[name = 'prev_page']").val();
		var next = $("input[name = 'nxt_page']").val();

		$("ul.messages").html('<img src="<?php echo base_url('assets/img/gif/Fading squares.gif'); ?>" style="display:block;margin-left: auto;margin-right: auto; margin-top:242px; margin-bottom:242px;"></img>')
		$.ajax({
		    url: "<?php echo site_url('view_message'); ?>",
		    type: 'POST',
		    data: { previous:previous },
		    success: function (data) {

		    	$("ul.messages").html(data);
		    }
		});

		$("button.refresh").click(function() {

			location.reload();
		});

		$("button.previous").click(function() {
			
			$("div.view_message").show();
			$("div.view_message_detail").addClass("hide");
			var previous = $("input[name = 'prev_page']").val();
			var next = $("input[name = 'nxt_page']").val();

			$("input[name = 'prev_page']").val('');			
			$("input[name = 'nxt_page']").val('');

			if (previous != 0) {

				previous 	= (previous * 1) - 10;
				next 		= (next * 1) - 10;

				$("input[name = 'prev_page']").val(previous);			
				$("input[name = 'nxt_page']").val(next);

				$("ul.messages").html('<img src="<?php echo base_url('assets/img/gif/Fading squares.gif'); ?>" style="display:block;margin-left: auto;margin-right: auto; margin-top:242px; margin-bottom:242px;"></img>')
				$.ajax({
				    url: "<?php echo site_url('view_message'); ?>",
				    type: 'POST',
				    data: { previous:previous },
				    success: function (data) {

				    	$("ul.messages").html(data);
				    }
				});			
			} else  {

				if (previous == 0) {

					$("input[name = 'prev_page']").val(previous);			
					$("input[name = 'nxt_page']").val(next);
				} else {

					$("input[name = 'prev_page']").val(previous);			
					$("input[name = 'nxt_page']").val(next);
					$("ul.messages").html('<img src="<?php echo base_url('assets/img/gif/Fading squares.gif'); ?>" style="display:block;margin-left: auto;margin-right: auto; margin-top:242px; margin-bottom:242px;"></img>')
					$.ajax({
					    url: "<?php echo site_url('view_message'); ?>",
					    type: 'POST',
					    data: { previous:previous },
					    success: function (data) {

					    	$("ul.messages").html(data);
					    }
					});
				}
			}
		});

		$("button.next").click(function() {
			
			$("div.view_message").show();
			$("div.view_message_detail").addClass("hide");
			var previous = $("input[name = 'prev_page']").val();
			var next = $("input[name = 'nxt_page']").val();
			var count_msg = $("input[name = 'total_msg']").val();

			var page = (count_msg * 1) / 10;
			if (Number(page) === page && page % 1 !== 0) {

				page = (parseInt(page, 10) + 1);
				page2 = page * 10;
				if (next < page2) {

					previous 	= (previous * 1) + 10;
					next 		= (next * 1) + 10;

					$("input[name = 'prev_page']").val(previous);			
					$("input[name = 'nxt_page']").val(next);

					$("ul.messages").html('<img src="<?php echo base_url('assets/img/gif/Fading squares.gif'); ?>" style="display:block;margin-left: auto;margin-right: auto; margin-top:242px; margin-bottom:242px;"></img>')
					$.ajax({
					    url: "<?php echo site_url('view_message'); ?>",
					    type: 'POST',
					    data: { previous:previous },
					    success: function (data) {

					    	$("ul.messages").html(data);
					    }
					});
				} else {

					$("input[name = 'prev_page']").val(previous);			
					$("input[name = 'nxt_page']").val(next);
				}
			} else {

				page2 = page * 10;
				if (next < page2) {

					previous 	= (previous * 1) + 10;
					next 		= (next * 1) + 10;

					$("input[name = 'prev_page']").val(previous);			
					$("input[name = 'nxt_page']").val(next);
					
					$("ul.messages").html('<img src="<?php echo base_url('assets/img/gif/Fading squares.gif'); ?>" style="display:block;margin-left: auto;margin-right: auto; margin-top:242px; margin-bottom:242px;"></img>')
					$.ajax({
					    url: "<?php echo site_url('view_message'); ?>",
					    type: 'POST',
					    data: { previous:previous },
					    success: function (data) {

					    	$("ul.messages").html(data);
					    }
					});
				} else {

					$("input[name = 'prev_page']").val(previous);			
					$("input[name = 'nxt_page']").val(next);
				}
			}			
		});

		$("button.delete_email").click(function() {

			/*var values = $("input[name='chkId[]']")
              .map(function(){return $(this).val();}).get();*/

            var chk = $("input[name = 'chkId[]']");

            var newCHK = "";
            for(var i = 0;i<chk.length;i++) {

              	if(chk[i].checked == true) {
	
              	  	newCHK += chk[i].value+"*";
              	} 
            }

            $.ajax({
                url: "<?php echo site_url('delete_message'); ?>",
                type: 'POST',
                data: { newCHK:newCHK },
                success: function (response) {
 
                	response = response.trim();
                	if (response == "success") {

        		    	$.gritter.add({
	    	            	image: '<?php echo base_url('assets/plugins/gritter/images/warning.png'); ?>',
	    					title: 'Opsss!',
	    					text: 'Conversation Moved to Bin!'
	    				});
                	} else {

                		alert(response);
                	}
                }
            });
		});

		$("a.back_to_page").click(function() {

			$("input.msgId").val('');
			$("div.view_message").show();
			$("div.view_message_detail").addClass("hide");

			var previous = $("input[name = 'prev_page']").val();
			var next = $("input[name = 'nxt_page']").val();
			$("input[name = 'previous_page']").val('');
			$("input[name = 'next_page']").val('');

			$("ul.messages").html('<img src="<?php echo base_url('assets/img/gif/Fading squares.gif'); ?>" style="display:block;margin-left: auto;margin-right: auto; margin-top:242px; margin-bottom:242px;"></img>')

			var getAjaxResponse = $.post("<?php echo site_url('view_message'); ?>",
									{
										previous : previous
									},
									function(data,status){
									    
									    if (status == "success") {

									    	$("ul.messages").html(data);
									    }
									}
								);

			$.when(getAjaxResponse).then(function( data, textStatus, jqXHR) {

				$.ajax({
		    	    url: "<?php echo site_url('count_unread_msg'); ?>",
		    	    success: function (data) {

		    	    	$("span.count_unread_msg").html(data);
		    	    }
		    	});
			});
		});

		$("a.delete_spec_msg").click(function() {

			var msgId = $("input[name = 'msgId']").val();
			$.ajax({
			    url: "<?php echo site_url('delete_this_msg'); ?>",
			    type: 'POST',
			    data: { msgId:msgId },
			    success: function (response) {

			    	response = response.trim();
                	if (response == "success") {

        		    	$.gritter.add({
	    	            	image: '<?php echo base_url('assets/plugins/gritter/images/warning.png'); ?>',
	    					title: 'Opsss!',
	    					text: 'Conversation Moved to Bin!',

	    					// (function | optional) function called after it opens
	    					after_open: function(){
								setTimeout(function(){ location.reload(); }, 500);
							}
	    				});
                	} else {

                		alert(response);
                	}
			    }
			});
		});

		$("a.previous_details").click(function() {

			var row_position = $("input.row_position").val();
			row_position = (row_position * 1) - 1;
			previous = row_position - 1;
			next = row_position + 1;
			
			if (row_position >= 0) {

				$("input[name = 'previous_page']").val(previous);			
				$("input[name = 'next_page']").val(next);
				$("input.row_position").val(row_position);

				$.ajax({
				    url: "<?php echo site_url('view_message_detail'); ?>",
				    type: 'POST',
				    data: { row_position:(row_position - 1) },
				    success: function (data) {

				    	$("div.view_details").html(data);
				    }
				});
			}
		});

		$("a.next_details").click(function() {

			var total_msg = $("input[name = 'total_msg']").val();
			var row_position = $("input.row_position").val();

			row_position = (row_position * 1) + 1;
			total_msg = (total_msg * 1);
			previous = row_position - 1;
			next = row_position + 1;
			
			if (total_msg >= row_position) {

				$("input[name = 'previous_page']").val(previous);			
				$("input[name = 'next_page']").val(next);
				$("input.row_position").val(row_position);

				$.ajax({
				    url: "<?php echo site_url('view_message_detail'); ?>",
				    type: 'POST',
				    data: { row_position:(row_position + 1) },
				    success: function (data) {

				    	$("div.view_details").html(data);
				    }
				});
			}
		});
	});

	function view_details(msgId) {

		$("input[name = 'msgId']").val(msgId);
		$("div.view_message").hide();
		$("div.view_message_detail").removeClass("hide");

		$.ajax({
		    url: "<?php echo site_url('view_details'); ?>",
		    type: 'POST',
		    data: { msgId:msgId },
		    success: function (data) {

		    	$("div.view_details").html(data);
		    }
		});
	}
</script>