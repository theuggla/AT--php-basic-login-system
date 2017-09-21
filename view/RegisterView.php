<?php

namespace view;

    class RegisterView implements IUseCaseView {

    	private static $name = 'RegisterView::UserName';
		private static $register = 'RegisterView::Register';
    	private static $password = 'RegisterView::Password';
		private static $passwordRepeat = 'RegisterView::PasswordRepeat';
		private static $message = 'RegisterView::Message';
    	private static $messageId = 'RegisterView::Message';

		 public function renderBodyWithMessage(bool $isLoggedIn = false, string $message = '') {
        	$response = $this->generateRegisterFormHTML($message);
        	return $response;
    	}

        private function generateRegisterFormHTML($message)
    	{
        	return '
				<form action="?register" method="post" enctype="multipart/form-data"> 
					<fieldset>
						<legend>Register a new user - Write username and password</legend>
						<p id="' . self::$messageId . '">' . $message . '</p>
					
						<label for="' . self::$name . '">Username :</label>
						<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="" />

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