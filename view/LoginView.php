<?php

namespace view;

	class LoginView {
    	private static $login = 'LoginView::Login';
    	private static $logout = 'LoginView::Logout';
    	private static $name = 'LoginView::UserName';
    	private static $password = 'LoginView::Password';
    	private static $cookieName = 'LoginView::CookieName';
    	private static $cookiePassword = 'LoginView::CookiePassword';
    	private static $keep = 'LoginView::KeepMeLoggedIn';
    	private static $messageId = 'LoginView::Message';

		public function getHTML(bool $isLoggedIn, string $message, string $lastUsernameTried) 
		{
			if ($isLoggedIn) 
			{
				$response = $this->generateLogoutButtonHTML($message);
			} 
			else 
			{
				$response = $this->generateLoginFormHTML($message, $lastUsernameTried);
			}
        	
        	return $response;
    	}

		public function userWantsToLogin() 
		{
    		return isset($_POST[self::$login]);
		}

		public function userWantsToLogout()
		{
  			return isset($_POST[self::$logout]);
  		}

		public function userWantsToKeepCredentials() 
		{
    		return isset($_POST[self::$keep]);
		}

		public function getLoginFormUsername()
    	{
        	return isset($_POST[self::$name]) ? $_POST[self::$name] : '' ;
    	}

		public function getLoginFormPassword()
    	{
        	return isset($_POST[self::$password]) ? $_POST[self::$password]: '' ;
    	}

		public function getCookieUsername()
    	{
        	return isset($_COOKIE[self::$cookieName]) ? $_COOKIE[self::$cookieName] : '' ;
    	}

		public function getCookiePassword()
    	{
        	return isset($_COOKIE[self::$cookiePassword]) ? $_COOKIE[self::$cookiePassword] : '' ;
    	}

		public function cookieCredentialsArePresent() 
		{
			return isset($_COOKIE[self::$cookieName]) && isset($_COOKIE[self::$cookiePassword]);
		}

		public function setCookieCredentials(string $username, string $password, $expiry) 
		{
			setcookie(self::$cookieName, $username, $expiry, "/");
			setcookie(self::$cookiePassword, $password, $expiry, "/");
		}	

		public function removeCookieCredentials() 
		{
			setcookie(self::$cookieName, "", time()-3600);
			setcookie(self::$cookiePassword, "", time()-3600);
		}

		private function generateLoginFormHTML($message, $lastUsernameTried)
    	{
        	return '
				<form method="post" > 
					<fieldset>
						<legend>Login - enter Username and password</legend>
						<p id="' . self::$messageId . '">' . $message . '</p>
					
						<label for="' . self::$name . '">Username :</label>
						<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="' . $lastUsernameTried . '"/>

						<label for="' . self::$password . '">Password :</label>
						<input type="password" id="' . self::$password . '" name="' . self::$password . '" />

						<label for="' . self::$keep . '">Keep me logged in  :</label>
						<input type="checkbox" id="' . self::$keep . '" name="' . self::$keep . '" />
					
						<input type="submit" name="' . self::$login . '" value="login" />
					</fieldset>	
				</form>
			';
    	}

		private function generateLogoutButtonHTML($message)
    	{
        	return '
				<form  method="post" >
					<p id="' . self::$messageId . '">' . $message .'</p>
					<input type="submit" name="' . self::$logout . '" value="logout"/>
				</form>
			';
    	}
	}
?>