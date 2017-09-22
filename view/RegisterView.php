<?php

namespace view;

    class RegisterView implements IUseCaseView {

    	private static $name = 'RegisterView::UserName';
		private static $register = 'RegisterView::Register';
    	private static $password = 'RegisterView::Password';
		private static $passwordRepeat = 'RegisterView::PasswordRepeat';
    	private static $messageId = 'RegisterView::Message';

		 public function getBodyWithMessage(string $message = '', bool $isLoggedIn = false) {
        	$response = $this->generateRegisterFormHTML($message);
        	return $response;
    	}

        private function generateRegisterFormHTML($message)
    	{
			$lastUsernameTried = $this->getRequestUsername();

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

		public function userWantsToViewForm() {
    		return isset($_GET['register']);
  		}

		public function userWantsToRegister() {
    		return isset($_POST[self::$register]);
  		}

		public function getUserCredentials() {
			$username = $this->getRequestUserName();
			$password = $this->getRequestPassword();
			$repeatPassword = $this->getRequestRepeatPassword();

    		return array('username'=>$username, 'password'=>$password, 'passwordRepeat'=>$repeatPassword);
		}

		private function getRequestUserName()
    	{
        	return isset($_POST[self::$name]) ? $_POST[self::$name] : '' ;
    	}

		private function getRequestPassword()
    	{
        	return isset($_POST[self::$password]) ? $_POST[self::$password]: '' ;
    	}

		private function getRequestRepeatPassword()
    	{
        	return isset($_POST[self::$passwordRepeat]) ? $_POST[self::$passwordRepeat]: '' ;
    	}
    }
?>