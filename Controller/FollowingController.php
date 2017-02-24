<?php

require ("Model/FollowingModel.php");
require ("Model/UserModel.php");
require ("Model/FollowingTimelineModel.php");
require ("Model/NotificationModel.php");
require ("Model/NotificationTypeModel.php");
require ("Model/JobModel.php");
require ("Model/QualificationModel.php");
require ("Model/TypeModel.php");

class FollowingController {
    
    // Follow A User
    function FollowAUser($userId,$followinguserId, $dateoffollowed)
    {
        $followingModel = new FollowingModel();
        $followingModel->FollowAUser($userId, $followinguserId, $dateoffollowed);
    }
    
    // Check if a user already follows another user
    function CheckIfUserAlreadyFollowedAnotherUser($userId,$followinguserId)
    {
        $followingModel = new FollowingModel();
        return $followingModel->CheckIfUserAlreadyFollowedAnotherUser($userId, $followinguserId);
    }
    
    // Get User's Followers
    function GetFollowersByUserId($userId)
    {
        $followingModel = new FollowingModel();
        $followingModel->GetFollowersByUserId($userId);
    }
    
    //Unfollow a user
    function unfollowAUser($userId,$followinguserId)
    {
        $followingModel = new FollowingModel();
        $followingModel->unfollowAUser($userId, $followinguserId);
    }
    
    // Get My Followers
    function GetFollowersByFollowingUserId($followinguserId)
    {
        $followingModel = new FollowingModel();
        $followingModel->GetFollowersByFollowingUserId($followinguserId);
    }
    
    //Code to create the user following page sidebar
    function FollowingSidebar()
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
						<li>
							<a href='UserReview.php?epr=review&id=".$_SESSION['id']."'>
							<i class='glyphicon glyphicon-comment'></i>
							My Review </a>
						</li>
						<li class='active'>
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
    
    //Code to create the user following page content
    function FollowingContent()
    {
        $followingModel = new FollowingModel();
        $search = $followingModel->GetFollowersByUserId($_SESSION['id']);
        $myFollowers = $followingModel->GetFollowersByFollowingUserId($_SESSION['id']);
        
        $userModel = new UserModel();
        
        $followingTimelineModel = new FollowingTimelineModel();
        $TimelineEvents = $followingTimelineModel->GetAllTimelineEvents();
        
        $notificationTypeModel = new NotificationTypeModel();
        
        $qualificationModel = new QualificationModel();
        $typeModel = new TypeModel();
        
        $jobModel = new JobModel();
        
                $result = "<div class='row'>"
                    . "<div class='panel-group col-md-6'>
			  <div class='panel panel-default'>
					<div class='panel-heading' style='text-align:center;'>
					<a data-toggle='collapse' data-parent='#accordion' href='#collapseadvertisedjobs' class='glyphicon glyphicon-hand-up'><strong>People I'm Following</strong></a>
					</div>
					<div id='collapseadvertisedjobs' class='panel-collapse collapse in'>
						<div class='panel-body'>
                                                    <div class='table-responsive'>"
                                                        . "<table class='table sortable'>"
                                                        . "<tr>"
                                                        . "     <th style='text-align:center;'>Username</th>"
                                                        . "     <th style='text-align:center;'>Date</th>"
                                                        . "</tr>";
                                                        try
                                                        {
                                                            if($search != null)
                                                            {
                                                                foreach($search as $row)
                                                                {
                                                                    $result.= "<tr>"
                                                                            . "<td align='center'><a href='ViewUserProfile.php?epr=view&id=".$row->followinguserId."'>";$result.=$userModel->GetUserById($row->followinguserId)->username;$result.="</a></td>"
                                                                            . "<td align='center'>$row->dateoffollowed</td>"
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
                . "<div class='panel-group col-md-6'>
			  <div class='panel panel-default'>
					<div class='panel-heading' style='text-align:center;'>
					<a data-toggle='collapse' data-parent='#accordion' href='#collapseMyPlacedOffers' class='glyphicon glyphicon-hand-up'><strong>My Followers</strong></a>
					</div>
					<div id='collapseMyPlacedOffers' class='panel-collapse collapse in'>
						<div class='panel-body'>"
                                                        . "<table class='table sortable'>"
                                                        . "<tr>"
                                                        . "     <th style='text-align:center;'>Username</th>"
                                                        . "     <th style='text-align:center;'>Date</th>"
                                                        . "</tr>";
                                                        try
                                                        {
                                                            if($myFollowers != null)
                                                            {
                                                                foreach($myFollowers as $row1)
                                                                {
                                                                    $result.= "<tr>"
                                                                            . "<td align='center'><a href='ViewUserProfile.php?epr=view&id=".$row1->userId."'>";$result.=$userModel->GetUserById($row1->userId)->username;$result.="</a></td>"
                                                                            . "<td align='center'>$row1->dateoffollowed</td>"
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
                
                . "<div class='panel-group col-md-12'>
			  <div class='panel panel-default'>
					<div class='panel-heading' style='text-align:center;'>
					<a data-toggle='collapse' data-parent='#accordion' href='#collapseTimeline' class='glyphicon glyphicon-hand-up'><strong>Timeline</strong></a>
					</div>
					<div id='collapseTimeline' class='panel-collapse collapse in'>
                                            <div class='panel-body'>
                                                <div class='timeline' id='timeline'>
                                                <div class='row col-md-offset-8'>
                                                    <select onchange='myFunction()' class='form-control col-md-8' id='userfollowing' name = 'userfollowing' style='width:200px;'>
                                                    <option value='0'>All</option>";
                                                    if($search != null)
                                                    {
                                                      foreach($search as $row2)
                                                      { 
                                                        $result .= '<option value='.$row2->followinguserId.'>'.$userModel->GetUserById($row2->followinguserId)->username.'</option>';
                                                      }
                                                    }
                                                   $result.= " </select>"
                                              . "</div>"
                                            . "<script>
						function myFunction() {
                                                var x = document.getElementById('userfollowing').value;
                                                $('#timeline').load('updateTimeline.php?epr=view&select=' + x);
                                            }
                                            </script>";
                                                        try
                                                        {
                                                                    if($TimelineEvents != null)
                                                                    {
                                                                        foreach($TimelineEvents as $row1)
                                                                        {
                                                                            if($search != null)
                                                                            {
                                                                                foreach($search as $row)
                                                                                {
                                                                                    if($row->followinguserId == $row1->userid)
                                                                                    {
                                                                                        $user = $userModel->GetUserById($row->followinguserId);
                                                                                        $timeLineEvent = $notificationTypeModel->GetNotificationTypeById($row1->typeid)->name;

                                                                                        $job = $jobModel->GetJobsByID($row1->jobid);
                                                                                        if($job != NULL)
                                                                                        {
                                                                                            $qualification = $qualificationModel->GetQualificationByID($job->qualification);
                                                                                            $type = $typeModel->GetTypeByID($job->type);
                                                                                            if($row1->typeid == 6)
                                                                                            {

                                                                                                $dateT = new DateTime($row1->dateposted);
                                                                                                $dateposted = $dateT->format("H:i:s d/m/Y");
                                                                                                $result.="<div class='timeline-item' id='gdsa'>
                                                                                                    <div class='year'><div class='col-md-7'>$dateposted</div> <span class='marker'><span class='dot'></span></span>
                                                                                                    </div>
                                                                                                    <div class='info'>
                                                                                                        <div class='row'>
                                                                                                            <div class='tl col-md-3'>
                                                                                                                    <a href='ViewUserProfile.php?epr=view&id=".$job->id."'><img src='$user->photo' class='img-responsive' alt=''></a>
                                                                                                                    <div class='row col-md-3'>
                                                                                                                        <p style='text-align:center;'><strong>$user->username</strong></p>
                                                                                                                    </div>
                                                                                                            </div>

                                                                                                            <div class='col-md-9'>
                                                                                                                <p style='font-size: 14px;' style='text-align:center;'><strong>$timeLineEvent:</strong></p>
                                                                                                                <div class='row col-md-offset-2'>
                                                                                                                    <p><a href='SearchResult.php?epr=view&id=".$job->jobid."&typeId=".$job->type."' style='font-size: 14px; text-align:center;margin-left:10px;'><strong>$job->name</strong></a></p>
                                                                                                                        </br>
                                                                                                                    <table class='sortable table' id='myJobTable'>
                                                                                                                        <tr>
                                                                                                                            <td><strong>Qualification:</strong>&nbsp&nbsp$qualification->qualificationName</td>
                                                                                                                        </tr>
                                                                                                                        <tr>
                                                                                                                            <td><strong>Category:</strong>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp$type->name</td>
                                                                                                                        </tr>
                                                                                                                        <tr>
                                                                                                                            <td><strong>Number Of Days:</strong>&nbsp&nbsp $job->numberOfDays </td>
                                                                                                                        </tr>
                                                                                                                        <tr>
                                                                                                                            <td><strong>Number Of People Required:</strong>&nbsp&nbsp $job->numberOfPeopleRequired </td>
                                                                                                                        </tr>
                                                                                                                        <tr>
                                                                                                                            <td><strong>Price / Minimum Bid:</strong>&nbsp&nbsp $job->price </td>
                                                                                                                        </tr>
                                                                                                                    </table>
                                                                                                                </div>
                                                                                                            </div>

                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>"; 
                                                                                            }
                                                                                        }
                                                                                    }
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                
                                                            
                                                    }catch(Exception $x)
                                                    {
                                                        echo 'Caught exception: ',  $x->getMessage(), "\n";
                                                    }
                                                $result.="</div>
                                                
                                            </div>
                                        </div>
                           </div>
                   </div>"
                . "</div>"
                . "<script>"
                . "$('.timeline-item').hover(function () {
                    $('.timeline-item').removeClass('active');
                    $(this).toggleClass('active');
                    $(this).prev('.timeline-item').toggleClass('close');
                    $(this).next('.timeline-item').toggleClass('close');
                });"
                . "</script>";
        return $result;
    }
}
