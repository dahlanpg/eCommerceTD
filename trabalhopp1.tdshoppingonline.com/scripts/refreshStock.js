function refreshStock() {
    var currentStock = currentProduct.children[4];
    var newStock = document.getElementById('inputQtd').value;
    var xmlhttp = new XMLHttpRequest();
    var method = 'GET';
    var url = "scripts/refreshStock.php?idProduct=" + currentIdProduct + "&newStock="+newStock;

    xmlhttp.open(method, url, true);
    xmlhttp.onload = function () {
        if(xmlhttp.responseText == "ok"){
            currentStock.innerHTML = "<span id='qtdTd'>"+newStock; + "</span>";
            showMessageSuccessQtd(newStock);
        }
        else{
            showMessageErrorQtd(xmlhttp.responseText);
        }
        };
    
    xmlhttp.onerror = function () {
        showMessageErrorQtd(xmlhttp.responseText);
    };
    
    xmlhttp.send();
}

function showMessageErrorQtd(message)
{
    document.getElementById("errorMsgQtd").innerHTML = message;
    $("#divErrorMsg").stop().fadeIn(200).delay(3000).fadeOut(200); 
}

function showMessageSuccessQtd(message)
{
    document.getElementById('successMsgQtd').innerHTML = message;
    $("#divSuccessMsgQtd").stop().fadeIn(200).delay(600).fadeOut(200, function(){
        $("#modalQtd").hide(200, function(){
            $(this).modal('hide');
        });
    });		
}	    
