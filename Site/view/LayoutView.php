<?php

namespace site\view;

class LayoutView
{
    public function renderToOutput(bool $isLoggedIn, string $loginViewHTML, string $dbViewHTML)
    {
        echo '<!DOCTYPE html>
      <html>
        <head>
          <meta charset="utf-8">
          <title>ABIS</title>
          <link rel="stylesheet" type="text/css" href="/style.css">
        </head>
        <body>
          <h1>Simple Abis Database</h1>
          <div class="login-container">
              ' . $this->getCorrectNavigation($isLoggedIn) . '
              ' . $this->getCorrectLoggedInStatus($isLoggedIn) . '
              ' . $loginViewHTML . '
          </div>
          <div class="db">
          ' . $dbViewHTML . '
          </div>
         </body>
      </html>
    ';
    }

    private function getCorrectNavigation(bool $isLoggedIn) : string
    {
        $response;

        if ($isLoggedIn) {
            $response = '';
        } elseif ($this->userWantsToRegister()) {
            $response = '<a href="?">Back to login</a>';
        } else {
            $response = '<a href="?register">Register a new user</a>';
        }

          return $response;
    }

    private function getCorrectLoggedInStatus(bool $isLoggedIn) : string
    {
        if ($isLoggedIn) {
            return '<h4>Logged in</h4>';
        } else {
            return '<h4>Not logged in</h4>';
        }
    }

    private function userWantsToRegister() : bool
    {
        return isset($_GET['register']);
    }
}
