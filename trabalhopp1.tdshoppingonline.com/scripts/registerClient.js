function registerClient()
	{
        if(!validateRegister())
            return false;
		$("#divSuccessMsg").hide();
		$("#divErrorMsg").hide();

		document.getElementsByClassName("btn-register")[0].disabled = true;    
		var formClient = document.getElementById("formRegister");
		var formData = new FormData(formClient);  

		$.ajax({
			url: 'scripts/registerClient.php',
			method: "POST",
			data: formData,
			
			cache: false,
			processData: false,  
			contentType: false,  

			success: function (result)
            {

				if (result.substring(0, 2) == "ok")
				{
					showMessageSuccess(" ");
					document.getElementsByClassName("btn-register")[0].disabled = false;
					document.getElementById("formRegister").reset(); 
				}
				else
					showMessageError(result);
			},

			error: function (xhr, status, error)
            {
                showMessageError(xhr.responseText);
				document.getElementsByClassName("btn-register")[0].disabled = false;
			}
		});
	}
	
	function showMessageError(message)
	{
		document.getElementById("errorMsg").innerHTML = message;
        //$("#divErrorMsg").stop().fadeIn(200).delay(3000).fadeOut(200); 
        $("#divErrorMsg").stop().fadeIn(200); 
	}
    
	function showMessageSuccess(message)
	{
        document.getElementById('successMsg').innerHTML = message;
		$("#divSuccessMsg").stop().fadeIn(200).delay(2000).fadeOut(200, function(){
            window.location.href = "login.php";
        });		
	}	    
	