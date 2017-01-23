<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MessageController
 *
 * @author Jake Valino
 */

require 'Model/MessagesModel.php';
require 'Model/TypeModel.php';
require 'Model/NotificationModel.php';

class MessageController {

    // Send A Message
    function SendAMessage($fromusername, $tousername, $message, $dateofmessage)
    {
        $messagesModel = new MessagesModel();
        $messagesModel->SendAMessage($fromusername,$tousername, $message,$dateofmessage);
    }
    
    // Set Message Seen by user.
    function SetMessagesSeen($fromusername,$tousername)
    {
        $messagesModel = new MessagesModel();
        $messagesModel->SetMessagesSeen($fromusername,$tousername);
    }
    
    //Get Messages Belonging to a User.
    function GetMessages()
    {
        $messagesModel = new MessagesModel(); 
        
        return $messagesModel->GetMessages();
    }
    
    // Get All Messages Belonging to a user
    function GetAllMyMessages($username)
    {
        $messagesModel = new MessagesModel(); 
        
        return $messagesModel->GetAllMyMessages($username);
    }
    
    // Get all of my messages
    function GetMyInbox()
    {
        $messagesModel = new MessagesModel(); 
        
        return $messagesModel->GetMyInbox();
    }
    
    // Message Content
    function MessageContent()
    {
       $myMessages = $this->GetAllMyMessages($_SESSION['username']);
       $myInbox = $this->GetMyInbox(); 
       $result= "
           <div class='row'>
           <div class='panel-group col-md-5'>
			  <div class='panel panel-default'>
					<div class='panel-heading' style='text-align:center;'>
					<a data-toggle='collapse' data-parent='#accordion' href='#collapseMyPlacedOffers' class='glyphicon glyphicon-hand-up'><strong>Inbox</strong></a>
					</div>
					<div id='collapseMyPlacedOffers' class='panel-collapse collapse in'>
						<div class='panel-body'>"
                                                    ."<div class='table-responsive scrollit' style='background-color:white; text-align:center;'>"
                                                        . "<table class='table sortable'>"
                                                        . "<tr style='text-align:center;'>"
                                                        . "     <th style='text-align:center;'>User</th>"
                                                        . "     <th style='text-align:center;'>Time</th>"
                                                        . "     <th style='text-align:center;'>Status</th>"
                                                        . "     <th style='text-align:center;'>Actions</th>"
                                                        . "</tr>";
                                                        try
                                                        {
                                                            if($myInbox != null)
                                                            {
                                                                foreach($myInbox as $row)
                                                                {
                                                                    if($row->seen == 0 && $row->tousername == $_SESSION['username'])
                                                                    {
                                                                            $result.= "<tr>"
                                                                            . "<td align='center'><a href='Messages.php?epr=view&fromusername=".$row->fromusername."'>$row->fromusername</a></td>"
                                                                            . "<td align='center'>$row->dateofmessage</td>"
                                                                            . "<td align='center' style='font-weight:bold; color:blue'>New</td>"
                                                                            . "<td>"
                                                                            . "     <a href='Messages.php?epr=view&fromusername=".$row->fromusername."'>Reply</a>"
                                                                            . "</td>"
                                                                            . "</tr>".
                                                                            "<tr>";
                                                                    }else if($row->seen == 1 && $row->tousername == $_SESSION['username'])
                                                                    {
                                                                            $result.= "<tr>"
                                                                            . "<td align='center'><a href='Messages.php?epr=view&fromusername=".$row->fromusername."'>$row->fromusername</a></td>"
                                                                            . "<td align='center'>$row->dateofmessage</td>"
                                                                            . "<td align='center' color:blue'>Seen</td>"
                                                                            . "<td>"
                                                                            . "     <a href='Messages.php?epr=view&fromusername=".$row->fromusername."'>Reply</a>"
                                                                            . "</td>"
                                                                            . "</tr>".
                                                                            "<tr>";
                                                                    }

                                                                }
                                                            }
                                                        }catch(Exception $x)
                                                        {
                                                            echo 'Caught exception: ',  $x->getMessage(), "\n";
                                                        }
                                                    $result.= "</table>"
                                                            . "</div>"
						."</div>"
					."</div>"
				."</div>"
			."</div>"
                                                            
                        . "<div class='panel-group col-md-7'>
			  <div class='panel panel-default'>
					<div class='panel-heading' style='text-align:center;'>
					<a data-toggle='collapse' data-parent='#accordion' href='#collapseMessages' class='glyphicon glyphicon-hand-up'><strong>Message</strong></a>
					</div>
					<div id='collapseMessages' class='panel-collapse collapse in'>
						<div class='panel-body'>"
                                                 ."<div class=''>
                                                    <form action='' method = 'POST'>
                                                    <div class='clearfix'>
                                                      <label for='tousername' class='col-md-2'> To: </label>
                                                      <input type='text' name = 'tousername' id='tousername' class='col-md-8' placeholder='Name' required autofocus>
                                                    </div>
                                                    <div class='msg-container'>
                                                        <div class='msg-area' id='msg-area'>";
                                                            $result.="<div class='msgc' style='margin-bottom: 30px;'> 
                                                                    <div class='msg msgfrom'> Send A New Message :) </div> 
                                                                    <div class='msgarr msgarrfrom'></div>
                                                                    <div class='msgsentby msgsentbyfrom'></div> 
                                                                    </div>";
                                             $result.="</div>
                                                        
                                                          <fieldset>
                                                          
                                                            <div class='clearfix'>
                                                            <label for='messages' class='col-md-2'> Message: </label>
                                                              <textarea class='col-md-8' rows='5' id='messages' name = 'messages' placeholder='Message' required autofocus></textarea>
                                                            </div>

                                                            <div class='row'>
                                                            <button class='btn primary col-md-2 col-md-offset-9' Style='margin-left:185px;' name = 'sendMessage' type='submit'>Send</button>
                                                            </div>
                                                          </fieldset>
                                                        </form>
                                                      </div>"
						."</div>"
					."</div>"
				."</div>"
			."</div>"
                . "</div>";
       
       return $result;
    }
    
    // Ajax Function To Update The Page
    function UpdatePage()
    {
        $result= '<script>
                $(function () {
                    var test = "";
                    var timer = 5;
                    function inTime() {
                        setTimeout(inTime, 1000);
                        if(timer === 0){
                             $("#msga").load("updateMessage.php");
                             $.post("UpdateMessage.php",{testing:test}, function(data){
                                 $("realTime h2").html(data); 
                             })
                             timer = 5;
                             clearTimeout(inTime);
                        }
                         timer--;  
                 }
                 inTime();
             });
            </script>';
        
        return $result;
    }
    
    // Keep the message box at the bottom of the page
    function KeepScrollBarAtTheBottom()
    {
        $result= '<script>
                    $("#msga").scrollTop(1000);
                    </script>';
        return $result;
    }
    
    // Message Content for a specific person
    function MessageContentPerPerson($tousername)
    {
       $myMessages = $this->GetMyInbox();
       $search = $this->GetMessages();
       $result= "
           <div class='row'>
           <div class='panel-group col-md-4'>
			  <div class='panel panel-default'>
					<div class='panel-heading' style='text-align:center;'>
					<a data-toggle='collapse' data-parent='#accordion' href='#collapseMyPlacedOffers' class='glyphicon glyphicon-hand-up'><strong>Inbox</strong></a>
					</div>
					<div id='collapseMyPlacedOffers' class='panel-collapse collapse in'>
						<div class='panel-body'>"
                                                    ."<div class='table-responsive scrollit' style='background-color:white; text-align:center;'>"
                                                        . "<table class='table sortable'>"
                                                        . "<tr style='text-align:center;'>"
                                                        . "     <th style='text-align:center;'>User</th>"
                                                        . "     <th style='text-align:center;'>Time</th>"
                                                        . "     <th style='text-align:center;'>Status</th>"
                                                        . "     <th style='text-align:center;'>Actions</th>"
                                                        . "</tr>";
                                                        try
                                                        {
                                                            if($myMessages != null)
                                                            {
                                                                foreach($myMessages as $row)
                                                                {
                                                                    if($row->seen == 0 && $row->tousername == $_SESSION['username'])
                                                                    {
                                                                        $result.= "<tr>"
                                                                                . "<td align='center'><a href='Messages.php?epr=view&fromusername=".$row->fromusername."'>$row->fromusername</a></td>"
                                                                                . "<td align='center'>$row->dateofmessage</td>"
                                                                                . "<td align='center' style='font-weight:bold; color:blue'>New</td>"
                                                                                . "<td>"
                                                                                . "     <a href='Messages.php?epr=view&fromusername=".$row->fromusername."'>Reply</a>"
                                                                                . "</td>"
                                                                                . "</tr>".
                                                                                "<tr>";
                                                                    }else if($row->seen == 1 && $row->tousername == $_SESSION['username'])
                                                                    {
                                                                            $result.= "<tr>"
                                                                            . "<td align='center'><a href='Messages.php?epr=view&fromusername=".$row->fromusername."'>$row->fromusername</a></td>"
                                                                            . "<td align='center'>$row->dateofmessage</td>"
                                                                            . "<td align='center' color:blue'>Seen</td>"
                                                                            . "<td>"
                                                                            . "     <a href='Messages.php?epr=view&fromusername=".$row->fromusername."'>Reply</a>"
                                                                            . "</td>"
                                                                            . "</tr>".
                                                                            "<tr>";
                                                                    }
                                                                }
                                                            }
                                                        }catch(Exception $x)
                                                        {
                                                            echo 'Caught exception: ',  $x->getMessage(), "\n";
                                                        }
                                                    $result.= "</table>"
                                                            . "</div>"
						."</div>"
					."</div>"
				."</div>"
			."</div>"
                                                            
                        . "<div class='panel-group col-md-8'>
			  <div class='panel panel-default'>
					<div class='panel-heading' style='text-align:center;'>
					<a data-toggle='collapse' data-parent='#accordion' href='#collapseMessages' class='glyphicon glyphicon-hand-up'><strong>Message</strong></a>
					</div>
					<div id='collapseMessages' class='panel-collapse collapse in'>
						<div class='panel-body'>"
                                                 ."<div class=''>
                                                    <form action='' method = 'POST'>
                                                    <div class='clearfix'>
                                                      <label for='tousername' class='col-md-2'> To: </label>
                                                      <input type='text' name = 'tousername' id='tousername' value='$tousername' class='col-md-8' placeholder='Name' autofocus>
                                                    </div>
                                                    <div class='msg-container'>
                                                        <div class='msg-area' id='msga'>";
                                                        try
                                                        {
                                                            if($search != null)
                                                            {
                                                                foreach($search as $row)
                                                                {
                                                                    if ($row->fromusername == $_SESSION['username'] && $row->tousername == $tousername)
                                                                    {
                                                                        $result.="<div class='msgc' style='margin-bottom: 30px;'> 
                                                                        <div class='msg msgfrom'> $row->message </div> 
                                                                        <div class='msgarr msgarrfrom'></div>
                                                                        <div class='msgsentby msgsentbyfrom'>Sent by $row->fromusername $row->dateofmessage</div> 
                                                                        </div>";
                                                                    }else if($row->fromusername == $tousername && $row->tousername == $_SESSION['username'])
                                                                    {
                                                                        $result.="<div class='msgc'> 
                                                                            <div class='msg'> $row->message </div>
                                                                            <div class='msgarr'></div>
                                                                            <div class='msgsentby'>Sent by $row->fromusername $row->dateofmessage</div>
                                                                        </div>";
                                                                    }
                                                                }
                                                            }
                                                         }catch(Exception $x)
                                                        {
                                                            echo 'Caught exception: ',  $x->getMessage(), "\n";
                                                        }
                                                    $result.="</div>
                                                        
                                                          <fieldset>
                                                          
                                                            <div class='clearfix'>
                                                            <label for='messages' class='col-md-2'> Message: </label>
                                                              <textarea class='col-md-8' rows='5' id='messages' name = 'messages' placeholder='Message' required autofocus></textarea>
                                                            </div>

                                                            <div class='row'>
                                                            <button class='btn primary col-md-2 col-md-offset-9' Style='margin-left:185px;' name = 'sendMessage' type='submit'>Send</button>
                                                            </div>
                                                          </fieldset>
                                                        </form>
                                                      </div>"
						."</div>"
					."</div>"
				."</div>"
			."</div>"
                . "</div>";
       
       return $result;
    }
    
    
    // Message Content Invalid Username
    function MessageInvalidUsernameContent($errors,$tousername,$messages)
    {
        $myMessages = $this->GetAllMyMessages($_SESSION['username']);
        
        
       $result= "
           <div class='row'>
           <div class='panel-group col-md-4'>
			  <div class='panel panel-default'>
					<div class='panel-heading' style='text-align:center;'>
					<a data-toggle='collapse' data-parent='#accordion' href='#collapseMyPlacedOffers' class='glyphicon glyphicon-hand-up'><strong>Inbox</strong></a>
					</div>
					<div id='collapseMyPlacedOffers' class='panel-collapse collapse in'>
						<div class='panel-body'>"
                                                    ."<div class='table-responsive scrollit' style='background-color:white; text-align:center;'>"
                                                        . "<table class='table sortable'>"
                                                        . "<tr style='text-align:center;'>"
                                                        . "     <th style='text-align:center;'>User</th>"
                                                        . "     <th style='text-align:center;'>Time</th>"
                                                        . "     <th style='text-align:center;'>Actions</th>"
                                                        . "</tr>";
                                                        try
                                                        {
                                                            if($myMessages != null)
                                                            {
                                                                foreach($myMessages as $row)
                                                                {
                                                                    $result.= "<tr>"
                                                                            . "<td align='center'><a href='SearchResult.php?epr=view&fromusername=".$row->fromusername."'>$row->fromusername</a></td>"
                                                                            . "<td align='center'>$row->fromusername</td>"
                                                                            . "<td>"
                                                                            . "     <a href='Messages.php?epr=delete&id=".$row->fromusername."'>Delete</a>"
                                                                            . "     <a href='Messages.php?epr=reply&id=".$row->fromusername."'>Reply</a>"
                                                                            . "</td>"
                                                                            . "</tr>".
                                                                            "<tr>";
                                                                }
                                                                
                                                            }
                                                        }catch(Exception $x)
                                                        {
                                                            echo 'Caught exception: ',  $x->getMessage(), "\n";
                                                        }
                                                    $result.= "</table>"
                                                            . "</div>"
						."</div>"
					."</div>"
				."</div>"
			."</div>"
                                                            
                        . "<div class='panel-group col-md-8'>
			  <div class='panel panel-default'>
					<div class='panel-heading' style='text-align:center;'>
					<a data-toggle='collapse' data-parent='#accordion' href='#collapseMessages' class='glyphicon glyphicon-hand-up'><strong>Message</strong></a>
					</div>
					<div id='collapseMessages' class='panel-collapse collapse in'>
						<div class='panel-body'>"
                                                 ."<div class=''>
                                                    <form action='' method = 'POST'>
                                                    <div class='clearfix'>
                                                      <label for='tousername' class='col-md-2 style='color:red'> To: </label>
                                                      <input type='text' name = 'tousername' id='tousername' value='$tousername' class='col-md-8' placeholder='Name' required autofocus>
                                                        <?php echo error_for('tousername') ?>
                                                        <p for='tousername'class='col-md-2' style='color:red;'> $errors[tousername] </p> 
                                                    </div>

                                                        <div class='msg-area' id='msg-area'>";
                                                            $result.="<div class='msgc' style='margin-bottom: 30px;'> 
                                                                    <div class='msg msgfrom'> Send A New Message :) </div> 
                                                                    <div class='msgarr msgarrfrom'></div>
                                                                    <div class='msgsentby msgsentbyfrom'></div> 
                                                                    </div>";
                                             $result.="</div>
                                                        
                                                          <fieldset>
                                                          
                                                            <div class='clearfix'>
                                                            <label for='messages' class='col-md-2'> Message: </label>
                                                              <textarea class='col-md-8' rows='5' id='messages' name = 'messages' value='' placeholder='Message' required autofocus>$messages</textarea>
                                                            </div>

                                                            <div class='row'>
                                                            <button class='btn primary col-md-2 col-md-offset-9' Style='margin-left:185px;' name = 'sendMessage' type='submit'>Send</button>
                                                            </div>
                                                          </fieldset>
                                                        </form>
                                                      </div>"
						."</div>"
					."</div>"
				."</div>"
			."</div>"
                . "</div>";
       
       return $result;
    }
    
    // Messenger Side Bar
    function CreateMessengerSideBar()
    {
         $result = "<div class='panel panel-default'>
					<div class='panel-heading' style='text-align:center;'>
					<a data-toggle='collapse' data-parent='#accordion' href='#collapseJObOverviewPage' class='glyphicon glyphicon-hand-up'><strong>Overview:</strong></a>
					</div>
					<div id='collapseJObOverviewPage' class='panel-collapse collapse in'>
						<div class='panel-body'>"
                                    ."<div class='col-md-12'>
                                                            <div class='profile-sidebar'>
                                                                    <!-- SIDEBAR MENU -->
                                                                    <div class='home-usermenu'>
                                                                            <ul class='nav'>
                                                                                    <li class='active'>
                                                                                            <a href='Home.php'>
                                                                                            <i class='glyphicon glyphicon-home'></i>
                                                                                            Home </a>
                                                                                    </li>
                                                                                    <li>
                                                                                            <a href='Search.php'>
                                                                                            <i class='glyphicon glyphicon-search'></i>
                                                                                            Search </a>
                                                                                    </li>
                                                                                    <li>
                                                                                            <a href='#' data-toggle='modal' data-target='#myModal'>
                                                                                            <i class='glyphicon glyphicon-book'></i>
                                                                                            Categories </a>
                                                                                    </li>
                                                                                    <li>
                                                                                            <a href='#' data-toggle='modal' data-target='#priceModal'>
                                                                                            <i class='glyphicon glyphicon-usd'></i>
                                                                                            Price </a>
                                                                                    </li>
                                                                                    <li>
                                                                                            <a href='SearchResult.php?epr=myJobs'>
                                                                                            <i class='gglyphicon glyphicon-pencil'></i>
                                                                                            My Jobs </a>
                                                                                    </li>
                                                                                    <li>
                                                                                            <a href='JobsOverview.php'>
                                                                                            <i class='glyphicon glyphicon-pencil'></i>
                                                                                            Job Offers </a>
                                                                                    </li>
                                                                                    <li>
                                                                                            <a href='Favorite.php'>
                                                                                            <i class='glyphicon glyphicon-heart'></i>
                                                                                            Favorite </a>
                                                                                    </li>
                                                                                    <li>
                                                                                            <a href='#' target='_blank'>
                                                                                            <i class='glyphicon glyphicon-italic'></i>
                                                                                            About Us </a>
                                                                                    </li>
                                                                                    <li>
                                                                                            <a href='#' target='_blank'>
                                                                                            <i class='glyphicon glyphicon-flag'></i>
                                                                                            Help </a>
                                                                                    </li>
                                                                            </ul>
                                                                    </div>
                                                                    <!-- END MENU -->
                                                            </div>
                                                    </div>"
						."</div>"
					."</div>"
                            ."</div>";
        return $result;
    }
    
    // Modal for searching based on categories
    function CategoryModal()
    {
        $typeModel = new TypeModel();
        
                $result = "<div class='modal fade' id='myModal' role='dialog'>
			<div class='modal-dialog'>
			
			  <!-- Modal content-->
			  <div class='modal-content'>
				<div class='modal-header'>
				  <button type='button' class='close' data-dismiss='modal'>&times;</button>
				  <h4 class='modal-title'>List Of Categories</h4>
				</div>
				<div class='modal-body'>
                                <div class='row'>
                                    <ul class='nav col-md-12' style='text-align:center;'>";
                                        try
                                        {
                                            $types = $typeModel->GetTypes();
                                            foreach($types as $row)
                                            {
                                                $result.= "<li class='active'>
                                            <a href='Home.php?epr=cat&id=".$row->typeId."'>
                                                <i class='glyphicon glyphicon-home'></i>";
                                              $result.=  $row->name;
                                            $result.= "</a>
                                                      </li>";
                                            }
                                        }catch(Exception $x)
                                        {
                                            echo 'Caught exception: ',  $x->getMessage(), "\n";
                                        }
                                        $result .= "
                                    </ul>
                                </div>
				</div>
				<div class='modal-footer'>
				  <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
				</div>
			  </div>
			  
			</div>
	  </div>";
        return $result;
    }
    
    // Modal for searching based on price
    function PriceModal()
    {
                $result = "<div class='modal fade' id='priceModal' role='dialog'>
			<div class='modal-dialog'>
			
			  <!-- Modal content-->
			  <div class='modal-content col-md-8'>
				<div class='modal-header'>
				  <button type='button' class='close' data-dismiss='modal'>&times;</button>
				  <h4 class='modal-title'>Search By Price</h4>
				</div>
				<div class='modal-body'>
                                        <form action='' method = 'POST'>
                                          <fieldset>
                                            <div class='row' style='padding-bottom:10px;'>
                                                <input type='text' name = 'min' id='min' style='width:50%;' class='col-md-6'placeholder='max' required autofocus>
                                                <input type='text' name = 'max' id='max' style='width:50%;' class='col-md-6'  placeholder='max' required autofocus>
                                            </div>
                                            <div class='row'>
                                            <button class='btn btn-info col-md-4 col-md-offset-8' name = 'searchByPrice' type='submit'>Search</button>
                                            </div>
                                          </fieldset>
                                        </form>"                        

                                ."
				</div>
				<div class='modal-footer'>
                                  <div class='row'>
                                    <button type='button' class='btn btn-default col-md-4 col-md-offset-4' data-dismiss='modal'>Close</button>
                                    
                                  </div>
				</div>
			  </div>
			  
			</div>
	  </div>";
        return $result;
    }
}
