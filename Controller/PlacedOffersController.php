<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PlacedOffersController
 *
 * @author Jake Valino
 */
require 'Model/PlacedOffersModel.php';
require 'Model/NotificationModel.php';

class PlacedOffersController {

    // Place An Offer To A Job
    function PlaceAnOffer($jobId, $userId, $comment, $date, $offerPrice,$fromusername,$tousername,$bidType,$numberOfDays,$prefferedCommenceDate)
    {
        $placedOffersModel = new PlacedOffersModel();
        $placedOffersModel->PlaceAnOffer($jobId, $userId, $comment, $date, $offerPrice,$bidType,$numberOfDays,$prefferedCommenceDate);
        
        $notificationModel = new NotificationModel();
        $notificationModel->InsertNotification($fromusername, $tousername, 2, 0, $date,$jobId);
    }
    
    //Update an offer
    function updateAnOffer($jobid,$userId,$newDate,$offerPrice,$comment,$fromusername,$tousername,$numberOfDays,$prefferedCommenceDate)
    {
        $placedOffersModel = new PlacedOffersModel();
        $placedOffersModel->updateAnOffer($jobid, $userId, $newDate, $offerPrice, $comment, $numberOfDays, $prefferedCommenceDate);
        
        //Today's date
        $date = new DateTime();
        $dateTime = $date->format('Y-m-d H:i:s');
        
        $notificationModel = new NotificationModel();
        $notificationModel->InsertNotification($fromusername, $tousername, 5, 0, $dateTime,$jobid);
    }
    
    //Update seen
    function updateSeen($seen,$jobid,$userId)
    {
        $placedOffersModel = new PlacedOffersModel();
        $placedOffersModel->updateSeen($seen, $jobid, $userId);
    }
    
    //Update Bid Status
    function updateBidStatus($status,$jobid,$userId)
    {
        $placedOffersModel = new PlacedOffersModel();
        $placedOffersModel->updateBidStatus($status, $jobid, $userId); 
    }
    
    // Get The Lowest Placed Offers Price in a specific job
    function GetLowestPlacedOffersByJobId($jobid)
    {
        $placedOffersModel = new PlacedOffersModel();
        return $placedOffersModel->GetLowestPlacedOffersByJobId($jobid);
    }
    
    // Get All Placed Offers By UserID
    function GetAllPlacedOffersByUserID($UserID)
    {
        $placedOffersModel = new PlacedOffersModel();
        return $placedOffersModel->GetAllPlacedOffersByUserID($UserID);
    }
    
    // Get All Placed Offers By UserID
    function GetAllPlacedOffersToUsersJob($id)
    {
        $placedOffersModel = new PlacedOffersModel();
        return $placedOffersModel->GetAllPlacedOffersToUsersJob($id);
    }
    
    // Get All Placed Offers in a specific job
    function GetAllPlacedOffers()
    {
        $placedOffersModel = new PlacedOffersModel();
        return $placedOffersModel->GetAllPlacedOffers();
    }
    
    // Get All Accepted Placed Offers By UserID
    function GetAllAcceptedPlacedOffersByUserID($UserID)
    {
        $placedOffersModel = new PlacedOffersModel();
        return $placedOffersModel->GetAllAcceptedPlacedOffersByUserID($UserID);
    }
    
    // Get All Placed Offers by other users I accepted
    function GetAllPlacedOffersIAccepted($userId)
    {
        $placedOffersModel = new PlacedOffersModel();
        $placedOffersModel->GetAllPlacedOffersIAccepted($userId);
    }
    
    // Get Users Placed Offers
    function GetUsersPlacedOffer($jobid,$userId)
    {
        $placedOffersModel = new PlacedOffersModel();
        return $placedOffersModel->GetUsersPlacedOffer($jobid, $userId);
    }
    
    // Get All User Placed Offers in a specific job by a specific person and return a boolean value
    function GetUserlacedOffersByJobIdAndUserId($jobid,$userId)
    {
        $placedOffersModel = new PlacedOffersModel();
        return $placedOffersModel->GetUserlacedOffersByJobIdAndUserId($jobid, $userId);
    }
    
    // Get All Placed Offers By jobId
    function GetAllPlacedOffersByJobID($jobId)
    {
        $placedOffersModel = new PlacedOffersModel();
        return $placedOffersModel->GetAllPlacedOffersByJobID($jobId);
    }
    
    // Get All Placed In User Profile Offers in a specific job
    function CountViewUserJobNoPlacedOffersByJobId($jobid)
    {
        $placedOffersModel = new PlacedOffersModel();
        return $placedOffersModel->CountViewUserJobNoPlacedOffersByJobId($jobid);
    }
    
    //Delete an Offer
    function deleteAnOffer($jobid,$userId)
    {
        $placedOffersModel = new PlacedOffersModel();
        $placedOffersModel->deleteAnOffer($jobid, $userId);
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
    
    // Search All Placed Offers
    function AdminAllPlacedOffes()
    {
        $placedOffersModel = new PlacedOffersModel();
        
        $search = $placedOffersModel->GetAllPlacedOffers();
        
        require_once 'Model/JobModel.php';
        $jobModel = new JobModel();
        
        require_once 'Model/UserModel.php';
        $userModel = new UserModel();
        $result = "<div class='row'>"
                . "<div class='panel-group col-md-12'>
			  <div class='panel panel-default'>
					<div class='panel-heading' style='text-align:center;'>
					<a data-toggle='collapse' data-parent='#accordion' href='#collapseListPlacedOffers' class='glyphicon glyphicon-hand-up'><strong>List Of Offers</strong></a>
					</div>
					<div id='collapseListPlacedOffers' class='panel-collapse collapse in'>
						<div class='panel-body'>
                                                    <div class='row' style='margin:auto; width:100%; padding-top:10px;'>
							<input type='text' id='myInput' class='col-md-4' onkeyup='placedOfferTableFunction()' placeholder='Search for Jobs' title='Type in a job name' style='display: block; margin: auto;'>
                                                    </div>"
                                                        . "<table class='table sortable' id='placedOffersTable'>"
                                                        . "<tr>"
                                                        . "     <th style='text-align:center;'>Job</th>"
                                                        . "     <th style='text-align:center;'>User</th>" 
                                                        . "     <th style='text-align:center;'>Comment</th>"
                                                        . "     <th style='text-align:center;'>No. Of Days</th>"
                                                        . "     <th style='text-align:center;'>Preferred Commence Date</th>"
                                                        . "     <th style='text-align:center;'>Date</th>"
                                                        . "     <th style='text-align:center;'>Offer Price</th>"
                                                        . "     <th style='text-align:center;'>Seen</th>"
                                                        . "     <th style='text-align:center;'>Bid Type:</th>"
                                                        . "     <th style='text-align:center;'>Bid Status:</th>"
                                                        . "</tr>";
                                                        try
                                                        {
                                                            if($search != null)
                                                            {
                                                                foreach($search as $row)
                                                                {
                                                                    $bidType = $row->bidType;
                                                                    $job = $jobModel->GetJobsByID($row->jobid);
                                                                    $result.= "<tr>"
                                                                            . "<td align='center'><a href='#'>".$jobModel->GetJobsByID($row->jobid)->name."</a></td>"
                                                                            . "<td align='center'><a href='ViewUserProfile.php?epr=view&id=".$userModel->GetUserById($row->userID)->id."'>".$userModel->GetUserById($row->userID)->username."</a></td>"
                                                                            . "<td align='center'>$row->comment</td>"
                                                                            . "<td align='center'>$row->numberOfDays</td>"
                                                                            . "<td align='center'>$row->prefferedCommenceDate</td>"
                                                                            . "<td align='center'>$row->placementDate</td>"
                                                                            . "<td align='center'>$row->offerPrice</td>"
                                                                            . "<td align='center'>$row->seen</td>";
                                                                            if($bidType == 1)
                                                                            {
                                                                                $result.= "<td align='center'>Part Time</td>";
                                                                            }else if($bidType == 0)
                                                                            {
                                                                                $result.= "<td align='center'>Full Time</td>";
                                                                            }
                                                                            if($row->bidStatus == NULL)
                                                                            {
                                                                                $result.="<td align='center'>?</td>"
                                                                                        . "</tr>";
                                                                            }else if($row->bidStatus == 1)
                                                                            {
                                                                                 $result.="<td align='center'>Accepted</td>"
                                                                                        . "</tr>";
                                                                            }else
                                                                            {
                                                                                 $result.="<td align='center'>Denied</td>"
                                                                                        . "</tr>";
                                                                            }
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
    
    // Get All Accepted Placed Offers By UserID
    function GetAllAcceptedPlacedOffers()
    {
        $placedOffersModel = new PlacedOffersModel();
        $placedOffersModel->GetAllAcceptedPlacedOffers();
    }
    
    // Search All Accepted Placed Offers
    function AdminAllAcceptedPlacedOffes()
    {
        $placedOffersModel = new PlacedOffersModel();
        
        $search = $placedOffersModel->GetAllAcceptedPlacedOffers();
        
        require_once 'Model/JobModel.php';
        $jobModel = new JobModel();
        
        require_once 'Model/UserModel.php';
        $userModel = new UserModel();
        $result = "<div class='row'>"
                . "<div class='panel-group col-md-12'>
			  <div class='panel panel-default'>
					<div class='panel-heading' style='text-align:center;'>
					<a data-toggle='collapse' data-parent='#accordion' href='#collapseListPlacedOffers' class='glyphicon glyphicon-hand-up'><strong>List Of Offers</strong></a>
					</div>
					<div id='collapseListPlacedOffers' class='panel-collapse collapse in'>
						<div class='panel-body'>
                                                    <div class='row' style='margin:auto; width:100%; padding-top:10px;'>
							<input type='text' id='myInput' class='col-md-4' onkeyup='placedOfferTableFunction()' placeholder='Search for Jobs' title='Type in a job name' style='display: block; margin: auto;'>
                                                    </div>"
                                                        . "<table class='table sortable' id='placedOffersTable'>"
                                                        . "<tr>"
                                                        . "     <th style='text-align:center;'>Job</th>"
                                                        . "     <th style='text-align:center;'>User</th>" 
                                                        . "     <th style='text-align:center;'>Comment</th>"
                                                        . "     <th style='text-align:center;'>No. Of Days</th>"
                                                        . "     <th style='text-align:center;'>Preferred Commence Date</th>"
                                                        . "     <th style='text-align:center;'>Date</th>"
                                                        . "     <th style='text-align:center;'>Offer Price</th>"
                                                        . "     <th style='text-align:center;'>Seen</th>"
                                                        . "     <th style='text-align:center;'>Bid Type:</th>"
                                                        . "     <th style='text-align:center;'>Bid Status:</th>"
                                                        . "</tr>";
                                                        try
                                                        {
                                                            if($search != null)
                                                            {
                                                                foreach($search as $row)
                                                                {
                                                                    $bidType = $row->bidType;
                                                                    $job = $jobModel->GetJobsByID($row->jobid);
                                                                    $result.= "<tr>"
                                                                            . "<td align='center'><a href='#'>".$jobModel->GetJobsByID($row->jobid)->name."</a></td>"
                                                                            . "<td align='center'><a href='ViewUserProfile.php?epr=view&id=".$userModel->GetUserById($row->userID)->id."'>".$userModel->GetUserById($row->userID)->username."</a></td>"
                                                                            . "<td align='center'>$row->comment</td>"
                                                                            . "<td align='center'>$row->numberOfDays</td>"
                                                                            . "<td align='center'>$row->prefferedCommenceDate</td>"
                                                                            . "<td align='center'>$row->placementDate</td>"
                                                                            . "<td align='center'>$row->offerPrice</td>"
                                                                            . "<td align='center'>$row->seen</td>";
                                                                            if($bidType == 1)
                                                                            {
                                                                                $result.= "<td align='center'>Part Time</td>";
                                                                            }else if($bidType == 0)
                                                                            {
                                                                                $result.= "<td align='center'>Full Time</td>";
                                                                            }
                                                                            if($row->bidStatus == NULL)
                                                                            {
                                                                                $result.="<td align='center'>?</td>"
                                                                                        . "</tr>";
                                                                            }else if($row->bidStatus == 1)
                                                                            {
                                                                                 $result.="<td align='center'>Accepted</td>"
                                                                                        . "</tr>";
                                                                            }else
                                                                            {
                                                                                 $result.="<td align='center'>Denied</td>"
                                                                                        . "</tr>";
                                                                            }
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
    
    // Get All Denied Placed Offers By UserID
    function GetAllDeniedPlacedOffers()
    {
        $placedOffersModel = new PlacedOffersModel();
        $placedOffersModel->GetAllDeniedPlacedOffers();
    }
    
    // Search All Denied Placed Offers
    function AdminAllDeniedPlacedOffes()
    {
        $placedOffersModel = new PlacedOffersModel();
        
        $search = $placedOffersModel->GetAllDeniedPlacedOffers();
        
        require_once 'Model/JobModel.php';
        $jobModel = new JobModel();
        
        require_once 'Model/UserModel.php';
        $userModel = new UserModel();
        $result = "<div class='row'>"
                . "<div class='panel-group col-md-12'>
			  <div class='panel panel-default'>
					<div class='panel-heading' style='text-align:center;'>
					<a data-toggle='collapse' data-parent='#accordion' href='#collapseListPlacedOffers' class='glyphicon glyphicon-hand-up'><strong>List Of Offers</strong></a>
					</div>
					<div id='collapseListPlacedOffers' class='panel-collapse collapse in'>
						<div class='panel-body'>
                                                    <div class='row' style='margin:auto; width:100%; padding-top:10px;'>
							<input type='text' id='myInput' class='col-md-4' onkeyup='placedOfferTableFunction()' placeholder='Search for Jobs' title='Type in a job name' style='display: block; margin: auto;'>
                                                    </div>"
                                                        . "<table class='table sortable' id='placedOffersTable'>"
                                                        . "<tr>"
                                                        . "     <th style='text-align:center;'>Job</th>"
                                                        . "     <th style='text-align:center;'>User</th>" 
                                                        . "     <th style='text-align:center;'>Comment</th>"
                                                        . "     <th style='text-align:center;'>No. Of Days</th>"
                                                        . "     <th style='text-align:center;'>Preferred Commence Date</th>"
                                                        . "     <th style='text-align:center;'>Date</th>"
                                                        . "     <th style='text-align:center;'>Offer Price</th>"
                                                        . "     <th style='text-align:center;'>Seen</th>"
                                                        . "     <th style='text-align:center;'>Bid Type:</th>"
                                                        . "     <th style='text-align:center;'>Bid Status:</th>"
                                                        . "</tr>";
                                                        try
                                                        {
                                                            if($search != null)
                                                            {
                                                                foreach($search as $row)
                                                                {
                                                                    $bidType = $row->bidType;
                                                                    $job = $jobModel->GetJobsByID($row->jobid);
                                                                    $result.= "<tr>"
                                                                            . "<td align='center'><a href='#'>".$jobModel->GetJobsByID($row->jobid)->name."</a></td>"
                                                                            . "<td align='center'><a href='ViewUserProfile.php?epr=view&id=".$userModel->GetUserById($row->userID)->id."'>".$userModel->GetUserById($row->userID)->username."</a></td>"
                                                                            . "<td align='center'>$row->comment</td>"
                                                                            . "<td align='center'>$row->numberOfDays</td>"
                                                                            . "<td align='center'>$row->prefferedCommenceDate</td>"
                                                                            . "<td align='center'>$row->placementDate</td>"
                                                                            . "<td align='center'>$row->offerPrice</td>"
                                                                            . "<td align='center'>$row->seen</td>";
                                                                            if($bidType == 1)
                                                                            {
                                                                                $result.= "<td align='center'>Part Time</td>";
                                                                            }else if($bidType == 0)
                                                                            {
                                                                                $result.= "<td align='center'>Full Time</td>";
                                                                            }
                                                                            if($row->bidStatus == NULL)
                                                                            {
                                                                                $result.="<td align='center'>?</td>"
                                                                                        . "</tr>";
                                                                            }else if($row->bidStatus == 1)
                                                                            {
                                                                                 $result.="<td align='center'>Accepted</td>"
                                                                                        . "</tr>";
                                                                            }else
                                                                            {
                                                                                 $result.="<td align='center'>Denied</td>"
                                                                                        . "</tr>";
                                                                            }
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
