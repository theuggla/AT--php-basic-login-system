<?php

namespace view;

class LayoutView {

  private $dateTimeView;

  public function __construct(DateTimeView $dateTimeView)
  {
    $this->dateTimeView = $dateTimeView;
  }
  
  public function renderToOutput(bool $isLoggedIn, string $mainViewHTML) 
  {
      echo '<!DOCTYPE html>
      <html>
        <head>
          <meta charset="utf-8">
          <title>Login Example</title>
        </head>
        <body>
          <h1>Assignment 2</h1>
          ' . $this->getCorrectNavigation($isLoggedIn) . '
          ' . $this->getCorrectLoggedInStatus($isLoggedIn) . '
          <div class="container">
              ' . $mainViewHTML . '
              ' . $this->dateTimeView->getFormattedDateString() . '
          </div>
         </body>
      </html>
    ';
  }

  public function userWantsToRegister() 
  {
    		return isset($_GET['register']);
  }

  private function getCorrectNavigation($isLoggedIn) 
  {
      $response;

      if ($isLoggedIn) 
      {
        $response = '';
      }
      else if ($this->userWantsToRegister()) 
      {
        $response = '<a href="?">Back to login</a>';
      } else 
      {
        $response = '<a href="?register">Register a new user</a>';
      }

      return $response;
  }

  private function getCorrectLoggedInStatus($isLoggedIn) 
  {
    if ($isLoggedIn) 
    {
      return '<h2>Logged in</h2>';
    }
    else 
    {
      return '<h2>Not logged in</h2>';
    }
  }
}

?>
