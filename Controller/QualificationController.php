<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of QualificationController
 *
 * @author Jake Valino
 */
require 'Model/QualificationModel.php';

class QualificationController {
    //put your code here
    
    function AddDisplayQualificationForm()
    {
        $qualificationName = '';
        $description = '';
        
        $qualificationModel = new QualificationModel();
        $result = "<div class='row'>
            <div class='panel-group col-md-12'>
			  <div class='panel panel-default'>
					<div class='panel-heading' style='text-align:center;'>
					<a data-toggle='collapse' data-parent='#accordion' href='#collapseSearchResult' class='glyphicon glyphicon-hand-up'><strong>Qualification</strong></a>
					</div>
					<div id='collapseSearchResult' class='panel-collapse collapse in'>
						<div class='panel-body'>
                                                    <div class='row' style='margin:auto; width:100%; padding-top:10px;'>
							<input type='text' id='myQualificationInput' class='col-md-4' onkeyup='myQualificationTableFunction()' placeholder='Search for Qualification' title='Type in a qualification name' style='display: block; margin: auto;'>
                                                    </div>
                                                    <div class='table-responsive' id='qualificationTable'>"
                                                        . "<table class='table sortable'>"
                                                        . "<tr>"
                                                        . "     <th>Id</th>"
                                                        . "     <th>Name</th>"
                                                        . "     <th>Description</th>"
                                                        . "     <th>Actions</th>"
                                                        . "</tr>";
                                                        try
                                                        {
                                                            $qualification = $qualificationModel->GetQualifications();
                                                            foreach($qualification as $row)
                                                            {
                                                                $result.= "<tr>"
                                                                        . "<td>$row->qualificationId</td>"
                                                                        . "<td>$row->qualificationName</td>"
                                                                        . "<td>$row->description</td>"
                                                                        . "<td>"
                                                                        . "     <a href='AddEditQualification.php?epr=delete&id=".$row->qualificationId."'>Delete</a>&nbsp|"
                                                                        . "     <a href='AddEditQualification.php?epr=update&id=".$row->qualificationId."'>Update</a>"
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
                          <h2 class='col-md-12' style='text-align:center;'>Add a new Qualification</h2>
                        </div>
                        <form action='' method = 'POST'>
                          <fieldset>
                            <div class='clearfix'>
                              <label for='qualificationName' class='col-md-2'> Name: </label>
                              <input type='text' name = 'qualificationName' id='qualificationName' value='$qualificationName' class='col-md-8' placeholder='Qualification Name' required autofocus>
                            </div>
                            <div class='clearfix'>
                              <label for='description' class='col-md-2'> Description: </label>
                              <textarea class='col-md-8' rows='5' id='description' name = 'description' value='$description' placeholder='Description' required autofocus></textarea>
                            </div>
                            <button class='btn primary col-md-2 col-md-offset-8' name = 'addQualification' type='submit'>Add</button>
                          </fieldset>
                        </form>
                      </div>"                     
                     . "<script>
				function myQualificationTableFunction() {
				  var input, filter, table, tr, td, i;
				  input = document.getElementById('myQualificationInput');
				  filter = input.value.toUpperCase();
				  table = document.getElementById('qualificationTable');
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
    
    function EditQualificationForm($id)
    {
        $qualificationModel = new QualificationModel();
        $qualificationName = $qualificationModel->GetQualificationByID($id)->qualificationName;
        $description = $qualificationModel->GetQualificationByID($id)->description;
        
        $result = "<div class='row'>
            <div class='panel-group col-md-12'>
			  <div class='panel panel-default'>
					<div class='panel-heading' style='text-align:center;'>
					<a data-toggle='collapse' data-parent='#accordion' href='#collapseSearchResult' class='glyphicon glyphicon-hand-up'><strong>Qualification</strong></a>
					</div>
					<div id='collapseSearchResult' class='panel-collapse collapse in'>
						<div class='panel-body'>
                                                    <div class='row' style='margin:auto; width:100%; padding-top:10px;'>
							<input type='text' id='myQualificationInput' class='col-md-4' onkeyup='myQualificationTableFunction()' placeholder='Search for Qualification' title='Type in a qualification name' style='display: block; margin: auto;'>
                                                    </div>
                                                    <div class='table-responsive'>"
                                                        . "<table class='table' id='qualificationTable'>"
                                                        . "<tr>"
                                                        . "     <th>Id</th>"
                                                        . "     <th>Name</th>"
                                                        . "     <th>Description</th>"
                                                        . "     <th>Actions</th>"
                                                        . "</tr>";
                                                        try
                                                        {
                                                            $qualification = $qualificationModel->GetQualifications();
                                                            foreach($qualification as $row)
                                                            {
                                                                $result.= "<tr>"
                                                                        . "<td>$row->qualificationId</td>"
                                                                        . "<td>$row->qualificationName</td>"
                                                                        . "<td>$row->description</td>"
                                                                        . "<td>"
                                                                        . "     <a href='AddEditQualification.php?epr=delete&id=".$row->qualificationId."'>Delete</a>&nbsp|"
                                                                        . "     <a href='AddEditQualification.php?epr=update&id=".$row->qualificationId."'>Update</a>"
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
                          <h2 class='col-md-12' style='text-align:center;'>Update Qualification</h2>
                        </div>
                        <form action='' method = 'POST'>
                          <fieldset>
                            <div class='clearfix'>
                              <label for='qualificationName' class='col-md-2'> Name: </label>
                              <input type='text' name = 'qualificationName' id='qualificationName' value='$qualificationName' class='col-md-8' placeholder='Qualification Name' required autofocus>
                            </div>
                            <div class='clearfix'>
                              <label for='description' class='col-md-2'> Description: </label>
                              <textarea class='col-md-8' rows='5' id='description' name = 'description' value='$description' placeholder='Description' required autofocus>$description</textarea>
                            </div>
                            <button class='btn primary col-md-2 col-md-offset-8' name = 'updateQualification' type='submit'>Update</button>
                          </fieldset>
                        </form>
                      </div>"                     
                     . "<script>
				function myQualificationTableFunction() {
				  var input, filter, table, tr, td, i;
				  input = document.getElementById('myQualificationInput');
				  filter = input.value.toUpperCase();
				  table = document.getElementById('qualificationTable');
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
    
   //Code to create the user profile sidebar
    function CreateJobOverviewSidebar()
    {
        $result = "<div class='col-md-12'>
			<div class='profile-sidebar'>
				<!-- SIDEBAR USERPIC -->
				<div class='profile-userpic'>
					<img src='Images/jobsbanner.jpg' class='img-responsive' alt=''>
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
				<div class='' style='margin-left:8px;'>
					<button type='button' class='btn btn-success'>Follow</button>
					<button type='button' class='btn btn-danger'>Message</button>
				</div>
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
						<li class='active'>
							<a href='JobsOverview.php'>
							<i class='glyphicon glyphicon-ok'></i>
							Jobs </a>
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
    
    //Insert a new Qualification into the database
    function InsertANewQualification()
    {
        $qualificationName = $_POST["qualificationName"];
        $description = $_POST["description"];
        
        $qualification = new QualificationEntities(-1, $qualificationName, $description);
        $qualificationModel = new QualificationModel();
        $qualificationModel->InsertANewQualification($qualification);
    }
    
    //Get Qualification By ID.
    function GetQualificationByID($id)
    {
        $qualificationModel = new QualificationModel();
        return $qualificationModel->GetQualificationByID($id);
    }
    
    //Get Qualifications.
    function GetQualifications()
    {
        $qualificationModel = new QualificationModel();
        return $qualificationModel->GetQualifications();
    }
        
    //Delete Qualification
    function DeleteQualification($id)
    {
        $qualificationModel = new QualificationModel();
        $qualificationModel->deleteQualification($id);
    }
    
    //Update Qualification
    function  updateQualification($id)
    {
        $qualificationModel = new QualificationModel();
        return $qualificationModel->updateQualification($id,$_POST["qualificationName"], $_POST["description"]);
    }
    
}
