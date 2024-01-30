	<script type="text/javascript">
		
		$(document).ready(function() {

			get_default('basic_info');

			$("a.profile").click(function() {

				var code = $(this).attr('id');
				get_default(code);
			});

			$("form#dataProfilePic").submit(function(e) {
			    
			    e.preventDefault();    
			    var formData = new FormData(this);

			    $.ajax({
			        url: "<?php echo site_url('uploadProfilePic'); ?>",
			        type: 'POST',
			        data: formData,
			        success: function (data) {
			       
			            response = data.trim();
			            if(response == "success"){

			                swal({
			                  	title: "Updated!",
			                  	text: "Photo Successfully Updated!",
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
			        cache: false,
			        contentType: false,
			        processData: false
			    });
			});
		});

		function get_default(code) {

			$("a.profile").css("color", "#444");
			$("a#"+code).css("color", "rgb(0, 172, 172)");
			

			var userId = $("input[name = 'userId']").val();
			var supplier_name = $("input[name = 'supplier_name']").val();
			$.ajax({
			    url: "<?php echo site_url(); ?>"+code,
			    type: 'POST',
			    data: { userId:userId, supplier_name:supplier_name },
			    success: function (data) {

			    	$("div.content_").html(data);
			    }
			});
		}

		function clears(file,preview,clrbtn){

	        $("#"+file).val("");
	        // $('#'+preview).removeAttr('src');
	        $('#'+preview).attr("src", "<?php echo base_url('assets/img/user/user-1.png'); ?>");
	        $('#'+clrbtn).hide();
	    }

	    function changePhoto(file, photoid, change) {
	          	  	
      	  	$('#'+change).hide();
            $('#'+photoid).show();
	    }

	    function readURL(input, upload) {

        $('#clear'+upload).show();
        var res = validateForm(upload);
     
        if(res !=1){
            
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#photo'+upload).attr('src', e.target.result);
                }
                    reader.readAsDataURL(input.files[0]);
               }
            }
        else
        {
            $('#clear'+upload).hide();
            $('#photo'+upload).removeAttr('src');
        } 
    }

    function validateForm(imgid)
    {   
        var img =  $("#"+imgid).val();
        var res = '';
        var i = img.length-1;   
        while(img[i] != "."){
            res = img[i] + res;     
            i--;
        }   
        
        //checks the file format
        if(res != "PNG" && res != "jpg" && res !="JPG" && res != "png"){
            $("#"+imgid).val("");
            errDup('Invalid File Format. Take note on the allowed file!');
            return 1;
        }   

        //checks the filesize- should not be greater than 2MB
        var uploadedFile = document.getElementById(imgid);
        var fileSize = uploadedFile.files[0].size < 1024 * 1024 * 2;
        if(fileSize == false){
            $("#"+imgid).val("");
            errDup('The size of the file exceeds 2MB!')     
            return 1;
        }
    }
	</script>
</body>

</html>