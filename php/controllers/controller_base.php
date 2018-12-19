<?php

    include('db/db_proc.php');

    abstract class controller_base {
        public abstract function process();
    }

    if (isset($_POST['controller'])) {
        include('php/controllers/' . array_shift($_POST) . '.php');
        $c = new controller($_POST);
        $rc = $c->process();
    }