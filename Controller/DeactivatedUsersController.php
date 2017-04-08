<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DeactivatedUsersController
 *
 * @author Jake Valino
 */
require ("Model/DeactivatedUsersModel.php");
class DeactivatedUsersController {
    
    // Insert A De-Activated Job
    function InsertANewDeactivatedUser($userId,$reason,$date)
    {
        $deactivatedUsersModel = new DeactivatedUsersModel();
        $deactivatedUsersModel->InsertANewDeactivatedUser($userId, $reason, $date);
    }
    
    // Get All The Deactivated Users
    function GetAllDeactivatedUsers()
    {
        $deactivatedUsersModel = new DeactivatedUsersModel();
        return $deactivatedUsersModel->GetAllDeactivatedUsers();
    }
    
    // Get All The Deactivated Users by UserId
    function GetAllDeactivatedUsersByUserId($userId)
    {
        $deactivatedUsersModel = new DeactivatedUsersModel();
        return $deactivatedUsersModel->GetAllDeactivatedUsersByUserId($userId);
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
                                                                                            <a href='ViewAdminReports.php' style='text-align:center;'>
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
    
    function DeactivateUserForm()
    {
        $re= "<div class='row'>
            <div class='insertJob-form col-md-6 col-md-offset-3'>
          <div class='row'>
            <h2 class='col-md-12 col-sm-12 col-xs-12' style='text-align:center;color:blue;'>User De-Activation</h2>
          </div>
          <form action='' method = 'POST'>
            <fieldset>
              <div class='clearfix'>
              <label for='reason' class='col-md-4 col-sm-2 col-xs-3'> Reason: </label>
                <textarea name = 'reason' style='height:150px;' id='reason' class='col-md-12 col-sm-10 col-xs-9' placeholder='Reason For User Deactivation' required autofocus></textarea>
              </div>
              <div class='row'>
              <button class='btn primary col-sm-2 col-sm-offset-9 col-xs-offset-9 col-md-3 col-md-offset-8' name = 'submitUserDeactivation' type='submit'>Submit</button>
              </div>
            </fieldset>
          </form>
        </div>
      </div>";
                
       return $re;
    }
    
    // View PayPalMe Accounts
    function ViewDeactivatedUserReasons()
    {
        $deactivatedUsersModel = new DeactivatedUsersModel();
        
        $search = $deactivatedUsersModel->GetAllDeactivatedUsers();
        
        require_once 'Model/UserModel.php';
        $userModel = new UserModel();
        
        $result = "<div class='row'>"
                . "<div class='panel-group col-md-12'>
			  <div class='panel panel-default'>
					<div class='panel-heading' style='text-align:center;'>
					<a data-toggle='collapse' data-parent='#accordion' href='#collapseListPlacedOffers' class='glyphicon glyphicon-hand-up'><strong>Deactivation Reason</strong></a>
					</div>
					<div id='collapseListPlacedOffers' class='panel-collapse collapse in'>
						<div class='panel-body'>
                                                    <div class='row' style='margin:auto; width:100%; padding-top:10px;'>
							<input type='text' id='myInput' class='col-md-4' onkeyup='placedOfferTableFunction()' placeholder='Search for Users' title='Type in a user' style='display: block; margin: auto;'>
                                                    </div>"
                                                        . "<table class='table sortable' id='placedOffersTable'>"
                                                        . "<tr>"
                                                        . "     <th style='text-align:center;'>User</th>"
                                                        . "     <th style='text-align:center;'>Reason</th>"
                                                        . "     <th style='text-align:center;'>Date</th>" 
                                                        . "</tr>";
                                                        try
                                                        {
                                                            if($search != null)
                                                            {
                                                                foreach($search as $row)
                                                                {
                                                                    $user = $userModel->GetUserById($row->userId);
                                                                    $result.= "<tr>"
                                                                            . "<td align='center'><a href='ViewUserProfile.php?epr=view&id=".$row->userId."'>$user->firstName $user->lastName</a></td>"
                                                                            ."<td align='center'>$row->reason</td>"
                                                                            ."<td align='center'>$row->date</td>";
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
