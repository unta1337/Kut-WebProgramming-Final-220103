<?php
	class LoginView {
		function login($view) {
			echo "
				<form name='login' method='post' action='$view'>
					<input type='text' name='id' /> <br>
					<input type='password' name='passwd' /> <br>
					<input type='submit' name='login' value='Login' />
					<input type='submit' name='signUp' value='Sign up' />
				</form>
			";
		}
	}
?>