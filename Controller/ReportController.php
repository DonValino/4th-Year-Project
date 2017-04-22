<script>
    function closeReport(id) {
    var ask = window.confirm("Are You Sure You Want To Close This Report?");
    if (ask) {
        document.location.href = "ViewAdminReports.php?epr=close&id=" + id ;

    }
  }
    
    function reopenReport(id) {
    var ask = window.confirm("Are You Sure You Want To Reopen This Report?");
    if (ask) {
        document.location.href = "ViewAdminReports.php?epr=reopen&id=" + id ;

    }
}
</script>
<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ReportController
 *
 * @author Jake Valino
 */

require 'Model/ReportModel.php';

class ReportController {
    
    //Insert a new report 
    function InsertANewReport($userId,$description,$typeId,$date, $seen, $status)
    {
        $reportModel = new ReportModel();
        $reportModel->InsertANewReport($userId, $description, $typeId, $date, $seen, $status);
    }
    
    //Get Requests.
    function GetReports()
    {
        $reportModel = new ReportModel();
        return $reportModel->GetReports();
    }
    
    //Get Reports Test.
    function GetReportsTest($year)
    {
        $reportModel = new ReportModel();
        return $reportModel->GetReportsTest($year);
    }
    
    //Get Report By Id.
    function GetReportById($id)
    {
        $reportModel = new ReportModel();
        return $reportModel->GetReportById($id);
    }
    
    // Count Reports.
    function CountReports()
    {
        $reportModel = new ReportModel();
        return $reportModel->CountReports();
    }
    
    //Update report status
    function updateReportStatus($status,$id)
    {
        $reportModel = new ReportModel();
        $reportModel->updateReportStatus($status, $id);
    }
    
    function InsertANewReportForm()
    {
        require_once 'Model/ReportTypeModel.php';
        
        $reportTypeModel = new ReportTypeModel();
        $allType = $reportTypeModel->GetAllReportTypes();
        
        $re= " <div class='insertJob-form'>
          <div class='row'>
            <h2 class='col-md-12 col-sm-12 col-xs-12' style='text-align:center;color:blue;'>Submit A New Report</h2>
          </div>
          <div class='row'>
            <p class='col-md-4 col-sm-4 col-xs-12' style='margin-left:5px;color:blue;'>Please ensure that each field is populated</p>
          </div>
          <form action='' method = 'POST'>
            <fieldset>
              <div class='clearfix'>
              <label for='description' class='col-md-2 col-sm-2 col-xs-3'> Description: </label>
              <textarea class='form-control col-md-2 col-sm-2 col-xs-2' rows='5'  name = 'description' id='description' placeholder='Description' required autofocus></textarea>
              </div>
              <div class='clearfix'>
                <div class='form-group'>
                  <label for='type' class='col-md-2 col-sm-2 col-xs-4'>Category:</label>
                  <select class='form-control col-md-8 col-sm-8 col-xs-7' id='type' name = 'typeId' style='width:200px;'>";
                    foreach($allType as $row)
                    { 
                      $re .= '<option value='.$row->id.'>'.$row->name.'</option>';
                    }
                 $re .=" </select>
                </div>
              </div>
              <div class='clearfix'>
              <div class='row'>
              <button class='btn primary col-sm-2 col-sm-offset-9 col-md-2 col-md-offset-9' Style='margin-left:185px;' name = 'submitReport' type='submit'>Submit</button>
              </div>
            </fieldset>
          </form>
        </div>";
                
       return $re;
    }
    
    function InsertANewUserReportForm($id)
    {
        require_once 'Model/UserModel.php';
        $userModel = new UserModel();
        
        $user = $userModel->GetUserById($id);
        
        $re= " <div class='insertJob-form'>
          <div class='row'>
            <h2 class='col-md-12 col-sm-12 col-xs-12' style='text-align:center;color:blue;'>Submit A Report For User: $user->firstName $user->lastName</h2>
          </div>
          <div class='row'>
            <p class='col-md-4 col-sm-4 col-xs-12' style='margin-left:5px;color:blue;'>Please ensure that each field is populated</p>
          </div>
          <form action='' method = 'POST'>
            <fieldset>
              <div class='clearfix'>
              <label for='description' class='col-md-2 col-sm-2 col-xs-3'> Description: </label>
              <textarea class='form-control col-md-2 col-sm-2 col-xs-2' rows='5' style='width:400px;' name = 'description' id='description' placeholder='Description' required autofocus></textarea>
              </div>
              <div class='clearfix'>
              <div class='row'>
              <button class='btn primary col-sm-2 col-sm-offset-9 col-md-2 col-md-offset-9' Style='margin-left:185px;' name = 'submitReport' type='submit'>Submit</button>
              </div>
            </fieldset>
          </form>
        </div>";
                
       return $re;
    }
    
    function InsertANewJobReportForm($id)
    {
        require_once 'Model/JobModel.php';
        $jobModel = new JobModel();
        
        $job = $jobModel->GetJobsByID($id);
        
        $re= " <div class='insertJob-form'>
          <div class='row'>
            <h2 class='col-md-12 col-sm-12 col-xs-12' style='text-align:center;color:blue;'>Submit A Report For Job: $job->name</h2>
          </div>
          <div class='row'>
            <p class='col-md-4 col-sm-4 col-xs-12' style='margin-left:5px;color:blue;'>Please ensure that each field is populated</p>
          </div>
          <form action='' method = 'POST'>
            <fieldset>
              <div class='clearfix'>
              <label for='description' class='col-md-2 col-sm-2 col-xs-3'> Description: </label>
              <textarea class='form-control col-md-2 col-sm-2 col-xs-2' rows='5' style='width:400px;' name = 'description' id='description' placeholder='Description' required autofocus></textarea>
              </div>
              <div class='clearfix'>
              <div class='row'>
              <button class='btn primary col-sm-2 col-sm-offset-9 col-md-2 col-md-offset-9' Style='margin-left:185px;' name = 'submitReport' type='submit'>Submit</button>
              </div>
            </fieldset>
          </form>
        </div>";
                
       return $re;
    }
    
    //Code to create the user profile sidebar
    function CreateUserProfileSidebar()
    {
        require 'Model/UserModel.php';
        $userModel = new UserModel();
        $user = $userModel->CheckUser($_SESSION['username']);
        require 'Model/NotificationModel.php';
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
						<li class='active'>
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
    
    function AboutFreelanceMeModal()
    {
                $result = "<div class='modal fade col-xs-11' id='aboutFreelanceMeModal' role='dialog'>
			<div class='modal-dialog'>
			
			  <!-- Modal content-->
			  <div class='modal-content col-md-12 col-sm-12'>
				<div class='modal-header'>
				  <button type='button' class='close' data-dismiss='modal'>&times;</button>
				  <h4 class='modal-title'>About FreelanceMe</h4>
				</div>
				<div class='modal-body'>
                                    <p style='font-size:14px;color:green;'>This is a website that will serve as an instrument to allow people locate jobs advertised in the website and work as a freelancer.
                                       Users can post jobs on the website and vice versa, can also look for existing jobs posted by other users of the website. </p>
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
    
    function HelpContent()
    {
        require_once 'Model/ReportTypeModel.php';
        
        $reportTypeModel = new ReportTypeModel();
        $allType = $reportTypeModel->GetAllReportTypes();
        
        $result= "<div class='row'>
                    <div class='panel-group col-md-6'>
			  <div class='panel panel-default alert alert-info'>
					<div class='panel-heading' style='text-align:center;'>
					<a data-toggle='collapse' data-parent='#accordion' href='#collapseRating' class='glyphicon glyphicon-hand-up'><strong>About FreelanceMe</strong></a>
					</div>
					<div id='collapseRating' class='panel-collapse collapse in'>
						<div class='panel-body'>
                                                    <div class='row'>
                                                            <a href='download.php?epr=cv&path=AboutFreelanceMe/Project_Research_document_X00112730_Don_Valino.docx' class='col-sm-12 col-xs-12' style='text-align:center;'>
                                                        <i class='glyphicon glyphicon-book'></i>
                                                                User Manual </a>
                                                    </div>
                                                    <div class='row'>
                                                           <a href='#' data-toggle='modal' data-target='#aboutFreelanceMeModal' class='col-sm-12 col-xs-12' style='text-align:center;'>
                                                        <i class='glyphicon glyphicon-tint'></i>
                                                                About FreelanceMe </a>
                                                    </div>
                                                    <div class='row'>
                                                            <a href='download.php?epr=cv&path=AboutFreelanceMe/Project_Research_document_X00112730_Don_Valino.docx' class='col-sm-12 col-xs-12' style='text-align:center;'>
                                                        <i class='glyphicon glyphicon-search'></i>
                                                                Project Research Document </a>
                                                    </div>
                                                    <div class='row'>
                                                            <a href='download.php?epr=cv&path=AboutFreelanceMe/Technical-Architecture-Freelance_Me.docx' class='col-sm-12 col-xs-12' style='text-align:center;'>
                                                        <i class='glyphicon glyphicon-cog'></i>
                                                                Technical Architecture Document </a>
                                                    </div>"
						."</div>"
					."</div>"
				."</div>"
			."</div>
            <div class='panel-group col-md-6'>
			  <div class='panel panel-default alert alert-info'>
					<div class='panel-heading' style='text-align:center;'>
					<a data-toggle='collapse' data-parent='#accordion' href='#collapseRating' class='glyphicon glyphicon-hand-up'><strong>Report</strong></a>
					</div>
					<div id='collapseRating' class='panel-collapse collapse in'>
						<div class='panel-body'>
                                                    <div class='row'>
                                                            <a href='SubmitAReport.php' class='col-sm-12 col-xs-12' style='text-align:center;'>
                                                        <i class='glyphicon glyphicon-alert'></i>
                                                                Submit A Report </a>
                                                    </div>
                                                    <div class='row'>
                                                            <a href='ViewMyReports.php' class='col-sm-12 col-xs-12' style='text-align:center;'>
                                                        <i class='glyphicon glyphicon-align-left'></i>
                                                                View My Reports </a>
                                                    </div>"
						."</div>"
					."</div>"
				."</div>"
			."</div>"
                . "</div>"
                . "</div>";
                
       return $result;
    }
    
    function CreateAdminViewReportsSideBar()
    {
        require 'Model/MessagesModel.php';
        $messagesModel = new MessagesModel();
        $myMessages = $messagesModel->CountAllMyMessages($_SESSION['username']);
        
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
                                                                                    </li>";
                                                                                    if($myMessages != null)
                                                                                    {
                                                                                            $result.="<li>
                                                                                                            <a href='Messages.php' style='text-align:center;'>
                                                                                                            <i class='glyphicon glyphicon-envelope'></i>
                                                                                                             Inbox &nbsp<span class='badge'>$myMessages</span></a>
                                                                                            </li>";
                                                                                    }else
                                                                                    {
                                                                                            $result.="<li>
                                                                                                            <a href='Messages.php' style='text-align:center;'>
                                                                                                            <i class='glyphicon glyphicon-envelope'></i>
                                                                                                             Inbox</a>
                                                                                            </li>";
                                                                                    }
                                                                                    $result.="<li>
                                                                                            <a href='JobAdmin.php' style='text-align:center;'>
                                                                                            <i class='glyphicon glyphicon-wrench'></i>
                                                                                            Job </a>
                                                                                    </li>
                                                                                    <li>
                                                                                            <a href='UserAdmin.php' style='text-align:center;'>
                                                                                            <i class='glyphicon glyphicon-user'></i>
                                                                                            Users </a>
                                                                                    </li>
                                                                                    <li class='active'>
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
    
    //Get My Reports.
    function GetMyReports($userId)
    {
        $reportModel = new ReportModel();
        $reportModel->GetMyReports($userId);
    }
    
    // Count My Reports.
    function CountMyReports($userId)
    {
        $reportModel = new ReportModel();
        $reportModel->CountMyReports($userId);
    }
    
    // View All Reports
    function ViewMyReportsContent()
    {
        $reportModel = new ReportModel();
        
        $report = $reportModel->GetMyReports($_SESSION['id']);
        $count = $reportModel->CountMyReports($_SESSION['id']);
        
        require_once 'Model/ReportTypeModel.php';
        $reportTypeModel = new ReportTypeModel();
        
        $result="<div class='panel-group col-md-12 col-xs-12'>
			  <div class='panel panel-default alert alert-info'>
					<div class='panel-heading' style='text-align:center;'>
					<a data-toggle='collapse' data-parent='#accordion' href='#collapseSearchResult' class='glyphicon glyphicon-hand-up'><strong>My Reports</strong></a>
					</div>
					<div id='collapseSearchResult' class='panel-collapse collapse in'>
						<div class='panel-body'>
                                                    <div class='row' style='margin:auto; width:100%; padding-top:10px;'>
							<input type='text' id='myjobInput' class='col-md-4' onkeyup='myJobTableFunction()' placeholder='Search for Jobs' title='Type in a job name' style='display: block; margin: auto;'>
                                                    </div>
                                                    <div class='table-responsive col-xs-12'>"
                                                        . "<table class='sortable table' id='myJobTable'>"
                                                        . "<tr style='text-align:center;'>"
                                                        . "     <th style='text-align:center;color:black;'>Description</th>"
                                                        . "     <th style='text-align:center;color:black;'>Type</th>"
                                                        . "     <th style='text-align:center;color:black;'>Date</th>"
                                                        . "     <th style='text-align:center;color:black;'>Status</th>"
                                                        . "</tr>";
                                                        try
                                                        {
                                                            if ($report != null)
                                                            {
                                                                foreach($report as $row)
                                                                {
                                                                    if($row->status == 1)
                                                                    {
                                                                        $type = $reportTypeModel->GetReportTypeById($row->type)->name;
                                                                        $result.= "<tr>"
                                                                                . "<td align='center' style='color:black;'>$row->description</td>"
                                                                                . "<td align='center' style='color:black;'>$type</td>"
                                                                                . "<td align='center' style='color:black;'>$row->date</td>"
                                                                                . "<td align='center'><p style='color:green;'>Open</p></td>"
                                                                                . "</tr>";
                                                                    }else if($row->status == 2)
                                                                    {
                                                                        $type = $reportTypeModel->GetReportTypeById($row->type)->name;
                                                                        $result.= "<tr>"
                                                                                . "<td align='center' style='color:black;'>$row->description</td>"
                                                                                . "<td align='center' style='color:black;'>$type</td>"
                                                                                . "<td align='center' style='color:black;'>$row->date</td>"
                                                                                . "<td align='center'><p style='color:blue;'>Closed</p></td>"
                                                                                . "</tr>";
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
                        . "<script>
				function myJobTableFunction() {
				  var input, filter, table, tr, td, i;
				  input = document.getElementById('myjobInput');
				  filter = input.value.toUpperCase();
				  table = document.getElementById('myJobTable');
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
    
    function limit_text($text, $limit) {
      if (str_word_count($text, 0) > $limit) {
          $words = str_word_count($text, 2);
          $pos = array_keys($words);
          $text = substr($text, 0, $pos[$limit]) . '...';
      }
      return $text;
    }
    
    // View All Reports
    function ViewAdminReportsContent()
    {
        $reportModel = new ReportModel();
        
        $report = $reportModel->GetReports();
        $count = $reportModel->CountReports();
        
        $year = $_SESSION['yearDate'];
        
        $systemFault = $reportModel->GetSumReportsByYear($year, 1);
        $userComplaint = $reportModel->GetSumReportsByYear($year, 2);
        $bugComplaint = $reportModel->GetSumReportsByYear($year, 3);
        $jobComplaint = $reportModel->GetSumReportsByYear($year, 4);
        $paymentComplaint = $reportModel->GetSumReportsByYear($year, 5);
        $others = $reportModel->GetSumReportsByYear($year, 7);
        
        require_once 'Model/UserModel.php';
        $userModel = new UserModel();
        
        require_once 'Model/ReportTypeModel.php';
        $reportTypeModel = new ReportTypeModel();
        
        $result="<div class='row'>
            <form action='' method = 'POST'>
              <fieldset>
                <div class='clearfix row col-md-5 col-md-offset-4 col-xs-offset-1'>
                  <input type='text' onKeyPress='return checkIt(event)' name = 'year' id='keyword' placeholder='Search By Year' required autofocus>
                  <button class='btn primary' name = 'searchAdminDashboard' type='submit'>Submit</button>
                </div>
              </fieldset>
            </form>
          </div>
          <script>
          function checkIt(evt) {
    evt = (evt) ? evt : window.event
    var charCode = (evt.which) ? evt.which : evt.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        status = 'This field accepts numbers only.'
        return false
    }
    status = ''
    return true
}
</script>"
                ."<div class='row'>"
                    . "<div class='panel-group col-md-12 col-sm-12 col-xs-12'>
			  <div class='panel panel-default alert alert-info'>
                                    <div class='panel-heading' style='text-align:center;'>
					<a data-toggle='collapse' data-parent='#accordion' href='#collapseusersummary' class='glyphicon glyphicon-hand-up'><strong>Summary</strong></a>
					</div>
					<div id='collapseusersummary' class='panel-collapse collapse in'>
						<div class='panel-body'>
                                                <div class='col-md-12 col-sm-12 col-xs-12'>
                                                    <div class='row'>
                                                    <p style='text-align:center;'><strong>Based on <font color='blue'>$count</font> Reports</strong></p>
                                                    </div>"       
                                                    . "<div class='row'>"
                                                        . "<div style='background-color:lightgreen;text-align:center;font-weight:bold;font-size:13px;color:blue;' class='col-sm-4 col-sm-offset-4 col-md-4 col-md-offset-4'>Year</div>"
                                                    ."</div>"
                                                    . "<div class='row'>"
                                                        . "<div style='margin-top:10px;;text-align:center;font-weight:bold;font-size:13px;color:blue;' class='col-sm-4 col-sm-offset-4 col-md-4 col-md-offset-4'>$_SESSION[yearDate]</div>"
                                                    ."</div>"
                                                    ."<div class='row'>"
                                                        ."<div id='reportsContainer' style='height: 300px; width: 100%;'>
                                                        </div>"
                                                    . "</div>"
						."</div>"
					."</div>"
				."</div>"
			."</div>"
                ."</div>"
                . "<script  type='text/javascript'>"
                ."systemFault = $systemFault;"
                ."userComplaint = $userComplaint;"
                ."bugComplaint = $bugComplaint;"
                ."jobComplaint = $jobComplaint;"        
                ."paymentComplaint = $paymentComplaint;"
                ."others = $others;"
                . " var d = new Date();
                    var n = d.getMonth();
                    if(n == 0)
                    {"
                        . "  window.onload = function () {
                            var chart = new CanvasJS.Chart('reportsContainer',
                            {
                                    title:{
                                            text: 'Reports',
                                            verticalAlign: 'top',
                                            horizontalAlign: 'left'
                                    },
                                    animationEnabled: true,
                                    data: [
                                    {        
                                            type: 'doughnut',
                                            startAngle:20,
                                            toolTipContent: '{label}: {y} - <strong>#percent%</strong>',
                                            indexLabel: '{label} #percent%',
                                            dataPoints: [
                                                    {  y: systemFault, label: 'System Fault' },
                                                    {  y: userComplaint, label: 'User Complaint' },
                                                    {  y: bugComplaint, label: 'Bug Complaint' },
                                                    {  y: jobComplaint,  label: 'Job Complaint'},
                                                    {  y: paymentComplaint,  label: 'Payment Complaint'},
                                                    {  y: others,  label: 'Others'}
                                            ]
                                    }
                                    ]
                            });
                            chart.render();
                                }
                     }else if(n == 1)
                     {
                                window.onload = function () {
                            var chart = new CanvasJS.Chart('reportsContainer',
                            {
                                    title:{
                                            text: 'Reports',
                                            verticalAlign: 'top',
                                            horizontalAlign: 'left'
                                    },
                                    animationEnabled: true,
                                    data: [
                                    {        
                                            type: 'doughnut',
                                            startAngle:20,
                                            toolTipContent: '{label}: {y} - <strong>#percent%</strong>',
                                            indexLabel: '{label} #percent%',
                                            dataPoints: [
                                                    {  y: systemFault, label: 'System Fault' },
                                                    {  y: userComplaint, label: 'User Complaint' },
                                                    {  y: bugComplaint, label: 'Bug Complaint' },
                                                    {  y: jobComplaint,  label: 'Job Complaint'},
                                                    {  y: paymentComplaint,  label: 'Payment Complaint'},
                                                    {  y: others,  label: 'Others'}
                                            ]
                                    }
                                    ]
                            });
                            chart.render();
                                }
                     }else if(n == 2)
                     {
                                window.onload = function () {
                            var chart = new CanvasJS.Chart('reportsContainer',
                            {
                                    title:{
                                            text: 'Reports',
                                            verticalAlign: 'top',
                                            horizontalAlign: 'left'
                                    },
                                    animationEnabled: true,
                                    data: [
                                    {        
                                            type: 'doughnut',
                                            startAngle:20,
                                            toolTipContent: '{label}: {y} - <strong>#percent%</strong>',
                                            indexLabel: '{label} #percent%',
                                            dataPoints: [
                                                    {  y: systemFault, label: 'System Fault' },
                                                    {  y: userComplaint, label: 'User Complaint' },
                                                    {  y: bugComplaint, label: 'Bug Complaint' },
                                                    {  y: jobComplaint,  label: 'Job Complaint'},
                                                    {  y: paymentComplaint,  label: 'Payment Complaint'},
                                                    {  y: others,  label: 'Others'}
                                            ]
                                    }
                                    ]
                            });
                            chart.render();
                                }
                     }else if(n == 3)
                     {
                                window.onload = function () {
                            var chart = new CanvasJS.Chart('reportsContainer',
                            {
                                    title:{
                                            text: 'Reports',
                                            verticalAlign: 'top',
                                            horizontalAlign: 'left'
                                    },
                                    animationEnabled: true,
                                    data: [
                                    {        
                                            type: 'doughnut',
                                            startAngle:20,
                                            toolTipContent: '{label}: {y} - <strong>#percent%</strong>',
                                            indexLabel: '{label} #percent%',
                                            dataPoints: [
                                                    {  y: systemFault, label: 'System Fault' },
                                                    {  y: userComplaint, label: 'User Complaint' },
                                                    {  y: bugComplaint, label: 'Bug Complaint' },
                                                    {  y: jobComplaint,  label: 'Job Complaint'},
                                                    {  y: paymentComplaint,  label: 'Payment Complaint'},
                                                    {  y: others,  label: 'Others'}
                                            ]
                                    }
                                    ]
                            });
                            chart.render();
                                }
                     }else if(n == 4)
                     {
                                window.onload = function () {
							var chart = new CanvasJS.Chart('reportsContainer',
                            {
                                    title:{
                                            text: 'Reports',
                                            verticalAlign: 'top',
                                            horizontalAlign: 'left'
                                    },
                                    animationEnabled: true,
                                    data: [
                                    {        
                                            type: 'doughnut',
                                            startAngle:20,
                                            toolTipContent: '{label}: {y} - <strong>#percent%</strong>',
                                            indexLabel: '{label} #percent%',
                                            dataPoints: [
                                                    {  y: systemFault, label: 'System Fault' },
                                                    {  y: userComplaint, label: 'User Complaint' },
                                                    {  y: bugComplaint, label: 'Bug Complaint' },
                                                    {  y: jobComplaint,  label: 'Job Complaint'},
                                                    {  y: paymentComplaint,  label: 'Payment Complaint'},
                                                    {  y: others,  label: 'Others'}
                                            ]
                                    }
                                    ]
                            });
                            chart.render();
                                }
                     }else if(n == 5)
                     {
                                window.onload = function () {
                            var chart = new CanvasJS.Chart('reportsContainer',
                            {
                                    title:{
                                            text: 'Reports',
                                            verticalAlign: 'top',
                                            horizontalAlign: 'left'
                                    },
                                    animationEnabled: true,
                                    data: [
                                    {        
                                            type: 'doughnut',
                                            startAngle:20,
                                            toolTipContent: '{label}: {y} - <strong>#percent%</strong>',
                                            indexLabel: '{label} #percent%',
                                            dataPoints: [
                                                    {  y: systemFault, label: 'System Fault' },
                                                    {  y: userComplaint, label: 'User Complaint' },
                                                    {  y: bugComplaint, label: 'Bug Complaint' },
                                                    {  y: jobComplaint,  label: 'Job Complaint'},
                                                    {  y: paymentComplaint,  label: 'Payment Complaint'},
                                                    {  y: others,  label: 'Others'}
                                            ]
                                    }
                                    ]
                            });
                            chart.render();
                                }
                     }else if (n == 6)
                     {
                                window.onload = function () {
                            var chart = new CanvasJS.Chart('reportsContainer',
                            {
                                    title:{
                                            text: 'Reports',
                                            verticalAlign: 'top',
                                            horizontalAlign: 'left'
                                    },
                                    animationEnabled: true,
                                    data: [
                                    {        
                                            type: 'doughnut',
                                            startAngle:20,
                                            toolTipContent: '{label}: {y} - <strong>#percent%</strong>',
                                            indexLabel: '{label} #percent%',
                                            dataPoints: [
                                                    {  y: systemFault, label: 'System Fault' },
                                                    {  y: userComplaint, label: 'User Complaint' },
                                                    {  y: bugComplaint, label: 'Bug Complaint' },
                                                    {  y: jobComplaint,  label: 'Job Complaint'},
                                                    {  y: paymentComplaint,  label: 'Payment Complaint'},
                                                    {  y: others,  label: 'Others'}
                                            ]
                                    }
                                    ]
                            });
                            chart.render();
                                }
                     }else if(n == 7)
                     {
                                window.onload = function () {
                            var chart = new CanvasJS.Chart('reportsContainer',
                            {
                                    title:{
                                            text: 'Reports',
                                            verticalAlign: 'top',
                                            horizontalAlign: 'left'
                                    },
                                    animationEnabled: true,
                                    data: [
                                    {        
                                            type: 'doughnut',
                                            startAngle:20,
                                            toolTipContent: '{label}: {y} - <strong>#percent%</strong>',
                                            indexLabel: '{label} #percent%',
                                            dataPoints: [
                                                    {  y: systemFault, label: 'System Fault' },
                                                    {  y: userComplaint, label: 'User Complaint' },
                                                    {  y: bugComplaint, label: 'Bug Complaint' },
                                                    {  y: jobComplaint,  label: 'Job Complaint'},
                                                    {  y: paymentComplaint,  label: 'Payment Complaint'},
                                                    {  y: others,  label: 'Others'}
                                            ]
                                    }
                                    ]
                            });
                            chart.render();
                                }
                     }else if(n == 8)
                     {
                                window.onload = function () {
						var chart = new CanvasJS.Chart('reportsContainer',
                            {
                                    title:{
                                            text: 'Reports',
                                            verticalAlign: 'top',
                                            horizontalAlign: 'left'
                                    },
                                    animationEnabled: true,
                                    data: [
                                    {        
                                            type: 'doughnut',
                                            startAngle:20,
                                            toolTipContent: '{label}: {y} - <strong>#percent%</strong>',
                                            indexLabel: '{label} #percent%',
                                            dataPoints: [
                                                    {  y: systemFault, label: 'System Fault' },
                                                    {  y: userComplaint, label: 'User Complaint' },
                                                    {  y: bugComplaint, label: 'Bug Complaint' },
                                                    {  y: jobComplaint,  label: 'Job Complaint'},
                                                    {  y: paymentComplaint,  label: 'Payment Complaint'},
                                                    {  y: others,  label: 'Others'}
                                            ]
                                    }
                                    ]
                            });
                            chart.render();
                                }
                     }else if(n == 9)
                     {
                                window.onload = function () {
							var chart = new CanvasJS.Chart('reportsContainer',
                            {
                                    title:{
                                            text: 'Reports',
                                            verticalAlign: 'top',
                                            horizontalAlign: 'left'
                                    },
                                    animationEnabled: true,
                                    data: [
                                    {        
                                            type: 'doughnut',
                                            startAngle:20,
                                            toolTipContent: '{label}: {y} - <strong>#percent%</strong>',
                                            indexLabel: '{label} #percent%',
                                            dataPoints: [
                                                    {  y: systemFault, label: 'System Fault' },
                                                    {  y: userComplaint, label: 'User Complaint' },
                                                    {  y: bugComplaint, label: 'Bug Complaint' },
                                                    {  y: jobComplaint,  label: 'Job Complaint'},
                                                    {  y: paymentComplaint,  label: 'Payment Complaint'},
                                                    {  y: others,  label: 'Others'}
                                            ]
                                    }
                                    ]
                            });
                            chart.render();
                                }
                     }else if(n == 10)
                     {
                                window.onload = function () {
                            var chart = new CanvasJS.Chart('reportsContainer',
                            {
                                    title:{
                                            text: 'Reports',
                                            verticalAlign: 'top',
                                            horizontalAlign: 'left'
                                    },
                                    animationEnabled: true,
                                    data: [
                                    {        
                                            type: 'doughnut',
                                            startAngle:20,
                                            toolTipContent: '{label}: {y} - <strong>#percent%</strong>',
                                            indexLabel: '{label} #percent%',
                                            dataPoints: [
                                                    {  y: systemFault, label: 'System Fault' },
                                                    {  y: userComplaint, label: 'User Complaint' },
                                                    {  y: bugComplaint, label: 'Bug Complaint' },
                                                    {  y: jobComplaint,  label: 'Job Complaint'},
                                                    {  y: paymentComplaint,  label: 'Payment Complaint'},
                                                    {  y: others,  label: 'Others'}
                                            ]
                                    }
                                    ]
                            });
                            chart.render();
                                }
                     }else if(n == 11)
                     {
                                window.onload = function () {
                            var chart = new CanvasJS.Chart('reportsContainer',
                            {
                                    title:{
                                            text: 'Reports',
                                            verticalAlign: 'top',
                                            horizontalAlign: 'left'
                                    },
                                    animationEnabled: true,
                                    data: [
                                    {        
                                            type: 'doughnut',
                                            startAngle:20,
                                            toolTipContent: '{label}: {y} - <strong>#percent%</strong>',
                                            indexLabel: '{label} #percent%',
                                            dataPoints: [
                                                    {  y: systemFault, label: 'System Fault' },
                                                    {  y: userComplaint, label: 'User Complaint' },
                                                    {  y: bugComplaint, label: 'Bug Complaint' },
                                                    {  y: jobComplaint,  label: 'Job Complaint'},
                                                    {  y: paymentComplaint,  label: 'Payment Complaint'},
                                                    {  y: others,  label: 'Others'}
                                            ]
                                    }
                                    ]
                            });
                            chart.render();
                                }
                     }"
                . "</script>"
                
                    ."<div class='row'>"
                           . "<div class='panel-group col-md-12 col-sm-12 col-xs-12'>
                                <div class='panel panel-default alert alert-info'>
                                            <div class='panel-heading' style='text-align:center;'>
                                                <a data-toggle='collapse' data-parent='#accordion' href='#collapseuserrating' class='glyphicon glyphicon-hand-up'><strong>Reviews</strong></a>
                                            </div>
                                            <div id='collapseuserrating' class='panel-collapse collapse in'>
                                                    <div class='panel-body'>
                                                <div class='table-responsive scrollit'>"
                                                . "<table class='table sortable col-xs-12'>"
                                                        . "<tr>"
                                                        . "     <th style='color:black;'>User</th>"
                                                        . "     <th style='color:black;'>Description</th>"
                                                        . "     <th style='color:black;'>Type</th>"
                                                        . "     <th style='color:black;'>Date</th>"
                                                        . "     <th style='color:black;'>Status</th>"
                                                        . "     <th style='color:black;'>Action</th>"
                                                        . "</tr>
                                                    <tr>";
                                                        try
                                                        {
                                                            if($report != null)
                                                            {
                                                                foreach($report as $row)
                                                                {
                                                                    $username = $userModel->GetUserById($row->userId)->username;
                                                                    $type = $reportTypeModel->GetReportTypeById($row->type)->name;
                                                                    
                                                                   if($row->status == 1)
                                                                   {
                                                                    $result.="<td><a href='ViewUserProfile.php?epr=view&id=".$row->userId."' target='_blank'>$username</a></td>
                                                                                    <td><p style='color:black;'>";$result.=$this->limit_text($row->description,2); $result.="</p></td>
                                                                                    <td><p style='color:black;'>$type</p></td>
                                                                                    <td><p style='color:black;'>$row->date</p></td>
                                                                                    <td><p>Open</p></td>
                                                                                    <td style='color:black;'><a href='#' a href='#' onclick='closeReport(".$row->id.")'>Close</a></td>
                                                                                    <td style='color:black;'><p class='glyphicon glyphicon-plus' style='text-align:center;'></p></td>
                                                                                    </tr>
                                                                                    <tr><td colspan='7'>                                                                                 
                                                                                    <h4 style='color:black;'>Description</h4>
                                                                                    <p style='color:black;'>$row->description</p>
                                                                                        
                                                                             </td>
                                                    </tr>"
                                                                                            . "</div>";
                                                                   }else if($row->status == 2)
                                                                   {
                                                                    $result.="<td><a href='ViewUserProfile.php?epr=view&id=".$row->userId."' target='_blank'>$username</a></td>
                                                                                    <td><p style='color:black;'>";$result.=$this->limit_text($row->description,2); $result.="</p></td>
                                                                                    <td><p style='color:black;'>$type</p></td>
                                                                                    <td><p style='color:black;'>$row->date</p></td>
                                                                                    <td><p>Closed</p></td>
                                                                                    <td style='color:black;'><a href='#' onclick='reopenReport(".$row->id.")'>Reopen</a></td>
                                                                                    <td style='color:black;'><p class='glyphicon glyphicon-plus' style='text-align:center;'></p></td>
                                                                                    </tr>
                                                                                    <tr><td colspan='7'>                                                                                 
                                                                                    <h4  style='color:black;'>Description</h4>
                                                                                    <p  style='color:black;'>$row->description</p>
                                                                                        
                                                                             </td>
                                                    </tr>"
                                                                                            . "</div>";
                                                                   }else if($row->status == 0)
                                                                   {
                                                                    $result.="<td><a href='ViewUserProfile.php?epr=view&id=".$row->userId."' target='_blank'>$username</a></td>
                                                                                    <td><p style='color:black;'>";$result.=$this->limit_text($row->description,2); $result.="</p></td>
                                                                                    <td><p style='color:black;'>$type</p></td>
                                                                                    <td><p style='color:black;'>$row->date</p></td>
                                                                                    <td><p style='color:black;'>Irrelevant</p></td>
                                                                                    <td style='color:black;'><p class='glyphicon glyphicon-plus' style='text-align:center;'></p></td>
                                                                                    </tr>
                                                                                    <td><p style='color:black;'>Irrelevant</p></td>
                                                                                    <tr><td colspan='7'>                                                                                 
                                                                                    <h4 style='color:black;'>Description</h4>
                                                                                    <p style='color:black;'>$row->description</p>
                                                                                        
                                                                             </td>
                                                    </tr>"
                                                                                            . "</div>";
                                                                   }
                                                                }
                                                            }
                                                        }catch(Exception $x)
                                                        {
                                                            echo 'Caught exception: ',  $x->getMessage(), "\n";
                                                        } 
                                                $result.="</table>
<script>
$(function() {
    $('td[colspan=7]').find('p').hide();
    $('td[colspan=7]').find('h4').hide();
    $('table').click(function(event) {
        event.stopPropagation();
        
        if ( $(event.target).closest('td').attr('colspan') > 1 ) {
            $(event.target).slideUp();
        } else {
            $(event.target).closest('tr').next().find('p').slideToggle();
            $(event.target).closest('tr').next().find('h4').slideToggle();
        }                    
    });
});</script>"
                                                    ."</div>"
                                            ."</div>"
                                    ."</div>"
                            ."</div>"
                . "</div>"
               . "</div>";
        
        return $result;
    }
    
    //Get Sum Of Reports By Type Id, Month and Year
    function GetSumReportsByMonthYear($month,$year,$typeId)
    {
        $reportModel = new ReportModel();
        return $reportModel->GetSumReportsByMonthYear($month, $year, $typeId);
    }
    
    //Get Sum Of Reports By Type Id and Year
    function GetSumReportsByYear($year,$typeId)
    {
       $reportModel = new ReportModel();
       return $reportModel->GetSumReportsByYear($year, $typeId);
    }
}
