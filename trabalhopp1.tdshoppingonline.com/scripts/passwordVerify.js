function passwordVerify()
{
    var password1 = document.getElementById('passwordRegister').value;
    var password2 = document.getElementById('password2Register').value;

    var label = document.getElementById('labelPassword');
    if(password1 == "")
        label.innerText = "As senhas não correspondem";
    if(password2 != ""){
        if (password1 == password2){
            label.classList.toggle('text-danger');
            label.classList.add('text-success');
            label.innerText = "As senhas correspondem"; 
        }
        else{
            label.classList.toggle("text-success");
            label.classList.add('text-danger');
            label.innerText = "As senhas não correspondem";
            if(password2 == "")
                label.innerText = "";
        }
    }
}
