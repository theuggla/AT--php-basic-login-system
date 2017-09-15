<?php

	class LogoutView
	{
    	private static $logout = 'LogoutView::Logout';
    	private static $message = 'LogoutView::Message';
		private static $messageId = 'LogoutView::MessageId';

		public function renderHeader() {
			return '<h2>Logged in</h2>';
		}

		public function renderNavigation() {
			return '';
		}

    	public function renderBody()
    	{
        	$response .= $this->generateLogoutButtonHTML();
        	return $response;
    	}

    	private function generateLogoutButtonHTML()
    	{
        	return '
				<form  method="post" >
					<p id="' . self::$messageId . '">' . self::$message .'</p>
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