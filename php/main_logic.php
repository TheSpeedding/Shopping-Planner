<?php
    if (!isset($_SESSION['name']) || !isset($_SESSION['login'])) {
        header("Location: index.php?action=login&type=error&message='". urlencode("Your session has expired. Log-in again.") . "'");  
        exit();
    }