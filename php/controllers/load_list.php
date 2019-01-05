<?php
    include_once(__DIR__ . '/controller.php');

    if (!isset($_SESSION['login'])) {
        $rc = new error_code("Session has expired.");
    }

    else if (!isset($_POST['id'])) {
        $rc = new error_code("Missing parameters.");
    }

    else {
        $login = $_SESSION['login'];
        $id = $_POST['id'];

        try {                
            $request = new mysqli_request();
            $list = $request->load_list($login, $id);  
                        
            $sanitized_items = array();
            foreach ($list['items'] as $item) {
                $sanitized_items[] = array(
                    'id' => $item['id'],
                    'item' => htmlspecialchars($item['item']),
                    'amount' => $item['amount']
                );
            }

            $rc = new success_code("List loaded successfully.", array(
                'id' => $list['id'],
                'name' => htmlspecialchars($list['name']), 
                'created' => $list['created'], 
                'items' => $sanitized_items
            ));
        }
    
        catch (Exception $e) {
            $rc = new error_code(htmlspecialchars($e->getMessage()));            
        }
    }