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
        
        <script type="text/javascript" src="./Styles/canvasjs.min.js"></script>

        <meta name="viewport" content="width=device-width, initial-scale=1">
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
    var month = today.getMonth() + 1;
    var year = today.getFullYear();
    m = checkTime(m);
    s = checkTime(s);
    //document.getElementById('time').innerHTML =
    //h + ":" + m + ":" + s;
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
                <a href="Home.php"><img src="Images/jobsbanner.jpg" class="col-md-1 col-sm-1 col-xs-1" style="width: 145px;"/></a>
                <!--<div id="date" class="col-xs-1 col-md-1 col-md-offset-4 col-sm-2 col-sm-offset-3" style="width: 145px; margin-right: 10px; height:37px; font-family: Arial; font-size: 20px; border :2px solid black; background-color: white; border-radius: 5px; text-align:center; color:blue;"> </div>-->
              <?php 
              if(isset($_SESSION['countBadge']) && isset($_SESSION['admin']))
              {
                if(!$_SESSION['countBadge'] == 0 && $_SESSION['admin'] == 0)
                {?>
                    <a href="<?php echo $log; ?>" class="btn btn-info col-md-1 col-md-offset-9 col-sm-2 col-sm-offset-7 col-xs-offset-2 col-xs-4" style="float: right; margin-right: 20px;"><?php echo $loginStatus; ?>&nbsp;<span class='badge'><?php echo $_SESSION['countBadge'] ?></span></a>
       <?php    }else if($_SESSION['countBadge'] == 0 && $_SESSION['admin'] == 0)
                {?>
                    <a href="<?php echo $log; ?>" class="btn btn-info col-md-1 col-md-offset-9 col-sm-2 col-sm-offset-7 col-xs-offset-2 col-xs-4" style="float: right; margin-right: 20px;"><?php echo $loginStatus; ?></a>
        <?php   }
              }else
              {?>
                    <a href="<?php echo $log; ?>" class="btn btn-info col-md-1 col-md-offset-9 col-sm-2 col-sm-offset-7 col-xs-offset-2 col-xs-4" style="float: right; margin-right: 20px;"><?php echo $loginStatus; ?></a>
        <?php }?>
        

              <?php 
              if(isset($_SESSION['countBadge']) && isset($_SESSION['admin']))
              { 
                  if($_SESSION['admin'] == 1)
                  {?>
                    <a href="<?php echo $log; ?>" class="btn btn-info col-md-1 col-md-offset-9 col-sm-2 col-sm-offset-7 col-xs-offset-2 col-xs-4" style="float: right; margin-right: 20px;"><?php echo $loginStatus; ?></a>  
            <?php }?>
        <?php }?>
   
             
                    
            </div>
            
            <div class="row">
            <div id="sidebar" class="col-md-2 col-sm-12">
               <?php echo $sidebar; ?>
            </div>

            <div id="content_area" class="col-md-10 col-sm-12">
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
