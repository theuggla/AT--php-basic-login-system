<?php

namespace tictactoe\view;

class GameView {

    public function displayInstructions()
    {
        return "<p>Welcome!</p>"
        ."<p>"
        . $this->getActionsHTML()
        ."</p><p>"
        . $this->getBoard()
        . "</p>"
        ;
    }

    public function wantsToPlay()
    {
        return isset($_GET['newgame']);
    }

    private function getActionsHTML()
    {
        return
        '
            <a href="?newgame">Play new game</a>
        ';
    }

    private function getBoard()
    {
        return
        "<pre>
                 __ __ __ 
                |__|__|__|
                |__|__|__|
                |__|__|__|
        </pre>
        ";
    }
}