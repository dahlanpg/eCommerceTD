function sendForm() {
    var attributs = document.getElementsByClassName("attributes");
    var textAttributs = "";
    for (var i = 0; i < attributs.length; ++i) {
        textAttributs += "<li>" + attributs[i].value + "</li>";
    }
    document.getElementById('attributesHidden').value = textAttributs;
     $("#successMsg").hide();
     $("#errorMsg").hide();

    document.getElementById("btn-register").disabled = true;
    var formProduct = document.getElementById("formProduct");
    var formData = new FormData(formProduct);

    $.ajax({
        url: 'scripts/addProduct.php',
        method: "POST",
        data: formData,

        cache: false,
        processData: false,
        contentType: false,

        success: function (result) {

            if (result.substring(0, 2) == "OK") {
                showMessageSuccess1(result);
                document.getElementById("btn-register").disabled = false;
                document.getElementById("formProduct").reset();
                document.getElementById('imgP1').src = "";
                document.getElementById('imgP2').src = "";
            }
            else
                 showMessageError1(result);
        },

        error: function (xhr) {
            showMessageError1(xhr.responseText);
            document.getElementById("btn-register").disabled = false;
        }
    });
}

function showMessageError1(message) {
    document.getElementById("errorMsg").innerHTML = message;
    $("#errorMsg").stop().fadeIn(200).delay(3000).fadeOut(200); 
}

function showMessageSuccess1(message) {
    document.getElementById('successMsg').innerHTML = message;
    $("#successMsg").stop().fadeIn(200).delay(3000).fadeOut(200);		
}	