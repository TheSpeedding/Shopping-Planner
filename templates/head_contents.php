<link rel="stylesheet" href="css/main.css" type="text/css">
<link rel="stylesheet" href="css/mobile.css" type="text/css">
<meta name="description" content="A web application in which every user can create an unlimited amount of shopping lists.">
<meta name="keywords" content="Shopping,List,Planner">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Shopping Planner</title>
<script src="js/utils.js" type="text/javascript"></script>

<?php
    if (isset($_GET['action']) && isset($_GET['type']) && isset($_GET['message'])) {
        ?>
        <script type="text/javascript">                            
            document.addEventListener('DOMContentLoaded', function() {
                showMessage(<?= json_encode($_GET['action'] . "_message"); ?>, 
                            <?= json_encode($_GET['message']); ?>, 
                            <?= json_encode($_GET['type']); ?>,
                            <?= isset($_GET['fade']) ? "true" : "false"; ?>);
                });
        </script>
        <?php
    }