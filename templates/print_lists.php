<?php
    $rc = NULL;

    include_once(__DIR__ . '/../php/controllers/fetch_lists.php');

    if (!($rc instanceof success_code)) {
        die("Invalid return code.");
    }

    foreach ($rc->payload as $list) {
        ?>
            <li><a data-id="<?php echo $list['id']; ?>"><?php echo $list['name']; ?></a></li>
        <?php
    }