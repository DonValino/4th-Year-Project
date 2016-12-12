<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TypeController
 *
 * @author Jake Valino
 */
require 'Model/TypeModel.php';

class TypeController {
    //put your code here
    
    function AddDisplaytypeForm()
    {
        $typeName = '';
        $typeModel = new TypeModel();
        $result = "<div class='row'>
            <div class='panel-group col-md-12'>
			  <div class='panel panel-default'>
					<div class='panel-heading' style='text-align:center;'>
					<a data-toggle='collapse' data-parent='#accordion' href='#collapseSearchResult' class='glyphicon glyphicon-hand-up'><strong>Type</strong></a>
					</div>
					<div id='collapseSearchResult' class='panel-collapse collapse in'>
						<div class='panel-body'>
                                                    <div class='row' style='margin:auto; width:100%; padding-top:10px;'>
							<input type='text' id='myTypeInput' class='col-md-4' onkeyup='myTypeTableFunction()' placeholder='Search for Category' title='Type in a job category' style='display: block; margin: auto;'>
                                                    </div>
                                                    <div class='table-responsive'>"
                                                        . "<table class='table sortable' id='jobTypeTable'>"
                                                        . "<tr>"
                                                        . "     <th>Id</th>"
                                                        . "     <th>Name</th>"
                                                        . "     <th>Actions</th>"
                                                        . "</tr>";
                                                        try
                                                        {
                                                            $types = $typeModel->GetTypes();
                                                            foreach($types as $row)
                                                            {
                                                                $result.= "<tr>"
                                                                        . "<td>$row->typeId</td>"
                                                                        . "<td>$row->name</td>"
                                                                        . "<td>"
                                                                        . "     <a href='AddEditType.php?epr=delete&id=".$row->typeId."'>Delete</a>&nbsp|"
                                                                        . "     <a href='AddEditType.php?epr=update&id=".$row->typeId."'>Update</a>"
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
            <h2 class='col-md-12' style='text-align:center;'>Add a new Category</h2>
          </div>
          <form action='' method = 'POST'>
            <fieldset>
              <div class='clearfix'>
                <label for='typeName' class='col-md-2'> Type Name: </label>
                <input type='text' name = 'typeName' id='typeName' value='$typeName' class='col-md-8' placeholder='Type Name' required autofocus>
              </div>
              <button class='btn primary col-md-2 col-md-offset-8' name = 'addType' type='submit'>Add</button>
            </fieldset>
          </form>
        </div>"                        
                     . "<script>
				function myTypeTableFunction() {
				  var input, filter, table, tr, td, i;
				  input = document.getElementById('myTypeInput');
				  filter = input.value.toUpperCase();
				  table = document.getElementById('jobTypeTable');
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
    
    function EditypeForm($id)
    {
        $typeModel = new TypeModel();
        $typeName = $typeModel->GetTypeByID($id)->name;
        
        $result = "<div class='row'>
            <div class='panel-group col-md-12'>
			  <div class='panel panel-default'>
					<div class='panel-heading' style='text-align:center;'>
					<a data-toggle='collapse' data-parent='#accordion' href='#collapseSearchResult' class='glyphicon glyphicon-hand-up'><strong>Type</strong></a>
					</div>
					<div id='collapseSearchResult' class='panel-collapse collapse in'>
						<div class='panel-body'>
                                                    <div class='row' style='margin:auto; width:100%; padding-top:10px;'>
							<input type='text' id='myTypeInput' class='col-md-4' onkeyup='myTypeTableFunction()' placeholder='Search for Category' title='Type in a job category' style='display: block; margin: auto;'>
                                                    </div>
                                                    <div class='table-responsive'>"
                                                        . "<table class='table' id='jobTypeTable'>"
                                                        . "<tr>"
                                                        . "     <th>Id</th>"
                                                        . "     <th>Name</th>"
                                                        . "     <th>Actions</th>"
                                                        . "</tr>";
                                                        try
                                                        {
                                                            $types = $typeModel->GetTypes();
                                                            foreach($types as $row)
                                                            {
                                                                $result.= "<tr>"
                                                                        . "<td>$row->typeId</td>"
                                                                        . "<td>$row->name</td>"
                                                                        . "<td>"
                                                                        . "     <a href='AddEditType.php?epr=delete&id=".$row->typeId."'>Delete</a>&nbsp|"
                                                                        . "     <a href='AddEditType.php?epr=update&id=".$row->typeId."'>Update</a>"
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
            <h2 class='col-md-12' style='text-align:center;'>Edit Category</h2>
          </div>
          <form action='' method = 'POST'>
            <fieldset>
              <div class='clearfix'>
                <label for='typeName' class='col-md-2'> Type Name: </label>
                <input type='text' name = 'typeName' id='typeName' value='$typeName' class='col-md-8' placeholder='Type Name' required autofocus>
              </div>
              <button class='btn primary col-md-2 col-md-offset-8' name = 'updateType' type='submit'>Update</button>
            </fieldset>
          </form>
        </div>"                        
                     . "<script>
				function myTypeTableFunction() {
				  var input, filter, table, tr, td, i;
				  input = document.getElementById('myTypeInput');
				  filter = input.value.toUpperCase();
				  table = document.getElementById('jobTypeTable');
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
    function InsertANewType()
    {
        $name = $_POST["typeName"];
        
        $type = new TypeEntities(-1, $name);
        $typeModel = new TypeModel();
        $typeModel->InsertANewType($type);
    }
    
    //Get Qualification By ID.
    function GetTypeByID($id)
    {
        $typeModel = new TypeModel();
        return $typeModel->GetTypeByID($id);
    }
    
    //Get Qualifications.
    function GetTypes()
    {
        $typeModel = new TypeModel();
        return $typeModel->GetTypes();
    }
    
    //Delete Type
    function DeleteType($id)
    {
        $typeModel = new TypeModel();
        return $typeModel->deleteType($id);
    }
    
    // Update Type
    function UpdateType($id)
    {
        $typeModel = new TypeModel();
        return $typeModel->updateType($id, $_POST["typeName"]);
    }
    
}
