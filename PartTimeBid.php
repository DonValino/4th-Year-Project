<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title><?php echo $title; ?></title>
        <link rel="stylesheet" type="text/css" href="Styles/StyleSheet.css">
        
        <script src="Styles/sorttable.js"></script>
        
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    </head>
    <body>
        <div class="container-fluid">
            
<?php 
                                      echo  "<div class='row'>
                                               <h2 class='col-md-12' style='text-align:center;'>Place An Offer</h2>
                                             </div>
                                             <div class='row'>
                                                <input type='radio' onclick = 'fullTimeBid()' style='margin-left:38%; margin-bottom:20px;' name='gender' value='0'> Full Time 
                                                &nbsp&nbsp&nbsp&nbsp&nbsp<input type='radio' checked='checked' onclick = 'partTimeBid()' name='gender' value='1'> Part Time 
                                             </div>
                                             <form action='' method = 'POST'>
                                               <fieldset>
                                                 <div class='clearfix'>
                                                   <label for='offerPrice' class='col-md-2'> Price: </label>
                                                   <input type='text' name = 'offerPrice' id='offerPrice' class='col-md-8' placeholder='Enter Price' required autofocus>
                                                 </div>
                                                 <div class='clearfix'>
                                                 <label for='comment' class='col-md-2'> Comment: </label>
                                                   <input type='text' name = 'comment' class='col-md-8' placeholder='Comment' required autofocus>
                                                 </div>
                                                 <script>
                                                    function fullTimeBid() {
                                                    $('#register').load('fulltimeBid.php?epr=view&select=38');
                                                    }
                                                </script>
                                                
                                                <div class='clearfix'>
                                                  <label for='numberOfDays' class='col-md-2'> Number Of Days: </label>
                                                  <select class='form-control'id='numberOfDays' name = 'numberOfDays' style='width:200px;'>
                                                      <option value=1>1</option>
                                                      <option value=2>2</option>
                                                      <option value=3>3</option>
                                                      <option value=4>4</option>
                                                      <option value=5>5</option>
                                                      <option value=6>6</option>
                                                      <option value=7>7</option>
                                                      <option value=14>2 Weeks</option>
                                                      <option value=21>3 Weeks</option>
                                                      <option value=28>4 Weeks</option>
                                                  </select>
                                                </div>
                                                
                                                 <div class='clearfix'>
                                                 <label for='prefferedCommenceDate' class='col-md-2'> Preffered Commence Date: </label>
                                                   <input type='date' name = 'prefferedCommenceDate' class='col-md-8' placeholder='Preferred Commence Date' required autofocus>
                                                 </div>
                                                
                                                 <script>
                                                    function partTimeBid() {
                                                    $('#register').load('PartTimeBid.php?epr=view&select=38');
                                                    }
                                                </script>
                                                
                                                <button class='btn primary col-md-2 col-md-offset-8' name = 'placeOfferPB' type='submit'>Submit</button>
                                               </fieldset>
                                             </form>";

?>
        </div>
    </body>
</html>