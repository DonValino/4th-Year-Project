<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RequestController
 *
 * @author Jake Valino
 */

require 'Model/RequestModel.php';
require 'Model/UserModel.php';
require 'Model/NotificationModel.php';
require 'Model/RequestTypeModel.php';
class RequestController {
    
    //Insert a new request 
    function InsertANewRequest($userId,$targetUserId,$typeId,$date, $status)
    {
        $requestModel = new RequestModel();
        $requestModel->InsertANewRequest($userId, $targetUserId, $typeId, $date, $status);
    }
    
    //Get Requests.
    function GetRequests()
    {
        $requestModel = new RequestModel();
        return $requestModel->GetRequests();
    }
    
    //Get Requests By userId.
    function GetRequestsByUserId($userId)
    {
        $requestModel = new RequestModel();
        return $requestModel->GetRequestsByUserId($userId);
    }
    
    //Get Requests By targetUserId.
    function GetRequestsByTargetUserId($targetUserId)
    {
        $requestModel = new RequestModel();
        return $requestModel->GetRequestsByTargetUserId($targetUserId);
    }
    
    //Get Requests By userId And targetUserId.
    function GetRequestsByUserIdANDTargetUserId($userId, $targetUserId)
    {
        $requestModel = new RequestModel();
        return $requestModel->GetRequestsByUserIdANDTargetUserId($userId, $targetUserId); 
    }
    
    //Get CV / CoverLetter Requests By userId And targetUserId.
    function GetCVCoverLetterRequestsByUserIdANDTargetUserId($userId, $targetUserId)
    {
        $requestModel = new RequestModel();
        return $requestModel->GetCVCoverLetterRequestsByUserIdANDTargetUserId($userId, $targetUserId); 
    }
    
    // Cancel Request
    function cancelRequest($userId, $targetUserId)
    {
        $requestModel = new RequestModel();
        $requestModel->cancelRequest($userId, $targetUserId);
    }
    
    //Update seen request
    function updateRequestSeen($targetUserId)
    {
        $requestModel = new RequestModel();
        $requestModel->updateRequestSeen($targetUserId);
    }
    
    //Update request status
    function updateRequestStatus($statusId, $userId, $targetUserId)
    {
        $requestModel = new RequestModel();
        $requestModel->updateRequestStatus($statusId, $userId, $targetUserId);
    }
    
    //Count Requests By targetUserId.
    function CountRequestsByTargetUserId($targetUserId)
    {
        $requestModel = new RequestModel();
        return $requestModel->CountRequestsByTargetUserId($targetUserId);
    }
    
    //Code to create the user profile sidebar
    function CreateRequestSideBar()
    {
        $userModel = new UserModel();
        $user = $userModel->CheckUser($_SESSION['username']);
        $notificationModel = new NotificationModel();
        $userNotification = $notificationModel->CountNotificationByToUsername($_SESSION['username']);
        
        require 'Model/MessagesModel.php';
        $messagesModel = new MessagesModel();
        $myMessages = $messagesModel->CountAllMyMessages($_SESSION['username']);
        
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
    
   // Request Content
    function RequestContent()
    {
       $myRequest = $this->GetRequestsByTargetUserId($_SESSION['id']);
       $userModel = new UserModel();
       $requestTypeModel = new RequestTypeModel();
       
       $result= '<div class="panel-group col-md-12">
			  <div class="panel panel-default">
					<div class="panel-heading" style="text-align:center;">
					<a data-toggle="collapse" data-parent="#accordion" href="#collapseMyNotification" class="glyphicon glyphicon-hand-up"><strong>Request</strong></a>
					</div>
					<div id="collapseMyNotification" class="panel-collapse collapse in">
						<div class="panel-body">
                                                    <div class="table-responsive scrollitY" style="height:450px;">
                                                        <table class="sortable table" id="myJobTable">
                                                            <tr>
                                                                <th>Name</th>
                                                                <th>Description</th>
                                                                <th>Date</th>
                                                                <th>Action:</th>
                                                            </tr>';
                                                           try
                                                            {
                                                               if($myRequest != 0)
                                                               {
                                                                    foreach($myRequest as $row)
                                                                    {
                                                                        $username= $userModel->GetUserById($row->userId)->username;
                                                                        $_SESSION['tousername'] = $username;
                                                                        $id= $userModel->GetUserById($row->userId)->id;
                                                                        $dateT = new DateTime($row->date);
                                                                        $dateposted = $dateT->format("H:i:s d-m-Y");
                                                                        
                                                                        if($row->seen == 0)
                                                                        {
                                                                            // Reqeust has not been seen by user
                                                                            $result.='<tr>';
                                                                            // Check if user exist
                                                                            if($userModel->GetUserById($row->userId) === 0)
                                                                            {
                                                                                // User does not exist go here (Account been deleted but records are still retained).
                                                                                if($row->status == 2)
                                                                                {
                                                                                    // Request Accepted
                                                                                    $result.='<td><strong>' .$row->userId;$result.='</strong> &nbsp &nbsp &nbsp &nbsp'; $result.='</td>
                                                                                                 <td  style="color:blue;">'; $result.= $requestTypeModel->GetARequestTypeById($row->typeId)->name; $result.='</td>
                                                                                                 <td  style="color:blue;">'; $result.= $dateposted; $result.='</td>
                                                                                                 <td  style="color:blue;"></td>
                                                                                                 <td>
                                                                                                      <a class="btn btn-info disabled" href="">Accepted</a>
                                                                                                 </td>
                                                                                         </tr>';
                                                                                }else if($row->status == 1)
                                                                                {
                                                                                    // Request Sent
                                                                                    $result.='<td><strong>' .$row->userId;$result.='</strong> &nbsp &nbsp &nbsp &nbsp'; $result.='</td>
                                                                                                 <td  style="color:blue;">'; $result.= $requestTypeModel->GetARequestTypeById($row->typeId)->name; $result.='</td>
                                                                                                 <td  style="color:blue;">'; $result.= $dateposted; $result.='</td>
                                                                                                 <td  style="color:blue;"></td>
                                                                                                 <td>
                                                                                                      <a class="btn btn-info" href="RequestSeen.php?epr=accept&id='.$row->userId.'">Accept</a>&nbsp|
                                                                                                      <a class="btn btn-danger" href="RequestSeen.php?epr=denied&id='.$row->userId.'">Decline</a>
                                                                                                 </td>
                                                                                         </tr>';
                                                                                }else if($row->status == 0)
                                                                                {
                                                                                    // Request Denied
                                                                                    $result.='<td><strong>' .$row->userId;$result.='</strong> &nbsp &nbsp &nbsp &nbsp'; $result.='</td>
                                                                                                 <td  style="color:blue;">'; $result.= $requestTypeModel->GetARequestTypeById($row->typeId)->name; $result.='</td>
                                                                                                 <td  style="color:blue;">'; $result.= $dateposted; $result.='</td>
                                                                                                 <td  style="color:blue;"></td>
                                                                                                 <td>
                                                                                                      <a class="btn btn-danger disabled" href="">Denied</a>
                                                                                                 </td>
                                                                                         </tr>';
                                                                                }
                                                                            }else
                                                                            {
                                                                                // User does exist go here.
                                                                                if($row->status == 2)
                                                                                {
                                                                                    // Request Accepted
                                                                                    $result.='<td bgcolor="#ccd7ea" style="color:blue;"><strong>'; $result.= '<a href="ViewUserProfile.php?epr=view&id='.$userModel->GetUserById($row->userId)->id.'">'. $username; $result.='</strong></a> &nbsp &nbsp &nbsp &nbsp'; $result.='</td>
                                                                                                <td bgcolor="#ccd7ea" style="color:blue;">'; $result.= $requestTypeModel->GetARequestTypeById($row->typeId)->name;  $result.='</td>
                                                                                                <td bgcolor="#ccd7ea"  style="color:blue;">'; $result.= $dateposted;  $result.='</td>
                                                                                                <td bgcolor="#ccd7ea">
                                                                                                     <a class="btn btn-info disabled" href="">Accepted</a>
                                                                                                </td>
                                                                                        </tr>';
                                                                                }else if($row->status == 1)
                                                                                {
                                                                                    // Request Sent
                                                                                    $result.='<td bgcolor="#ccd7ea" style="color:blue;"><strong>'; $result.= '<a href="ViewUserProfile.php?epr=view&id='.$userModel->GetUserById($row->userId)->id.'">'. $username; $result.='</strong></a> &nbsp &nbsp &nbsp &nbsp'; $result.='</td>
                                                                                                <td bgcolor="#ccd7ea" style="color:blue;">'; $result.= $requestTypeModel->GetARequestTypeById($row->typeId)->name;  $result.='</td>
                                                                                                <td bgcolor="#ccd7ea"  style="color:blue;">'; $result.= $dateposted;  $result.='</td>
                                                                                                <td bgcolor="#ccd7ea">
                                                                                                     <a class="btn btn-info" href="RequestSeen.php?epr=accept&id='.$row->userId.'">Accept</a>&nbsp|
                                                                                                     <a class="btn btn-danger" href="RequestSeen.php?epr=denied&id='.$row->userId.'">Decline</a>
                                                                                                </td>
                                                                                        </tr>';
                                                                                }else if($row->status == 0)
                                                                                {
                                                                                    // Request Denied
                                                                                    $result.='<td bgcolor="#ccd7ea" style="color:blue;"><strong>'; $result.= '<a href="ViewUserProfile.php?epr=view&id='.$userModel->GetUserById($row->userId)->id.'">'. $username; $result.='</strong></a> &nbsp &nbsp &nbsp &nbsp'; $result.='</td>
                                                                                                <td bgcolor="#ccd7ea" style="color:blue;">'; $result.= $requestTypeModel->GetARequestTypeById($row->typeId)->name;  $result.='</td>
                                                                                                <td bgcolor="#ccd7ea"  style="color:blue;">'; $result.= $dateposted;  $result.='</td>
                                                                                                <td bgcolor="#ccd7ea">
                                                                                                     <a class="btn btn-danger disabled" href="">Denied</a>
                                                                                                </td>
                                                                                        </tr>';
                                                                                }
                                                                            }
                                                                                
                                                                                
                                                                        }else if($row->seen == 1)
                                                                        {
                                                                            // Request Has been seen by user
                                                                            if($userModel->GetUserById($row->userId) === 0)
                                                                            {
                                                                                // User does not exist go here.
                                                                                if($row->status == 2)
                                                                                {
                                                                                    // Request Accepted
                                                                                    $result.='<tr>
                                                                                            <td><strong>' .$row->userId;$result.='</strong> &nbsp &nbsp &nbsp &nbsp'; $result.='</td>
                                                                                            <td style="color:blue;">';  $result.= $requestTypeModel->GetARequestTypeById($row->typeId)->name; $result.='</td>
                                                                                            <td  style="color:blue;">'; $result.= $dateposted; $result.='</td>
                                                                                                <td>
                                                                                                     <a class="btn btn-info disabled" href="">Accepted</a>
                                                                                                </td>
                                                                                        </tr>';
                                                                                }else if($row->status == 1)
                                                                                {
                                                                                    // Request Sent
                                                                                    $result.='<tr>
                                                                                            <td><strong>' .$row->userId;$result.='</strong> &nbsp &nbsp &nbsp &nbsp'; $result.='</td>
                                                                                            <td style="color:blue;">';  $result.= $requestTypeModel->GetARequestTypeById($row->typeId)->name; $result.='</td>
                                                                                            <td  style="color:blue;">'; $result.= $dateposted; $result.='</td>
                                                                                                <td>
                                                                                                     <a class="btn btn-info" href="RequestSeen.php?epr=accept&id='.$row->userId.'">Accept</a>&nbsp|
                                                                                                     <a class="btn btn-danger" href="RequestSeen.php?epr=denied&id='.$row->userId.'">Decline</a>
                                                                                                </td>
                                                                                        </tr>';
                                                                                }else if($row->status == 0)
                                                                                {
                                                                                    // Request Denied
                                                                                    $result.='<tr>
                                                                                            <td><strong>' .$row->userId;$result.='</strong> &nbsp &nbsp &nbsp &nbsp'; $result.='</td>
                                                                                            <td style="color:blue;">';  $result.= $requestTypeModel->GetARequestTypeById($row->typeId)->name; $result.='</td>
                                                                                            <td  style="color:blue;">'; $result.= $dateposted; $result.='</td>
                                                                                                <td>
                                                                                                     <a class="btn btn-danger disabled" href="">Denied</a>
                                                                                                </td>
                                                                                        </tr>';
                                                                                }
                                                                            }else
                                                                            {
                                                                                // User does exist go here.
                                                                                if($row->status == 2)
                                                                                {
                                                                                    // Request Accepted
                                                                                    // Request Sent
                                                                                    $result.='<tr>
                                                                                            <td style="color:blue;"><strong>'; $result.= '<a href="ViewUserProfile.php?epr=view&id='.$userModel->GetUserById($row->userId)->id.'">'. $username; $result.='</strong></a> &nbsp &nbsp &nbsp &nbsp'; $result.='</td>
                                                                                            <td style="color:blue;">';  $result.= $requestTypeModel->GetARequestTypeById($row->typeId)->name; $result.='</td>
                                                                                            <td style="color:blue;">'; $result.= $dateposted; $result.='</td>
                                                                                                <td>
                                                                                                     <a class="btn btn-info disabled" href="">Accepted</a>
                                                                                                </td>
                                                                                        </tr>';
                                                                                }else if($row->status == 1)
                                                                                {
                                                                                    // Request Sent
                                                                                    $result.='<tr>
                                                                                            <td style="color:blue;"><strong>'; $result.= '<a href="ViewUserProfile.php?epr=view&id='.$userModel->GetUserById($row->userId)->id.'">'. $username; $result.='</strong></a> &nbsp &nbsp &nbsp &nbsp'; $result.='</td>
                                                                                            <td style="color:blue;">';  $result.= $requestTypeModel->GetARequestTypeById($row->typeId)->name; $result.='</td>
                                                                                            <td style="color:blue;">'; $result.= $dateposted; $result.='</td>
                                                                                                <td>
                                                                                                     <a class="btn btn-info" href="RequestSeen.php?epr=accept&id='.$row->userId.'">Accept</a>&nbsp|
                                                                                                     <a class="btn btn-danger" href="RequestSeen.php?epr=denied&id='.$row->userId.'">Decline</a>
                                                                                                </td>
                                                                                        </tr>';
                                                                                }else if($row->status == 0)
                                                                                {
                                                                                    // Request Denied
                                                                                    $result.='<tr>
                                                                                            <td style="color:blue;"><strong>'; $result.= '<a href="ViewUserProfile.php?epr=view&id='.$userModel->GetUserById($row->userId)->id.'">'. $username; $result.='</strong></a> &nbsp &nbsp &nbsp &nbsp'; $result.='</td>
                                                                                            <td style="color:blue;">';  $result.= $requestTypeModel->GetARequestTypeById($row->typeId)->name; $result.='</td>
                                                                                            <td style="color:blue;">'; $result.= $dateposted; $result.='</td>
                                                                                                <td>
                                                                                                     <a class="btn btn-danger disabled" href="">Denied</a>
                                                                                                </td>
                                                                                        </tr>';
                                                                                }
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
    
    function CreateAdminUserSideBar()
    {
        $result = "<div class='panel panel-default'>
					<div class='panel-heading' style='text-align:center;'>
					<a data-toggle='collapse' data-parent='#accordion' href='#collapseJObOverviewPage' class='glyphicon glyphicon glyphicon-th-list'><strong> Menu</strong></a>
					</div>
					<div id='collapseJObOverviewPage' class='panel-collapse collapse in'>
						<div class='panel-body'>"
                                    ."<div class='col-md-12'>
                                                            <div class='profile-sidebar'>
                                                                    <!-- SIDEBAR MENU -->
                                                                    <div class='home-usermenu'>
                                                                            <ul class='nav'>
                                                                                    <li>
                                                                                            <a href='Home.php' style='text-align:center;'>
                                                                                            <i class='glyphicon glyphicon-home'></i>
                                                                                            Home </a>
                                                                                    </li>
                                                                                    <li>
                                                                                            <a href='SearchResult.php?epr=myJobs' style='text-align:center;'>
                                                                                            <i class='glyphicon glyphicon-envelope'></i>
                                                                                             Inbox</a>
                                                                                    </li>
                                                                                    <li>
                                                                                            <a href='JobAdmin.php' style='text-align:center;'>
                                                                                            <i class='glyphicon glyphicon-wrench'></i>
                                                                                            Job </a>
                                                                                    </li>
                                                                                    <li class='active'>
                                                                                            <a href='UserAdmin.php' style='text-align:center;'>
                                                                                            <i class='glyphicon glyphicon-user'></i>
                                                                                            Users </a>
                                                                                    </li>
                                                                                    <li>
                                                                                            <a href='#' data-toggle='modal' data-target='#priceModal' style='text-align:center;'>
                                                                                            <i class='glyphicon glyphicon-flag'></i>
                                                                                            Reports </a>
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
    
    // Admin All Resume Requests
    function AdminAllResumeRequest()
    {
        $requestModel = new RequestModel();
        
        $search = $requestModel->GetRequests();
        
        require_once 'Model/UserModel.php';
        $userModel = new UserModel();
        
        $result = "<div class='row'>"
                . "<div class='panel-group col-md-12'>
			  <div class='panel panel-default'>
					<div class='panel-heading' style='text-align:center;'>
					<a data-toggle='collapse' data-parent='#accordion' href='#collapseListPlacedOffers' class='glyphicon glyphicon-hand-up'><strong>Resume Requests</strong></a>
					</div>
					<div id='collapseListPlacedOffers' class='panel-collapse collapse in'>
						<div class='panel-body'>
                                                    <div class='row' style='margin:auto; width:100%; padding-top:10px;'>
							<input type='text' id='myInput' class='col-md-4' onkeyup='placedOfferTableFunction()' placeholder='Search for Requests' title='Type in a request name' style='display: block; margin: auto;'>
                                                    </div>"
                                                        . "<table class='table sortable' id='placedOffersTable'>"
                                                        . "<tr>"
                                                        . "     <th style='text-align:center;'>From User</th>"
                                                        . "     <th style='text-align:center;'>To User</th>" 
                                                        . "     <th style='text-align:center;'>Status</th>"
                                                        . "     <th style='text-align:center;'>Date</th>"
                                                        . "     <th style='text-align:center;'>Status</th>"
                                                        . "     <th style='text-align:center;'>Seen</th>"
                                                        . "</tr>";
                                                        try
                                                        {
                                                            if($search != null)
                                                            {
                                                                foreach($search as $row)
                                                                {
                                                                    $fromUserName = $userModel->GetUserById($row->userId)->username;
                                                                    $toUsername = $userModel->GetUserById($row->targetUserId)->username;
                                                                    $result.= "<tr>"
                                                                            . "<td align='center'><a href='ViewUserProfile.php?epr=view&id=".$row->userId."'>$fromUserName</a></td>"
                                                                            . "<td align='center'><a href='ViewUserProfile.php?epr=view&id=".$row->targetUserId."'>$toUsername</a></td>";
                                                                            if($row->typeId == 2)
                                                                            {
                                                                                $result.= "<td align='center'>Accepted</td>";
                                                                            }else if($row->typeId == 1)
                                                                            {
                                                                                $result.= "<td align='center'>?</td>";
                                                                            }else
                                                                            {
                                                                                $result.= "<td align='center'>Denied</td>";
                                                                            }
                                                                            $result.="<td align='center'>$row->date</td>";
                                                                            if($row->status == 2)
                                                                            {
                                                                                $result.="<td align='center'>Accepted</td>";
                                                                            }else if($row->status == 1)
                                                                            {
                                                                                $result.="<td align='center'>?</td>";
                                                                            }else
                                                                            {
                                                                                $result.="<td align='center'>Denied</td>";
                                                                            }
                                                                            
                                                                            $result.= "<td align='center'>$row->seen</td>";
                                                                                    
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
                        . "<script>
				function placedOfferTableFunction() {
				  var input, filter, table, tr, td, i;
				  input = document.getElementById('myInput');
				  filter = input.value.toUpperCase();
				  table = document.getElementById('placedOffersTable');
				  tr = table.getElementsByTagName('tr');
				  for (i = 0; i < tr.length; i++) {
					td = tr[i].getElementsByTagName('td')[0];
					if (td) {
					  if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
						tr[i].style.display = '';
					  } else {
						tr[i].style.display = 'none';
					  }
					}       
				  }
				}
			</script>";
                return $result; 
    }
    
}
