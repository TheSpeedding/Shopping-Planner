<?php

    include('db/db_proc.php');

abstract class controller_base {
    public abstract function process();
}