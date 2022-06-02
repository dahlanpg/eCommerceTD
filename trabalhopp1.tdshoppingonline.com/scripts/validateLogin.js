function validateLogin()
{
	var user = document.forms["formRegister"]["emailLogin"].value;
	if (user == null || user == "") {
		alert("O campo email deve ser preenchido");
		return false;
	}
	var password = document.forms["formLogin"]["passwordLogin"].value;
	if (password == null || password == "") {
		alert("O campo senha deve ser preenchido");
		return false;
	}

	return true;
}