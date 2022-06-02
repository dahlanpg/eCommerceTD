function addToFavorites(idProduct, wrapper) {
    var xmlhttp = new XMLHttpRequest();
    var method = 'GET';
    var url = "scripts/addToFavorites.php?idProduct=" + idProduct;

    xmlhttp.open(method, url, true);
    xmlhttp.onload = function () {
        if (xmlhttp.status == 200) {
            if(xmlhttp.responseText == "ok"){
                $(wrapper).hide(500);
                document.getElementById("itensFavorites").innerHTML =
                parseInt(document.getElementById("itensFavorites").innerHTML) + 1;
            }
            else{
                if(xmlhttp.responseText == "Esse produto já está entre os seus favoritos")
                    alert(xmlhttp.responseText)
                else
                    window.location.href = "login.php";}
        } else{
            window.location.href = "login.php";
        }
    };
    
    xmlhttp.onerror = function () {
        alert("Ocorreu um erro ao processar a requisição");
    };
    
    xmlhttp.send();
}