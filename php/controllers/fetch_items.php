<?php
    include_once(__DIR__ . '/controller.php');

    try {                
        $request = new mysqli_request();
        $items = $request->fetch_items();
        $rc = new success_code("Items fetched successfully.", $items);
    }

    catch (Exception $e) {
        // On caught exception, just do nothing. There will be no hints in the textbox, shit happens.
    }