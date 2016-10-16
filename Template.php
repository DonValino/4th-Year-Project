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
        <link rel="stylesheet" type="text/css" href="Styles/StyleSheet.css">
        
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        
        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
        
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    </head>
    <body>
        <div id="wrapper">
            <div id="bannerAndSearchBar">
                <img src="Images/jobsbanner.jpg" class="bannerImage" style="width: 145px; margin-left: 160px; margin-top: 5px;"/>
                <a href='<?php echo $log; ?>' class="loginLink"><?php echo $loginStatus; ?></a>
            </div>
            
            <div id="content_area">
                <h4 class="errorMessage" style="color:red;"> <?php echo $errorMessage; ?> </h4>
                <br>
                <?php echo $content; ?>
            </div>
            
            <div id="sidebar">
               <?php echo $sidebar; ?>
            </div>
            
            <footer>
                <p>All rights reserved</p>
            </footer>
            
        </div>
    </body>
</html>
