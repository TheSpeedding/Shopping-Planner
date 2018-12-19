<link rel="stylesheet" href="css/main.css" type="text/css">
<meta charset="UTF-8">
<meta name="description" content="A web application in which every user can create an unlimited amount of shopping lists.">
<meta name="keywords" content="Shopping,List,Planner">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Shopping Planner</title>

<?php
    if (isset($_GET['action']) && isset($_GET['type']) && isset($_GET['message'])) {
        ?>
        <script type="text/javascript">                            
            document.addEventListener('DOMContentLoaded', function() {
                showMessage(<?php echo "'" . $_GET['action'] . "_message'" ?>, 
                            <?php echo $_GET['message']; ?>, 
                            <?php echo "'" . $_GET['type'] . "'"; ?>);
                });
        </script>
        <?php
    }