<?php 

namespace view;

    interface IUseCaseView
    {
        public function renderBodyWithMessage(bool $isLoggedIn, string $message);
    }
?>