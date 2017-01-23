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
    
    
    // Notification Content
    function NotificationContent()
    {
       $myNotification = $this->GetNotificationByToUsername($_SESSION['username']);
       $notificationTypeModel = new NotificationTypeModel();
       $jobModel = new JobModel();
       
       $result= '<div class="panel-group col-md-12">
			  <div class="panel panel-default">
					<div class="panel-heading" style="text-align:center;">
					<a data-toggle="collapse" data-parent="#accordion" href="#collapseMyNotification" class="glyphicon glyphicon-hand-up"><strong>Notification</strong></a>
					</div>
					<div id="collapseMyNotification" class="panel-collapse collapse in">
						<div class="panel-body">
                                                    <div class="table-responsive">
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
                                                                            $result.='<tr>
                                                                                <td style="color:blue;"><strong>'; $result.= '<a href="google.ie">'. $row->fromusername;$result.='</strong></a> &nbsp &nbsp &nbsp &nbsp'; $result.='</td>
                                                                                <td style="color:blue;">'; $result.= $notificationTypeModel->GetNotificationTypeById($row->typeId)->name;  $result.='</td>
                                                                                <td style="color:blue;">'; $result.= '<a href="viewJob.php?epr=view&jobid='.$row->jobid.'">'. $jobModel->GetJobsByID($row->jobid)->name; $result.='</a></td>
                                                                                <td style="color:blue;">'; $result.=$row->dateofnotification; $result.='</td>
                                                                                <td style="color:blue;"> No </td>
                                                                            </tr>';
                                                                        }else if($row->seen == 1)
                                                                        {
                                                                            $result.='<tr>
                                                                                <td style="color:blue;"><strong>'; $result.= '<a href="google.ie">'. $row->fromusername;$result.='</strong></a> &nbsp &nbsp &nbsp &nbsp'; $result.='</td>
                                                                                <td style="color:blue;">'; $result.= $notificationTypeModel->GetNotificationTypeById($row->typeId)->name;  $result.='</td>
                                                                                <td style="color:blue;">'; $result.= '<a href="viewJob.php?epr=view&jobid='.$row->jobid.'">'. $jobModel->GetJobsByID($row->jobid)->name; $result.='</a></td>
                                                                                <td style="color:blue;">'; $result.=$row->dateofnotification; $result.='</td>
                                                                                <td style="color:blue;"> Yes </td>
                                                                            </tr>';
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
    
    // Messenger Side Bar
    function CreateNotificationSideBar()
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
