<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SignInController
 *
 * @author Jake Valino
 */

require 'Model/SignInModel.php';

class SignInController {
    
    //Insert a user sign in
    function InsertAUserSignIn($userId,$jobId,$date,$latest)
    {
        $signInModel = new SignInModel();
        $signInModel->InsertAUserSignIn($userId, $jobId, $date, $latest);
    }
    
    //Get All Sign In Records by jobId.
    function GetAllSignInRecordsByJobId($jobId)
    {
        $signInModel = new SignInModel();
        return $signInModel->GetAllSignInRecordsByJobId($jobId);
    }
    
    //Get Sign In Records by userId And jobId.
    function GetSignInRecordsByUserIdAndJobId($userId,$jobId)
    {
       $signInModel = new SignInModel();
       return $signInModel->GetSignInRecordsByUserIdAndJobId($userId, $jobId);
    }
    
    // Count Attendance To A Job
    function CountAttendanceToAJob($userId,$jobId)
    {
        $signInModel = new SignInModel();
        $signInModel->CountAttendanceToAJob($userId, $jobId);
    }
    
    //Update latest status
    function updateLatestStatus($latest,$userId,$jobId)
    {
        $signInModel = new SignInModel();
        $signInModel->updateLatestStatus($latest, $userId, $jobId);
    }
    
    function CreateAdminJobSideBar()
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
                                                                                    <li class='active'>
                                                                                            <a href='JobAdmin.php' style='text-align:center;'>
                                                                                            <i class='glyphicon glyphicon-wrench'></i>
                                                                                            Job </a>
                                                                                    </li>
                                                                                    <li>
                                                                                            <a href='#' data-toggle='modal' data-target='#myModal' style='text-align:center;'>
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
    
    //Get All Sign In.
    function GetAllSignIn()
    {
       $signInModel = new SignInModel();
       return $signInModel->GetAllSignIn();
    }
    
    // User Job Attendance
    function UserJobAttendance()
    {
        $signInModel = new SignInModel();
        
        $search = $signInModel->GetAllSignIn();
        
        require_once 'Model/JobModel.php';
        $jobModel = new JobModel();
        
        require_once 'Model/UserModel.php';
        $userModel = new UserModel();
        
        require_once 'Model/PlacedOffersModel.php';
        $placedOffersModel = new PlacedOffersModel();
        
        $result = "<div class='row'>"
                . "<div class='panel-group col-md-12'>
			  <div class='panel panel-default'>
					<div class='panel-heading' style='text-align:center;'>
					<a data-toggle='collapse' data-parent='#accordion' href='#collapseListPlacedOffers' class='glyphicon glyphicon-hand-up'><strong>Job Attendance</strong></a>
					</div>
					<div id='collapseListPlacedOffers' class='panel-collapse collapse in'>
						<div class='panel-body'>
                                                    <div class='row' style='margin:auto; width:100%; padding-top:10px;'>
							<input type='text' id='myInput' class='col-md-4' onkeyup='placedOfferTableFunction()' placeholder='Search for Users' title='Type in a User' style='display: block; margin: auto;'>
                                                    </div>"
                                                        . "<table class='table sortable' id='placedOffersTable'>"
                                                        . "<tr>"
                                                        . "     <th style='text-align:center;'>User</th>" 
                                                        . "     <th style='text-align:center;'>Job</th>"
                                                        . "     <th style='text-align:center;'>Date</th>"
                                                        . "     <th style='text-align:center;'>Latest</th>"
                                                        . "     <th style='text-align:center;'>Wage</th>"
                                                        . "</tr>";
                                                        try
                                                        {
                                                            if($search != null)
                                                            {
                                                                foreach($search as $row)
                                                                {
                                                                    $bidRate = $placedOffersModel->GetPlacedOffersByJobIdAndUserId($row->jobId, $row->userId);
                                                                    $result.= "<tr>"
                                                                            . "<td align='center'><a href='ViewUserProfile.php?epr=view&id=".$userModel->GetUserById($row->userId)->id."'>".$userModel->GetUserById($row->userId)->username."</a></td>"
                                                                            . "<td align='center'><a href='#'>".$jobModel->GetJobsByID($row->jobId)->name."</a></td>"
                                                                            . "<td align='center'>$row->date</td>";
                                                                            if($row->latest == 1)
                                                                            {
                                                                                $result.= "<td align='center'>True</td>";
                                                                            }else if($row->latest == 0)
                                                                            {
                                                                                $result.= "<td align='center'>False</td>";
                                                                            }
                                                                            $result.= "<td align='center'>$bidRate->offerPrice</td>";
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
