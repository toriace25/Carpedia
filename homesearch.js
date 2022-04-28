$(document).ready(function() {
	$('#make').change(function() {
		var make = $(this).val();
                if(make) {
			$.ajax({
				url:"action.php",
                                type:"GET",
                                cache:false,
                                data:{make:make},
                                success:function(data){
                                        $('#model').html(data);
                                        $('#year').html('<option value="">Choose Year</option>');
                                }
                        });
                }
                else {
                        $('#model').html('<option value="">Choose Model</option>');
                        $('#year').html('<option value="">Choose Year</option>');
                }
        });

        $("#model").on("change", function() {
                var model = $(this).val();
                if(model) {
                        $.ajax({
				url :"action.php",
                                type:"GET",
                                cache:false,
                                data:{model:model},
                                success:function(data){
                                        $("#year").html(data);
                                }
                        });
                }
                else {
                        $('#year').html('<option value="">Choose Year</option>');
                }
        });
});
