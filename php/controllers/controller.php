<?php
    include(__DIR__ . '/../rc_structure.php');
    include(__DIR__ . '/../../db/db_proc.php');

    /*
     * This script will call a script specified in $_POST['controller']. 
     * Results of the underlying scripts are "return_code" objects stored in $rc variable.
     */

    if (session_status() == PHP_SESSION_NONE) {
        include_once(__DIR__ . '/../session_start.php');
    }

    // This is here for debug purposes and should be removed in a release version.
    if (!isset($_POST['controller'])) $_POST = $_GET;
    
    if (isset($_POST['controller'])) {
        $rc = NULL;

        // Path traversal check.
        $files = glob(__DIR__ . "/*.php");
        $controllers = array();

        foreach($files as $file) {
            $file = pathinfo($file);
            $controllers[] = $file['filename'];
        }

        if (!in_array($_POST['controller'], $controllers)) {
            die('Attempt to do a path traversal.');
        } 
        
        include(__DIR__ . '/' . $_POST['controller'] . '.php');
    
        $rc->print_json();
    }