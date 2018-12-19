<?php
    include_once(__DIR__ . '/controller.php');

    $names = array();

    try {                
        $request = new mysqli_request();
        $names = $request->fetch_items();
    }

    catch (Exception $e) {
        // On caught exception, just do nothing. There will be no hints in the textbox, shit happens.
    }

    $rc = new success_code("Items fetched successfully.", $names);