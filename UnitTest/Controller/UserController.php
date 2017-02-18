<script>
//Display a confirmation box when trying to delete an object
function showConfirm()
{
    // build the confirmation box
    var c = confirm("Are you sure you wish to delete your account?");
    
    // if true, delete item and refresh
    if(c)
        window.location = "AccountSettings.php?delete=" + 0;
}
</script>
<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserController
 *
 * @author Jake Valino
 */

require 'Model/UserModel.php';
require 'Model/PlacedOffersModel.php';
require 'Model/FollowingModel.php';
require 'Model/NotificationModel.php';


class UserController {

    //put your code here
    
    //Code to create the user profile sidebar
    function CreateUserProfileSidebar()
    {
        $userModel = new UserModel();
        $user = $userModel->CheckUser($_SESSION['username']);
        $notificationModel = new NotificationModel();
        $userNotification = $notificationModel->CountNotificationByToUsername($_SESSION['username']);
        require 'Model/MessagesModel.php';
        $messagesModel = new MessagesModel();
        $myMessages = $messagesModel->CountAllMyMessages($_SESSION['username']);
        require 'Model/RequestModel.php';
        $requestModel = new RequestModel();
        $myRequest = $requestModel->CountRequestsByTargetUserId($_SESSION['id']);
        
        $result = "<div class='col-md-12'>
			<div class='profile-sidebar'>
				<!-- SIDEBAR USERPIC -->
				<div class='profile-userpic'>
					<img src='$user->photo' class='img-responsive' alt=''>
				</div>
				<!-- END SIDEBAR USERPIC -->
				<!-- SIDEBAR USER TITLE -->
				<div class='profile-usertitle'>
					<div class='profile-usertitle-name'>
						$_SESSION[username]
					</div>
					<div class='profile-usertitle-job'>
						Developer
					</div>
				</div>
				<!-- END SIDEBAR USER TITLE -->
				<!-- SIDEBAR BUTTONS -->
				<div class='nav-button-sidebar'>";
                                   try
                                   {
                                        if($userNotification != null && $myMessages != null && $myRequest != null)
                                        {

                                                $result.="<div class='row' style='padding-bottom:4px;'>
                                                        <a href='Request.php' class='btn btn-warning btn-sm' role='button'>Request &nbsp<span class='badge'>$myRequest</span></a>
                                                    </div>"
                                                        . "<a href='Messages.php' style='margin-bottom:5px;' class='btn btn-success btn-sm' role='button'>Inbox &nbsp<span class='badge'>$myMessages</span></a>&nbsp
                                                    <div class='row'>
                                                <a href='Notification.php' class='btn btn-danger btn-sm' role='button'>Notification &nbsp<span class='badge'>$userNotification</span></a>"
                                                . "</div>";
                                        }else if($userNotification != null && $myMessages != null && $myRequest == null)
                                        {
                                                $result.="<div class='row' style='padding-bottom:4px;'>
                                                        <a href='Request.php' class='btn btn-warning btn-sm' role='button'>Request</a>
                                                    </div>"
                                                        . "<a href='Messages.php' style='margin-bottom:5px;' class='btn btn-success btn-sm' role='button'>Inbox &nbsp<span class='badge'>$myMessages</span></a>&nbsp
                                                    <div class='row'>
                                                <a href='Notification.php' class='btn btn-danger btn-sm' role='button'>Notification &nbsp<span class='badge'>$userNotification</span></a>"
                                                . "</div>";  
                                        }else if($userNotification == null && $myMessages != null && $myRequest != null)
                                        {
                                                $result.="<div class='row' style='padding-bottom:4px;'>
                                                        <a href='Request.php' class='btn btn-warning btn-sm' role='button'>Request &nbsp<span class='badge'>$myRequest</span></a>
                                                    </div>"
                                                        . "<a href='Messages.php' style='margin-bottom:5px;' class='btn btn-success btn-sm' role='button'>Inbox &nbsp<span class='badge'>$myMessages</span></a>&nbsp
                                                    <div class='row'>
                                                <a href='Notification.php' class='btn btn-danger btn-sm' role='button'>Notification</a>"
                                                . "</div>";  
                                        }else if($userNotification != null && $myMessages == null && $myRequest != null)
                                        {
                                                $result.="<div class='row' style='padding-bottom:4px;'>
                                                        <a href='Request.php' class='btn btn-warning btn-sm' role='button'>Request &nbsp<span class='badge'>$myRequest</span></a>
                                                    </div>"
                                                        . "<a href='Messages.php' style='margin-bottom:5px;' class='btn btn-success btn-sm' role='button'>Inbox</a>&nbsp
                                                    <div class='row'>
                                                <a href='Notification.php' class='btn btn-danger btn-sm' role='button'>Notification &nbsp<span class='badge'>$userNotification</span></a>"
                                                . "</div>";  
                                        }else if($userNotification == null && $myMessages == null && $myRequest != null)
                                        {
                                                $result.="<div class='row' style='padding-bottom:4px;'>
                                                        <a href='Request.php' class='btn btn-warning btn-sm' role='button'>Request &nbsp<span class='badge'>$myRequest</span></a>
                                                    </div>"
                                                        . "<a href='Messages.php' style='margin-bottom:5px;' class='btn btn-success btn-sm' role='button'>Inbox</a>&nbsp
                                                    <div class='row'>
                                                <a href='Notification.php' class='btn btn-danger btn-sm' role='button'>Notification</a>"
                                                . "</div>";  
                                        }else if($userNotification == null && $myMessages != null && $myRequest == null)
                                        {
                                                $result.="<div class='row' style='padding-bottom:4px;'>
                                                        <a href='Request.php' class='btn btn-warning btn-sm' role='button'>Request</a>
                                                    </div>"
                                                        . "<a href='Messages.php' style='margin-bottom:5px;' class='btn btn-success btn-sm' role='button'>Inbox &nbsp<span class='badge'>$myMessages</span></a>&nbsp
                                                    <div class='row'>
                                                <a href='Notification.php' class='btn btn-danger btn-sm' role='button'>Notification</a>"
                                                . "</div>";  
                                        }else if($userNotification != null && $myMessages == null && $myRequest == null)
                                        {
                                                $result.="<div class='row' style='padding-bottom:4px;'>
                                                        <a href='Request.php' class='btn btn-warning btn-sm' role='button'>Request</a>
                                                    </div>"
                                                        . "<a href='Messages.php' style='margin-bottom:5px;' class='btn btn-success btn-sm' role='button'>Inbox</a>&nbsp
                                                    <div class='row'>
                                                <a href='Notification.php' class='btn btn-danger btn-sm' role='button'>Notification &nbsp<span class='badge'>$userNotification</span></a>"
                                                . "</div>";  
                                        }else if($userNotification == null && $myMessages == null && $myRequest == null)
                                        {
                                                $result.="<a href='Messages.php' class='btn btn-success btn-sm' role='button'>Inbox</a>
                                                    <div class='row' style='margin-top:10px;'>
                                                    <a href='Request.php' class='btn btn-warning btn-sm' role='button'>Request</a>
                                                    <a href='Notification.php' class='btn btn-danger btn-sm' role='button'>Notification</a>
                                                    </div>
                                                "; 
                                        }
                                    }catch(Exception $x)
                                    {
                                        echo 'Caught exception: ',  $x->getMessage(), "\n";
                                    } 
				$result.="</div>
				<!-- END SIDEBAR BUTTONS -->
				<!-- SIDEBAR MENU -->
				<div class='profile-usermenu'>
					<ul class='nav'>
						<li class='active'>
							<a href='UserAccount.php'>
							<i class='glyphicon glyphicon-home'></i>
							Overview </a>
						</li>
						<li>
							<a href='AccountSettings.php'>
							<i class='glyphicon glyphicon-user'></i>
							Account Settings </a>
						</li>
						<li>
							<a href='JobsOverview.php'>
							<i class='glyphicon glyphicon-ok'></i>
							Jobs </a>
						</li>
						<li>
							<a href='UserReview.php?epr=review&id=".$_SESSION['id']."'>
							<i class='glyphicon glyphicon-comment'></i>
							My Review </a>
						</li>
						<li>
							<a href='Following.php'>
							<i class='glyphicon glyphicon-star-empty'></i>
							Followers </a>
						</li>
                                                <li>
							<a href='Logout.php'>
							<i class='glyphicon glyphicon-log-out'></i>
							Logout </a>
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
		</div>";
                
        return $result;
    }
    
    //Code to create the user profile sidebar
    function CreateUserReviewSidebar()
    {
        $userModel = new UserModel();
        $user = $userModel->CheckUser($_SESSION['username']);
        $notificationModel = new NotificationModel();
        $userNotification = $notificationModel->CountNotificationByToUsername($_SESSION['username']);
        
        require 'Model/MessagesModel.php';
	$messagesModel = new MessagesModel();
	$myMessages = $messagesModel->CountAllMyMessages($_SESSION['username']);
        
        require 'Model/RequestModel.php';
        $requestModel = new RequestModel();
        $myRequest = $requestModel->CountRequestsByTargetUserId($_SESSION['id']);
        
        $result = "<div class='col-md-12'>
			<div class='profile-sidebar'>
				<!-- SIDEBAR USERPIC -->
				<div class='profile-userpic'>
					<img src='$user->photo' class='img-responsive' alt=''>
				</div>
				<!-- END SIDEBAR USERPIC -->
				<!-- SIDEBAR USER TITLE -->
				<div class='profile-usertitle'>
					<div class='profile-usertitle-name'>
						$_SESSION[username]
					</div>
					<div class='profile-usertitle-job'>
						Developer
					</div>
				</div>
				<!-- END SIDEBAR USER TITLE -->
				<!-- SIDEBAR BUTTONS -->
				<div class='nav-button-sidebar'>";
                                   try
                                   {
                                        if($userNotification != null && $myMessages != null && $myRequest != null)
                                        {

                                                $result.="<div class='row' style='padding-bottom:4px;'>
                                                        <a href='Request.php' class='btn btn-warning btn-sm' role='button'>Request &nbsp<span class='badge'>$myRequest</span></a>
                                                    </div>"
                                                        . "<a href='Messages.php' style='margin-bottom:5px;' class='btn btn-success btn-sm' role='button'>Inbox &nbsp<span class='badge'>$myMessages</span></a>&nbsp
                                                    <div class='row'>
                                                <a href='Notification.php' class='btn btn-danger btn-sm' role='button'>Notification &nbsp<span class='badge'>$userNotification</span></a>"
                                                . "</div>";
                                        }else if($userNotification != null && $myMessages != null && $myRequest == null)
                                        {
                                                $result.="<div class='row' style='padding-bottom:4px;'>
                                                        <a href='Request.php' class='btn btn-warning btn-sm' role='button'>Request</a>
                                                    </div>"
                                                        . "<a href='Messages.php' style='margin-bottom:5px;' class='btn btn-success btn-sm' role='button'>Inbox &nbsp<span class='badge'>$myMessages</span></a>&nbsp
                                                    <div class='row'>
                                                <a href='Notification.php' class='btn btn-danger btn-sm' role='button'>Notification &nbsp<span class='badge'>$userNotification</span></a>"
                                                . "</div>";  
                                        }else if($userNotification == null && $myMessages != null && $myRequest != null)
                                        {
                                                $result.="<div class='row' style='padding-bottom:4px;'>
                                                        <a href='Request.php' class='btn btn-warning btn-sm' role='button'>Request &nbsp<span class='badge'>$myRequest</span></a>
                                                    </div>"
                                                        . "<a href='Messages.php' style='margin-bottom:5px;' class='btn btn-success btn-sm' role='button'>Inbox &nbsp<span class='badge'>$myMessages</span></a>&nbsp
                                                    <div class='row'>
                                                <a href='Notification.php' class='btn btn-danger btn-sm' role='button'>Notification</a>"
                                                . "</div>";  
                                        }else if($userNotification != null && $myMessages == null && $myRequest != null)
                                        {
                                                $result.="<div class='row' style='padding-bottom:4px;'>
                                                        <a href='Request.php' class='btn btn-warning btn-sm' role='button'>Request &nbsp<span class='badge'>$myRequest</span></a>
                                                    </div>"
                                                        . "<a href='Messages.php' style='margin-bottom:5px;' class='btn btn-success btn-sm' role='button'>Inbox</a>&nbsp
                                                    <div class='row'>
                                                <a href='Notification.php' class='btn btn-danger btn-sm' role='button'>Notification &nbsp<span class='badge'>$userNotification</span></a>"
                                                . "</div>";  
                                        }else if($userNotification == null && $myMessages == null && $myRequest != null)
                                        {
                                                $result.="<div class='row' style='padding-bottom:4px;'>
                                                        <a href='Request.php' class='btn btn-warning btn-sm' role='button'>Request &nbsp<span class='badge'>$myRequest</span></a>
                                                    </div>"
                                                        . "<a href='Messages.php' style='margin-bottom:5px;' class='btn btn-success btn-sm' role='button'>Inbox</a>&nbsp
                                                    <div class='row'>
                                                <a href='Notification.php' class='btn btn-danger btn-sm' role='button'>Notification</a>"
                                                . "</div>";  
                                        }else if($userNotification == null && $myMessages != null && $myRequest == null)
                                        {
                                                $result.="<div class='row' style='padding-bottom:4px;'>
                                                        <a href='Request.php' class='btn btn-warning btn-sm' role='button'>Request</a>
                                                    </div>"
                                                        . "<a href='Messages.php' style='margin-bottom:5px;' class='btn btn-success btn-sm' role='button'>Inbox &nbsp<span class='badge'>$myMessages</span></a>&nbsp
                                                    <div class='row'>
                                                <a href='Notification.php' class='btn btn-danger btn-sm' role='button'>Notification</a>"
                                                . "</div>";  
                                        }else if($userNotification != null && $myMessages == null && $myRequest == null)
                                        {
                                                $result.="<div class='row' style='padding-bottom:4px;'>
                                                        <a href='Request.php' class='btn btn-warning btn-sm' role='button'>Request</a>
                                                    </div>"
                                                        . "<a href='Messages.php' style='margin-bottom:5px;' class='btn btn-success btn-sm' role='button'>Inbox</a>&nbsp
                                                    <div class='row'>
                                                <a href='Notification.php' class='btn btn-danger btn-sm' role='button'>Notification &nbsp<span class='badge'>$userNotification</span></a>"
                                                . "</div>";  
                                        }else if($userNotification == null && $myMessages == null && $myRequest == null)
                                        {
                                                $result.="<a href='Messages.php' class='btn btn-success btn-sm' role='button'>Inbox</a>
                                                    <div class='row' style='margin-top:10px;'>
                                                    <a href='Request.php' class='btn btn-warning btn-sm' role='button'>Request</a>
                                                    <a href='Notification.php' class='btn btn-danger btn-sm' role='button'>Notification</a>
                                                    </div>
                                                "; 
                                        }
                                    }catch(Exception $x)
                                    {
                                        echo 'Caught exception: ',  $x->getMessage(), "\n";
                                    }
				$result.="</div>
				<!-- END SIDEBAR BUTTONS -->
				<!-- SIDEBAR MENU -->
				<div class='profile-usermenu'>
					<ul class='nav'>
						<li>
							<a href='UserAccount.php'>
							<i class='glyphicon glyphicon-home'></i>
							Overview </a>
						</li>
						<li>
							<a href='AccountSettings.php'>
							<i class='glyphicon glyphicon-user'></i>
							Account Settings </a>
						</li>
						<li>
							<a href='JobsOverview.php'>
							<i class='glyphicon glyphicon-ok'></i>
							Jobs </a>
						</li>
						<li class='active'>
							<a href='UserReview.php?epr=review&id=".$_SESSION['id']."'>
							<i class='glyphicon glyphicon-comment'></i>
							My Review </a>
						</li>
						<li>
							<a href='Following.php'>
							<i class='glyphicon glyphicon-star-empty'></i>
							Followers </a>
						</li>
                                                <li>
							<a href='Logout.php'>
							<i class='glyphicon glyphicon-log-out'></i>
							Logout </a>
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
		</div>";
                
        return $result;
    }
    
    //Code to create the user profile sidebar
    function CreateUserAccSettingsProfileSidebar()
    {
        $userModel = new UserModel();
        $user = $userModel->CheckUser($_SESSION['username']);
        $result = "<div class='col-md-12'>
			<div class='profile-sidebar'>
				<!-- SIDEBAR USERPIC -->
				<div class='profile-userpic'>
					<img src='$user->photo' class='img-responsive' alt=''>
				</div>
				<!-- END SIDEBAR USERPIC -->
				<!-- SIDEBAR USER TITLE -->
				<div class='profile-usertitle'>
					<div class='profile-usertitle-name'>
						$_SESSION[username]
					</div>
					<div class='profile-usertitle-job'>
						Developer
					</div>
				</div>
				<!-- END SIDEBAR USER TITLE -->
				<!-- SIDEBAR BUTTONS -->
				<div class='profile-userbuttons'>

                                        <a href='#' data-toggle='modal' class='btn btn-success btn-sm' data-target='#profilePictureModal' onclick='$(#profilePictureModal).modal({backdrop: static});'>
                                        Profile Picture </a>
 
				</div>
				<!-- END SIDEBAR BUTTONS -->
				<!-- SIDEBAR MENU -->
				<div class='profile-usermenu'>
					<ul class='nav'>
						<li>
							<a href='UserAccount.php'>
							<i class='glyphicon glyphicon-home'></i>
							Overview </a>
						</li>
						<li class='active'>
							<a href='AccountSettings.php'>
							<i class='glyphicon glyphicon-user'></i>
							Account Settings </a>
						</li>
						<li>
							<a href='JobsOverview.php'>
							<i class='glyphicon glyphicon-ok'></i>
							Jobs </a>
						</li>
						<li>
							<a href='UserReview.php?epr=review&id=".$_SESSION['id']."'>
							<i class='glyphicon glyphicon-comment'></i>
							My Review </a>
						</li>
						<li>
							<a href='Following.php'>
							<i class='glyphicon glyphicon-star-empty'></i>
							Followers </a>
						</li>
                                                <li>
							<a href='Logout.php'>
							<i class='glyphicon glyphicon-log-out'></i>
							Logout </a>
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
		</div>";
                
        return $result;
    }
    
    // Modal To Send A New Messages
    function SendMessageModal($id)
    {
        $userModel = new UserModel();
        
        $userName = $userModel->GetUserById($id)->username;
        $_SESSION['SendUsername']=$userName;
                $result = "
                    <div class='modal fade' id='sendMessageModal' role='dialog'>
			<div class='modal-dialog'>
			
			  <!-- Modal content-->
			  <div class='modal-content'>
				<div class='modal-header'>
				  <button type='button' class='close' data-dismiss='modal'>&times;</button>
				  <h4 class='modal-title'>Send User a Message</h4>
				</div>
				<div class='modal-body'>
                                <div class='row'>
                                    <form action='' method = 'POST'>
                                                    <div class='msg-container'>
                                                        <div class='msg-area' id='msg-area'>";
                                                            $result.="<div class='msgc' style='margin-bottom: 30px;'> 
                                                                    <div class='msg msgfrom'> Send A New Message :) </div> 
                                                                    <div class='msgarr msgarrfrom'></div>
                                                                    <div class='msgsentby msgsentbyfrom'>Type your message in the message box and click send.</div> 
                                                                    </div>";

                                                            $result.="<div class='msgc'> 
                                                                      <div class='msg'> <a href='Messages.php?epr=view&fromusername=".$userName."'> View Previous Conversation </a> </div>
                                                                      <div class='msgarr'></div>
                                                                      <div class='msgsentby'>View your previous conversation between this user</div>
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
    
    // Modal To Send A New Messages
    function ProfilePictureModal()
    {
                $result = "
                    <div class='modal fade' id='profilePictureModal' role='dialog'>
			<div class='modal-dialog'>
			
			  <!-- Modal content-->
			  <div class='modal-content'>
				<div class='modal-header'>
				  <button type='button' class='close' data-dismiss='modal'>&times;</button>
				  <h4 class='modal-title'>Upload Profile Picture</h4>
				</div>
				<div class='modal-body'>
                                                    <form action='uploadProfilePicture.php' method='post' enctype='multipart/form-data'>
                                                        <div class='row'>
                                                            <input required class='col-md-8' type='file' name='file'>
                                                            <input type='submit' value='upload'>
                                                        </div>
                                                    </form>
				</div>
				<div class='modal-footer'>
				  <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
				</div>
			  </div>
			  
			</div>
	  </div>";
        return $result;
    }

    //Code To Create Form to allow user change account details
    function CreateUserUpdateForm($firstName,$lastName,$usernameRegister,$password,$email,$phone)
    {
        $result = " <div class='register-form'>
          <div class='row'>
            <h2 class='col-md-12' style='text-align:center;'>Change Account Details</h2>
          </div>
          <div class='row'>
            <p class='col-md-3'>e.g. Change FirstName and Save</p>
          </div>
          <div class='row'>
           &nbsp&nbsp<a href='' onclick='showConfirm()' class='btn btn-info col-md-2 col-md-offset-9'>Delete Account</a>
          </div>
          </br>
          <form action='' method = 'POST'>
            <fieldset>
              <div class='clearfix'>
                <label for='firstName' class='col-md-2'> First Name: </label>
                <input type='text' name = 'firstName' class='col-md-8' id='firstName' value='$firstName'placeholder='First Name' required autofocus>
              </div>
              <div class='clearfix'>
              <label for='lastName' class='col-md-2'> Last Name: </label>
                <input type='text' name = 'lastName' class='col-md-8' value='$lastName' placeholder='Last Name' required autofocus>
              </div>
              <div class='clearfix'>
              <label for='usernameRegister' class='col-md-2'> Username: </label>
                    <input type='text' id='usernameRegister' class='col-md-8' name = 'usernameRegister' value='$usernameRegister' placeholder='Username' required autofocus>
                    <?php echo error_for('usernameRegister') ?>
              </div>
              <div class='clearfix'>
              <label for='password' class='col-md-2'> Password: </label>
                <input type='password' name = 'password' class='col-md-8' value='$password' placeholder='Password' required>
              </div>
              <div class='clearfix'>
              <label for='email' class='col-md-2'> Email: </label>
                <input type='text' name = 'email' class='col-md-8' value='$email' placeholder='email' required>
              </div>
              <div class='clearfix'>
                <label for='phone' class='col-md-2'> Phone: </label>
                <input type='text' name = 'phone' class='col-md-8' value='$phone' placeholder='phone' required>
              </div>
              <button class='btn primary col-md-2 col-md-offset-8' name = 'save' type='submit'>Save</button>
            </fieldset>
          </form>
        </div>"; //This ensures that the data entered by the user retains retains 
                
        return $result;
    }
    
    //Code To Create Resume Form
    function CreateResumeForm($id)
    {
        $userModel = new UserModel();
        $user = $userModel->GetUserById($id);
        
        $result = "<div class='row'>"
                . "<div class='panel-group col-md-6'>
			  <div class='panel panel-default'>
					<div class='panel-heading' style='text-align:center;'>
					<a data-toggle='collapse' data-parent='#accordion' href='#collapseCV' class='glyphicon glyphicon-hand-up'><strong>CV</strong></a>
					</div>
					<div id='collapseCV' class='panel-collapse collapse in'>
						<div class='panel-body'>
                                                    <form action='upload.php' method='post' enctype='multipart/form-data'>
                                                    <div class='row'>
                                                        <p class='col-md-12' style=' font-size:20px;'> Upload A New CV</p>
                                                    </div>
                                                        <div class='row'>
                                                            <input required class='col-md-6' type='file' name='file'>
                                                            <input type='submit' value='upload'>
                                                        </div>
                                                    </form>";
                                                    if($user->cv != NULL)
                                                    {
                                                        $result.="<div class='row'>
                                                            <p class='col-md-12' style=' font-size:20px;'> Download CV</p>
                                                        </div>
                                                        <a href='download.php?epr=cv&path=".$user->cv."'><img src='Images/wordicon.png' alt='CV' style=' display: block; margin: auto; text-align:center; margin-top:10px;'></a>";
                                                    }

						$result.="</div>"
					."</div>"
				."</div>"
			."</div>"

                                                        
                        . "<div class='panel-group col-md-6'>
			  <div class='panel panel-default'>
					<div class='panel-heading' style='text-align:center;'>
					<a data-toggle='collapse' data-parent='#accordion' href='#collapseCoverLetter' class='glyphicon glyphicon-hand-up'><strong>Cover Letter</strong></a>
					</div>
					<div id='collapseCoverLetter' class='panel-collapse collapse in'>
						<div class='panel-body'>
                                                    <form action='uploadCoverLetter.php' method='post' enctype='multipart/form-data'>
                                                    <div class='row'>
                                                        <p class='col-md-12' style=' font-size:20px;'> Upload A New Cover Letter</p>
                                                    </div>
                                                        <div class='row'>
                                                            <input required class='col-md-6' type='file' name='file'>
                                                            <input type='submit' value='upload'>
                                                        </div>
                                                    </form>";
                                                    if($user->coverletter != NULL)
                                                    {
                                                        $result.="<div class='row'>
                                                            <p class='col-md-12' style=' font-size:20px;'> Download Cover Letter</p>
                                                        </div>
                                                        <a href='download.php?epr=cv&path=".$user->coverletter."'><img src='Images/wordicon.png' alt='CV' style=' display: block; margin: auto; text-align:center; margin-top:10px;'></a>";
                                                    }

						$result.="</div>"
					."</div>"
				."</div>"
			."</div>"
                . "</div>";
        return $result;
    }
    
    //Use this form when an invalid Email occurs
    function CreateUserUpdateFormInvalidEmail($errors,$firstName,$lastName,$usernameRegister,$password,$email,$phone)
    {
        $result = " <div class='register-form'>
                <div class='row'>
                  <h2 class='col-md-12' style='text-align:center;'>Change Account Details</h2>
                </div>
                <div class='row'>
                  <p class='col-md-3'>e.g. Change FirstName and Save</p>
                </div>
                <div class='row'>
                 &nbsp&nbsp<a href='' onclick='showConfirm()' class='btn btn-info col-md-2 col-md-offset-9'>Delete Account</a>
                </div>
                </br>
              <form action='' method = 'POST'>
                <fieldset>
                  <div class='clearfix'>
                    <label for='firstName' class='col-md-2'> First Name: </label>
                    <input type='text' class='col-md-8' name = 'firstName' id='firstName' value='$firstName'placeholder='First Name' required autofocus>
                  </div>
                  <div class='clearfix'>
                  <label for='lastName' class='col-md-2'> Last Name: </label>
                    <input type='text' class='col-md-8' name = 'lastName' value='$lastName' placeholder='Last Name' required autofocus>
                  </div>
                  <div class='clearfix'>
                  <label for='usernameRegister' class='col-md-2'> Username: </label>
                        <input type='text' class='col-md-8' id='usernameRegister' name = 'usernameRegister' value='$usernameRegister' placeholder='Username' required autofocus>
                  </div>
                  <div class='clearfix'>
                  <label for='password' class='col-md-2'> Password: </label>
                    <input type='password' class='col-md-8' name = 'password' value='$password' placeholder='Password' required>
                  </div>
                  <div class='clearfix'>
                  <label for='email' class='col-md-2' style='color:red'> Email: </label>
                    <input type='text' name = 'email' class='col-md-6' value='$email' placeholder='email' required>
                    <p for='email' class='col-md-2' style='color:red;'> $errors[email] </p> 
                  </div>
                  <div class='clearfix'>
                    <label for='phone' class='col-md-2'> Phone: </label>
                    <input type='text' class='col-md-8' name = 'phone' value='$phone' placeholder='phone' required>
                  </div>
                  <button class='btn primary col-md-2 col-md-offset-8' name = 'save' type='submit'>Save</button>
                </fieldset>
              </form>
            </div>"; //This ensures that the data entered by the user retains retains 
                
        return $result;
    }
    
    function CreateUserUpdateFormInvalidPhone($errors,$firstName,$lastName,$usernameRegister,$password,$email,$phone)
    {
        $result = " <div class='register-form'>
                    <div class='row'>
                      <h2 class='col-md-12' style='text-align:center;'>Change Account Details</h2>
                    </div>
                    <div class='row'>
                      <p class='col-md-3'>e.g. Change FirstName and Save</p>
                    </div>
                    <div class='row'>
                     &nbsp&nbsp<a href='' onclick='showConfirm()' class='btn btn-info col-md-2 col-md-offset-9'>Delete Account</a>
                    </div>
                    </br>
                        <form action='' method = 'POST'>
                          <fieldset>
                            <div class='clearfix'>
                              <label for='firstName' class='col-md-2'> First Name: </label>
                              <input type='text' class='col-md-8' name = 'firstName' id='firstName' value='$firstName'placeholder='First Name' required autofocus>
                            </div>
                            <div class='clearfix'>
                            <label for='lastName' class='col-md-2'> Last Name: </label>
                              <input type='text' class='col-md-8' name = 'lastName' value='$lastName'placeholder='Last Name' required autofocus>
                            </div>
                            <div class='clearfix'>
                            <label for='usernameRegister' class='col-md-2'> Username: </label>
                                  <input type='text' class='col-md-8' id='usernameRegister' name = 'usernameRegister' value='$usernameRegister' placeholder='Username' required autofocus>
                            </div>
                            <div class='clearfix'>
                            <label for='password' class='col-md-2'> Password: </label>
                              <input type='password' class='col-md-8' name = 'password' value='$password' placeholder='Password' required>
                            </div>
                            <div class='clearfix'>
                            <label for='email' class='col-md-2'> Email: </label>
                              <input type='text' class='col-md-8' name = 'email' value='$email' placeholder='email' required>
                            </div>
                            <div class='clearfix'>
                              <label for='phone' style='color:red' class='col-md-2'> Phone: </label>
                              <input type='text' name = 'phone' class='col-md-6' value='$phone' placeholder='phone' required>
                              <p for='phone' class='col-md-2' style='color:red;'> $errors[phone] </p> 
                            </div>
                            <button class='btn primary col-md-2 col-md-offset-8' name = 'save' type='submit'>Save</button>
                          </fieldset>
                        </form>
                      </div>"; //This ensures that the data entered by the user retains retains 
                
        return $result;
    }
    
    //Use this form when an invalid Username occurs
    function CreateUserUpdateFormInvalidUsername($errors,$firstName,$lastName,$usernameRegister,$password,$email,$phone)
    {
        $result = " <div class='register-form'>
                <div class='row'>
                  <h2 class='col-md-12' style='text-align:center;'>Change Account Details</h2>
                </div>
                <div class='row'>
                  <p class='col-md-3'>e.g. Change FirstName and Save</p>
                </div>
                <div class='row'>
                 &nbsp&nbsp<a href='' onclick='showConfirm()' class='btn btn-info col-md-2 col-md-offset-9'>Delete Account</a>
                </div>
                </br>
          <form action='' method = 'POST'>
            <fieldset>
              <div class='clearfix'>
                <label for='firstName' class='col-md-2'> First Name: </label>
                <input type='text' class='col-md-8' name = 'firstName' id='firstName' value='$firstName' placeholder='First Name' required autofocus>
              </div>
              <div class='clearfix'>
              <label for='lastName' class='col-md-2'> Last Name: </label>
                <input type='text' class='col-md-8' name = 'lastName' value='$lastName' placeholder='Last Name' required autofocus>
              </div>
              <div class='clearfix'>
              <label for='usernameRegister' class='col-md-2' style='color:red'> Username: </label>
                    <input type='text' id='usernameRegister' class='col-md-6' name = 'usernameRegister' value='$usernameRegister' placeholder='Username' required autofocus>
                    <?php echo error_for('usernameRegister') ?>
                    <p for='usernameRegister'class='col-md-2' style='color:red;'> $errors[usernameRegister] </p> 
              </div>
              <div class='clearfix'>
              <label for='password' class='col-md-2'> Password: </label>
                <input type='password' class='col-md-8' name = 'password' value='$password' placeholder='Password' required>
              </div>
              <div class='clearfix'>
              <label for='email' class='col-md-2'> Email: </label>
                <input type='text' class='col-md-8' name = 'email' value='$email' placeholder='email' required>
              </div>
              <div class='clearfix'>
                <label for='phone' class='col-md-2'> Phone: </label>
                <input type='text' class='col-md-8' name = 'phone' value='$phone' placeholder='phone' required>
              </div>
              <button class='btn primary col-md-2 col-md-offset-1' name = 'save' type='submit'>Save</button>
            </fieldset>
          </form>
        </div>"; //This ensures that the data entered by the user retains retains 
                
        return $result;
    }
    
    //Code for default content 
    function CreateOverviewContent($id)
    {
        require 'Model/TypeModel.php';
        require 'Model/QualificationModel.php';
        require 'Model/JobModel.php';
        require 'Model/UserReviewModel.php';
        
        $userModel = new UserModel();
        
        $jobModel = new JobModel();
        $qualificationModel = new QualificationModel();
        
        $search = $jobModel->GetJobsByUserID($id);
        $typeModel = new TypeModel();
        
        $placedOffersModel = new PlacedOffersModel();
        $allOfUsersPlacedOffers = $placedOffersModel->GetAllPlacedOffersByUserID($id);
        $offersToUsersJob= $placedOffersModel->GetAllPlacedOffersToUsersJob($id);
        
        $userReviewModel = new UserReviewModel();
        $review = $userReviewModel->GetUserReviewById($id);
        $count = $userReviewModel->GetNumberOfUserReviewById($id);
        
        $result = "<H4 Style='text-align:center;'>Welcome to the User Account Page: </H4>"
                . "<div class='row'>"
                . "<div class='panel-group col-md-7'>
			  <div class='panel panel-default'>
					<div class='panel-heading' style='text-align:center;'>
					<a data-toggle='collapse' data-parent='#accordion' href='#collapseadvertisedjobs' class='glyphicon glyphicon-hand-up'><strong>My Advertised Jobs</strong></a>
					</div>
					<div id='collapseadvertisedjobs' class='panel-collapse collapse in'>
						<div class='panel-body'>
                                                    <div class='table-responsive scrollit'>"
                                                        . "<table class='table sortable'>"
                                                        . "<tr>"
                                                        . "     <th>Job</th>"
                                                        . "     <th>Description</th>"
                                                        . "     <th>Category</th>"
                                                        . "     <th>Qualificaion</th>"
                                                        . "     <th>Action: </th>"
                                                        . "</tr>";
                                                        try
                                                        {
                                                            if($search != null)
                                                            {
                                                                foreach($search as $row)
                                                                {
                                                                    $type = $typeModel->GetTypeByID($row->type);
                                                                    $qualification = $qualificationModel->GetQualificationByID($row->qualification);
                                                                    $result.= "<tr>"
                                                                            . "<td align='center'><a href='SearchResult.php?epr=view&id=".$row->jobid."&typeId=".$row->type."'>$row->name</a></td>"
                                                                            . "<td align='center'>$row->description</td>"
                                                                            . "<td align='center'>$type->name</td>"
                                                                            . "<td align='center'>$qualification->qualificationName</td>"
                                                                            . "<td>"
                                                                            . "     <a href='EditJob.php?epr=delete&id=".$row->jobid."'>Deactivate</a>&nbsp|"
                                                                            . "     <a href='EditJob.php?epr=update&id=".$row->jobid."'>Update</a>"
                                                                            . "</td>"
                                                                            . "</tr>";
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
                . "<div class='panel-group col-md-5'>
			  <div class='panel panel-default'>
					<div class='panel-heading' style='text-align:center;'>
					<a data-toggle='collapse' data-parent='#accordion' href='#collapseMyPlacedOffers' class='glyphicon glyphicon-hand-up'><strong>Offer Placed By Me</strong></a>
					</div>
					<div id='collapseMyPlacedOffers' class='panel-collapse collapse in'>
						<div class='panel-body'>"
                                                        . "<table class='table sortable'>"
                                                        . "<tr>"
                                                        . "     <th style='text-align:center;'>Job</th>"
                                                        . "     <th style='text-align:center;'>Price</th>"
                                                        . "     <th style='text-align:center;'>Date</th>"
                                                        . "</tr>";
                                                        try
                                                        {
                                                            if($allOfUsersPlacedOffers != null)
                                                            {
                                                                foreach($allOfUsersPlacedOffers as $row)
                                                                {
                                                                   $job = $jobModel->GetJobsByID($row->jobid);
                                                                    $result.= "<tr>"
                                                                            . "<td align='center'><a href='SearchResult.php?epr=view&id=".$row->jobid."&typeId=".$job->type."'>".$jobModel->GetJobsByID($row->jobid)->name."</a></td>"
                                                                            . "<td align='center'>$row->offerPrice</td>"
                                                                            . "<td align='center'>$row->placementDate</td>"
                                                                            . "</tr>";
                                                                }
                                                            }
                                                        }catch(Exception $x)
                                                        {
                                                            echo 'Caught exception: ',  $x->getMessage(), "\n";
                                                        }
                                                    $result.= "</table>"
						."</div>"
					."</div>"
				."</div>"
			."</div>"
                . "</div>"
                . "<div class='row'>"
                . "<div class='panel-group col-md-6'>
			  <div class='panel panel-default'>
					<div class='panel-heading' style='text-align:center;'>
					<a data-toggle='collapse' data-parent='#accordion' href='#collapseListPlacedOffers' class='glyphicon glyphicon-hand-up'><strong>My Job Offers</strong></a>
					</div>
					<div id='collapseListPlacedOffers' class='panel-collapse collapse in'>
						<div class='panel-body'>"
                                                        . "<table class='table sortable'>"
                                                        . "<tr>"
                                                        . "     <th style='text-align:center;'>Job</th>"
                                                        . "     <th style='text-align:center;'>User</th>" 
                                                        . "     <th style='text-align:center;'>Price</th>"
                                                        . "     <th style='text-align:center;'>Date</th>"
                                                        . "</tr>";
                                                        try
                                                        {
                                                            if($offersToUsersJob != null)
                                                            {
                                                                foreach($offersToUsersJob as $row)
                                                                {
                                                                    $job = $jobModel->GetJobsByID($row->jobid);
                                                                    $result.= "<tr>"
                                                                            . "<td align='center'><a href='SearchResult.php?epr=view&id=".$row->jobid."&typeId=".$job->type."'>".$jobModel->GetJobsByID($row->jobid)->name."</a></td>"
                                                                            . "<td align='center'>".$userModel->GetUserById($row->userID)->username."</td>"
                                                                            . "<td align='center'>$row->offerPrice</td>"
                                                                            . "<td align='center'>$row->placementDate</td>"
                                                                            . "</tr>";
                                                                }
                                                            }
                                                        }catch(Exception $x)
                                                        {
                                                            echo 'Caught exception: ',  $x->getMessage(), "\n";
                                                        }
                                                    $result.= "</table>"
						."</div>"
					."</div>"
				."</div>"
			."</div>"
                . "<div class='panel-group col-md-6'>
			  <div class='panel panel-default'>
					<div class='panel-heading' style='text-align:center;'>
					<a data-toggle='collapse' data-parent='#accordion' href='#collapseRating' class='glyphicon glyphicon-hand-up'><strong>My Rating</strong></a>
					</div>
					<div id='collapseRating' class='panel-collapse collapse in'>
						<div class='panel-body'>
                                                <div class='col-md-12'>
                                                    <div class='row'>
                                                    <a href='UserReview.php?epr=review&id=".$id."'><p style='text-align:center;'><strong>Based on $count reviews</strong></p></a>
                                                    </div>
                                                            <div class='col-md-1' style='padding-left:20px;'>";
                                                                try
                                                                {
                                                                            $actualRate = 0;
                                                                            $expectedRate = 0;
                                                                            $res = 0;
                                                                            if($review != null)
                                                                            {
                                                                                foreach($review as $row1)
                                                                                {
                                                                                    $actualRate= $actualRate + $row1->punctionality;
                                                                                   
                                                                                    $expectedRate = $expectedRate + 5;
                                                                                    
                                                                                    $res = ($actualRate / $expectedRate) * 100;
                                                                                    $res = (int)$res;
                                                                                }
                                                                               
                                                                                $result.="<div class='row'>
                                                                                        <div class='c100 p$res'>
                                                                                          <span>$res%</span>
                                                                                          <div class='slice'>
                                                                                                <div class='bar'></div>
                                                                                                <div class='fill'></div>
                                                                                          </div>
                                                                                        </div>
                                                                                </div>
                                                                                <div class='row'>
                                                                                    <p class='col-md-12'>Punctionality</p>
                                                                                </div> 
                                                                            </div>";
                                                                                
                                                                                foreach($review as $row1)
                                                                                {
                                                                                    $actualRate= $actualRate + $row1->workSatisfaction;
                                                                                   
                                                                                    $expectedRate = $expectedRate + 5;
                                                                                    
                                                                                    $res = ($actualRate / $expectedRate) * 100;
                                                                                    $res = (int)$res;
                                                                                }
                                                                            
                                                                            $result.="<div class='col-md-1 col-md-offset-3' style='padding-left:20px;'>
                                                                                <div class='row'>
                                                                                        <div class='c100 p$res'>
                                                                                          <span>$res%</span>
                                                                                          <div class='slice'>
                                                                                                <div class='bar'></div>
                                                                                                <div class='fill'></div>
                                                                                          </div>
                                                                                        </div>
                                                                                </div>
                                                                                <div class='row'>
                                                                                    <p class='col-md-12'>Work Satisfaction</p>
                                                                                </div>
                                                                            </div>";
                                                                            
                                                                                foreach($review as $row1)
                                                                                {
                                                                                    $actualRate= $actualRate + $row1->skills;
                                                                                   
                                                                                    $expectedRate = $expectedRate + 5;
                                                                                    
                                                                                    $res = ($actualRate / $expectedRate) * 100;
                                                                                    $res = (int)$res;
                                                                                }
                                                                            $result.="<div class='col-md-1 col-md-offset-3' style='padding-left:20px;'>
                                                                                <div class='row'>
                                                                                        <div class='c100 p$res'>
                                                                                          <span>$res%</span>
                                                                                          <div class='slice'>
                                                                                                <div class='bar'></div>
                                                                                                <div class='fill'></div>
                                                                                          </div>
                                                                                        </div>
                                                                                </div>
                                                                                <div class='row'>
                                                                                    <p class='col-md-12'>Skills</p>
                                                                                </div>
                                                                            </div>
                                                                        </div>";
                                                                        }
                                                                }catch(Exception $x)
                                                                {
                                                                    echo 'Caught exception: ',  $x->getMessage(), "\n";
                                                                }
                                             $result.= "</div>"          
						."</div>"
					."</div>"
				."</div>"
			."</div>"
                . "</div>"
                . "</div>";
                
        return $result;
    }
    
    // Get User By Id
    function GetUsers()
    {
        $userModel = new UserModel();
        $userModel->GetUsers();
    }
    
    // View to display user profile
    function ViewUserProfile($id)
    {
        require ("Model/UserReviewModel.php");
        $userModel = new UserModel();
        
        $user = $userModel->GetUserById($id);
        
        $userReviewModel = new UserReviewModel();
        $review = $userReviewModel->GetUserReviewById($id);
        $count = $userReviewModel->GetNumberOfUserReviewById($id);
        
        $requestModel = new RequestModel();
        $cvCoverLetterRequest = $requestModel->GetCVCoverLetterRequestsByUserIdANDTargetUserId($_SESSION['id'], $id);
        $result="<div class='row'>"
                    . "<div class='panel-group col-md-6'>
			  <div class='panel panel-default'>
                                    <div class='panel-heading' style='text-align:center;'>
					<a data-toggle='collapse' data-parent='#accordion' href='#collapseusersummary' class='glyphicon glyphicon-hand-up'><strong>User Summary</strong></a>
					</div>
					<div id='collapseusersummary' class='panel-collapse collapse in'>
						<div class='panel-body'>"
                                                    ."<table class='sortable table' id='myJobTable'>
                                                            <tr>
                                                                <td><strong>Id:</strong>&nbsp $user->id</td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Name:</strong>&nbsp $user->firstName &nbsp&nbsp $user->lastName</td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Username:</strong>&nbsp $user->username</td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Email:</strong><a href='mailto:$user->email' class='col-md-10 col-md-offset-1 btn btn-success glyphicon glyphicon-edit' style='font-size:15px; text-align: center; padding-right:10px;'> $user->email</a></td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Phone:</strong><a class='col-md-10 col-md-offset-1 btn btn-success glyphicon glyphicon-phone' href='tel:$user->phone' style='font-size:15px; text-align: center;'> $user->phone </a></td>
                                                            </tr>
                                                    </table>"
                                             . "</div>"
						."</div>"
					."</div>"
				."</div>"
                
                       . "<div class='panel-group col-md-6'>
                            <div class='panel panel-default'>
					<div class='panel-heading' style='text-align:center;'>
                                            <a data-toggle='collapse' data-parent='#accordion' href='#collapseuserrating' class='glyphicon glyphicon-hand-up'><strong>User Rating</strong></a>
					</div>
					<div id='collapseuserrating' class='panel-collapse collapse in'>
						<div class='panel-body'>
                                                <div class='col-md-12'>
                                                    <div class='row'>
                                                    <a href='UserReview.php?epr=review&id=".$id."'><p style='text-align:center;'><strong>Based on $count reviews</strong></p></a>
                                                    </div>
                                                            <div class='col-md-1' style='padding-left:20px;'>";
                                                                try
                                                                {
                                                                            $actualRate = 0;
                                                                            $expectedRate = 0;
                                                                            $res = 0;
                                                                            if($review != null)
                                                                            {
                                                                                foreach($review as $row1)
                                                                                {
                                                                                    $actualRate= $actualRate + $row1->punctionality;
                                                                                   
                                                                                    $expectedRate = $expectedRate + 5;
                                                                                    
                                                                                    $res = ($actualRate / $expectedRate) * 100;
                                                                                    $res = (int)$res;
                                                                                }
                                                                               
                                                                                $result.="<div class='row'>
                                                                                        <div class='c100 p$res'>
                                                                                          <span>$res%</span>
                                                                                          <div class='slice'>
                                                                                                <div class='bar'></div>
                                                                                                <div class='fill'></div>
                                                                                          </div>
                                                                                        </div>
                                                                                </div>
                                                                                <div class='row'>
                                                                                    <p class='col-md-12'>Punctionality</p>
                                                                                </div> 
                                                                            </div>";
                                                                                
                                                                                foreach($review as $row1)
                                                                                {
                                                                                    $actualRate= $actualRate + $row1->workSatisfaction;
                                                                                   
                                                                                    $expectedRate = $expectedRate + 5;
                                                                                    
                                                                                    $res = ($actualRate / $expectedRate) * 100;
                                                                                    $res = (int)$res;
                                                                                }
                                                                            
                                                                            $result.="<div class='col-md-1 col-md-offset-3' style='padding-left:20px;'>
                                                                                <div class='row'>
                                                                                        <div class='c100 p$res'>
                                                                                          <span>$res%</span>
                                                                                          <div class='slice'>
                                                                                                <div class='bar'></div>
                                                                                                <div class='fill'></div>
                                                                                          </div>
                                                                                        </div>
                                                                                </div>
                                                                                <div class='row'>
                                                                                    <p class='col-md-12'>Work Satisfaction</p>
                                                                                </div>
                                                                            </div>";
                                                                            
                                                                                foreach($review as $row1)
                                                                                {
                                                                                    $actualRate= $actualRate + $row1->skills;
                                                                                   
                                                                                    $expectedRate = $expectedRate + 5;
                                                                                    
                                                                                    $res = ($actualRate / $expectedRate) * 100;
                                                                                    $res = (int)$res;
                                                                                }
                                                                            $result.="<div class='col-md-1 col-md-offset-3' style='padding-left:20px;'>
                                                                                <div class='row'>
                                                                                        <div class='c100 p$res'>
                                                                                          <span>$res%</span>
                                                                                          <div class='slice'>
                                                                                                <div class='bar'></div>
                                                                                                <div class='fill'></div>
                                                                                          </div>
                                                                                        </div>
                                                                                </div>
                                                                                <div class='row'>
                                                                                    <p class='col-md-12'>Skills</p>
                                                                                </div>
                                                                            </div>
                                                                        </div>";
                                                                        }
                                                                }catch(Exception $x)
                                                                {
                                                                    echo 'Caught exception: ',  $x->getMessage(), "\n";
                                                                }
						$result.="</div>"
					."</div>"
				."</div>"
			."</div>"
			."</div>"
                
                    ."<div class='row'>";
                           $result.= "<div class='panel-group col-md-6'>
                                <div class='panel panel-default'>
                                            <div class='panel-heading' style='text-align:center;'>
                                                <a data-toggle='collapse' data-parent='#accordion' href='#collapsresume' class='glyphicon glyphicon-hand-up'><strong>Resume</strong></a>
                                            </div>
                                            <div id='collapsresume' class='panel-collapse collapse in'>
                                                    <div class='panel-body'>";
                                            try
                                            {
                                                if($cvCoverLetterRequest != NULL && $cvCoverLetterRequest->typeId == 1 && $cvCoverLetterRequest->status == 2)
                                                {
                                                    if($user->cv != NULL)
                                                    {
                                                        $result.="<div class='row'>
                                                            <p class='col-md-12' style=' font-size:20px;'> Download CV</p>
                                                        </div>
                                                        <a href='download.php?epr=cv&path=".$user->cv."'><img src='Images/wordicon.png' alt='CV' style=' display: block; margin: auto; text-align:center; margin-top:10px;'></a>";
                                                    }
                                                    
                                                    if($user->coverletter != NULL)
                                                    {
                                                        $result.="<div class='row'>
                                                            <p class='col-md-12' style=' font-size:20px;'> Download Cover Letter</p>
                                                        </div>
                                                        <a href='download.php?epr=cv&path=".$user->coverletter."'><img src='Images/wordicon.png' alt='Cover Letter' style=' display: block; margin: auto; text-align:center; margin-top:10px;'></a>";
                                                    }
                                                }else if($cvCoverLetterRequest != NULL && $cvCoverLetterRequest->typeId == 1 && $cvCoverLetterRequest->status == 1)
                                                {
                                                    $result.="<div class='row'>
                                                                <p style='color:Green; font-size:18px; text-align:center;'> Request Sent :) </p>
                                                              </div>
                                                                <div class='row'>
                                                                    <a href='ViewUserProfile.php?epr=cancelRequest&id=$id' id='addFavorite' class='btn btn-danger col-md-4 col-md-offset-4'>
                                                                    <i class='glyphicon glyphicon-remove-sign'></i>
                                                                Cancel Request </a>
                                                                </div>";
                                                }else if($cvCoverLetterRequest != NULL && $cvCoverLetterRequest->typeId == 1 && $cvCoverLetterRequest->status == 0)
                                                {
                                                    $result.= "<div class='row'>"
                                                            . "<p style='color:red; text-align:center;'>* Permission to view resume has been denied </p>"
                                                            . "</div>";
                                                }else
                                                {
                                                    $result.="<div class='row'>
                                                                <p style='color:Green; font-size:18px; text-align:center;'> Request Permission to view user resume. </p>
                                                              </div>
                                                              <div class='row'>
                                                                    <a href='ViewUserProfile.php?epr=request&id=$id' class='btn btn-primary col-md-5 col-md-offset-3'>
                                                                    <i class='glyphicon glyphicon-flag'></i>
                                                                Request Permission </a>
                                                              </div>";
                                                }
                                            }catch(Exception $x)
                                            {
                                                echo 'Caught exception: ',  $x->getMessage(), "\n";
                                            }
                                                    $result.="</div>"
                                            ."</div>"
                                    ."</div>"
                            ."</div>"
                
                           . "<div class='panel-group col-md-6'>
                                <div class='panel panel-default'>
                                            <div class='panel-heading' style='text-align:center;'>
                                                <a data-toggle='collapse' data-parent='#accordion' href='#collapseuserrating' class='glyphicon glyphicon-hand-up'><strong>Experience</strong></a>
                                            </div>
                                            <div id='collapseuserrating' class='panel-collapse collapse in'>
                                                    <div class='panel-body'>"

                                                    ."</div>"
                                            ."</div>"
                                    ."</div>"
                            ."</div>"
                . "</div>"
                
               . "</div>";
        
        return $result;
    }
    
    // View to display user profile
    function AddAUserReviewModal($id)
    {
        $result="<div class='modal fade' id='addUserReviewModal' role='dialog'>
			<div class='modal-dialog'>
			
			  <!-- Modal content-->
			  <div class='modal-content'>
				<div class='modal-header'>
				  <button type='button' class='close' data-dismiss='modal'>&times;</button>
				  <h4 class='modal-title'>Add A Review</h4>
				</div>
				<div class='modal-body'>
                                <div class='row'>"
                                         ."<form action='' method = 'POST'>
                                           <fieldset>
                                             <div class='clearfix'>
                                               <label for='descriptionreview' class='col-md-3'> Description: </label>
                                               <textarea class='col-md-8' rows='5' id='descriptionreview' name = 'descriptionreview' placeholder='Description' required autofocus></textarea>
                                             </div>
                                             <div class='clearfix'>
                                                <label for='punctionalityreview' class='col-md-3'> Punctionality: </label>
                                                <select class='form-control'id='punctionalityreview' name = 'punctionalityreview' style='width:200px;'>
                                                    <option value=1>1</option>
                                                    <option value=2>2</option>
                                                    <option value=3>3</option>
                                                    <option value=4>4</option>
                                                    <option value=5>5</option>
                                                </select>
                                             </div>
                                             <div class='clearfix'>
                                                <label for='worksatisfactionreview' class='col-md-3'> Work Satisfaction: </label>
                                                <select class='form-control'id='worksatisfactionreview' name = 'worksatisfactionreview' style='width:200px;'>
                                                    <option value=1>1</option>
                                                    <option value=2>2</option>
                                                    <option value=3>3</option>
                                                    <option value=4>4</option>
                                                    <option value=5>5</option>
                                                </select>
                                             </div>
                                             <div class='clearfix'>
                                                <label for='skillreview' class='col-md-3'> Skill: </label>
                                                <select class='form-control'id='skillreview' name = 'skillreview' style='width:200px;'>
                                                    <option value=1>1</option>
                                                    <option value=2>2</option>
                                                    <option value=3>3</option>
                                                    <option value=4>4</option>
                                                    <option value=5>5</option>
                                                </select>
                                             </div>
                                             <button class='btn primary col-md-2 col-md-offset-8' name = 'addUserReview' type='submit'>Add</button>
                                           </fieldset>
                                         </form>"
                               . "</div>
				</div>
				<div class='modal-footer'>
				  <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
				</div>
			  </div>
			  
			</div>
	  </div>";
        
        return $result;
    }
    
    // View to display user profile sidebar
    function ViewUserProfileSideBar($id)
    {
        $userModel = new UserModel();
        
        $user = $userModel->GetUserById($id);
        
        $followingModel = new FollowingModel();
        $followed = $followingModel->CheckIfUserAlreadyFollowedAnotherUser($_SESSION['id'], $user->id);
        $result = "<div class='col-md-12'>
			<div class='profile-sidebar'>
				<!-- SIDEBAR USERPIC -->
				<div class='profile-userpic'>
					<img src='$user->photo' class='img-responsive' alt=''>
				</div>
				<!-- END SIDEBAR USERPIC -->
				<!-- SIDEBAR USER TITLE -->
				<div class='profile-usertitle'>
					<div class='profile-usertitle-name'>
						$user->username
					</div>
				</div>
				<!-- END SIDEBAR USER TITLE -->
				<!-- SIDEBAR BUTTONS -->
				<div class='nav-button-sidebar'>";
                                    if($followed != NULL)
                                    {
                                        $result.= "<a href='Following.php?epr=unfollowfromuserprofile&followinguserId=$user->id' style='margin-bottom:10px;' class='btn btn-success btn-sm'>
                                        Un-Follow </a>";
                                    }else
                                    {
                                        $result.= "<a href='Following.php?epr=followfromuserprofile&followinguserId=$user->id' style='margin-bottom:10px;' class='btn btn-success btn-sm'>
                                        Follow </a>";
                                    }
                                       $result.= "<div class='row'>
                                            <a href='#' data-toggle='modal' class='btn btn-success btn-sm' data-target='#sendMessageModal' onclick='$(#sendMessageModal).modal({backdrop: static});'>
                                            Message </a>
                                        </div>
				</div>
				<!-- END SIDEBAR BUTTONS -->
				<!-- SIDEBAR MENU -->
				<div class='profile-usermenu'>
					<ul class='nav'>
						<li class='active'>
							<a href='ViewUserProfile.php?epr=view&id=".$id."'>
							<i class='glyphicon glyphicon-user'></i>
							Overview </a>
						</li>
						<li>
							<a href='JobPosted.php?epr=view&id=".$id."'>
							<i class='glyphicon glyphicon-list'></i>
							Jobs Posted </a>
						</li>
						<li>
							<a href='UserReview.php?epr=review&id=".$id."'>
							<i class='glyphicon glyphicon-comment'></i>
							Review </a>
						</li>
                                                <li>
							<a href='Logout.php'>
							<i class='glyphicon glyphicon-globe'></i>
							Connections </a>
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
		</div>";
                
        return $result;
    }
    
    // View to display user profile sidebar
    function ViewUserReviewSideBar($id)
    {
        $userModel = new UserModel();
        
        $user = $userModel->GetUserById($id);
        $followingModel = new FollowingModel();
        $followed = $followingModel->CheckIfUserAlreadyFollowedAnotherUser($_SESSION['id'], $user->id);
        $result = "<div class='col-md-12'>
			<div class='profile-sidebar'>
				<!-- SIDEBAR USERPIC -->
				<div class='profile-userpic'>
					<img src='$user->photo' class='img-responsive' alt=''>
				</div>
				<!-- END SIDEBAR USERPIC -->
				<!-- SIDEBAR USER TITLE -->
				<div class='profile-usertitle'>
					<div class='profile-usertitle-name'>
						$user->username
					</div>
				</div>
				<!-- END SIDEBAR USER TITLE -->
				<!-- SIDEBAR BUTTONS -->
				<div class='nav-button-sidebar'>";
                                    if($followed != NULL)
                                    {
                                        $result.= "<a href='Following.php?epr=unfollowfromusereview&followinguserId=$user->id' style='margin-bottom:10px;' class='btn btn-success btn-sm'>
                                        Un-Follow </a>";
                                    }else
                                    {
                                        $result.= "<a href='Following.php?epr=followfromusereview&followinguserId=$user->id' style='margin-bottom:10px;' class='btn btn-success btn-sm'>
                                        Follow </a>";
                                    }

                                        $result.= "<div class='row'>
                                            <a href='#' data-toggle='modal' class='btn btn-success btn-sm' data-target='#sendMessageModal' onclick='$(#sendMessageModal).modal({backdrop: static});'>
                                            Message </a>
                                        </div>
				</div>
				<!-- END SIDEBAR BUTTONS -->
				<!-- SIDEBAR MENU -->
				<div class='profile-usermenu'>
					<ul class='nav'>
						<li>
							<a href='ViewUserProfile.php?epr=view&id=".$id."'>
							<i class='glyphicon glyphicon-user'></i>
							Overview </a>
						</li>
						<li>
							<a href='JobPosted.php?epr=view&id=".$id."'>
							<i class='glyphicon glyphicon-list'></i>
							Jobs Posted </a>
						</li>
						<li class='active'>
							<a href='UserReview.php?epr=review&id=".$id."'>
							<i class='glyphicon glyphicon-comment'></i>
							Review </a>
						</li>
                                                <li>
							<a href='Logout.php'>
							<i class='glyphicon glyphicon-globe'></i>
							Connections </a>
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
		</div>";
                
        return $result;
    }
    
    // Get User By Id
    function GetUserById($id)
    {
        $userModel = new UserModel();
        return $userModel->GetUserById($id);
    }
    
     //Check if a user exist using the model and return the object
    function CheckUser($username)
    {
        $userModel = new UserModel();
        return $userModel->CheckUser($username);
    }
    
    //Check if an email already exist in the database
    function CheckEmail($email)
    {
        $userModel = new UserModel();
        return $userModel->CheckEmail($email);
    }
    
    //Update a user
    function updateUser($id,$firstName,$lastName,$usernameRegister,$password,$email,$phone)
    {
        $userModel = new UserModel();
        return $userModel->updateUser($id, $firstName,$lastName,$usernameRegister,$password,$email,$phone);
    }
    
    //Delete a user
    function deleteUser($id)
    {
        $userModel = new UserModel();
        $userModel->deleteUser($id);
    }
    
    //Update a user cv
    function uploadCV($id,$cvPath)
    {
        $userModel = new UserModel();
        $userModel->uploadCV($id, $cvPath);
    }
    
    //Update a user cover letter
    function uploadCoverLetter($id,$coverLetterPath)
    {
        $userModel = new UserModel();
        $userModel->uploadCoverLetter($id, $coverLetterPath);
    }
    
    //Update a user profile picture
    function uploadProfilePicture($id,$profilePicturePath)
    {
        $userModel = new UserModel();
        $userModel->uploadProfilePicture($id, $profilePicturePath);
    }
}
