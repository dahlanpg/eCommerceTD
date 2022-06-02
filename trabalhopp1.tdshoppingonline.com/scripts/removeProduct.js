var currentIdProduct = 0;
var currentProduct;

function removeProduct() {
    var xmlhttp = new XMLHttpRequest();
    var method = 'GET';
    var url = "scripts/removeProduct.php?idProduct=" + currentIdProduct;

    xmlhttp.open(method, url, true);
    xmlhttp.onload = function () {
        if(xmlhttp.responseText.substring(0,2) == "ok")
            $(currentProduct).hide(500);
    };
    
    xmlhttp.onerror = function () {
        alert("Ocorreu um erro ao processar a requisição");
    };
    
    xmlhttp.send();
}

function recordIdProduct(idProduct, productRow){
    currentIdProduct = idProduct;
    currentProduct = productRow.parentElement.parentElement;
}