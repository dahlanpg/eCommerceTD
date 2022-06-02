function refreshTicketPayment(total){
    var discount = (0.15 * total).toFixed(2);
    document.getElementById('ticketDiscount').innerHTML = discount;
}

function refreshCreditPayment(total){
    var option = document.getElementById('inputFormPayment');

    option[0].innerHTML = "À vista - Até 15% de desconto - R$ " + (0.85*total).toFixed(2);
    option[1].innerHTML = "2x - Até 10% de desconto - R$ " + ((0.9*total)/2).toFixed(2);
    option[2].innerHTML = "3x - Até 5% de desconto - R$ " + ((0.95*total)/3).toFixed(2);
    var phrase = "x - sem juros - R$ ";
    for(var i = 4; i <= 12 ; ++i){
        option[i-1].innerHTML = i + phrase + (total/i).toFixed(2);
    }    
}