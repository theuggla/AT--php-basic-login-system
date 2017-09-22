<?php 

namespace view;

    interface IUseCaseView
    {
        public function getBodyWithMessage(string $message, bool $isLoggedIn);
    }
?>