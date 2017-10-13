<?php

namespace loginmodule\view;

class RegisterView
{

    private static $name = 'RegisterView::UserName';
    private static $register = 'RegisterView::Register';
    private static $password = 'RegisterView::Password';
    private static $passwordRepeat = 'RegisterView::PasswordRepeat';
    private static $messageId = 'RegisterView::Message';
        
    public function getHTML(string $message, string $lastUsernameTried) : string
    {
        $response = $this->generateRegisterFormHTML($message, $lastUsernameTried);
        return $response;
    }

    public function userWantsToViewForm() : bool
    {
        return isset($_GET['register']);
    }

    public function userWantsToRegister() : bool
    {
        return isset($_POST[self::$register]);
    }

    public function getAttemptedUsername() : string
    {
        $username = isset($_POST[self::$name]) ? $_POST[self::$name] : '';
        return $username;
    }

    public function getAttemptedPassword() : string
    {
        return isset($_POST[self::$password]) ? $_POST[self::$password]: '' ;
    }

    public function getAttemptedRepeatedPassword() : string
    {
        return isset($_POST[self::$passwordRepeat]) ? $_POST[self::$passwordRepeat]: '' ;
    }

    private function generateRegisterFormHTML(string $message, string $lastUsernameTried) : string
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
