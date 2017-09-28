<?php

namespace view;

    class RegisterView {

    	private static $name = 'RegisterView::UserName';
		private static $register = 'RegisterView::Register';
    	private static $password = 'RegisterView::Password';
		private static $passwordRepeat = 'RegisterView::PasswordRepeat';
    	private static $messageId = 'RegisterView::Message';
		
		public function getHTML($message, $lastUsernameTried) 
		{
			$response = $this->generateRegisterFormHTML($message, $lastUsernameTried);
        	return $response;
		}

		public function userWantsToViewForm() 
		{
    		return isset($_GET['register']);
  		}

		public function userWantsToRegister() 
		{
    		return isset($_POST[self::$register]);
  		}

		public function getAttemptedUsername()
    	{
        	return isset($_POST[self::$name]) ? $_POST[self::$name] : '' ;
    	}

		public function getAttemptedPassword()
    	{
        	return isset($_POST[self::$password]) ? $_POST[self::$password]: '' ;
    	}

		public function getAttemptedRepeatedPassword()
    	{
        	return isset($_POST[self::$passwordRepeat]) ? $_POST[self::$passwordRepeat]: '' ;
    	}

		private function generateRegisterFormHTML($message, $lastUsernameTried)
    	{
        	return '
				<form action="?register" method="post" enctype="multipart/form-data"> 
					<fieldset>
						<legend>Register a new user - Write username and password</legend>
						<p id="' . self::$messageId . '">' . $message . '</p>
					
						<label for="' . self::$name . '">Username :</label>
						<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="' . $lastUsernameTried . '"/>

						<label for="' . self::$password . '">Password :</label>
						<input type="password" id="' . self::$password . '" name="' . self::$password . '" />

						<label for="' . self::$passwordRepeat . '">Repeat password :</label>
						<input type="password" id="' . self::$passwordRepeat . '" name="' . self::$passwordRepeat . '" />
					
						<input type="submit" name="' . self::$register . '" value="register" />
					</fieldset>	
				</form>
			';
		}
    }
?>