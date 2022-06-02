function validateRegister()
{
	var username = document.forms["formRegister"]["nameRegister"].value;
	if (username == null || username == "") {
		alert("O campo nome deve ser preenchido");
		return false;
	}

	var userGender = document.forms["formRegister"]["genderRegister"].value;
	if (userGender == "") {
		alert("Uma opcao de genero deve ser selecionada");
		return false;
	}

	var emailRegister = document.forms["formRegister"]["emailRegister"].value;
	if (emailRegister == null || emailRegister == "") {
		alert("O campo email deve ser preenchido");
		return false;
	}

	var cpfRegister = document.forms["formRegister"]["cpfRegister"].value;
	if (cpfRegister == null || cpfRegister == "") {
		alert("O campo cpf deve ser preenchido");
		return false;
	}

	var passwordRegister = document.forms["formRegister"]["passwordRegister"].value;
	if (passwordRegister == null || passwordRegister == "") {
		alert("O campo senha deve ser preenchido");
		return false;
	}

	var password2Register = document.forms["formRegister"]["password2Register"].value;
	if (password2Register != passwordRegister) {
		alert("As senhas digitadas não correspondem");
		return false;
	}

	if(password2Register.length < 6){
		alert("A senha precisa conter no minimo 6 digitos");
		return false;
	}

	var cepRegister = document.forms["formRegister"]["cpfRegister"].value;
	if (cepRegister == null || cepRegister == "") {
		alert("O campo cep deve ser preenchido");
		return false;
	}

	var publicAreaRegister = document.forms["formRegister"]["publicAreaRegister"].value;
	if (publicAreaRegister == null || publicAreaRegister == "") {
		alert("O campo logradouro deve ser preenchido");
		return false;
	}

	var districtRegister = document.forms["formRegister"]["districtRegister"].value;
	if (districtRegister == null || districtRegister == "") {
		alert("O campo bairro deve ser preenchido");
		return false;
	}

	var numberHouseRegister = document.forms["formRegister"]["numberHouseRegister"].value;
	if (numberHouseRegister == null || numberHouseRegister == "") {
		alert("O campo numero deve ser preenchido");
		return false;
	}

	var cityRegister = document.forms["formRegister"]["cityRegister"].value;
	if (cityRegister == null || cityRegister == "") {
		alert("O campo cidade deve ser preenchido");
		return false;
	}
	
	var stateRegister = document.forms["formRegister"]["stateRegister"].value;
	if (stateRegister == "") {
		alert("um estado deve ser selecionado");
		return false;
	}

	return true;
}