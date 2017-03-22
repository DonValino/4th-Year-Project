<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CancelRequestController
 *
 * @author Jake Valino
 */

require ("Model/CancelRequestModel.php");
class CancelRequestController {

    // Insert A Cancel Request
    function InsertANewCancelRequest($userId, $tagerUserId, $jobId, $reason, $date, $seen)
    {
       $cancelRequestModel = new CancelRequestModel();
       $cancelRequestModel->InsertANewCancelRequest($userId, $tagerUserId, $jobId, $reason, $date, $seen);
    }
    
    // Get Cancel Request by Target User Id
    function GetCancelRequestByTargetUserId($tagerUserId)
    {
       $cancelRequestModel = new CancelRequestModel();
       return $cancelRequestModel->GetCancelRequestByTargetUserId($tagerUserId);
    }
    
    // Get Cancel Request by User Id
    function GetCancelRequestByUserId($userId)
    {
       $cancelRequestModel = new CancelRequestModel();
       $cancelRequestModel->GetCancelRequestByUserId($userId);
    }
    
    // Update A Cancel Request Status
    function updateCancelRequestStatus($status,$userId,$targetUserId,$jobId)
    {
        $cancelRequestModel = new CancelRequestModel();
        $cancelRequestModel->updateCancelRequestStatus($status, $userId, $targetUserId, $jobId);
    }
    
    // Update A Cancel Request Reason
    function updateCancelReason($reason,$userId,$targetUserId,$jobId)
    {
        $cancelRequestModel = new CancelRequestModel();
        $cancelRequestModel->updateCancelReason($reason, $userId, $targetUserId, $jobId);
    }
    
    // Update A Cancel Request Seen
    function updateCancelSeen($seen,$userId,$targetUserId,$jobId)
    {
        $cancelRequestModel = new CancelRequestModel();
        $cancelRequestModel->updateCancelSeen($seen, $userId, $targetUserId, $jobId);
    }
    
    // Count Cancel Request by Target User Id
    function CountCancelRequestByTargetUserId($tagerUserId)
    {
        $cancelRequestModel = new CancelRequestModel();
        $cancelRequestModel->CountCancelRequestByTargetUserId($tagerUserId);
    }
    
    // Modal To Send A New Messages
    function SendMessageModal($id)
    {
        $userModel = new UserModel();
        
        $userName = $userModel->GetUserById($id)->username;
        $_SESSION['SendUsername']=$userName;
                $result = "
                    <div class='modal fade col-md-12 col-xs-11' id='sendMessageModal' role='dialog'>
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
                                                            <label for='messages' class='col-md-2 col-sm-2 col-xs-3'> Message: </label>
                                                              <textarea class='col-md-8 col-sm-8 col-xs-8' rows='5' id='messages' name = 'messages' placeholder='Message' required autofocus></textarea>
                                                            </div>

                                                            <div class='row'>
                                                            <button class='btn primary col-sm-2 col-sm-offset-9 col-md-2 col-md-offset-9' Style='margin-left:185px;' name = 'sendMessage' type='submit'>Send</button>
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
    
   // Request Content
    function CancelRequestInfoContent()
    {
        require_once 'Model/JobModel.php';
        require_once 'Model/UserModel.php';
        
       $cancelRequestModel = new CancelRequestModel();
       
       $myCancellationRequest = $this->GetCancelRequestByTargetUserId($_SESSION['id']);
       
       $userModel = new UserModel();
       $jobModel = new JobModel();

       
       $result= '<div class="panel-group col-md-12">
			  <div class="panel panel-default">
					<div class="panel-heading" style="text-align:center;">
					<a data-toggle="collapse" data-parent="#accordion" href="#collapseMyNotification" class="glyphicon glyphicon-hand-up"><strong>Offer Cancellation Request</strong></a>
					</div>
					<div id="collapseMyNotification" class="panel-collapse collapse in">
						<div class="panel-body">
                                                    <div class="table-responsive scrollitY" style="height:450px;">
                                                        <table class="sortable table" id="myJobTable">
                                                            <tr>
                                                                <th>Name</th>
                                                                <th>Job</th>
                                                                <th>Reason</th>
                                                                <th>Date</th>
                                                                <th>Action:</th>
                                                            </tr>';
                                                           try
                                                            {
                                                               if($myCancellationRequest != 0)
                                                               {
                                                                    foreach($myCancellationRequest as $row)
                                                                    {
                                                                        $username= $userModel->GetUserById($row->userId)->username;
                                                                       // $_SESSION['tousername'] = $username;
                                                                        $id= $row->userId;
                                                                        $dateT = new DateTime($row->date);
                                                                        $dateposted = $dateT->format("H:i:s d-m-Y");
                                                                        
                                                                        if($row->seen == 0)
                                                                        {
                                                                            // Cancel Reqeust has not been seen by user
                                                                            $result.='<tr>';
                                                                            // Check if user exist
                                                                            if($userModel->GetUserById($row->userId) === 0)
                                                                            {
                                                                                // User does not exist go here (Account been deleted but records are still retained).
                                                                                if($row->status == 2)
                                                                                {
                                                                                    // Request Accepted
                                                                                    $result.='<td><strong>' .$row->userId;$result.='</strong> &nbsp &nbsp &nbsp &nbsp'; $result.='</td>
                                                                                                 <td  style="color:blue;">'; $result.= $jobModel->GetJobsByID($row->jobId)->name; $result.='</td>
                                                                                                 <td  style="color:blue;">'.$row->reason.'</td>    
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
                                                                                                 <td  style="color:blue;">'; $result.= $jobModel->GetJobsByID($row->jobId)->name; $result.='</td>
                                                                                                 <td  style="color:blue;">'.$row->reason.'</td>  
                                                                                                 <td  style="color:blue;">'; $result.= $dateposted; $result.='</td>
                                                                                                 <td>
                                                                                                      <a class="btn btn-info" href="CancelOfferRequest.php?epr=accept&userId='.$row->userId.'&jobId='.$row->jobId.'">Accept</a> |
                                                                                                      <a class="btn btn-danger" href="CancelOfferRequest.php?epr=denied&userId='.$row->userId.'&jobId='.$row->jobId.'">Decline</a>
                                                                                                 </td>
                                                                                         </tr>';
                                                                                }else if($row->status == 0)
                                                                                {
                                                                                    // Request Denied
                                                                                    $result.='<td><strong>' .$row->userId;$result.='</strong> &nbsp &nbsp &nbsp &nbsp'; $result.='</td>
                                                                                                 <td  style="color:blue;">'; $result.= $jobModel->GetJobsByID($row->jobId)->name; $result.='</td>
                                                                                                 <td  style="color:blue;">'.$row->reason.'</td>  
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
                                                                                    $result.='<td bgcolor="#ccd7ea" style="color:blue;"><strong>'; $result.= '<a href="ViewUserProfile.php?epr=view&id='.$userModel->GetUserById($row->userId)->id.'">'. $username; $result.='</strong></a> &nbsp &nbsp &nbsp &nbsp'; $result.='</td>
                                                                                                <td bgcolor="#ccd7ea" style="color:blue;">'; $result.= $jobModel->GetJobsByID($row->jobId)->name;  $result.='</td>
                                                                                                <td bgcolor="#ccd7ea" style="color:blue;">'.$row->reason.'</td>
                                                                                                <td bgcolor="#ccd7ea"  style="color:blue;">'; $result.= $dateposted;  $result.='</td>
                                                                                                <td bgcolor="#ccd7ea">
                                                                                                     <a class="btn btn-info disabled" href="">Accepted</a>
                                                                                                </td>
                                                                                        </tr>';
                                                                                }else if($row->status == 1)
                                                                                {
                                                                                    // Request Sent
                                                                                    $result.='<td bgcolor="#ccd7ea" style="color:blue;"><strong>'; $result.= '<a href="ViewUserProfile.php?epr=view&id='.$userModel->GetUserById($row->userId)->id.'">'. $username; $result.='</strong></a> &nbsp &nbsp &nbsp &nbsp'; $result.='</td>
                                                                                                <td bgcolor="#ccd7ea" style="color:blue;">'; $result.= $jobModel->GetJobsByID($row->jobId)->name;  $result.='</td>
                                                                                                <td bgcolor="#ccd7ea" style="color:blue;">'.$row->reason.'</td>
                                                                                                <td bgcolor="#ccd7ea"  style="color:blue;">'; $result.= $dateposted;  $result.='</td>
                                                                                                <td bgcolor="#ccd7ea">
                                                                                                      <a class="btn btn-info" href="CancelOfferRequest.php?epr=accept&userId='.$row->userId.'&jobId='.$row->jobId.'">Accept</a> |
                                                                                                      <a class="btn btn-danger" href="CancelOfferRequest.php?epr=denied&userId='.$row->userId.'&jobId='.$row->jobId.'">Decline</a>
                                                                                                </td>
                                                                                        </tr>';
                                                                                }else if($row->status == 0)
                                                                                {
                                                                                    // Request Denied
                                                                                    $result.='<td bgcolor="#ccd7ea" style="color:blue;"><strong>'; $result.= '<a href="ViewUserProfile.php?epr=view&id='.$userModel->GetUserById($row->userId)->id.'">'. $username; $result.='</strong></a> &nbsp &nbsp &nbsp &nbsp'; $result.='</td>
                                                                                                <td bgcolor="#ccd7ea" style="color:blue;">'; $result.= $jobModel->GetJobsByID($row->jobId)->name;  $result.='</td>
                                                                                                <td bgcolor="#ccd7ea" style="color:blue;">'.$row->reason.'</td>    
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
                                                                                            <td style="color:blue;">';  $result.= $jobModel->GetJobsByID($row->jobId)->name; $result.='</td>
                                                                                            <td style="color:blue;">'.$row->reason.'</td>
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
                                                                                            <td style="color:blue;">';  $result.= $jobModel->GetJobsByID($row->jobId)->name; $result.='</td>
                                                                                            <td style="color:blue;">'.$row->reason.'</td>
                                                                                            <td  style="color:blue;">'; $result.= $dateposted; $result.='</td>
                                                                                                <td>
                                                                                                      <a class="btn btn-info" href="CancelOfferRequest.php?epr=accept&userId='.$row->userId.'&jobId='.$row->jobId.'">Accept</a>|
                                                                                                      <a class="btn btn-danger" href="CancelOfferRequest.php?epr=denied&userId='.$row->userId.'&jobId='.$row->jobId.'">Decline</a>
                                                                                                </td>
                                                                                        </tr>';
                                                                                }else if($row->status == 0)
                                                                                {
                                                                                    // Request Denied
                                                                                    $result.='<tr>
                                                                                            <td><strong>' .$row->userId;$result.='</strong> &nbsp &nbsp &nbsp &nbsp'; $result.='</td>
                                                                                            <td style="color:blue;">'; $result.= $jobModel->GetJobsByID($row->jobId)->name; $result.='</td>
                                                                                            <td style="color:blue;">'.$row->reason.'</td>
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
                                                                                            <td style="color:blue;">';  $result.= $jobModel->GetJobsByID($row->jobId)->name; $result.='</td>
                                                                                            <td style="color:blue;">'.$row->reason.'</td>
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
                                                                                            <td style="color:blue;">';  $result.= $jobModel->GetJobsByID($row->jobId)->name; $result.='</td>
                                                                                            <td style="color:blue;">'.$row->reason.'</td>
                                                                                            <td style="color:blue;">'; $result.= $dateposted; $result.='</td>
                                                                                                <td>
                                                                                                      <a class="btn btn-info" href="CancelOfferRequest.php?epr=accept&userId='.$row->userId.'&jobId='.$row->jobId.'">Accept</a>|
                                                                                                      <a class="btn btn-danger" href="CancelOfferRequest.php?epr=denied&userId='.$row->userId.'&jobId='.$row->jobId.'">Decline</a>
                                                                                                </td>
                                                                                        </tr>';
                                                                                }else if($row->status == 0)
                                                                                {
                                                                                    // Request Denied
                                                                                    $result.='<tr>
                                                                                            <td style="color:blue;"><strong>'; $result.= '<a href="ViewUserProfile.php?epr=view&id='.$userModel->GetUserById($row->userId)->id.'">'. $username; $result.='</strong></a> &nbsp &nbsp &nbsp &nbsp'; $result.='</td>
                                                                                            <td style="color:blue;">';  $result.= $jobModel->GetJobsByID($row->jobId)->name; $result.='</td>
                                                                                            <td style="color:blue;">'.$row->reason.'</td>
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
    
    function CancelRequestForm()
    {
        $re= "<div class='row'>
            <div class='insertJob-form col-md-6 col-md-offset-3'>
          <div class='row'>
            <h2 class='col-md-12 col-sm-12 col-xs-12' style='text-align:center;color:blue;'>Request Offer Cancellation</h2>
          </div>
          <form action='' method = 'POST'>
            <fieldset>
              <div class='clearfix'>
              <label for='reason' class='col-md-4 col-sm-2 col-xs-3'> Reason: </label>
                <textarea name = 'reason' style='height:150px;' id='reason' class='col-md-12 col-sm-10 col-xs-9' placeholder='Reason For Cancellation' required autofocus></textarea>
              </div>
              <div class='row'>
              <button class='btn primary col-sm-2 col-sm-offset-9 col-xs-offset-9 col-md-3 col-md-offset-8' name = 'submitCancellationRequest' type='submit'>Submit</button>
              </div>
            </fieldset>
          </form>
        </div>
      </div>";
                
       return $re;
    }
    
    function  CancelRequestSideBarForm()
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
                                                                                            <a href='Home.php' style='text-align:center;'>
                                                                                            <i class='glyphicon glyphicon-home'></i>
                                                                                            Home </a>
                                                                                    </li>
                                                                                    <li>
                                                                                            <a href='Search.php' style='text-align:center;'>
                                                                                            <i class='glyphicon glyphicon-search'></i>
                                                                                            Search </a>
                                                                                    </li>
                                                                                    <li>
                                                                                            <a href='#' data-toggle='modal' data-target='#myModal' style='text-align:center;'>
                                                                                            <i class='glyphicon glyphicon-book'></i>
                                                                                            Categories </a>
                                                                                    </li>
                                                                                    <li>
                                                                                            <a href='#' data-toggle='modal' data-target='#priceModal' style='text-align:center;'>
                                                                                            <i class='glyphicon glyphicon-usd'></i>
                                                                                            Price </a>
                                                                                    </li>
                                                                                    <li>
                                                                                            <a href='SearchResult.php?epr=myJobs' style='text-align:center;'>
                                                                                            <i class='gglyphicon glyphicon-pencil'></i>
                                                                                            My Jobs </a>
                                                                                    </li>
                                                                                    <li>
                                                                                            <a href='JobsOverview.php' style='text-align:center;'>
                                                                                            <i class='glyphicon glyphicon-pencil'></i>
                                                                                            Job Offers </a>
                                                                                    </li>
                                                                                    <li>
                                                                                            <a href='FavoriteJobs.php' style='text-align:center;'>
                                                                                            <i class='glyphicon glyphicon-heart'></i>
                                                                                            Favorite </a>
                                                                                    </li>
                                                                                    <li>
                                                                                            <a href='#' target='_blank' style='text-align:center;'>
                                                                                            <i class='glyphicon glyphicon-italic'></i>
                                                                                            About Us </a>
                                                                                    </li>
                                                                                    <li>
                                                                                            <a href='#' target='_blank' style='text-align:center;'>
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
                            ."</div>"
                . "<div class='row'>"
                . "     <a href='Report.php' class='glyphicon glyphicon-exclamation-sign col-xs-12 col-md-12 col-sm-12' style='text-align:center;'>Report</a>"
                . "</div>";
       
                
        return $result;
    }
    
    function  CancelRequestSideBar()
    {
        $userModel = new UserModel();
        $user = $userModel->CheckUser($_SESSION['username']);
        require_once 'Model/NotificationModel.php';
        $notificationModel = new NotificationModel();
        $userNotification = $notificationModel->CountNotificationByToUsername($_SESSION['username']);
        
        require_once 'Model/MessagesModel.php';
	$messagesModel = new MessagesModel();
	$myMessages = $messagesModel->CountAllMyMessages($_SESSION['username']);
        require_once 'Model/RequestModel.php';
        $requestModel = new RequestModel();
        $myRequest = $requestModel->CountRequestsByTargetUserId($_SESSION['id']);
        
        $result = "<div class='col-md-12 col-sm-12'>
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
							<a href='UserAccount.php' style='text-align:center;'>
							<i class='glyphicon glyphicon-home'></i>
							Overview </a>
						</li>
						<li>
							<a href='AccountSettings.php' style='text-align:center;'>
							<i class='glyphicon glyphicon-user'></i>
							Account Settings </a>
						</li>
						<li class='active'>
							<a href='JobsOverview.php' style='text-align:center;'>
							<i class='glyphicon glyphicon-ok'></i>
							Jobs </a>
						</li>
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
							<a href='#' target='_blank' style='text-align:center;'>
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
}
