<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title><?php echo $title; ?></title>
        <link rel="stylesheet" type="text/css" href="./Styles/StyleSheet.css">
        <link rel="stylesheet" type="text/css" href="./Styles/circle.css">
        
        <script src="Styles/sorttable.js"></script>

        
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        
<script>
function startTime() {
    var today = new Date();
    var h = today.getHours();
    var m = today.getMinutes();
    var s = today.getSeconds();
    var day = today.getDate();
    var month = today.getMonth();
    var year = today.getFullYear();
    m = checkTime(m);
    s = checkTime(s);
    document.getElementById('time').innerHTML =
    h + ":" + m + ":" + s;
    document.getElementById('date').innerHTML =
    day + "-" + month + "-" + year;
    var t = setTimeout(startTime, 500);
}
function checkTime(i) {
    if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
    return i;
}
</script>
    </head>
    <body onload="startTime()">
        <div class="container-fluid">
            <div id="bannerAndSearchBar" class="row">
                <a href="home.php"><img src="Images/jobsbanner.jpg" class="col-md-1 col-sm-1" style="width: 145px;"/></a>
                <div id="time" class="col-sm-1 col-md-1 col-md-offset-4 col-sm-offset-4" style="width: 135px; height:37px; font-family: forte; font-size: 20px; border:2px solid black; background-color: white; border-radius: 5px; text-align:center; color:blue;"> </div>
                <div id="date" class="col-md-2 col-sm-2" style="width: 155px; margin-left: 5px; height:37px; font-family: forte; font-size: 20px; border:2px solid black; background-color: white; border-radius: 5px; text-align:center; color:blue;"> </div>
                    <a href="<?php echo $log; ?>" class="btn btn-info col-md-1 col-md-offset-3"><?php echo $loginStatus; ?></a>
            </div>
            
            <div class="row">
            <div id="sidebar" class="col-md-2">
               <?php echo $sidebar; ?>
            </div>

            <div id="content_area" class="col-md-9">
                <div class="row">
                <h4 class="col-md-12" style="color:red; text-align: center;"> <?php echo $errorMessage; ?> </h4>
                </div>
                <br>
                <?php echo $content; ?>
            </div>
                
            </div>
            
            <footer>
                <p>All rights reserved</p>
            </footer>
            
        </div>
    </body>
</html>
