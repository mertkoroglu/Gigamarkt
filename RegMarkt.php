<?php
/*<form action="?" method="post">
    Email : <input type="text" name="email">
    <br><br>
    Password : <input type="password" name="pass">
    <br><br>
    <button type="submit">Enter</button>
</form>*/
require "db.php";
$error = 0;

session_start();


if (validSessionCons()) {

    header("Location: cons.php");
    exit;
}

if (!empty($_POST)) {
    extract($_POST);

    $stmt = $db->prepare("select * from market_user where email=?");
    $stmt->execute([$email]);
    if ($stmt->rowCount()) {
        $error = 1;
    } else {
        if ($password == '' || $name == '' || $city == '' || $dis == '' || $email == '' || $address == '') {
            echo "<script>alert('Please enter all fields!')</script>";
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<script>alert('Invalid Email!')</script>";
        } else {

            $rand = rand(100000, 999999);
            $stmt = $db->prepare("insert into market_user (email, name, password, city, district, address, Flag, Auth_Code, token) values (?, ?, ?, ?, ?, ?, false, $rand, 1)");
            require_once "email.php";

            email($email, $rand);

            $salt = "fni13uc0xrhf7332mf3";
            $pass = $password . $salt;
            $pass = sha1($pass);

            $stmt->execute([$email, $name, $pass, $city, $dis, $address]);


            // var_dump($password);
            if (checkUserMarkt($email, $password)) {
                $_SESSION["MarktUser"] = getUserMarkt($email);
                // header("Location: mail.php?email=$email");
                exit;
            }
        }
    }
}


?>

<!--<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Market Login</title>
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Oxygen&family=Righteous&display=swap');

    #head {
        width: 100%;
        background-color: orange;
        color: white;
        padding: 10px 10px;
        border-radius: 10px;
    }

    body {
        margin: 0px 0px;
        background-color: rgba(60, 0, 50, 1);
    }

    #head h1 {
        margin: 0px 0px;
        font-family: 'Righteous', cursive;
        font-size: 50px;
    }

    span {
        font-size: 20px;
        color: lightgreen;
    }

    #main {
        font-size: 20px;
        font-family: 'Oxygen', sans-serif;
        margin: 20px auto;
        border: 1px solid black;
        border-radius: 7px;
        background-color: rgba(240, 240, 240, .9);

    }

    #main td {
        padding: 10px 10px;
    }

    form {}

    input {
        border-radius: 7px;
    }

    button {
        background-color: green;
        color: white;
        border-radius: 7px;
    }

    #back {
        text-align: center;
    }
    </style>
</head>

<body>
    <div id="head">
        <h1>GigaMarkt.com <span>Market Login</span> </h1>
    </div>




    <form id="form" action="?" method="post">
        <table id="main">
            <tr>
                <td>E-mail:</td>
                <td><input type="text" name="email"></input></td>
            </tr>
            <tr>
                <td>Name: </td>
                <td><input type="text" name="name"></input></td>
            </tr>
            <tr>
                <td>Password: </td>
                <td><input type="password" name="password"></input></td>
            </tr>
            <tr>
                <td>City: </td>
                <td><input type="text" name="city"></input></td>
            </tr>
            <tr>
                <td>District: </td>
                <td><input type="text" name="dis"></input></td>
            </tr>
            <tr>
                <td>Address: </td>
                <td><input type="text" name="address"></input></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center;"><button>Register</button></a></td>
            </tr>
        </table>
    </form>
    <div id="back"><a href="index.php">Go Back</a><br><?php /*if ($error == 1) {
                                                            echo "Invalid email";
                                                        } */ ?></div>
    <script>
    //    function reg(){
    //     alert("Hello")

    //    }
    </script>
</body>

</html>-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Market Login</title>
    <link rel="stylesheet" href="css\stylenew.css">
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Oxygen&family=Righteous&display=swap');
    .slide-in-bottom{-webkit-animation:slide-in-bottom .5s cubic-bezier(.25,.46,.45,.94) both;animation:slide-in-bottom .5s cubic-bezier(.25,.46,.45,.94) both}
    /* ----------------------------------------------
 * Generated by Animista on 2022-5-15 21:4:45
 * Licensed under FreeBSD License.
 * See http://animista.net/license for more info. 
 * w: http://animista.net, t: @cssanimista
 * ---------------------------------------------- */

@-webkit-keyframes slide-in-bottom{0%{-webkit-transform:translateY(1000px);transform:translateY(1000px);opacity:0}100%{-webkit-transform:translateY(0);transform:translateY(0);opacity:1}}@keyframes slide-in-bottom{0%{-webkit-transform:translateY(1000px);transform:translateY(1000px);opacity:0}100%{-webkit-transform:translateY(0);transform:translateY(0);opacity:1}}
 
    #head {
        width: 100%;
        background-color: orangered;
        color: white;
        padding: 10px 10px;
        border-radius: 10px;
    }

    body {
        margin: 0px 0px;
    }

    #head h1 {
        margin: 0px 0px;
        font-family: 'Righteous', cursive;
        font-size: 50px;
    }

    span {
        font-size: 20px;
        color: lightgreen;
    }

    #main {
        font-size: 20px;
        font-family: 'Oxygen', sans-serif;
        margin: 100px auto;
        border: 1px solid black;
        border-radius: 7px;
        color: white;
        background-color: #444;
    }

    #main td {
        padding: 10px 10px;
    }

    input {
        border-radius: 7px;
    }

    button {
        border-radius: 7px;
        color: white;
        background-color: #444;
    }

    #back {
        text-align: center;
    }
    </style>
</head>

<body>
    <div class="container">
        <div class="header_section_top" style="width: 100vw; position:absolute;top:0;left:0;">
            <div class="row">
                <div class="col-sm-12">
                    <div class="custom_menu">
                        <h1 class="fashion_taital" style=" font-family: 'Roboto', sans-serif;">GigaMarkt&trade;</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <form action="?" method="post" class="slide-in-bottom">
        <table id="main">
            <tr>
                <td>E-mail:</td>
                <td><input type="text" name="email" value="<?= isset($email) ?  $email : '' ?>"></input></td>
            </tr>
            <tr>
                <td>Name: </td>
                <td><input type="text" name="name" value="<?= isset($name) ?  $name : '' ?>"></input></td>
            </tr>
            <tr>
                <td>Password: </td>
                <td><input type="password" name="password" value="<?= isset($password) ?  $password : '' ?>"></input>
                </td>
            </tr>
            <tr>
                <td>City: </td>
                <td><input type="text" name="city" value="<?= isset($city) ?  $city : '' ?>"></input></td>
            </tr>
            <tr>
                <td>District: </td>
                <td><input type="text" name="dis" value="<?= isset($dis) ?  $dis : '' ?>"></input></td>
            </tr>
            <tr>
                <td>Address: </td>
                <td><input type="text" name="address" value="<?= isset($address) ?  $address : '' ?>"></input></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center;"><button>Register</button></a></td>
            </tr>
        </table>
    </form>
    <div id="back"><a href="index.php">Go Back</a><br><?php if ($error == 1) {
                                                            echo "Invalid email";
                                                        } ?></div>
</body>

</html>