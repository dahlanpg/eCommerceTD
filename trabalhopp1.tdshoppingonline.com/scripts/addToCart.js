function addToCart(idProduct, wrapper) {
    var xmlhttp = new XMLHttpRequest();
    var method = 'GET';
    var url = "scripts/addToCart.php?idProduct=" + idProduct;

    xmlhttp.open(method, url, true);
    xmlhttp.onload = function () {
        if (xmlhttp.status == 200) {
            $(wrapper).hide(500);
            if(xmlhttp.responseText != "erro")
                document.getElementById("itensCart").innerHTML = parseInt(document.getElementById("itensCart").innerHTML) + 1;
        } else{
             alert('erro');
        }
    };
    
    xmlhttp.onerror = function () {
        alert("Ocorreu um erro ao processar a requisição");
    };
    
    xmlhttp.send();
}