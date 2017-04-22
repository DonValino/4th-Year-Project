<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CountyController
 *
 * @author Jake Valino
 */

require ("Model/CountyModel.php");
class CountyController {

    // Insert A new County
    function InsertANewCounty($county)
    {
        $countyModel = new CountyModel();
        $countyModel->InsertANewCounty($county);
    }
    
    // Get County By Id
    function GetCountyById($id)
    {
        $countyModel = new CountyModel();
        return $countyModel->GetCountyById($id);
    }
    
    // Get County By Name
    function GetCountyByName($name)
    {
        $countyModel = new CountyModel();
        return $countyModel->GetCountyByName($name);
    }
    
    // Update A County By Id
    function updateACountyById($county,$id)
    {
        $countyModel = new CountyModel();
        return $countyModel->updateACountyById($county, $id);
    }
    
    // Delete A County By Id
    function deleteACountyByID($id)
    {
        $countyModel = new CountyModel();
        $countyModel->deleteACountyByID($id);
    }
    
    // Get All The Counties
    function GetAllCounties()
    {
      $countyModel = new CountyModel(); 
      return $countyModel->GetAllCounties();
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
    
    function AddDisplayCountyForm()
    {
        $countyName = '';
        
        $countyModel = new CountyModel(); 
        $result = "<div class='row'>
            <div class='panel-group col-md-12 col-sm-12'>
			  <div class='panel panel-default'>
					<div class='panel-heading' style='text-align:center;'>
					<a data-toggle='collapse' data-parent='#accordion' href='#collapseSearchResult' class='glyphicon glyphicon-hand-up'><strong>County</strong></a>
					</div>
					<div id='collapseSearchResult' class='panel-collapse collapse in'>
						<div class='panel-body'>
                                                    <div class='row' style='margin:auto; width:100%; padding-top:10px;'>
							<input type='text' id='myCountyInput' class='col-md-4' onkeyup='myCountyTableFunction()' placeholder='Search for County' title='Type in a county name' style='display: block; margin: auto;'>
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
                                                            $counties = $countyModel->GetAllCounties();
                                                            foreach($counties as $row)
                                                            {
                                                                $result.= "<tr>"
                                                                        . "<td>$row->id</td>"
                                                                        . "<td>$row->county</td>"
                                                                        . "<td>"
                                                                        . "     <a href='AddEditCounty.php?epr=delete&id=".$row->id."'>Delete</a>&nbsp|"
                                                                        . "     <a href='AddEditCounty.php?epr=update&id=".$row->id."'>Update</a>"
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
                          <h2 class='col-md-12 col-sm-12 col-xs-12' style='text-align:center;'>Add a new County</h2>
                        </div>
                        <form action='' method = 'POST'>
                          <fieldset>
                            <div class='clearfix'>
                              <label for='countyName' class='col-md-2 col-sm-2 col-xs-3'> Name: </label>
                              <input type='text' name = 'countyName' id='countyName' value='$countyName' class='col-md-8 col-sm-8 col-xs-8' placeholder='County Name' required autofocus>
                            </div>
                            <button class='btn primary col-xs-2 col-xs-offset-9 col-sm-2 col-sm-offset-8 col-md-2 col-md-offset-8' name = 'addCounty' type='submit'>Add</button>
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
    
    function EditCountyForm($id)
    {
        $countyModel = new CountyModel(); 
        $result = "<div class='row'>
            <div class='panel-group col-md-12 col-sm-12'>
			  <div class='panel panel-default'>
					<div class='panel-heading' style='text-align:center;'>
					<a data-toggle='collapse' data-parent='#accordion' href='#collapseSearchResult' class='glyphicon glyphicon-hand-up'><strong>County</strong></a>
					</div>
					<div id='collapseSearchResult' class='panel-collapse collapse in'>
						<div class='panel-body'>
                                                    <div class='row' style='margin:auto; width:100%; padding-top:10px;'>
							<input type='text' id='myCountyInput' class='col-md-4' onkeyup='myCountyTableFunction()' placeholder='Search for County' title='Type in a county name' style='display: block; margin: auto;'>
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
                                                            $id = $countyModel->GetCountyById($id)->id;
                                                            $name = $countyModel->GetCountyById($id)->county;
                                                                $result.= "<tr>"
                                                                        . "<td>$id</td>"
                                                                        . "<td>$name</td>"
                                                                        . "<td>"
                                                                        . "     <a href='AddEditCounty.php?epr=delete&id=".$id."'>Delete</a>&nbsp|"
                                                                        . "     <a href='AddEditCounty.php?epr=update&id=".$id."'>Update</a>"
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
                          <h2 class='col-md-12 col-sm-12 col-xs-12' style='text-align:center;'>Add a new County</h2>
                        </div>
                        <form action='' method = 'POST'>
                          <fieldset>
                            <div class='clearfix'>
                              <label for='countyName' class='col-md-2 col-sm-2 col-xs-3'> Name: </label>
                              <input type='text' name = 'countyName' id='countyName' value='$name' class='col-md-8 col-sm-8 col-xs-8' placeholder='County Name' required autofocus>
                            </div>
                            <button class='btn primary col-xs-2 col-xs-offset-9 col-sm-2 col-sm-offset-8 col-md-2 col-md-offset-8' name = 'updateCounty' type='submit'>Update</button>
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
