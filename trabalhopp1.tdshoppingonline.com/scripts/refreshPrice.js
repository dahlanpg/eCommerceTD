function refreshPrice() {
    var currentPrice = currentProduct.children[3];
    var newPrice = document.getElementById('inputPrice').value;
    var xmlhttp = new XMLHttpRequest();
    var method = 'GET';
    var url = "scripts/refreshPrice.php?idProduct=" + currentIdProduct + "&newPrice="+newPrice;

    xmlhttp.open(method, url, true);
    xmlhttp.onload = function () {
        if(xmlhttp.responseText == "ok"){
            currentPrice.innerHTML = "R$" + newPrice;
            showMessageSuccessPrice("R$" + newPrice);
        }
        else
        showMessageErrorPrice(xmlhttp.responseText);
    };
    
    xmlhttp.onerror = function () {
        showMessageErrorPrice(xmlhttp.responseText);
    };
    
    xmlhttp.send();
}

function showMessageErrorPrice(message)
{
    document.getElementById("errorMsgPrice").innerHTML = message;
    $("#divErrorMsg").stop().fadeIn(200).delay(3000).fadeOut(200); 
}

function showMessageSuccessPrice(message)
{
    document.getElementById('successMsgPrice').innerHTML = message;
    $("#divSuccessMsgPrice").stop().fadeIn(200).delay(2000).fadeOut(200, function(){
        $("#modalPrice").hide(500, function(){
            $(this).modal('hide');
        });
    });		
}	    
