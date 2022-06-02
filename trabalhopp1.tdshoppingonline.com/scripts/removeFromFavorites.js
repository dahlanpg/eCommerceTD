var currentIdProduct;
var currentProductRow;

function removeFavorite() {
    var xmlhttp = new XMLHttpRequest();
    var method = 'GET';
    var url = "scripts/removeFromFavorites.php?idProduct=" + currentIdProduct;

    xmlhttp.open(method, url, true);
    xmlhttp.onload = function () {
        if(xmlhttp.responseText == "ok")
            $(currentProductRow).hide(500);
        else
            alert(xmlhttp.responseText);
    };
    
    xmlhttp.onerror = function () {
        alert("Ocorreu um erro ao processar a requisição");
    };
    
    xmlhttp.send();
}

function recordId(idProduct, productRow){
    currentIdProduct = idProduct;
    currentProductRow = productRow.parentElement.parentElement;
}