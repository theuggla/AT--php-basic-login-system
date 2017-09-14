<?php

  class LayoutView {
  
    public function renderToOutput($mainView, DateTimeView $dateTime) {
      echo '<!DOCTYPE html>
        <html>
          <head>
            <meta charset="utf-8">
            <title>Login Example</title>
          </head>
          <body>
            <h1>Assignment 2</h1>
              ' . $mainView->renderHeading() . '
            <div class="container">
              ' . $mainView->renderBody() . '
              ' . $dateTime->show() . '
            </div>
          </body>
        </html>
      ';
    }
  }
?>
