<?php

namespace view;

	class LoginView implements IUseCaseView {
    	private static $login = 'LoginView::Login';
    	private static $logout = 'LoginView::Logout';
    	private static $name = 'LoginView::UserName';
    	private static $password = 'LoginView::Password';
    	private static $cookieName = 'LoginView::CookieName';
    	private static $cookiePassword = 'LoginView::CookiePassword';
    	private static $keep = 'LoginView::KeepMeLoggedIn';
    	private static $messageId = 'LoginView::Message';

		public function renderHeading() {
			return '<h2>Not logged in</h2>';
		}

		public function renderNavigation() {
			return '<a href="?register">Register a new user</a>';
		}

		public function renderBodyWithMessage($message = '', $lastUsername = '') {
        	$response = $this->generateLoginFormHTML($message, $lastUsername);
        	return $response;
    	}
    
    	private function generateLoginFormHTML($message, $lastUsername)
    	{
        	return '
				<form method="post" > 
					<fieldset>
						<legend>Login - enter Username and password</legend>
						<p id="' . self::$messageId . '">' . $message . '</p>
					
						<label for="' . self::$name . '">Username :</label>
						<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="' . $lastUsername . '"/>

						<label for="' . self::$password . '">Password :</label>
						<input type="password" id="' . self::$password . '" name="' . self::$password . '" />

						<label for="' . self::$keep . '">Keep me logged in  :</label>
						<input type="checkbox" id="' . self::$keep . '" name="' . self::$keep . '" />
					
						<input type="submit" name="' . self::$login . '" value="login" />
					</fieldset>	
				</form>
			';
    	}

		public function userWantsToLogin() {
    		return isset($_POST[self::$login]);
		}

		public function getUserCredentials() {
			$username = $this->getRequestUserName();
			$password = $this->getRequestPassword();
    		return array('username'=>$username, 'password'=>$password);
		}	
    
    	private function getRequestUserName()
    	{
        	return $_POST[self::$name];
    	}

		private function getRequestPassword()
    	{
        	return $_POST[self::$password];
    	}
	}
?>