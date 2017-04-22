<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of NotificationTypeController
 *
 * @author Jake Valino
 */

require 'Model/NotificationTypeModel.php';

class NotificationTypeController {

    // Insert A New Notification Type
    function InsertNotificationType()
    {
        $name = $_POST["name"];

        $notificationType = new NotificationTypeEntities(-1, $name);
        $notificationModel = new NotificationTypeModel();
        $notificationModel->InsertNotificationType($notificationType);
    }
    
    // Get Notification Type By Id
    function GetNotificationTypeById($typeId)
    {
        $notificationTypeModel = new NotificationTypeModel(); 
        return $notificationTypeModel->GetNotificationTypeById($typeId);
    }
    
    //Delete a notification type
    function deleteANotificationType($id)
    {
        $notificationTypeModel = new NotificationTypeModel(); 
        $notificationTypeModel->deleteANotificationType($id);
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
    
    // Get All Notification Types
    function GetAllNotificationTypes()
    {
        $notificationModel = new NotificationTypeModel();
        $notificationModel->GetAllNotificationTypes();
    }
    
    function AddDisplayNotificationTypeForm()
    {   
        $notificationModel = new NotificationTypeModel();
        
        $result = "<div class='row'>
            <div class='panel-group col-md-12 col-sm-12'>
			  <div class='panel panel-default'>
					<div class='panel-heading' style='text-align:center;'>
					<a data-toggle='collapse' data-parent='#accordion' href='#collapseSearchResult' class='glyphicon glyphicon-hand-up'><strong>Notification Type</strong></a>
					</div>
					<div id='collapseSearchResult' class='panel-collapse collapse in'>
						<div class='panel-body'>
                                                    <div class='row' style='margin:auto; width:100%; padding-top:10px;'>
							<input type='text' id='myCountyInput' class='col-md-4' onkeyup='myCountyTableFunction()' placeholder='Search for Notification Type' title='Type in a Notification Type' style='display: block; margin: auto;'>
                                                    </div>
                                                    <div class='table-responsive' id='countyTable'>"
                                                        . "<table class='table sortable'>"
                                                        . "<tr>"
                                                        . "     <th>Id</th>"
                                                        . "     <th>Name</th>"
                                                        . "     <th>Action</th>"
                                                        . "</tr>";
                                                        try
                                                        {
                                                            $notificationTypes = $notificationModel->GetAllNotificationTypes();
                                                            foreach($notificationTypes as $row)
                                                            {
                                                                $result.= "<tr>"
                                                                        . "<td>$row->id</td>"
                                                                        . "<td>$row->name</td>"
                                                                        . "<td>"
                                                                        . "     <a href='AddEditNotificationType.php?epr=delete&id=".$row->id."'>Delete</a>&nbsp|"
                                                                        . "     <a href='AddEditNotificationType.php?epr=update&id=".$row->id."'>Update</a>"
                                                                        . "</td>"
                                                                        . "</tr>";
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
                        . "</div>"
                        ."<div class='register-form'>
                        <div class='row'>
                          <h2 class='col-md-12 col-sm-12 col-xs-12' style='text-align:center;'>Add a new Notification Type</h2>
                        </div>
                        <form action='' method = 'POST'>
                          <fieldset>
                            <div class='clearfix'>
                              <label for='name' class='col-md-2 col-sm-2 col-xs-3'> Type Des: </label>
                              <input type='text' name = 'name' id='name' class='col-md-8 col-sm-8 col-xs-8' placeholder='Type Description' required autofocus>
                            </div>
                            <button class='btn primary col-xs-2 col-xs-offset-9 col-sm-2 col-sm-offset-8 col-md-2 col-md-offset-8' name = 'addNotificationType' type='submit'>Add</button>
                          </fieldset>
                        </form>
                      </div>"                     
                     . "<script>
				function myCountyTableFunction() {
				  var input, filter, table, tr, td, i;
				  input = document.getElementById('myCountyInput');
				  filter = input.value.toUpperCase();
				  table = document.getElementById('countyTable');
				  tr = table.getElementsByTagName('tr');
				  for (i = 0; i < tr.length; i++) {
					td = tr[i].getElementsByTagName('td')[1];
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
    
    // Update A Notification Type By Id
    function updateACountyById($id, $name)
    {
        $notificationModel = new NotificationTypeModel();
        $notificationModel->updateACountyById($id, $name);
    }
    
    function EditDisplayNotificationTypeForm($id)
    {   
        $notificationModel = new NotificationTypeModel();
        
        $typeName = $notificationModel->GetNotificationTypeById($id)->name;
        
        $result = "<div class='row'>
            <div class='panel-group col-md-12 col-sm-12'>
			  <div class='panel panel-default'>
					<div class='panel-heading' style='text-align:center;'>
					<a data-toggle='collapse' data-parent='#accordion' href='#collapseSearchResult' class='glyphicon glyphicon-hand-up'><strong>Notification Type</strong></a>
					</div>
					<div id='collapseSearchResult' class='panel-collapse collapse in'>
						<div class='panel-body'>
                                                    <div class='row' style='margin:auto; width:100%; padding-top:10px;'>
							<input type='text' id='myCountyInput' class='col-md-4' onkeyup='myCountyTableFunction()' placeholder='Search for Notification Type' title='Type in a Notification Type' style='display: block; margin: auto;'>
                                                    </div>
                                                    <div class='table-responsive' id='countyTable'>"
                                                        . "<table class='table sortable'>"
                                                        . "<tr>"
                                                        . "     <th>Id</th>"
                                                        . "     <th>Name</th>"
                                                        . "     <th>Action</th>"
                                                        . "</tr>";
                                                        try
                                                        {
                                                            
                                                            $notificationTypes = $notificationModel->GetNotificationTypeById($id);
                                                                $result.= "<tr>"
                                                                        . "<td>$notificationTypes->id/td>"
                                                                        . "<td>$notificationTypes->name</td>"
                                                                        . "<td>"
                                                                        . "     <a href='AddEditNotificationType.php?epr=delete&id=".$notificationTypes->id."'>Delete</a>&nbsp|"
                                                                        . "     <a href='AddEditNotificationType.php?epr=update&id=".$notificationTypes->id."'>Update</a>"
                                                                        . "</td>"
                                                                        . "</tr>";
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
                        . "</div>"
                        ."<div class='register-form'>
                        <div class='row'>
                          <h2 class='col-md-12 col-sm-12 col-xs-12' style='text-align:center;'>Add a new Notification Type</h2>
                        </div>
                        <form action='' method = 'POST'>
                          <fieldset>
                            <div class='clearfix'>
                              <label for='name' class='col-md-2 col-sm-2 col-xs-3'> Type Des: </label>
                              <input type='text' name = 'name' id='name' value='$typeName' class='col-md-8 col-sm-8 col-xs-8' placeholder='Type Description' required autofocus>
                            </div>
                            <button class='btn primary col-xs-2 col-xs-offset-9 col-sm-2 col-sm-offset-8 col-md-2 col-md-offset-8' name = 'updateNotificationType' type='submit'>Update</button>
                          </fieldset>
                        </form>
                      </div>"                     
                     . "<script>
				function myCountyTableFunction() {
				  var input, filter, table, tr, td, i;
				  input = document.getElementById('myCountyInput');
				  filter = input.value.toUpperCase();
				  table = document.getElementById('countyTable');
				  tr = table.getElementsByTagName('tr');
				  for (i = 0; i < tr.length; i++) {
					td = tr[i].getElementsByTagName('td')[1];
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
