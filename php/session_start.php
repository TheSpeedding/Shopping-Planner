<?php
    if (isset($_COOKIE['session'])) {
        session_id($_COOKIE['session']);
    }
    session_start();