<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FavoriteJobsController
 *
 * @author Jake Valino
 */

require ("Model/FavoriteJobsModel.php");
require ("Model/QualificationModel.php");
require ("Model/TypeModel.php");
require ("Model/JobModel.php");
class FavoriteJobsController {
    
    // Post a new favorite job
    function InsertANewFavoriteJob($jobId,$userId, $dateAdded)
    {
        $favoriteJobsModel = new FavoriteJobsModel();
        $favoriteJobsModel->InsertANewFavoriteJob($jobId, $userId, $dateAdded);
    }
    
    // Get Active FavoriteJobs By jobId and userId
    function GetFavoriteJobsByJobIdANDUserId($jobId,$userId)
    {
        $favoriteJobsModel = new FavoriteJobsModel();
        return $favoriteJobsModel->GetFavoriteJobsByJobIdANDUserId($jobId, $userId);
    }
    
    // Delete A Favorite Job
    function deleteAFavoriteJob($jobId,$userId)
    {
        $favoriteJobsModel = new FavoriteJobsModel();
        $favoriteJobsModel->deleteAFavoriteJob($jobId, $userId);
    }
    
    // Get Active FavoriteJobs
    function GetActiveFavoriteJobsByUserId($userId)
    {
        $favoriteJobsModel = new FavoriteJobsModel();
        return $favoriteJobsModel->GetActiveFavoriteJobsByUserId($userId);
    }
    
    // Count Number Of FavoriteJobs By UserId
    function CountNumberFavoriteJobs($userId)
    {
        $favoriteJobsModel = new FavoriteJobsModel();
        $favoriteJobsModel->CountNumberFavoriteJobs($userId);
    }
    
    // Favorite Jobs Side Bar
    function FavoriteJobsSideBar()
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
                                                                                            <a href='JobOffer.php'>
                                                                                            <i class='glyphicon glyphicon-pencil'></i>
                                                                                            Job Offers </a>
                                                                                    </li>
                                                                                    <li class='active'>
                                                                                            <a href='FavoriteJobs.php'>
                                                                                            <i class='glyphicon glyphicon-heart'></i>
                                                                                            Favorite </a>
                                                                                    </li>
                                                                                    <li>
                                                                                            <a href='#' data-toggle='modal' data-target='#aboutFreelanceMeModal'>
                                                                                            <i class='glyphicon glyphicon-italic'></i>
                                                                                            About Us </a>
                                                                                    </li>
                                                                                    <li>
                                                                                            <a href='Help.php' target='_blank'>
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
    
    // Favorite Job Content
    function FavoriteJobContent($id)
    {
        $jobModel = new JobModel();
        $qualificationModel = new QualificationModel();
        
        $search = array();

        $typeModel = new TypeModel();

        $myFavoriteActiveJobs = $this->GetActiveFavoriteJobsByUserId($_SESSION['id']);
            try
            {
                if($myFavoriteActiveJobs != null)
                {
                    foreach($myFavoriteActiveJobs as $row)
                    {
                        array_push($search, $jobModel->GetJobsByID($row->jobId));
                    }
                }
            }catch(Exception $x)
            {
                echo 'Caught exception: ',  $x->getMessage(), "\n";
            }
        
        $result = "<div class='row'>
            <div class='panel-group col-md-12'>
			  <div class='panel panel-default alert alert-info'>
					<div class='panel-heading' style='text-align:center;'>
					<a data-toggle='collapse' data-parent='#accordion' href='#collapseSearchResult' class='glyphicon glyphicon-hand-up'><strong>Related Jobs</strong></a>
					</div>
					<div id='collapseSearchResult' class='panel-collapse collapse in'>
						<div class='panel-body'>
                                                    <div class='row' style='margin:auto; width:100%; padding-top:10px;'>
							<input type='text' id='myjobInput' class='col-md-4' onkeyup='myJobTableFunction()' placeholder='Search for Jobs' title='Type in a job name' style='display: block; margin: auto;'>
                                                    </div>
                                                    <div class='table-responsive'>"
                                                        . "<table class='sortable table' id='myJobTable'>"
                                                        . "<tr style='text-align:center;'>"
                                                        . "     <th style='text-align:center;color:black;'>Name</th>"
                                                        . "     <th style='text-align:center;color:black;'>Description</th>"
                                                        . "     <th style='text-align:center;color:black;'>Category</th>"
                                                        . "     <th style='text-align:center;color:black;'>Qualificaion</th>"
                                                        . "     <th style='text-align:center;color:black;'>Address</th>"
                                                        . "     <th style='text-align:center;color:black;'>Number Of Days</th>"
                                                        . "     <th style='text-align:center;color:black;'>Number Of People Required</th>"
                                                        . "     <th style='text-align:center;color:black;'>Price: </th>"
                                                        . "     <th style='text-align:center;color:black;'>Date Posted: </th>"
                                                        . "     <th style='text-align:center;color:black;'>Action: </th>"
                                                        . "</tr>";
                                                        try
                                                        {
                                                            if ($search != null)
                                                            {
                                                                foreach($search as $row)
                                                                {
                                                                    $type = $typeModel->GetTypeByID($row->type);
                                                                    $qualification = $qualificationModel->GetQualificationByID($row->qualification);
                                                                    $result.= "<tr>"
                                                                            . "<td align='center' style='color:black;'><a href='SearchResult.php?epr=view&id=".$row->jobid."&typeId=".$row->type."'>$row->name</a></td>"
                                                                            . "<td align='center' style='color:black;'>$row->description</td>"
                                                                            . "<td align='center' style='color:black;'>$type->name</td>"
                                                                            . "<td align='center' style='color:black;'>$qualification->qualificationName</td>"
                                                                            . "<td align='center' style='color:black;'>$row->address</td>"
                                                                            . "<td align='center' style='color:black;'>$row->numberOfDays</td>"
                                                                            . "<td align='center' style='color:black;'>$row->numberOfPeopleRequired</td>"
                                                                            . "<td align='center' style='color:black;'>$row->price</td>";
                                                                                $var = $row->date;
                                                                                if(time() - ((60 * 60 * 24) * 10) >= strtotime($var))
                                                                                {
                                                                                    $result.="<td style='color:black;' align='center'>$row->date</td>";
                                                                                }else
                                                                                {
                                                                                    $result.="<td style='color:black;' align='center' style='color:red'><strong>New</strong></td>";
                                                                                }
                                                                            $result.="<td style='color:black;'>"
                                                                            . "     <a href='FavoriteJobs.php?epr=removefromfavoritejobcontent&jobId=".$row->jobid."&typeId=".$row->type."'>Remove</a>"
                                                                            . "</td>"
                                                                            . "</tr>";
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
                    . "</div>"
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
}
