<!DOCTYPE HTML>
<html>
    <head>
        <link rel="stylesheet" href="./css/main.css" type="text/css">
        <meta charset="UTF-8">
        <meta name="description" content="A web application in which every user can create an unlimited amount of shopping lists.">
        <meta name="keywords" content="Shopping,List,Planner">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Shopping Planner</title>
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
                    User: Non-logged<br>
                    <a href="index.html">Log-in</a>
                </div>
            </div>

            <div id="main">
                <div id="login">
                    <h2>Please log-in to watch your lists.</h2>
                    
                    <span class="error">Invalid username or password.</span>

                    <form>
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
                    <form>
                        <table>
                            <tr>
                                <td>Fullname:</td>
                                <td><input type="text" name="fullname"></td>
                            </tr>
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