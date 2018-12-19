<?php

    include('db/db_proc.php');

    abstract class controller_base {
        public abstract function process();
    }

    if (isset($_GET['action'])) {
        include('php/' . $_GET['action'] . '.php');
        $c = new controller($_POST);
        $c->process();
    }