<?php 

namespace view;

    interface IUseCaseView
    {
        public function renderHeading();
        public function renderNavigation();
        public function renderBodyWithMessage();
    }
?>