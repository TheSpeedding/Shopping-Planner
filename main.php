<?php 
    if (isset($_GET['session'])) {
        session_id($_GET['session']);
    } 
    session_start(); 
    include('php/main_logic.php');
?>

<!DOCTYPE HTML>
<html>
    <head>
        <?php include('templates/head_contents.php'); ?>
        <script src="js/item_list.js" type="text/javascript"></script>        
        <script src="js/show_message.js" type="text/javascript"></script>     
    </head>
    <body>
        <div id="content">   

            <?php include('templates/header.php'); ?>

            <div id="main">
                <div id="lists">
                    <ul>
                        <li><a href="#">First list</a></li>
                        <li><a href="#">Second list</a></li>
                        <li><a href="#">Third list</a></li>
                        <li><a href="#">Create new list</a></li>
                    </ul>
                </div>
    
                <div id="current">
                    <h2>First list</h2>

                    <div id="created">
                        Created: 17.12.2018 17:00
                    </div>

                    <table>
                        <tr><th>Item</th><th>Amount</th><th></th><th></th></tr>

                        <tr><td>Máslo</td><td>10</td><td><a href="#" class="blue swap">↑↓</a></td><td><a href="#" class="yellow">Edit</a><a href="#" class="red">Delete</a></td></tr>
                        <tr><td>Rohlík</td><td>100</td><td><a href="#" class="blue swap">↑↓</a></td><td><a href="#" class="yellow">Edit</a><a href="#" class="red">Delete</a></td></tr>
                        <tr><td>Tatra Tea</td><td>1000</td><td><a href="#" class="blue swap">↑↓</a></td><td><a href="#" class="yellow">Edit</a><a href="#" class="red">Delete</a></td></tr>
                        <tr><td>Voda</td><td>1</td><td></td><td><a href="#" class="yellow">Edit</a><a href="#" class="red">Delete</a></td></tr>

                        <tr>
                            <td>
                                <input list="items" type="text" name="name">
                                <datalist id="items">
                                </datalist>
                            </td>
                            <td><input type="number" name="amount"></td>     
                            <td colspan="2"><a href="#" class="green">Add</a><a href="#" class="blue">Clear</a></td>                   
                        </tr>
                    </table>

                    <div id="delete_list">
                        <a href="#">Delete list</a>
                    </div>
                </div>

                <div class="spacer"></div>
            </div>
        </div>
    </body>
</html>