<?php
    include(__DIR__ . '/../rc_structure.php');
    include(__DIR__ . '/../../db/db_proc.php');

    /*
     * This script will call a script specified in $_POST['controller']. 
     * Results of the underlying scripts are "return_code" objects stored in $rc variable.
     */

    if (session_status() == PHP_SESSION_NONE) {
        if (isset($_COOKIE['session'])) {
            session_id($_COOKIE['session']);
        } 
        session_start();
    }

    // This is here for debug cases and should be removed in a release version.
    if (!isset($_POST['controller'])) $_POST = $_GET;
    
    if (isset($_POST['controller'])) {
        $rc = NULL;

        include(__DIR__ . '/' . $_POST['controller'] . '.php');
    
        $rc->print_json();
    }