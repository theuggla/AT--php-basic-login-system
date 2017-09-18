<?php

	class LogoutView
	{
    	private static $logout = 'LogoutView::Logout';
		private static $messageId = 'LogoutView::Message';

		public function renderHeader() {
			return '<h2>Logged in</h2>';
		}

		public function renderNavigation() {
			return '';
		}

    	public function renderBody($message = '')
    	{
        	$response = $this->generateLogoutButtonHTML($message);
        	return $response;
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
    
    	//CREATE GET-FUNCTIONS TO FETCH REQUEST VARIABLES
    	private function getRequestUserName()
    	{
        	//RETURN REQUEST VARIABLE: USERNAME
    	}
	}
?>