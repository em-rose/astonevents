window.onload = function(){
	var form = document.getElementById('sign_up');
	var fPassword = form.password;
	var sPassword = form.passwordCheck;
	var logform = document.getElementById('log_in');
	var loginPass = logform.password;
	
	
	var validate_password = function(){
		if(fPassword.value === sPassword.value){
			fPassword.setCustomValidity('');
		}
			
		else{
			fPassword.setCustomValidity('The two passwords must match');
		}
	};
	
	
	var incorrectPass = function(){
		loginPass.serCustomValidity('Password is incorrect');
	}
	
	
	fPassword.onchange = validate_password;
	sPassword.onchange = validate_password;
	
}
