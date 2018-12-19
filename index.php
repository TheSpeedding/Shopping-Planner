<!DOCTYPE HTML>
<html>
    <head>
        <?php include('templates/head_contents.php'); ?>
        <script src="js/show_message.js" type="text/javascript"></script>        
        <?php

            if (isset($_POST['action'])) {

                $action = array_shift($_POST);

                include("php/${action}.php");

                $c = new controller($_POST);

                try {
                    $rc = $c->process();
                    ?> 
                    <script type="text/javascript">                            
                        document.addEventListener('DOMContentLoaded', function() {
                            showSuccessMessage(<?php echo "'" . $action . "_message'" ?>, 
                                                <?php 
                                                    echo "'". $rc . "'";
                                                ?>);
                            });
                    </script>
                    <?php                        
                }

                catch (Exception $e) {
                    ?> 
                    <script type="text/javascript">                            
                        document.addEventListener('DOMContentLoaded', function() {
                            showErrorMessage(<?php echo "'" . $action . "_message'" ?>, 
                                                <?php 
                                                    echo "'". $e->getMessage() . "'";
                                                ?>);
                            });
                    </script>
                    <?php   
                }

            }

        ?>
    </head>
    <body>
        <div id="content">  
            
            <?php include('templates/header_main.php'); ?>

            <div id="main">
                <div id="login">
                    <h2>Please log-in to watch your lists.</h2>
                    
                    <span class="error">Invalid username or password.</span>

                    <form action="index.php" method="POST">
                        <input type="hidden" name="action" value="login">
                        <table>
                            <tr>
                                <td>Username:</td>
                                <td><input type="text" name="login"></td>
                            </tr>
                            <tr>
                                <td>Password:</td>
                                <td><input type="password" name="pw"></td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <input class="blue" type="submit" name="submit" value="Log-in">
                                </td>
                            </tr>
                        </table>                   
                    </form>
                </div>

                <div id="signup">
                    <h2>In case you don't have an account yet, please sign-up.</h2>

                    <span id="signup_message"></span>

                    <form action="index.php" method="POST">
                        <input type="hidden" name="action" value="signup">
                        <table>
                            <tr>
                                <td>Fullname:</td>
                                <td><input type="text" name="fullname" value="<?php if (isset($_POST['login'])) echo $_POST['fullname']; ?>"></td>
                            </tr>
                            <tr>
                                <td>Username:</td>
                                <td><input type="text" name="login" value="<?php if (isset($_POST['login'])) echo $_POST['login']; ?>"></td>
                            </tr>
                            <tr>
                                <td>Password:</td>
                                <td><input type="password" name="pw"></td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <input class="green" type="submit" name="submit" value="Sign-up">
                                </td>
                            </tr>
                        </table>                       
                    </form>
                </div>
                <div class="spacer"></div>
            </div>
        </div>
    </body>
</html>