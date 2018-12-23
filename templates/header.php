<?php
    $logged = isset($_SESSION['name']) && isset($_SESSION['login']);
?>

<div id="header">
    <div id="logo">
        <img src="img/logo.png" alt="Shopping Planner">
        SHOPPING PLANNER
    </div> 
    <div id="info">
        Date: <?= date('d.m.Y H:i'); ?> <br>
        User: <?= $logged ? $_SESSION['name'] : "Non-logged"; ?><br>
        <?php
            if ($logged) {
                ?>
                <a href= <?= "index.php?logout" ?>>Log-out</a>
                <?php
            }
            else {
                ?>
                <a href="index.php">Log-in</a>
                <?php
            }
        ?>        
    </div>
</div>