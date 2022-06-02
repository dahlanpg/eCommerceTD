var buttons = document.getElementsByClassName('buttons-change-stock');
        for(var i = 0; i < buttons.length ; ++i){
            if(buttons[i].children[1].value == '1'){
                buttons[i].children[0].style.opacity = "0.4";
            }
            buttons[i].children[2].onclick = function(){
				var value = parseInt(this.previousElementSibling.value);
				var max = parseInt(this.previousElementSibling.max);
				
				if(value < max){
					this.style.opacity = "1";
					value++;
					this.previousElementSibling.value = value;
				}
				if(value == max){
					this.style.opacity = "0.4";
				}
				if(value > 1)
					this.previousElementSibling.previousElementSibling.style.opacity = "1";
            }
            buttons[i].children[0].onclick = function(){
                var value = parseInt(this.nextElementSibling.value);
                if(value > 1){
					this.nextElementSibling.value = parseInt(value, 10) - 1;
					--value;
                    this.nextElementSibling.nextElementSibling.style.opacity = "1";
                }
                if(value > 1){
                    this.style.opacity = "1";
                }
                else{
                    this.style.opacity = "0.4";
           		 }
			}
		}