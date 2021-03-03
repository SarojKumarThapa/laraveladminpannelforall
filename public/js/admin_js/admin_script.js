$(document).ready(function(){
	// Check admin password is correct or not
	$("#current_pwd").keyup(function(){
		var current_pwd = $("#current_pwd").val();
		// alert(current_pwd);

		$.ajax({
			type:'post',
			url:'/admin/check-current-pwd',
			data:{current_pwd:current_pwd},
			success:function(resp){
				// alert(resp);
				if (resp=="false") {
					$("#chkCurrentPwd").html("<font color=red> Current Password is incorrect. </font>")
				} else if (resp == "true") {
					$("#chkCurrentPwd").html("<font color=green> Current Password is Correct. </font>")
				}
			},error:function(){
				alert("Error");
			}
		});
	});
});

// function previewFIle(input) {
// 	var file = $("input[type=file]").get(0).files[0];
// 	if(file)
// 	{
// 		var reader = new FileReader;
// 		reader.onload = function(){
// 			$('#previewImg').attr("src", reader.result);
// 		}
// 		reader.readAsDataURL(file);
// 	}
// }