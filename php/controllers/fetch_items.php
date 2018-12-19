<?php

    include_once('php/controllers/controller_base.php');

    class controller extends controller_base {
        public function process() {                
            $names = array();

            try {                
                $request = new mysqli_request();
                $names = $request->fetch_items();
            }

            catch (Exception $e) {
                // On caught exception, just do nothing. There will be no hints in the textbox, shit happens.
            }

            return json_encode($names);
        }
    }