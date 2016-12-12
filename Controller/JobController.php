<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of JobController
 *
 * @author Jake Valino
 */
require 'Model/JobModel.php';
require 'Model/TypeModel.php';
class JobController {
    
    function CreateSearchBar()
    {
        $keyword = '';
        $result = " <div>
          <form action='' method = 'POST'>
            <fieldset>
              <div class='clearfix row'>
                <label for='keyword' class='col-md-1'> Search: </label>
                <input type='text' class='col-md-4' style='padding-bottom:8px;' name = 'keyword' id='keyword' value='$keyword'placeholder='Search Jobs' required autofocus>
                <button class='btn primary col-md-1 col-md-offset-1' name = 'search' type='submit'>Search</button>
              </div>
            </fieldset>
          </form>
        </div>";
                
        return $result;
    }
    
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
                                            <a href='Home.php?epr=cat&name=".$row->name."'>
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
    
    function CreateHomeSideBar()
    {
        $result = "<div class='panel panel-default'>
					<div class='panel-heading' style='text-align:center;'>
					<a data-toggle='collapse' data-parent='#accordion' href='#collapseJObOverviewPage' class='glyphicon glyphicon-hand-up'><strong>Overview:</strong></a>
					</div>
					<div id='collapseadvertisedjobs' class='panel-collapse collapse in'>
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
    
    function CreateSearchResultSideBar()
    {
        $result = "<div class='panel panel-default'>
					<div class='panel-heading' style='text-align:center;'>
					<a data-toggle='collapse' data-parent='#accordion' href='#collapseJObOverviewPage' class='glyphicon glyphicon-hand-up'><strong>Overview:</strong></a>
					</div>
					<div id='collapseadvertisedjobs' class='panel-collapse collapse in'>
						<div class='panel-body'>"
                                    ."<div class='col-md-12'>
                                                            <div class='profile-sidebar'>
                                                                    <!-- SIDEBAR MENU -->
                                                                    <div class='home-usermenu'>
                                                                            <ul class='nav'>
                                                                                    <li>
                                                                                            <a href='Home.php'>
                                                                                            <i class='glyphicon glyphicon-home'></i>
                                                                                            Home </a>
                                                                                    </li>
                                                                                    <li class='active'>
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
                                                                                            <a href='JobsOverview.php'>
                                                                                            <i class='glyphicon glyphicon-usd'></i>
                                                                                            My Jobs </a>
                                                                                    </li>
                                                                                    <li>
                                                                                            <a href='JobsOverview.php'>
                                                                                            <i class='glyphicon glyphicon-usd'></i>
                                                                                            Job Offers </a>
                                                                                    </li>
                                                                                    <li>
                                                                                            <a href='Favorite.php'>
                                                                                            <i class='glyphicon glyphicon-save'></i>
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
    
    function CreateMyJobsSideBar()
    {
        $result = "<div class='panel panel-default'>
					<div class='panel-heading' style='text-align:center;'>
					<a data-toggle='collapse' data-parent='#accordion' href='#collapseJObOverviewPage' class='glyphicon glyphicon-hand-up'><strong>Overview:</strong></a>
					</div>
					<div id='collapseadvertisedjobs' class='panel-collapse collapse in'>
						<div class='panel-body'>"
                                    ."<div class='col-md-12'>
                                                            <div class='profile-sidebar'>
                                                                    <!-- SIDEBAR MENU -->
                                                                    <div class='home-usermenu'>
                                                                            <ul class='nav'>
                                                                                    <li>
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
                                                                                    <li class='active'>
                                                                                            <a href='JobsOverview.php'>
                                                                                            <i class='glyphicon glyphicon-usd'></i>
                                                                                            My Jobs </a>
                                                                                    </li>
                                                                                    <li>
                                                                                            <a href='JobsOverview.php'>
                                                                                            <i class='glyphicon glyphicon-usd'></i>
                                                                                            Job Offers </a>
                                                                                    </li>
                                                                                    <li>
                                                                                            <a href='Favorite.php'>
                                                                                            <i class='glyphicon glyphicon-save'></i>
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
    
    function SearchResult($name)
    {

        require 'Model/QualificationModel.php';
        $jobModel = new JobModel();
        $qualificationModel = new QualificationModel();
        
        $search = $jobModel->GetJobsByName($name);
        $typeModel = new TypeModel();
        
        $result = "<div class='panel-group col-md-12'>
			  <div class='panel panel-default'>
					<div class='panel-heading' style='text-align:center;'>
					<a data-toggle='collapse' data-parent='#accordion' href='#collapseSearchResult' class='glyphicon glyphicon-hand-up'><strong>Search Result</strong></a>
					</div>
					<div id='collapseSearchResult' class='panel-collapse collapse in'>
						<div class='panel-body'>
                                                    <div class='row' style='margin:auto; width:100%; padding-top:10px;'>
							<input type='text' id='myjobInput' class='col-md-4' onkeyup='myJobTableFunction()' placeholder='Search for Jobs' title='Type in a job name' style='display: block; margin: auto;'>
                                                    </div>
                                                    <div class='table-responsive'>"
                                                        . "<table class='table sortable'>"
                                                        . "<tr>"
                                                        . "     <th>Name</th>"
                                                        . "     <th>Description</th>"
                                                        . "     <th>Category</th>"
                                                        . "     <th>Qualificaion</th>"
                                                        . "     <th>Address</th>"
                                                        . "     <th>Number Of Days</th>"
                                                        . "     <th>Number Of People Required</th>"
                                                        . "     <th>Price: </th>"
                                                        . "</tr>";
                                                        try
                                                        {
                                                            foreach($search as $row)
                                                            {
                                                                $type = $typeModel->GetTypeByID($row->type);
                                                                $qualification = $qualificationModel->GetQualificationByID($row->qualification);
                                                                $result.= "<tr>"
                                                                        . "<td align='center'><a href='SearchResult.php?epr=view&id=".$row->jobid."'>$row->name</a></td>"
                                                                        . "<td align='center'>$row->description</td>"
                                                                        . "<td align='center'>$type->name</td>"
                                                                        . "<td align='center'>$qualification->qualificationName</td>"
                                                                        . "<td align='center'>$row->address</td>"
                                                                        . "<td align='center'>$row->numberOfDays</td>"
                                                                        . "<td align='center'>$row->numberOfPeopleRequired</td>"
                                                                        . "<td align='center'>$row->price</td>"
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
    
    function SearchResultPrice($min,$max)
    {
        require 'Model/QualificationModel.php';
        
        $jobModel = new JobModel();
        $qualificationModel = new QualificationModel();
        
        $search = $jobModel->GetJobsBetweenPrices($min, $max);
        $typeModel = new TypeModel();
        
        $result = "<div class='panel-group col-md-12'>
			  <div class='panel panel-default'>
					<div class='panel-heading' style='text-align:center;'>
					<a data-toggle='collapse' data-parent='#accordion' href='#collapseSearchResult' class='glyphicon glyphicon-hand-up'><strong>Search Result</strong></a>
					</div>
					<div id='collapseSearchResult' class='panel-collapse collapse in'>
						<div class='panel-body'>
                                                    <div class='row' style='margin:auto; width:100%; padding-top:10px;'>
							<input type='text' id='myjobInput' class='col-md-4' onkeyup='myJobTableFunction()' placeholder='Search for Jobs' title='Type in a job name' style='display: block; margin: auto;'>
                                                    </div>
                                                    </br>"
                                                    ."<div class='table-responsive'>"
                                                        . "<table class='table sortable'>"
                                                        . "<tr>"
                                                        . "     <th>Name</th>"
                                                        . "     <th>Description</th>"
                                                        . "     <th>Category</th>"
                                                        . "     <th>Qualificaion</th>"
                                                        . "     <th>Address</th>"
                                                        . "     <th>Number Of Days</th>"
                                                        . "     <th>Number Of People Required</th>"
                                                        . "     <th>Price: </th>"
                                                        . "</tr>";
                                                        try
                                                        {
                                                            foreach($search as $row)
                                                            {
                                                                $type = $typeModel->GetTypeByID($row->type);
                                                                $qualification = $qualificationModel->GetQualificationByID($row->qualification);
                                                                $result.= "<tr>"
                                                                        . "<td align='center'><a href='SearchResult.php?epr=view&id=".$row->jobid."'>$row->name</a></td>"
                                                                        . "<td align='center'>$row->description</td>"
                                                                        . "<td align='center'>$type->name</td>"
                                                                        . "<td align='center'>$qualification->qualificationName</td>"
                                                                        . "<td align='center'>$row->address</td>"
                                                                        . "<td align='center'>$row->numberOfDays</td>"
                                                                        . "<td align='center'>$row->numberOfPeopleRequired</td>"
                                                                        . "<td align='center'>$row->price</td>"
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
    
    function SearchUserJob($id)
    {
        require 'Model/QualificationModel.php';
        
        $jobModel = new JobModel();
        $qualificationModel = new QualificationModel();
        
        $search = $jobModel->GetJobsByUserID($id);
        $typeModel = new TypeModel();
        
        $result = "<div class='panel-group col-md-12'>
			  <div class='panel panel-default'>
					<div class='panel-heading' style='text-align:center;'>
					<a data-toggle='collapse' data-parent='#accordion' href='#collapseSearchResult' class='glyphicon glyphicon-hand-up'><strong>Search Result</strong></a>
					</div>
					<div id='collapseSearchResult' class='panel-collapse collapse in'>
						<div class='panel-body'>
                                                    <div class='row' style='margin:auto; width:100%; padding-top:10px;'>
							<input type='text' id='myjobInput' class='col-md-4' onkeyup='myJobTableFunction()' placeholder='Search for Jobs' title='Type in a job name' style='display: block; margin: auto;'>
                                                    </div>
                                                    <div class='table-responsive'>"
                                                        . "<table class='sortable table' id='myJobTable'>"
                                                        . "<tr style='text-align:center;'>"
                                                        . "     <th style='text-align:center;'>Name</th>"
                                                        . "     <th style='text-align:center;'>Description</th>"
                                                        . "     <th style='text-align:center;'>Category</th>"
                                                        . "     <th style='text-align:center;'>Qualificaion</th>"
                                                        . "     <th style='text-align:center;'>Address</th>"
                                                        . "     <th style='text-align:center;'>Number Of Days</th>"
                                                        . "     <th style='text-align:center;'>Number Of People Required</th>"
                                                        . "     <th style='text-align:center;'>Price: </th>"
                                                        . "     <th style='text-align:center;'>Action: </th>"
                                                        . "</tr>";
                                                        try
                                                        {
                                                            foreach($search as $row)
                                                            {
                                                                $type = $typeModel->GetTypeByID($row->type);
                                                                $qualification = $qualificationModel->GetQualificationByID($row->qualification);
                                                                $result.= "<tr>"
                                                                        . "<td align='center'><a href='SearchResult.php?epr=view&id=".$row->jobid."'>$row->name</a></td>"
                                                                        . "<td align='center'>$row->description</td>"
                                                                        . "<td align='center'>$type->name</td>"
                                                                        . "<td align='center'>$qualification->qualificationName</td>"
                                                                        . "<td align='center'>$row->address</td>"
                                                                        . "<td align='center'>$row->numberOfDays</td>"
                                                                        . "<td align='center'>$row->numberOfPeopleRequired</td>"
                                                                        . "<td align='center'>$row->price</td>"
                                                                        . "<td>"
                                                                        . "     <a href='EditJob.php?epr=delete&id=".$row->jobid."'>Delete</a>&nbsp|"
                                                                        . "     <a href='EditJob.php?epr=update&id=".$row->jobid."'>Update</a>"
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
    
    function InsertANewJobForm()
    {
        require 'Model/QualificationModel.php';
        $jobid = '';
        $name = '';
        $description = '';
        $typeId = '';
        $qualificationId = '';
        $address = '';
        $numberOfDays = '';
        $numberOfPeopleRequired = '';
        $price = '';
        $isActive = '';
        $id = '';
        
        $typeModel = new TypeModel();
        $allType = $typeModel->GetTypes();
        
        $qualificationModel = new QualificationModel();
        $allQualification = $qualificationModel->GetQualifications();
        
        $re= " <div class='insertJob-form'>
          <div class='row'>
            <h2 class='col-md-12' style='text-align:center;'>Upload A New Job</h2>
          </div>
          <div class='row'>
            <p class='col-md-4' style='margin-left:5px;'>Please ensure that each field is populated</p>
          </div>
          <form action='' method = 'POST'>
            <fieldset>
              <div class='clearfix'>
                <label for='name' class='col-md-2'> Name: </label>
                <input type='text' name = 'name' id='name' class='col-md-8' value='$name' placeholder='Name' required autofocus>
              </div>
              <div class='clearfix'>
              <label for='description' class='col-md-2'> Description: </label>
                <textarea class='col-md-8' rows='5' id='description' name = 'description' placeholder='Description' required autofocus></textarea>
              </div>
              <div class='clearfix'>
                <div class='form-group'>
                  <label for='type' class='col-md-2'>Category:</label>
                  <select class='form-control col-md-8' id='type' name = 'typeId' style='width:200px;'>";
                    foreach($allType as $row)
                    { 
                      $re .= '<option value='.$row->typeId.'>'.$row->name.'</option>';
                    }
                 $re .=" </select>
                </div>
              </div>
              <div class='clearfix'>
                <div class='form-group'>
                  <label for='qualificationId' class='col-md-2'>Qualification:</label>
                  <select class='form-control col-md-8' id='qualificationId' name = 'qualificationId' style='width:200px;'>";
                    foreach($allQualification as $row)
                    { 
                      $re .= '<option value='.$row->qualificationId.'>'.$row->qualificationName.'</option>';
                    }
                 $re.= " </select>
                </div>
              </div>
              <div class='clearfix'>
              <label for='address' class='col-md-2'> Address: </label>
                <input type='text' class='col-md-8' name = 'address' value='$address' placeholder='Address' required>
              </div>
              <div class='clearfix'>
                <label for='numberOfDays' class='col-md-2'> Number Of Days: </label>
                <select class='form-control'id='numberOfDays' name = 'numberOfDays' style='width:200px;'>
                    <option value=1>1</option>
                    <option value=2>2</option>
                    <option value=3>3</option>
                    <option value=4>4</option>
                    <option value=5>5</option>
                    <option value=6>6</option>
                    <option value=7>7</option>
                    <option value=14>2 Weeks</option>
                    <option value=21>3 Weeks</option>
                    <option value=28>4 Weeks</option>
                </select>
              </div>
              <div class='clearfix'>
                <label for='numberOfPeopleRequired' class='col-md-2'> Number Of People Required: </label>
                <select class='form-control col-md-2' id='numberOfPeopleRequired' name = 'numberOfPeopleRequired' style='width:200px;'>
                    <option value=1>1</option>
                    <option value=2>2</option>
                    <option value=3>3</option>
                    <option value=4>4</option>
                    <option value=5>5</option>
                    <option value=6>6</option>
                    <option value=7>7</option>
                    <option value=14>2 Weeks</option>
                    <option value=21>3 Weeks</option>
                    <option value=28>4 Weeks</option>
                </select>
              </div>
              <div class='clearfix'>
                <label for='price' class='col-md-2'> Price: </label>
                <input type='text' class='col-md-8' name = 'price' value='$price' placeholder='Price' required>
              </div>
              <div class='row'>
              <button class='btn primary col-md-2 col-md-offset-9' Style='margin-left:185px;' name = 'insertANewJob' type='submit'>Upload</button>
              </div>
            </fieldset>
          </form>
        </div>";
                
       return $re;
    }
    
    function EditANewJobForm($id)
    {
        require 'Model/QualificationModel.php';
        
        $typeModel = new TypeModel();
        $allType = $typeModel->GetTypes();
        
        $qualificationModel = new QualificationModel();
        $allQualification = $qualificationModel->GetQualifications();
        
        $jobController = $this->GetJobsByID($id);
        
        $name = $jobController->name;
        $description = $jobController->description;
        $typeId = $jobController->type;
        $qualificationId = $jobController->qualification;
        $address = $jobController->address;
        $numberOfDays = $jobController->numberOfDays;
        $numberOfPeopleRequired = $jobController->numberOfPeopleRequired;
        $price = $jobController->price;
        $userId = $jobController->id;

        
        $re= "
            <div class='editJob-form' style='background-color:white;'>
          <div class='row'>
            <h2 class='col-md-12' style='text-align:center;'>Update Job</h2>
          </div>
          <div class='row'>
            <p class='col-md-4' style='margin-left:5px;'>Please ensure that each field is populated</p>
          </div>
          <form action='' method = 'POST'>
            <fieldset>
              <div class='clearfix'>
                <label for='name' class='col-md-2'> Name: </label>
                <input type='text' name = 'name' id='name' class='col-md-8' value='$name' placeholder='Name' required autofocus>
              </div>
              <div class='clearfix'>
              <label for='description' class='col-md-2'> Description: </label>
                <textarea class='col-md-8' rows='5' id='description' name = 'description' placeholder='Description' required autofocus>$description</textarea>
              </div>
              <div class='clearfix'>
                <div class='form-group'>
                  <label for='type' class='col-md-2'>Category:</label>
                  <select class='form-control col-md-8' id='type' name = 'typeId' value='2' style='width:200px;'>";
                    foreach($allType as $row)
                    { 
                        if($jobController->type == $row->typeId)
                        {
                            $re .= '<option selected value='.$row->typeId.'>'.$row->name.'</option>';
                        }else
                        {
                            $re .= '<option value='.$row->typeId.'>'.$row->name.'</option>';
                        }
                    }
                 $re .=" </select>
                </div>
              </div>
              <div class='clearfix'>
                <div class='form-group'>
                  <label for='qualificationId' class='col-md-2'>Qualification:</label>
                  <select class='form-control col-md-8' value='$qualificationId' id='qualificationId' name = 'qualificationId' style='width:200px;'>";
                    foreach($allQualification as $row)
                    { 
                        if($jobController->qualification == $row->qualificationId)
                        {
                            $re .= '<option selected value='.$row->qualificationId.'>'.$row->qualificationName.'</option>';
                        }else
                        {
                            $re .= '<option value='.$row->qualificationId.'>'.$row->qualificationName.'</option>';
                        }   
                    }
                 $re.= " </select>
                </div>
              </div>
              <div class='clearfix'>
              <label for='address' class='col-md-2'> Address: </label>
                <input type='text' class='col-md-8' name = 'address' value='$address' placeholder='Address' required>
              </div>
              <div class='clearfix'>
                <label for='numberOfDays' class='col-md-2'> Number Of Days: </label>
                <select class='form-control'id='numberOfDays' value='$numberOfDays' name = 'numberOfDays' style='width:200px;'>";
                    for ($x = 1; $x <= 7; $x++) {
                        if($numberOfDays == $x)
                        {
                            $re .="<option selected value=$x>$x</option>";
                        }else
                        {
                            $re .="<option value=$x>$x</option>";
                        }
                        
                    }  
                    $x = 14;
                    while ( $x <= 28) {
                        if($x == 14)
                        {
                            if($numberOfDays == $x)
                            {
                                $re .="<option selected value=$x>2 Weeks</option>";
                            }else
                            {
                                $re .="<option value=$x>2 Weeks</option>";
                            }
                        }else if($x == 21)
                        {
                            if($numberOfDays == $x)
                            {
                                $re .="<option selected value=$x>3 Weeks</option>";
                            }else
                            {
                                $re .="<option value=$x>3 Weeks</option>";
                            }
                            
                        }else
                        {
                            if($numberOfDays == $x)
                            {
                                 $re .="<option selected value=$x>4 Weeks</option>";
                            }else
                            {
                                $re .="<option value=$x>4 Weeks</option>";
                            }
                           
                        }
                        $x= $x + 7;
                    }
                    $re .="
                </select>
              </div>
              <div class='clearfix'>
                <label for='numberOfPeopleRequired' class='col-md-2'> Number Of People Required: </label>
                <select class='form-control col-md-2' id='numberOfPeopleRequired' value='$numberOfPeopleRequired' name = 'numberOfPeopleRequired' style='width:200px;'>";
                    for ($x = 1; $x <= 7; $x++) {
                        if($numberOfPeopleRequired == $x)
                        {
                            $re .="<option selected value=$x>$x</option>";
                        }else
                        {
                            $re .="<option value=$x>$x</option>";
                        }
                        
                    }  
                    $x = 14;
                    while ( $x <= 28) {
                        if($x == 14)
                        {
                            if($numberOfPeopleRequired == $x)
                            {
                                $re .="<option selected value=$x>21 people</option>";
                            }else
                            {
                                $re .="<option value=$x>21 people</option>";
                            }
                        }else if($x == 21)
                        {
                            if($numberOfPeopleRequired == $x)
                            {
                                $re .="<option selected value=$x>28 people</option>";
                            }else
                            {
                                $re .="<option value=$x>28 people</option>";
                            }
                            
                        }else
                        {
                            if($numberOfPeopleRequired == $x)
                            {
                                 $re .="<option selected value=$x>4 Weeks</option>";
                            }else
                            {
                                $re .="<option value=$x>4 Weeks</option>";
                            }
                           
                        }
                        $x= $x + 7;
                    }
                    $re .="
                </select>
              </div>
              <div class='clearfix'>
                <label for='price' class='col-md-2'> Price: </label>
                <input type='text' class='col-md-8' name = 'price' value='$price' placeholder='Price' required>
              </div>
              <div class='row'>
              <button class='btn primary col-md-2 col-md-offset-9' Style='margin-left:185px;' name = 'EditJobSubmit' type='submit'>Save</button>
              </div>
            </fieldset>
          </form>
        </div>"
                         . "<script>
    document.getElementById(numberOfDays).selected = $numberOfDays;
</script>";
                
       return $re;
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
					<button type='button' class='btn btn-danger '>Message</button>
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
    
    //Code To Create Overview of jobs
    function CreateJobOverview()
    {
        $result = "<H4 Style='text-align:center'>Job Overview Page: </H4>"
                  . "<div class='panel-group col-md-6'>
			  <div class='panel panel-default'>
					<div class='panel-heading' style='text-align:center;'>
					<a data-toggle='collapse' data-parent='#accordion' href='#collapseJObOverviewPage' class='glyphicon glyphicon-hand-up'><strong>Overview:</strong></a>
					</div>
					<div id='collapseadvertisedjobs' class='panel-collapse collapse in'>
						<div class='panel-body'>"
                                                    . "<div class='row'>
                                                        <a href='InsertANewJob.php' style='margin-left:10px;'>
                                                    <i class='glyphicon glyphicon-upload'></i>
                                                            Upload A New Job </a>
                                                       </div>"
						."</div>"
					."</div>"
                            ."</div>"
                   ."</div>"
                    ."<div class='panel-group col-md-6'>
			  <div class='panel panel-default'>
					<div class='panel-heading' style='text-align:center;'>
					<a data-toggle='collapse' data-parent='#accordion' href='#collapseJObOverviewPage' class='glyphicon glyphicon-hand-up'><strong>Configuration:</strong></a>
					</div>
					<div id='collapseadvertisedjobs' class='panel-collapse collapse in'>
						<div class='panel-body'>"
                                                    . "<div class='row'>
                                                        <a href='AddEditQualification.php' style='margin-left:10px;'>
                                                    <i class='glyphicon glyphicon-upload'></i>
                                                            Add / Edit Qualification </a>
                                                       </div>
                                                    <div class='row'>
                                                       <a href='AddEditType.php' style='margin-left:10px;'>
                                                    <i class='glyphicon glyphicon-upload'></i>
                                                            Add / Edit Job Category </a>
                                                    </div>"
						."</div>"
					."</div>"
                            ."</div>"
                   ."</div>";
                
        return $result;
    }
    
    // View the Job Details
    function ViewJobDetails($id)
    {
        require 'Model/QualificationModel.php';
        $jobController = $this->GetJobsByID($id);
        
        $qualificationModel = new QualificationModel();
        $qualification = $qualificationModel->GetQualificationByID($jobController->qualification)->qualificationName;
        
        $typeModel = new TypeModel();
        $typeName = $typeModel->GetTypeByID($jobController->type)->name;
        
        $result = "<div class='row'>"
                  ."<div class='panel-group col-md-6'>
			  <div class='panel panel-default'>
					<div class='panel-heading' style='text-align:center;'>
					<a data-toggle='collapse' data-parent='#accordion' href='#collapseJobDescription' class='glyphicon glyphicon-hand-up'><strong>Description:</strong></a>
					</div>
					<div id='collapseJobDescription' class='panel-collapse collapse in'>
						<div class='panel-body'>"
                                                    . "<div class='row'>
                                                        <p class='col-md-12' id='description' style='font-size:13px;'><font face='arial'>$jobController->description</font></p>
                                                       </div>"
						."</div>"
					."</div>"
                            ."</div>"
                    ."</div>"
                
                
                  ."<div class='panel-group col-md-6'>
			  <div class='panel panel-default'>
					<div class='panel-heading' style='text-align:center;'>
					<a data-toggle='collapse' data-parent='#accordion' href='#collapseJobProperties' class='glyphicon glyphicon-hand-up'><strong>Job Properties:</strong></a>
					</div>
					<div id='collapseJobProperties' class='panel-collapse collapse in'>
						<div class='panel-body'>"
                                                    . "<div class='row'>
                                                            <div class='table-responsive'>
                                                                <table class='sortable table' id='myJobTable'>
                                                                    <tr>
                                                                        <td><strong>Name:</strong> $jobController->name</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><strong>Qualification:</strong>$qualification</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><strong>Category:</strong>$typeName</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><strong>Address:</strong> $jobController->address</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><strong>Number Of Days:</strong> $jobController->numberOfDays</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><strong>Number Of People Required:</strong> $jobController->numberOfPeopleRequired </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><strong>Price / Minimum Bid:</strong> $jobController->price </td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                       </div>"
						."</div>"
					."</div>"
                            ."</div>"
                    ."</div>"
                . "</div>";
        
        $result .= "<div class='row'>"
                  ."<div class='panel-group col-md-6'>
			  <div class='panel panel-default'>
					<div class='panel-heading' style='text-align:center;'>
					<a data-toggle='collapse' data-parent='#accordion' href='#collapseBiddingTable' class='glyphicon glyphicon-hand-up'><strong>Bidding Table:</strong></a>
					</div>
					<div id='collapseBiddingTable' class='panel-collapse collapse in'>
						<div class='panel-body'>"
                                                    . "<div class='row'>
                                                        
                                                       </div>"
						."</div>"
					."</div>"
                            ."</div>"
                    ."</div>"                  
                
                    ."<div class='panel-group col-md-6'>
			  <div class='panel panel-default'>
					<div class='panel-heading' style='text-align:center;'>
					<a data-toggle='collapse' data-parent='#accordion' href='#collapseHighestBid' class='glyphicon glyphicon-hand-up'><strong>Highest Bid:</strong></a>
					</div>
					<div id='collapseHighestBid' class='panel-collapse collapse in'>
						<div class='panel-body'>"
                                                    . "<div class='row'>
                                                        
                                                       </div>"
						."</div>"
					."</div>"
                            ."</div>"
                    ."</div>"
                . "</div>";
        
        return $result;
    }
    
    // View the Job Details
    function ViewJobDetailsSideBar()
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
				<div style='margin-left:50px;'>
					<button type='button' class='btn btn-success btn-sm'>Message</button>
				</div>
				<!-- END SIDEBAR BUTTONS -->
				<!-- SIDEBAR MENU -->
				<div class='profile-usermenu'>
					<ul class='nav'>
						<li class='active'>
							<a href='#'>
							<i class='glyphicon glyphicon-home'></i>
							View Profile </a>
						</li>
						<li>
							<a href='#'>
							<i class='glyphicon glyphicon-user'></i>
							Contact </a>
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
    
    //Insert a new admin user into the database
    function InsertAJob($id)
    {
        $name = $_POST["name"];
        $description = $_POST["description"];
        $type = $_POST["typeId"];
        $qualification = $_POST["qualificationId"];
        $address = $_POST["address"];
        $numberOfDays = $_POST["numberOfDays"];
        $numberOfPeopleRequired = $_POST["numberOfPeopleRequired"];
        $price = $_POST["price"];
        $isActive = 1;
        
        $job = new JobEntities(-1, $name, $description, $type, $qualification, $address, $numberOfDays, $numberOfPeopleRequired, $price, $isActive, $id);
        $jobModel = new JobModel();
        $jobModel->InsertANewJob($job);
    }
    
    //Get Jobs in a particular type from the database.
    function GetJobByType($type)
    {
        $jobModel = new JobModel();
        return $jobModel->GetJobByType($type);
    }
    
    //Get Job By ID.
    function GetJobsByID($id)
    {
        $jobModel = new JobModel();
        return $jobModel->GetJobsByID($id);
    }
    
    //Get Job By ID.
    function GetJobsByUserID($id)
    {
        $jobModel = new JobModel();
        return $jobModel->GetJobsByUserID($id);
    }
    
    //Get Job By Name.
    function GetJobsByName($name)
    {
        $jobModel = new JobModel();
        return $jobModel->GetJobsByName($name);
    }
    
     //Get Job By Address.
    function GetJobsByAddress($address)
    {
        $jobModel = new JobModel();
        return $jobModel->GetJobsByAddress($address);
    }
    
    //Get Jobs By Qualification.
    function GetJobsByQualification($qualification)
    {
        $jobModel = new JobModel();
        return $jobModel->GetJobsByQualification($qualification);
    }
    
    //Get Jobs By Number of people Required.
    function GetJobsByNumberOfPeopleRequired($numberOfPeopleRequired)
    {
        $jobModel = new JobModel();
        return $jobModel->GetJobsByNumberOfPeopleRequired($numberOfPeopleRequired);
    }
    
    //Get Jobs By Number of Days Required.
    function GetJobsByNumberOfDaysRequired($numberOfdaysRequired)
    {
        $jobModel = new JobModel();
        return $jobModel->GetJobsByNumberOfDaysRequired($numberOfdaysRequired);
    }
    
    //Get Jobs By between prices.
    function GetJobsBetweenPrices($minPrice,$maxPrice)
    {
        $jobModel = new JobModel();
        return $jobModel->GetJobsBetweenPrices($minPrice, $maxPrice);
    }
    
    //Update a user
    function updateJob($name,$description1,$type,$qualification,$address,$numberOfDays,$numberOfPeopleRequired,$price,$jobid)
    {
        $jobModel = new JobModel();
        return $jobModel->updateJob($name,$description1,$type,$qualification,$address,$numberOfDays,$numberOfPeopleRequired,$price,$jobid);
    }
    
    //Delete a job
    function deleteJob($id)
    {
        $jobModel = new JobModel();
        $jobModel->deleteJob($id);
    }
    
}
