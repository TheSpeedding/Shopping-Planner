<?php
    $_POST['controller'] = "fetch_lists";

    ob_start();

    include_once(__DIR__ . '/../php/controllers/controller.php');

    $response = json_decode(ob_get_contents());

    ob_end_clean();

    if (isset($response->error)) {
        die ($response->error);
    }

    foreach ($response->payload as $list) {
        ?>
            <li><a data-id="<?php echo $list->id; ?>"><?php echo $list->name; ?></a></li>
        <?php
    }