<?php
    include_once(__DIR__ . '/controller.php');

    try {                
        $request = new mysqli_request();
        $items = $request->fetch_items();

        $sanitized_items = array();
        foreach ($items as $item) {
            $sanitized_items[] = htmlspecialchars($item);
        }

        $rc = new success_code("Items fetched successfully.", $sanitized_items);
    }

    catch (Exception $e) {
        // On caught exception, just do nothing. There will be no hints in the textbox, shit happens.
    }