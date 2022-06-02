var modal;
function changeMyName()
{
    var errorMsg      = document.getElementById("errorMsg1");
    var divErrorMsg   = "#divErrorMsg1";
    var divSuccessMsg = "#divSuccessMsg1";
    var successMsg    = document.getElementById("successMsg1");
    var btn           = document.getElementById('btnChangeName');
    modal             = document.getElementById('myModalName');

    var name = document.getElementById('inputChangeName').value;
    if(name == ""){
        showMessageError("Campo inválido", errorMsg, divErrorMsg);
    }
    else{
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", "scripts/changeName.php?name=" + name, true);
        xmlhttp.onload = function ()
        {
            if (xmlhttp.status == 200)
            {
                if (xmlhttp.responseText == "ok")
                {
                     btn.disabled = true;
                     document.getElementById('nameClient').innerText = name;
                     name = name.split(" ")[0];
                     document.getElementById('welcome').innerText = "Olá, " + name;
                     document.getElementById('inputChangeName').value = "";
                     showMessageSuccess(name, successMsg, divSuccessMsg);
                }else{
                    showMessageError(xmlhttp.responseText, errorMsg, divErrorMsg);
                }
            }else{
                showMessageError(xmlhttp.responseText, errorMsg, divErrorMsg);
            }
        }

        xmlhttp.send();
    }
}

function changeMyEmail()
{
    var errorMsg      = document.getElementById("errorMsg2");
    var divErrorMsg   = "#divErrorMsg2";
    var divSuccessMsg = "#divSuccessMsg2";
    var successMsg    = document.getElementById("successMsg2");
    var btn           = document.getElementById('btnChangeEmail');
    modal             = document.getElementById('myModalMail');

    var email = document.getElementById('inputChangeEmail').value;
    if(email.indexOf('@') <= 0 || email.indexOf('.') <= 0 || email.indexOf(' ') >= 0){
        showMessageError("Email inválido", errorMsg, divErrorMsg);
    }
    else{
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", "scripts/changeEmail.php?email=" + email, true);
        xmlhttp.onload = function ()
        {
            if (xmlhttp.status == 200)
            {
                if (xmlhttp.responseText == "ok")
                {
                     btn.disabled = true;
                     document.getElementById('emailClient').innerText = email;
                     document.getElementById('inputChangeEmail').value = "";
                     showMessageSuccess(email, successMsg, divSuccessMsg);
                }else{
                    showMessageError(xmlhttp.responseText, errorMsg, divErrorMsg);
                }
            }else{
                showMessageError(xmlhttp.responseText, errorMsg, divErrorMsg);
            }
        }

        xmlhttp.send();
    }
}

function changeMyPhone()
{
    var errorMsg      = document.getElementById("errorMsg3");
    var divErrorMsg   = "#divErrorMsg3";
    var divSuccessMsg = "#divSuccessMsg3";
    var successMsg    = document.getElementById("successMsg3");
    var btn           = document.getElementById('btnChangePhone');
    modal             = document.getElementById('myModalPhone');

    var ddi = document.getElementById('inputChangeDDI').value;
    var ddd = document.getElementById('inputChangeDDD').value;
    var phone = document.getElementById('inputChangePhone').value;
    if(ddi.indexOf('+') > 0){
        showMessageError("DDI inválido", errorMsg, divErrorMsg);
        return false;
    }
    if(ddi.indexOf('+') == 0)
        ddi = ddi.split('+')[1];
    if(!$.isNumeric(ddi) || ddi.length != 2){
        showMessageError("DDI inválido", errorMsg, divErrorMsg);
    }
    else if(ddd.length != 2 || !$.isNumeric(ddd)){
        showMessageError("DDD inválido", errorMsg, divErrorMsg);
    }
    else if(phone.length != 9 || !$.isNumeric(phone)){
        showMessageError("Número inválido", errorMsg, divErrorMsg);
    }
    else{
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", "scripts/changePhone.php?ddi=" + ddi + "&ddd="+ddd + "&phone="+phone, true);
        xmlhttp.onload = function ()
        {
            if (xmlhttp.status == 200)
            {
                if (xmlhttp.responseText == "ok")
                {
                     btn.disabled = true;
                     var number = "+" + ddi + " " + ddd + " " + phone;
                     document.getElementById('phoneClient').innerText = number;
                     document.getElementById('inputChangeDDI').value = "";
                     document.getElementById('inputChangeDDD').value = "";
                     document.getElementById('inputChangePhone').value = "";
                     showMessageSuccess(number, successMsg, divSuccessMsg);
                }else{
                    showMessageError(xmlhttp.responseText, errorMsg, divErrorMsg);
                }
            }else{
                showMessageError(xmlhttp.responseText, errorMsg, divErrorMsg);
            }
        }

        xmlhttp.send();
    }
}

function showMessageError(message, errorMsg, divErrorMsg)
{
    errorMsg.innerHTML = message;
    $(divErrorMsg).stop().fadeIn(200).delay(2000).fadeOut(500); 
}

function showMessageSuccess(message, successMsg, divSuccessMsg)
{
    successMsg.innerHTML = message;
    $(divSuccessMsg).stop().fadeIn(200).delay(2000).fadeOut(500, function(){
        $(modal).hide(500, function(){
            $(this).modal('hide');
        });
    });		
}	    

