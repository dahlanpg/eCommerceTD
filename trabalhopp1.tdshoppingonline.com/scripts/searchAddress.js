function searchAddress(zipcode)
{
    if (zipcode.length != 8)
        return;

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onload = function (e)
    {
        if (xmlhttp.status == 200)
        {
            if (xmlhttp.responseText != "")
            {
                try
                {
                    address = JSON.parse(xmlhttp.responseText);
                    document.forms[1]["publicAreaRegister"].value    = address.publicArea;
                    document.forms[1]["districtRegister"].value      = address.district;
                    document.forms[1]["cityRegister"].value          = address.city;
                }
                catch (e)
                {
                    alert("A string retornada pelo servidor não é um JSON válido: " + xmlhttp.responseText);
                }
            }
            // else
            //      alert("cep não encontrado");
        }
    }

    xmlhttp.open("GET", "scripts/searchAddress.php?zipcode=" + zipcode, true);
    xmlhttp.send();
}
