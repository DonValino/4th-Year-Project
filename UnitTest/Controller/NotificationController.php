<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of NotificationController
 *
 * @author Jake Valino
 */

require 'Model/NotificationModel.php';
require 'Model/TypeModel.php';
require 'Model/NotificationTypeModel.php';
require 'Model/JobModel.php';
require 'Model/UserModel.php';

class NotificationController {
    
    // Insert A New Notification
    function InsertNotification($fromusername,$tousername,$typeId,$seen,$dateofnotification,$jobid)
    {
        $notificationModel = new NotificationModel();
        $notificationModel->InsertNotification($fromusername,$tousername,$typeId,$seen,$dateofnotification,$jobid);
    }
    
    // Get Notification By Id
    function GetNotificationById($id)
    {
        $notificationModel = new NotificationModel(); 
        
        return $notificationModel->GetNotificationById($id);
    }
    
    // Get Notification By FromUsername
    function GetNotificationByFromUsername($fromUsername)
    {
        $notificationModel = new NotificationModel(); 
        
        return $notificationModel->GetNotificationByFromUsername($fromUsername);
    }
    
    // Get Notification By ToUsername
    function GetNotificationByToUsername($toUsername)
    {
        $notificationModel = new NotificationModel(); 
        
        return $notificationModel->GetNotificationByToUsername($toUsername);
    }
    
    // Get Specific Notification
    function GetSpecificNotification($fromUsername, $toUsername)
    {
        $notificationModel = new NotificationModel(); 
        
        return $notificationModel->GetSpecificNotification($fromUsername, $toUsername);
    }
    
    // Update a notification
    function updateNotification($tousername,$dateofnotification)
    {
        $notificationModel = new NotificationModel();
        $notificationModel->updateNotification($tousername,$dateofnotification);
    }
    
    // Get Notification By ToUsername
    function CountNotificationByToUsername($toUsername)
    {
        $notificationModel = new NotificationModel();
        return $notificationModel->CountNotificationByToUsername($toUsername);
    }
    
    // Get Notification By ToUsername Test
    function CountNotificationByToUsernameTest($toUsername)
    {
        $notificationModel = new NotificationModel();
        return $notificationModel->CountNotificationByToUsernameTest($toUsername);
    }
    
    // Notification Content
    function NotificationContent()
    {
       $myNotification = $this->GetNotificationByToUsername($_SESSION['username']);
       $notificationTypeModel = new NotificationTypeModel();
       $jobModel = new JobModel();
       $userModel = new UserModel();
       $result= '<div class="panel-group col-md-12">
			  <div class="panel panel-default">
					<div class="panel-heading" style="text-align:center;">
					<a data-toggle="collapse" data-parent="#accordion" href="#collapseMyNotification" class="glyphicon glyphicon-hand-up"><strong>Notification</strong></a>
					</div>
					<div id="collapseMyNotification" class="panel-collapse collapse in">
						<div class="panel-body">
                                                    <div class="table-responsive scrollit" style="height:450px;">
                                                        <table class="sortable table" id="myJobTable">
                                                            <tr>
                                                                <th>Name</th>
                                                                <th>Description</th>
                                                                <th>Job Name</th>
                                                                <th>Date</th>
                                                                <th>Seen</th>
                                                            </tr>';
                                                           try
                                                            {
                                                               if($myNotification != 0)
                                                               {
                                                                    foreach($myNotification as $row)
                                                                    {
                                                                        if($row->seen == 0)
                                                                        {
                                                                            $result.='<tr>';
                                                                            if($userModel->CheckUser($row->fromusername) === 0)
                                                                            {
                                                                               $result.='<td bgcolor="#ccd7ea"><strong>' .$row->fromusername;$result.='</strong> &nbsp &nbsp &nbsp &nbsp'; $result.='</td>
                                                                                            <td bgcolor="#ccd7ea"  style="color:blue;">'; $result.= $notificationTypeModel->GetNotificationTypeById($row->typeId)->name;  $result.='</td>
                                                                                            <td  bgcolor="#ccd7ea" style="color:blue;">'; $result.= '<a href="ViewJob.php?epr=viewfromnotification&jobid='.$row->jobid.'&date='.$row->dateofnotification.'">'. $jobModel->GetJobsByID($row->jobid)->name; $result.='</a></td>
                                                                                            <td bgcolor="#ccd7ea" style="color:blue;">'; $result.=$row->dateofnotification; $result.='</td>
                                                                                            <td  bgcolor="#ccd7ea" style="color:blue;"> No </td>
                                                                                    </tr>';
                                                                            }else
                                                                            {
                                                                                $result.='<td bgcolor="#ccd7ea" style="color:blue;"><strong>'; $result.= '<a href="ViewUserProfile.php?epr=view&id='.$userModel->CheckUser($row->fromusername)->id.'">'. $row->fromusername;$result.='</strong></a> &nbsp &nbsp &nbsp &nbsp'; $result.='</td>
                                                                                            <td bgcolor="#ccd7ea" style="color:blue;">'; $result.= $notificationTypeModel->GetNotificationTypeById($row->typeId)->name;  $result.='</td>
                                                                                            <td bgcolor="#ccd7ea" style="color:blue;">'; $result.= '<a href="ViewJob.php?epr=viewfromnotification&jobid='.$row->jobid.'&date='.$row->dateofnotification.'">'. $jobModel->GetJobsByID($row->jobid)->name; $result.='</a></td>
                                                                                            <td bgcolor="#ccd7ea" style="color:blue;">'; $result.=$row->dateofnotification; $result.='</td>
                                                                                            <td bgcolor="#ccd7ea" style="color:blue;"> No </td>
                                                                                    </tr>';
                                                                            }
                                                                                
                                                                                
                                                                        }else if($row->seen == 1)
                                                                        {
                                                                            if($userModel->CheckUser($row->fromusername) === 0)
                                                                            {
                                                                                $result.='<tr>
                                                                                        <td><strong>' .$row->fromusername;$result.='</strong> &nbsp &nbsp &nbsp &nbsp'; $result.='</td>
                                                                                        <td style="color:blue;">'; $result.= $notificationTypeModel->GetNotificationTypeById($row->typeId)->name;  $result.='</td>
                                                                                        <td style="color:blue;">'; $result.= '<a href="ViewJob.php?epr=view&jobid='.$row->jobid.'">'. $jobModel->GetJobsByID($row->jobid)->name; $result.='</a></td>
                                                                                        <td style="color:blue;">'; $result.=$row->dateofnotification; $result.='</td>
                                                                                        <td style="color:blue;"> Yes </td>
                                                                                    </tr>';
                                                                            }else
                                                                            {
                                                                                $result.='<tr>
                                                                                        <td style="color:blue;"><strong>'; $result.= '<a href="ViewUserProfile.php?epr=view&id='.$userModel->CheckUser($row->fromusername)->id.'">'. $row->fromusername;$result.='</strong></a> &nbsp &nbsp &nbsp &nbsp'; $result.='</td>
                                                                                        <td style="color:blue;">'; $result.= $notificationTypeModel->GetNotificationTypeById($row->typeId)->name;  $result.='</td>
                                                                                        <td style="color:blue;">'; $result.= '<a href="ViewJob.php?epr=view&jobid='.$row->jobid.'">'. $jobModel->GetJobsByID($row->jobid)->name; $result.='</a></td>
                                                                                        <td style="color:blue;">'; $result.=$row->dateofnotification; $result.='</td>
                                                                                        <td style="color:blue;"> Yes </td>
                                                                                    </tr>';
                                                                            }
                                                                        }

                                                                    }
                                                               }
                                                            }catch(Exception $x)
                                                            {
                                                                echo 'Caught exception: ',  $x->getMessage(), "\n";
                                                            }
                                                        $result.='</table>
						</div>
					</div>
				</div>
			</div>
                </div>';
       
       return $result;
    }
    //Code to create the user profile sidebar
    function CreateNotificationSideBar()
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
        
        require_once 'Model/CancelRequestModel.php';
        $cancelRequestModel = new CancelRequestModel();
        $myOfferCancellationRequest = $cancelRequestModel->CountCancelRequestByTargetUserId($_SESSION['id']);
        
        require_once 'Model/PaymentModel.php';
        $paymentModel = new PaymentModel();
        $unseenPaymentConfirmation = $paymentModel->CountPaymentByTargetUserId($_SESSION['id']);
        
        if($unseenPaymentConfirmation != NULL)
        {
            $myOfferCancellationRequest = $myOfferCancellationRequest + $unseenPaymentConfirmation;
        }
        
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
							<a href='UserAccount.php' style='text-align:center;'>
							<i class='glyphicon glyphicon-home'></i>
							Overview </a>
						</li>
						<li>
							<a href='AccountSettings.php' style='text-align:center;'>
							<i class='glyphicon glyphicon-user'></i>
							Account Settings </a>
						</li>
						<li>";
                                                    if($myOfferCancellationRequest != NULL)
                                                    {
							$result.="<a href='JobsOverview.php' style='text-align:center;'>
                                                                    <i class='glyphicon glyphicon-ok'></i>
                                                                    Jobs &nbsp<span class='badge'>$myOfferCancellationRequest</span></a>";
                                                    }else
                                                    {
							$result.="<a href='JobsOverview.php' style='text-align:center;'>
                                                                    <i class='glyphicon glyphicon-ok'></i>
                                                                    Jobs </a>";
                                                    }
						$result.="</li>
						<li>
							<a href='UserReview.php?epr=review&id=".$_SESSION['id']."' style='text-align:center;'>
							<i class='glyphicon glyphicon-comment'></i>
							My Review </a>
						</li>
						<li>
							<a href='Following.php' style='text-align:center;'>
							<i class='glyphicon glyphicon-star-empty'></i>
							Followers </a>
						</li>
                                                <li>
							<a href='Logout.php' style='text-align:center;'>
							<i class='glyphicon glyphicon-log-out'></i>
							Logout </a>
						</li>
						<li>
							<a href='Help.php' target='_blank' style='text-align:center;'>
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
