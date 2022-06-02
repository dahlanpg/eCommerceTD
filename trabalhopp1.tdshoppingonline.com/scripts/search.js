function refreshSearch(keywords){
    var xmlhttp = new XMLHttpRequest();

    var method = 'GET';
    var url = "scripts/search.php?keywords=" + keywords;
    xmlhttp.open(method, url, true);
    xmlhttp.onload = function () {
        if (xmlhttp.status == 200) {
            document.getElementById('searchResult').innerHTML = xmlhttp.responseText;
        }
        else {
             alert("Erro ao recuperar seus pedidos");
        }
    };

    xmlhttp.onerror = function () {
        alert("Ocorreu um erro ao processar a requisição");
    };

    xmlhttp.send();
 }

 document.getElementById('btnSearch').onclick = function(){
    keywords = document.getElementById('searchBar').value;
    refreshSearch(keywords);
}