function redirectProduct(id){
    window.location.href="product.php?idProduct="+id;
}
function showProducts(name)
{
    if(name == "")
        document.getElementById('productsList').innerHTML = "";
    else{
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", "scripts/showProducts.php?name=" + name, true);
        xmlhttp.onload = function (e)
        {
            if (xmlhttp.status == 200)
            {
                if (xmlhttp.responseText != "")
                {
                    try
                    {
                        document.getElementById('productsList').innerHTML = xmlhttp.responseText;
                    }
                    catch (e){
                        alert("A string retornada pelo servidor não é válida: " + xmlhttp.responseText);
                    }
                }
            }
        }

        xmlhttp.send();
    }
}
