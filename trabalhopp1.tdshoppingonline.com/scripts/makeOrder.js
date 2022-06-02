function makeOrder(methodPayment){
            var wishs = document.getElementsByClassName('inputQtd');
            if(wishs.length == 0){
                alert("O carrinho está vazio");
                return false;
            }
                
            var arrayQtds = [];

            for(var i = 0; i < wishs.length ; ++i){
                arrayQtds.push(wishs[i].value); //array com quantidades (em ordem do carrinho)
            }
            jsonArray = JSON.stringify(arrayQtds);
            $.ajax({
                url: 'scripts/makeOrder.php?methodPayment='+methodPayment,
                type: 'POST',
                async: true,
                data: {data : jsonArray},
                cache: false,
                success: function (result)
                {
                    if(result.substring(0,2) == "OK"){
                        $(".activePayment").hide(300, function(){
                            $(".paymentOptions").hide(300);
                            $(".successOrder").show(300);
                            $(".rowCart").hide();
                        })
                        document.querySelector('.circleProgress3').style.backgroundColor = "black";
                        document.querySelector('#thirdProgressLine').style.backgroundColor = "black";
                        document.querySelector('#fourthProgressLine').style.backgroundColor = "black";
                    }
                    else{
                        $(".activePayment").hide(300, function(){
                            $(".paymentOptions").hide(300);
                            $(".rowCart").hide();
                        })
                        refreshPageValues();
                        document.getElementsByClassName('subtotalPurchase')[0].innerText = "R$0,00";
                        document.getElementsByClassName('totalPurchase')[0].innerText = "R$0,00";
                        alert(result);
                    }
                },

                error: function (xhr, textStatus, error)
                {
                    alert(textStatus + error + xhr.responseText);
                }

            });
}
