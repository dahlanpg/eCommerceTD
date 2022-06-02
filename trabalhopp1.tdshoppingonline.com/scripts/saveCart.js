function saveCart(idProduct, qtd) {
    var xmlhttp = new XMLHttpRequest();
    var url = "scripts/saveCart.php?idProduct=" + idProduct + "&qtd=" + qtd;
    xmlhttp.open("GET", url, true);
    xmlhttp.onload = function () {
        if (xmlhttp.responseText != "ok") {
           console.log("O carrinho nao pôde ser atualizado");
           window.location.href = "home.php";
        }
    };

    xmlhttp.onerror = function () {
        console.log("O carrinho nao pôde ser atualizado");
        window.location.href = "home.php";
    }

    xmlhttp.send();
}

function sumQuantity(button,idProduct, unitValue) {
    if(button.style.opacity != "0.4"){
        var value = parseInt(button.previousElementSibling.value);
        var max = parseInt(button.previousElementSibling.max);

        if (value < max) {
            button.style.opacity = "1";
            value++;
            button.previousElementSibling.value = value;
        }
        if (value == max) {
            button.style.opacity = "0.4";
        }
        if (value > 1)
            button.previousElementSibling.previousElementSibling.style.opacity = "1";
        
        saveCart(idProduct, value);

        refreshCartValues(button, unitValue, value);

    }
}

function subtractQuantity(button,idProduct, unitValue) {
    if(button.style.opacity != "0.4"){
        var value = parseInt(button.nextElementSibling.value);
        if (value > 1) {
            button.nextElementSibling.value = parseInt(value, 10) - 1;
            --value;
            button.nextElementSibling.nextElementSibling.style.opacity = "1";
        }
        if (value > 1) {
            button.style.opacity = "1";
        }
        else {
            button.style.opacity = "0.4";
        }

        saveCart(idProduct, value);

        refreshCartValues(button, unitValue, value);
        
    }
}

function refreshCartValues(button, unitValue, qtd){
    row = button.parentElement.parentElement.parentElement;
    row.children[5].children[0].innerText.split("R$")[1]; //subtotal text
    var total = unitValue * qtd;
    total = parseFloat(total.toFixed(2));
    row.children[5].children[0].innerText = "R$" + total; //subtotal row
    var subtotais = document.getElementsByClassName('Sub-total-Value');
    total = 0.0;
    for(var i = 0; i < subtotais.length ; ++i){
        total += parseFloat(subtotais[i].innerText.split("R$")[1]);
        total = parseFloat(total.toFixed(2));
    }
    document.getElementsByClassName('subtotalPurchase')[0].innerText = "R$" + total;
    document.getElementsByClassName('totalPurchase')[0].innerText = "R$" + total;
    refreshTicketPayment(total)
    refreshCreditPayment(total);
}

function refreshPageValues(){
        var inputs     = document.getElementsByClassName('inputQtd');
		var unitValues = document.getElementsByClassName('truePrice');
        var subvalues  = document.getElementsByClassName('Sub-total-Value');
        if(unitValues.length != 0){
            document.querySelector('.circleProgress1').style.backgroundColor = "black";
            document.querySelector('#firstProgressLine').style.backgroundColor = "black";
            document.getElementsByClassName('btn-buy')[0].disabled = false;
        }else{
            var btns = document.getElementsByClassName('btn-buy');
            for(var i =0; i < btns.length ; ++i){
                btns[i].disabled = true;
            }
            if(url == "cart.php"){
                document.getElementById('btnClear').style.opacity = "0.4";
                document.getElementById('btnClear').style.cursor = "not-allowed";
            }
        }
		for(var i = 0; i < unitValues.length ; ++i){
			var subtotal = 0.0;
			subtotal += parseFloat(unitValues[i].innerText.split("R$")[1])*parseInt(inputs[i].value);
            subtotal = parseFloat(subtotal.toFixed(2));
            subvalues[i].innerHTML = "R$" + subtotal;

			if(inputs[i].value == 1){
				inputs[i].previousElementSibling.style.opacity = "0.4";
			}
			if(inputs[i].value == inputs[i].max){
				inputs[i].nextElementSibling.style.opacity = "0.4";
			}
		}
    }