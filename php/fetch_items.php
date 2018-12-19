<?php

    include('php/controller_base.php');

    class controller extends controller_base {
        public function process() {                
            $names = array();

            try {                
                $request = new mysqli_request();
                $result = $request->fetch_items();

                while ($row = $result->fetch_assoc()) {
                    $names[] = $row['name'];
                }
            }

            catch (Exception $e) {
                // On caught exception, just do nothing. There will be no hints in the textbox, shit happens.
                echo json_encode($names);
                return false;
            }

            echo json_encode($names);
            return true;
        }
    }