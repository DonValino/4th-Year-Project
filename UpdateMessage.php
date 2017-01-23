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
                                                       require 'Controller/MessageController.php';
                                                       session_start();

                                                            if(isset($_SESSION['username']))
                                                            {
                                                               $loginStatus=$_SESSION['username'];
                                                               $log = $_SESSION['log'];
                                                            }
                                                       
                                                        //Creating an instance of Message Controller
                                                        $messageController = new MessageController();    
                                                        
                                                        $search = $messageController->GetMessages();
                                                        if(isset($_SESSION['fromusername']))
                                                        {
                                                        try
                                                            {
                                                                if($search != null)
                                                                {
                                                                    foreach($search as $row)
                                                                    {
                                                                        if ($row->fromusername == $_SESSION['username'] && $row->tousername == $_SESSION['fromusername'])
                                                                        {
                                                                            $message = $row->message;

                                                                           echo " <div class='msgc' style='margin-bottom: 30px;'> 
                                                                            <div class='msg msgfrom'>$message </div> 
                                                                            <div class='msgarr msgarrfrom'></div>
                                                                            <div class='msgsentby msgsentbyfrom'>Sent by $row->fromusername $row->dateofmessage</div> 
                                                                            </div>";
                                                                        }else if($row->fromusername == $_SESSION['fromusername'] && $row->tousername == $_SESSION['username'])
                                                                        {
                                                                           echo" <div class='msgc'> 
                                                                                <div class='msg'> $row->message  </div>
                                                                                <div class='msgarr'></div>
                                                                                <div class='msgsentby'>Sent by  $row->fromusername $row->dateofmessage </div>
                                                                            </div>";
                                                                        }
                                                                    }
                                                                }
                                                             }catch(Exception $x)
                                                            {
                                                                echo 'Caught exception: ',  $x->getMessage(), "\n";
                                                            }
                                                        }  else {
                                                                echo" 
                                                                     
                                                                      <div class='msgc' style='margin-bottom: 30px;'> 
                                                                            <div class='msg msgfrom'> Send A New Message :) </div> 
                                                                            <div class='msgarr msgarrfrom'></div>
                                                                            <div class='msgsentby msgsentbyfrom'></div> 
                                                                      </div>";
                                                        }
                                                        $messageController->KeepScrollBarAtTheBottom();
                                                       ?>
        </div>
    </body>
</html>
