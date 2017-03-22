<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PaymentController
 *
 * @author Jake Valino
 */

require 'Model/PaymentModel.php';
class PaymentController {
    
    // Insert A Payment
    function InsertANewPayment($userId, $targetUserId, $jobId, $amount, $date, $paymentType, $status, $seen)
    {
        $paymentModel = new PaymentModel();
        $paymentModel->InsertANewPayment($userId, $targetUserId, $jobId, $amount, $date, $paymentType, $status, $seen);
    }
    
    // Get Payment by targetUserId
    function GetPaymentMeAccountByUserId($targetUserId)
    {
        $paymentModel = new PaymentModel();
        $paymentModel->GetPayPalMeAccountByUserId($targetUserId);
    }
    
    // Get Payment by targetUserId And nobId
    function GetPayPalMeAccountByUserIdAndJobId($targetUserId,$jobId)
    {
        $paymentModel = new PaymentModel();
        $paymentModel->GetPayPalMeAccountByUserIdAndJobId($targetUserId, $jobId);
    }
    
    // Get Payment by targetUserId
    function GetPaymentMeAccountByUserIdTargetUserIdAndJobId($userId, $targetUserId, $jobId)
    {
        $paymentModel = new PaymentModel();
        $paymentModel->GetPaymentMeAccountByUserIdTargetUserIdAndJobId($userId, $targetUserId, $jobId);
    }
    
    //Update a Payment Confirmation
    function updatePaymentConfirmation($status, $targetUserId, $userId, $jobId)
    {
        $paymentModel = new PaymentModel();
        $paymentModel->updatePaymentConfirmation($status, $targetUserId, $userId, $jobId);
    }
    
    // Get Payment by targetUserId And nobId
    function CountPaymentByUserIdAndJobId($targetUserId,$jobId)
    {
       $paymentModel = new PaymentModel();
       $paymentModel->CountPayPalMeAccountByUserIdAndJobId($targetUserId, $jobId);
    }
    
    // Count Payment by targetUserId
    function CountPaymentByTargetUserId($targetUserId)
    {
        $paymentModel = new PaymentModel();
        $paymentModel->CountPaymentByTargetUserId($targetUserId);
    }
    
   // Request Content
    function PaymentConfirmationContent()
    {
        $paymentModel = new PaymentModel();
       
        $search = $paymentModel->GetPaymentMeAccountByUserId($_SESSION['id']);
        
        require_once  'Model/UserModel.php';
        $userModel = new UserModel();
        
        require_once  'Model/JobModel.php';
        $jobModel = new JobModel();
        
        $result= '<div class="panel-group col-md-12">
			  <div class="panel panel-default">
					<div class="panel-heading" style="text-align:center;">
					<a data-toggle="collapse" data-parent="#accordion" href="#collapsePayment" class="glyphicon glyphicon-hand-up"><strong>Payment Confirmation</strong></a>
					</div>
					<div id="collapsePayment" class="panel-collapse collapse in">
						<div class="panel-body">
                                                    <div class="table-responsive scrollitY" style="height:450px;">
                                                        <table class="sortable table" id="myJobTable">
                                                            <tr>
                                                                <th>Name</th>
                                                                <th>Job</th>
                                                                <th>Amount</th>
                                                                <th>Payment Type</th>
                                                                <th>Date</th>
                                                                <th>Action:</th>
                                                            </tr>';
                                                           try
                                                            {
                                                               if($search != 0)
                                                               {
                                                                   
                                                                    foreach($search as $row)
                                                                    {
                                                                        $username= $userModel->GetUserById($row->userId)->username;
                                                                        
                                                                        $dateT = new DateTime($row->date);
                                                                        $dateposted = $dateT->format("H:i:s d-m-Y");
                                                                        
                                                                        if($row->seen == 0)
                                                                        {
                                                                            // Payment Confirmation has not been seen by the user
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
                                                                                                 <td  style="color:blue;">'.$row->amount.'</td>';
                                                                                                  if($row->paymentType == 0)
                                                                                                  {
                                                                                                      $result.='<td bgcolor="#ccd7ea" style="color:blue;">PayPal</td>';
                                                                                                  }else
                                                                                                  {
                                                                                                      $result.='<td bgcolor="#ccd7ea" style="color:blue;">Cash</td>';
                                                                                                  }
                                                                                       $result.='<td  style="color:blue;">'; $result.= $dateposted; $result.='</td>
                                                                                                 <td  style="color:blue;"></td>
                                                                                                 <td>
                                                                                                      <a class="btn btn-info disabled" href="">Confirmed</a>
                                                                                                 </td>
                                                                                         </tr>';
                                                                                }else if($row->status == 1)
                                                                                {
                                                                                    // Request Sent
                                                                                    $result.='<td><strong>' .$row->userId;$result.='</strong> &nbsp &nbsp &nbsp &nbsp'; $result.='</td>
                                                                                                 <td  style="color:blue;">'; $result.= $jobModel->GetJobsByID($row->jobId)->name; $result.='</td>
                                                                                                 <td  style="color:blue;">'.$row->amount.'</td>';  
                                                                                                  if($row->paymentType == 0)
                                                                                                  {
                                                                                                      $result.='<td bgcolor="#ccd7ea" style="color:blue;">PayPal</td>';
                                                                                                  }else
                                                                                                  {
                                                                                                      $result.='<td bgcolor="#ccd7ea" style="color:blue;">Cash</td>';
                                                                                                  }
                                                                                       $result.='<td  style="color:blue;">'; $result.= $dateposted; $result.='</td>
                                                                                                 <td>
                                                                                                      <a class="btn btn-info" href="PaymentConfirmation.php?epr=confirm&userId='.$row->userId.'&jobId='.$row->jobId.'">Confirm</a>
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
                                                                                                <td bgcolor="#ccd7ea" style="color:blue;">'.$row->amount.'</td>';
                                                                                                  if($row->paymentType == 0)
                                                                                                  {
                                                                                                      $result.='<td bgcolor="#ccd7ea" style="color:blue;">PayPal</td>';
                                                                                                  }else
                                                                                                  {
                                                                                                      $result.='<td bgcolor="#ccd7ea" style="color:blue;">Cash</td>';
                                                                                                  }
                                                                                      $result.='<td bgcolor="#ccd7ea"  style="color:blue;">'; $result.= $dateposted;  $result.='</td>
                                                                                                <td bgcolor="#ccd7ea">
                                                                                                     <a class="btn btn-info disabled" href="">Confirmed</a>
                                                                                                </td>
                                                                                        </tr>';
                                                                                }else if($row->status == 1)
                                                                                {
                                                                                    // Request Sent
                                                                                    $result.='<td bgcolor="#ccd7ea" style="color:blue;"><strong>'; $result.= '<a href="ViewUserProfile.php?epr=view&id='.$userModel->GetUserById($row->userId)->id.'">'. $username; $result.='</strong></a> &nbsp &nbsp &nbsp &nbsp'; $result.='</td>
                                                                                                <td bgcolor="#ccd7ea" style="color:blue;">'; $result.= $jobModel->GetJobsByID($row->jobId)->name;  $result.='</td>
                                                                                                <td bgcolor="#ccd7ea" style="color:blue;">'.$row->amount.'</td>';
                                                                                                  if($row->paymentType == 0)
                                                                                                  {
                                                                                                      $result.='<td bgcolor="#ccd7ea" style="color:blue;">PayPal</td>';
                                                                                                  }else
                                                                                                  {
                                                                                                      $result.='<td bgcolor="#ccd7ea" style="color:blue;">Cash</td>';
                                                                                                  }
                                                                                      $result.='<td bgcolor="#ccd7ea"  style="color:blue;">'; $result.= $dateposted;  $result.='</td>
                                                                                                <td bgcolor="#ccd7ea">
                                                                                                      <a class="btn btn-info" href="PaymentConfirmation.php?epr=confirm&userId='.$row->userId.'&jobId='.$row->jobId.'">Confirm</a>
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
                                                                                            <td style="color:blue;">'.$row->amount.'</td>';
                                                                                            if($row->paymentType == 0)
                                                                                            {
                                                                                                $result.='<td  style="color:blue;">PayPal</td>';
                                                                                            }else
                                                                                            {
                                                                                                $result.='<td  style="color:blue;">Cash</td>';
                                                                                            }
                                                                                $result.='<td  style="color:blue;">'; $result.= $dateposted; $result.='</td>
                                                                                          <td>
                                                                                               <a class="btn btn-info disabled" href="">Confirmed</a>
                                                                                          </td>
                                                                                        </tr>';
                                                                                }else if($row->status == 1)
                                                                                {
                                                                                    // Request Sent
                                                                                    $result.='<tr>
                                                                                            <td><strong>' .$row->userId;$result.='</strong> &nbsp &nbsp &nbsp &nbsp'; $result.='</td>
                                                                                            <td style="color:blue;">';  $result.= $jobModel->GetJobsByID($row->jobId)->name; $result.='</td>
                                                                                            <td style="color:blue;">'.$row->amount.'</td>';
                                                                                            if($row->paymentType == 0)
                                                                                            {
                                                                                                $result.='<td  style="color:blue;">PayPal</td>';
                                                                                            }else
                                                                                            {
                                                                                                $result.='<td  style="color:blue;">Cash</td>';
                                                                                            }
                                                                                      $result.='<td  style="color:blue;">'; $result.= $dateposted; $result.='</td>
                                                                                                <td>
                                                                                                      <a class="btn btn-info" href="PaymentConfirmation.php?epr=confirm&userId='.$row->userId.'&jobId='.$row->jobId.'">Confirm</a>
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
                                                                                            <td style="color:blue;">'.$row->amount.'</td>';
                                                                                            if($row->paymentType == 0)
                                                                                            {
                                                                                                $result.='<td  style="color:blue;">PayPal</td>';
                                                                                            }else
                                                                                            {
                                                                                                $result.='<td  style="color:blue;">Cash</td>';
                                                                                            }
                                                                                $result.='<td style="color:blue;">'; $result.= $dateposted; $result.='</td>
                                                                                          <td>
                                                                                               <a class="btn btn-info disabled" href="">Confirmed</a>
                                                                                          </td>
                                                                                        </tr>';
                                                                                }else if($row->status == 1)
                                                                                {
                                                                                    // Request Sent
                                                                                    $result.='<tr>
                                                                                            <td style="color:blue;"><strong>'; $result.= '<a href="ViewUserProfile.php?epr=view&id='.$userModel->GetUserById($row->userId)->id.'">'. $username; $result.='</strong></a> &nbsp &nbsp &nbsp &nbsp'; $result.='</td>
                                                                                            <td style="color:blue;">';  $result.= $jobModel->GetJobsByID($row->jobId)->name; $result.='</td>
                                                                                            <td style="color:blue;">'.$row->amount.'</td>';
                                                                                            if($row->paymentType == 0)
                                                                                            {
                                                                                                $result.='<td  style="color:blue;">PayPal</td>';
                                                                                            }else
                                                                                            {
                                                                                                $result.='<td  style="color:blue;">Cash</td>';
                                                                                            }
                                                                                            $result.='<td style="color:blue;">'; $result.= $dateposted; $result.='</td>
                                                                                                <td>
                                                                                                      <a class="btn btn-info" href="PaymentConfirmation.php?epr=confirm&userId='.$row->userId.'&jobId='.$row->jobId.'">Confirm</a>
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
    
   //Code to create the user profile sidebar
    function CreatePaymentSidebar()
    {
        require_once  'Model/UserModel.php';
        $userModel = new UserModel();
        $user = $userModel->CheckUser($_SESSION['username']);
        
        require_once  'Model/NotificationModel.php';
        $notificationModel = new NotificationModel();
        $userNotification = $notificationModel->CountNotificationByToUsername($_SESSION['username']);
        
        require_once  'Model/MessagesModel.php';
	$messagesModel = new MessagesModel();
	$myMessages = $messagesModel->CountAllMyMessages($_SESSION['username']);
        require_once 'Model/RequestModel.php';
        $requestModel = new RequestModel();
        $myRequest = $requestModel->CountRequestsByTargetUserId($_SESSION['id']);
        
        require_once 'Model/CancelRequestModel.php';
        $cancelRequestModel = new CancelRequestModel();
        $myOfferCancellationRequest = $cancelRequestModel->CountCancelRequestByTargetUserId($_SESSION['id']);
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
						<li class='active'>";
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
