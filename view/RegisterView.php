<?php
    class RegisterView {

    	private static $name = 'RegisterView::UserName';
    	private static $password = 'RegisterView::Password';
		private static $passwordRepeat = 'RegisterView::PasswordRepeat';
    	private static $messageId = 'RegisterView::Message';

        public function renderBody() {
            
        }

        private function generateRegisterFormHTML($message)
    	{
        	return '
				<form action="?register" method="post" > 
					<fieldset>
						<legend>Register a new user - Write username and password</legend>
						<p id="' . self::$messageId . '">' . $message . '</p>
					
						<label for="' . self::$name . '">Username :</label>
						<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="" />

						<label for="' . self::$password . '">Password :</label>
						<input type="password" id="' . self::$password . '" name="' . self::$password . '" />

						<label for="' . self::$keep . '">Keep me logged in  :</label>
						<input type="checkbox" id="' . self::$keep . '" name="' . self::$keep . '" />
					
						<input type="submit" name="' . self::$login . '" value="login" />
					</fieldset>	
				</form>
			';
    	}
    }
?>