<?php

namespace view;

  class LayoutView {
  
    public function renderToOutput(IUseCaseView $mainView, DateTimeView $dateTime, bool $isLoggedIn, string $message = '', string $lastUsername = '') {
      echo '<!DOCTYPE html>
      <html>
        <head>
          <meta charset="utf-8">
          <title>Login Example</title>
        </head>
        <body>
          <h1>Assignment 2</h1>
          ' . $this->renderNavigation($isLoggedIn) . '

          ' . $this->renderIsLoggedIn($isLoggedIn) . '
          
          <div class="container">
              ' . $mainView->renderBodyWithMessage($isLoggedIn, $message) . '
              
              ' . $dateTime->show() . '
          </div>
         </body>
      </html>
    ';
    }
  
  private function renderNavigation($isLoggedIn) {
    $response;

      if ($isLoggedIn) {
        $response = '';
      }
      else if ($this->userWantsToRegister()) {
        $response = '<a href="?">Back to login</a>';
      } else {
        $response = '<a href="?register">Register a new user</a>';
      }

      return $response;
    }

  private function renderIsLoggedIn($isLoggedIn) {
    if ($isLoggedIn) {
      return '<h2>Logged in</h2>';
    }
    else {
      return '<h2>Not logged in</h2>';
    }
  }

  public function userWantsToRegister() {
    return isset($_GET["register"]);
  }
}
?>
