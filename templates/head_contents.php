<link rel="stylesheet" href="css/main.css" type="text/css">
<link rel="stylesheet" href="css/mobile.css" type="text/css">
<meta name="description" content="A web application in which every user can create an unlimited amount of shopping lists.">
<meta name="keywords" content="Shopping,List,Planner">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Shopping Planner</title>
<script src="js/utils.js" type="text/javascript"></script>

<?php
    $_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
    
    if (isset($_GET['action']) && isset($_GET['type']) && isset($_GET['message'])) {
        ?>
        <script type="text/javascript">                            
            document.addEventListener('DOMContentLoaded', function() {
                showMessage(<?= "'" . $_GET['action'] . "_message'" ?>, 
                            <?= $_GET['message']; ?>, 
                            <?= "'" . $_GET['type'] . "'"; ?>,
                            <?= isset($_GET['fade']); ?>);
                });
        </script>
        <?php
    }