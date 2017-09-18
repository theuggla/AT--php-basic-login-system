<?php

namespace view;

  class LayoutView {
  
    public function renderToOutput(IUseCaseView $mainView, DateTimeView $dateTime, string $message) {
      echo '<!DOCTYPE html>
        <html>
          <head>
            <meta charset="utf-8">
            <title>Login Example</title>
          </head>
          <body>
            <h1>Assignment 2</h1>
              ' . $mainView->renderNavigation() . '
              ' . $mainView->renderHeading() . '
            <div class="container">
              ' . $mainView->renderBodyWithMessage($message) . '
              ' . $dateTime->show() . '
            </div>
          </body>
        </html>
      ';
    }

    public function userWantsToLogin() {
      return isset($_POST['LoginView::Login']);
    }
  }
?>
