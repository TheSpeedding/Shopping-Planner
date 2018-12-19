<!DOCTYPE HTML>
<html>
    <head>
        <link rel="stylesheet" href="css/main.css" type="text/css">
        <meta charset="UTF-8">
        <meta name="description" content="A web application in which every user can create an unlimited amount of shopping lists.">
        <meta name="keywords" content="Shopping,List,Planner">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Shopping Planner</title>
        <script src="js/item_list.js" type="text/javascript"></script>                
        <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
                appendToDatalist(<?php 
                                     include('php/fetch_items.php');
                                     $c = new controller();
                                     $c->process();
                                 ?>, document.getElementById("items"));
            });
        </script>
    </head>
    <body>
        <div id="content">            
            <div id="header">
                <div id="logo">
                    <img src="./img/logo.png" alt="Shopping Planner">
                    SHOPPING PLANNER
                </div> 
                <div id="info">
                    Date: 17.12.2018 22:50<br>
                    User: Lukáš Riedel<br>
                    <a href="index.html">Log-out</a>
                </div>
            </div>

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