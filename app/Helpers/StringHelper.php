<?php
    function dash_case($str) {
        return str_replace('_', '-', snake_case($str));
    }
