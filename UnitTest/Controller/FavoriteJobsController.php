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
        return $favoriteJobsModel->CountNumberFavoriteJobs($userId);
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
                                                                                    <li class='active'>
                                                                                            <a href='FavoriteJobs.php'>
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
			  <div class='panel panel-default'>
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
                                                        . "     <th style='text-align:center;'>Name</th>"
                                                        . "     <th style='text-align:center;'>Description</th>"
                                                        . "     <th style='text-align:center;'>Category</th>"
                                                        . "     <th style='text-align:center;'>Qualificaion</th>"
                                                        . "     <th style='text-align:center;'>Address</th>"
                                                        . "     <th style='text-align:center;'>Number Of Days</th>"
                                                        . "     <th style='text-align:center;'>Number Of People Required</th>"
                                                        . "     <th style='text-align:center;'>Price: </th>"
                                                        . "     <th>Date Posted: </th>"
                                                        . "     <th style='text-align:center;'>Action: </th>"
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
                                                                            . "<td align='center'><a href='SearchResult.php?epr=view&id=".$row->jobid."&typeId=".$row->type."'>$row->name</a></td>"
                                                                            . "<td align='center'>$row->description</td>"
                                                                            . "<td align='center'>$type->name</td>"
                                                                            . "<td align='center'>$qualification->qualificationName</td>"
                                                                            . "<td align='center'>$row->address</td>"
                                                                            . "<td align='center'>$row->numberOfDays</td>"
                                                                            . "<td align='center'>$row->numberOfPeopleRequired</td>"
                                                                            . "<td align='center'>$row->price</td>";
                                                                                $var = $row->date;
                                                                                if(time() - ((60 * 60 * 24) * 10) >= strtotime($var))
                                                                                {
                                                                                    $result.="<td align='center'>$row->date</td>";
                                                                                }else
                                                                                {
                                                                                    $result.="<td align='center' style='color:red'><strong>New</strong></td>";
                                                                                }
                                                                            $result.="<td>"
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
