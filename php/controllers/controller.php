<?php
    include(__DIR__ . '/../rc_structure.php');
    include(__DIR__ . '/../../db/db_proc.php');

    /*
     * This script will call a script specified in $_POST['controller']. 
     * Results of the underlying scripts are "return_code" objects stored in $rc variable.
     */
    
    if (isset($_POST['controller'])) {
        $rc = NULL;

        include(__DIR__ . '/' . $_POST['controller'] . '.php');
    
        $rc->print_json();
    }