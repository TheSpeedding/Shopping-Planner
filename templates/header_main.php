<?php
    session_start();
    $logged = isset($_SESSION['name']);
?>

<div id="header">
    <div id="logo">
        <img src="img/logo.png" alt="Shopping Planner">
        SHOPPING PLANNER
    </div> 
    <div id="info">
        Date: <?= date('d.m.Y H:i'); ?> <br>
        User: <?php echo $logged ? $_SESSION['name'] : "Non-logged"; ?><br>
        <?php
            if ($logged) {
                ?>
                <a href="index.php">Log-out</a>
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