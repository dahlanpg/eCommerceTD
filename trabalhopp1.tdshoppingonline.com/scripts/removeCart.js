var actualProductModal;
var allCartPart6 = document.querySelectorAll('.cartPart6 a');

function refreshPrice(){
	var prices = document.getElementsByClassName('Sub-total-Value');
	var subtotalPurchase = document.getElementsByClassName('subtotalPurchase');
	var totalPurchase = document.getElementsByClassName('totalPurchase');
	var total = 0.0;
	for(var i = 0 ; i < prices.length ; ++i){
		total += parseFloat(prices[i].innerHTML.split("R$")[1]);
		total = parseFloat(total.toFixed(2));
	}
	totalPurchase[0].innerHTML = "R$" + total;
	subtotalPurchase[0].innerHTML = "R$" + total;

	document.getElementsByClassName('subtotalPurchase')[0].innerText = "R$" + total;
	document.getElementsByClassName('totalPurchase')[0].innerText = "R$" + total;
	if(url == "myAccount.php"){
		refreshTicketPayment(total);
		refreshCreditPayment(total);
	}
}

refreshPrice();

for (var i = 2; i < allCartPart6.length; i += 3) { //take only the trashs buttons
	allCartPart6[i].onclick = function () {
		actualProductModal = this;
	}
}

	var confirmBtn = document.getElementsByClassName('btn-primary')[0];
	confirmBtn.onclick = function () {
		var row = actualProductModal.parentNode.parentNode.parentNode;
		var href = row.children[1].children[0].href;
		var idProduct = parseInt(href.split("idProduct=")[1]);

		var xmlhttp = new XMLHttpRequest();

		var method = 'GET';
		var url = "scripts/removeFromCart.php?idProduct=" + idProduct;
		xmlhttp.open(method, url, true);
		xmlhttp.onload = function () {
			if (xmlhttp.status == 200) {
				$(row).fadeOut(700, function () {
					row.parentNode.removeChild(row)
					refreshPrice();
					var cart = document.getElementsByClassName('productCart');
					if(cart.length > 0){
						document.querySelector('.circleProgress1').style.backgroundColor = "black";
						document.querySelector('#firstProgressLine').style.backgroundColor = "black";
					}else{
						document.querySelector('.circleProgress1').style.backgroundColor = "#e0e0e0";
						document.querySelector('#firstProgressLine').style.backgroundColor = "#e0e0e0";
						document.getElementsByClassName('btn-buy')[0].disabled = true;
						if(window.location.href == "myAccount.php" || window.location.href == "myAccount.php?for=2"){
							document.getElementsByClassName('btn-buy')[1].disabled = true;
							document.getElementsByClassName('btn-buy')[2].disabled = true;
							document.getElementById('btnClear').style.opacity = "0.4";
							document.getElementById('btnClear').style.cursor = "not-allowed";
						}
					}
				});
				
			}
			else {
				 alert("Nao foi possivel remover");
			}
		};

		xmlhttp.onerror = function () {
			alert("Ocorreu um erro ao processar a requisição");
		};

		xmlhttp.send();
	}