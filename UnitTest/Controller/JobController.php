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
require 'Model/UserModel.php';
require 'Model/UserReviewModel.php';
require 'Model/QualificationModel.php';
require 'Model/PlacedOffersModel.php';
require 'Model/FollowingModel.php';
require 'Model/NotificationModel.php';
require 'Model/FavoriteJobsModel.php';
require 'Model/CountyModel.php';

class JobController {
    
    function CreateSearchBar()
    {
        require 'Model/UserSearchesModel.php';
        require_once 'Model/RecommenderModel.php';
        $userSearchesModel = new UserSearchesModel();
        $recommenderModel = new RecommenderModel();

        $search = $userSearchesModel->GetUserSearhesById($_SESSION['id']);
        $jobModel = new JobModel();
        
        $keyword = '';
        
        $result = " <div>
          <form action='' method = 'POST'>
            <fieldset>
              <div class='clearfix row'>
                <label for='keyword' class='col-md-1 col-sm-1'> Search: </label>
                <input type='text' class='col-md-6 col-sm-6' style='padding-bottom:8px;' name = 'keyword' id='keyword' value='$keyword'placeholder='Search Jobs' required autofocus>
                <button class='btn primary col-sm-1 col-sm-offset-1 col-md-1 col-md-offset-1' name = 'search' type='submit'>Search</button>
              </div>
            </fieldset>
          </form>
        </div>"
        . "<div class='row' style='padding-bottom:10px'>
                <div class='col-md-5 col-md-offset-3' style='background-color: white;' id='searchResults'>";
                    try
                        {
                            $userRecommender = $recommenderModel->GetRecordByUserId($_SESSION['id']);
                            if($userRecommender != null)
                            {
                                $category = array();
                                    foreach($userRecommender as $row)
                                    {
                                        array_push($category, $row->catId);
                                    }
                                    
                                    if(sizeof($category) == 4)
                                    {
                                        $recommendedJobs = $this->GetJobsByTop4Category($category[0], $category[1], $category[2], $category[3]);
                                        $countOfRecommendedJobs = $this->CountJobsByTop4Category($category[0], $category[1], $category[2], $category[3]); 
                                        if($recommendedJobs != null)
                                        {
                                            foreach($recommendedJobs as $row)
                                            {
                                                if($row->date)
                                                {
                                                    $var = $row->date;
                                                    // Check if more than 10 days
                                                    if(time() - ((60 * 60 * 24) * 10) >= strtotime($var))
                                                    {
                                                        $countOfRecommendedJobs = $countOfRecommendedJobs -1;
                                                    }
                                                }
                                            }
                                                    $result.="<div class='row' style='border-bottom: 1px solid #EBEBEB;'>
                                                        <p style='text-align:center;'><a href='SearchResult.php?epr=recommendedJob&cat1=".$category[0]."&cat2=".$category[1]."&cat3=".$category[2]."&cat4=".$category[3]."'> Recommended Jobs </a> - <font color='#f60'> $countOfRecommendedJobs new </font></p>
                                                    </div>";
                                        }

                                    }
                            }
                            if($search != null)
                            {
                                $numResult = 0;
                                $result.="<div class='row' style='border-bottom: 1px solid #EBEBEB;'>
                                    <p style='text-align:center;'> My Recent Searches - <a href='home.php?epr=clear'>clear</a></p>
                                </div>";

                                    foreach($search as $row)
                                    {
                                        $numResult= $this->CountJobsByName($row->keyword);
                                        if($numResult > $row->numResult)
                                        {
                                            $numNew = $numResult - $row->numResult;
                                            $result.= "<p style='text-align:center;'><a href='SearchResult.php?epr=previouskeyword&keyword=".$row->keyword."'>$row->keyword</a> &nbsp<font color='#f60'> $numNew new</font></p>";            
                                        }else
                                        {
                                            $result.= "<p style='text-align:center;'><a href='SearchResult.php?epr=previouskeyword&keyword=".$row->keyword."'>$row->keyword</a></p>";
                                        } 
                                    }  
                            }
                            
                            $numUserSearches = $userSearchesModel->CountNumberOfUserSearhesById($_SESSION['id']);
                    }catch(Exception $x)
                        {
                            echo 'Caught exception: ',  $x->getMessage(), "\n";
                        }
     $result.=" </div>
           </div>";
                
        return $result;
    }
      
    //Get Job By Top 4 Category.
    function GetJobsByTop4Category($typeId1,$typeId2,$typeId3,$typeId4)
    {
        $jobModel = new JobModel();
        return $jobModel->GetJobsByTop4Category($typeId1, $typeId2, $typeId3, $typeId4);
    }
    
    //Count Job By Top 4 Category.
    function CountJobsByTop4Category($typeId1,$typeId2,$typeId3,$typeId4)
    {
        $jobModel = new JobModel();
        return $jobModel->CountJobsByTop4Category($typeId1, $typeId2, $typeId3, $typeId4);
    }
    
    // Get Highest Priced Jobs
    function GetHighestPricedJobs($id)
    {
        $jobModel = new JobModel();
        return $jobModel->GetHighestPricedJobs($id);
    }
    
    // Get Number Of Jobs Per Category
    function GetNumberOfJobsPerQualification($id)
    {
        $jobModel = new JobModel();
        return $jobModel->GetNumberOfJobsPerQualification($id);
    }
    
    // Get Number Of Jobs Per Location
    function GetNumberOfJobsPerLocation($id)
    {
        $jobModel = new JobModel();
        return $jobModel->GetNumberOfJobsPerLocation($id);
    }
    
    function CreateHomeContent($id)
    {
        $jobModel = new JobModel();
        $qualificationModel = new QualificationModel();
        
        $search = $this->GetHighestPricedJobs($id);
        $typeModel = new TypeModel(); 
        $allType = $typeModel->GetTypes();
        $allQualifications = $qualificationModel->GetQualifications();
        
        $userModel = new UserModel();
        $allUsers = $userModel->GetUsers();
        
        $userReviewModel = new UserReviewModel();
        
        $countyModel = new CountyModel();
        $allCounty = $countyModel->GetAllCounties();
        $result = "<div class='row'>"
                . "<div class='panel-group col-md-6'>
			  <div class='panel panel-default'>
					<div class='panel-heading' style='text-align:center;'>
					<a data-toggle='collapse' data-parent='#accordion' href='#collapseTopPayingjobs' class='glyphicon glyphicon-hand-up'><strong>Top Paying Jobs</strong></a>
					</div>
					<div id='collapseTopPayingjobs' class='panel-collapse collapse in'>
						<div class='panel-body'>
                                                    <div class='row' style='margin:auto; width:100%; padding-top:10px;'>
							<input type='text' id='topPayingJobsInput' class='col-md-4' onkeyup='topPayingJobsFunction()' placeholder='Filter' title='Type in a job name' style='display: block; margin: auto;'>
                                                    </div>
                                                    <div class='table-responsive scrollitY' id='topPayingJobsTable'>"
                                                        . "<table class='table sortable'>"
                                                        . "<tr>"
                                                        . "     <th>Job</th>"
                                                        . "     <th>Category</th>"
                                                        . "     <th>Price</th>"
                                                        . "</tr>";
                                                        try
                                                        {
                                                            if($search != null)
                                                            {
                                                                foreach($search as $row)
                                                                {
                                                                    $type = $typeModel->GetTypeByID($row->type);
                                                                    $qualification = $qualificationModel->GetQualificationByID($row->qualification);
                                                                    $result.= "<tr>"
                                                                            . "<td align='center'><a href='SearchResult.php?epr=view&id=".$row->jobid."&typeId=".$row->type."'>$row->name</a></td>"
                                                                            . "<td align='center'>$type->name</td>"
                                                                            . "<td align='center'>$row->price</td>"
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
                . "<div class='panel-group col-md-6'>
			  <div class='panel panel-default'>
					<div class='panel-heading' style='text-align:center;'>
					<a data-toggle='collapse' data-parent='#accordion' href='#collapseTopEmployers' class='glyphicon glyphicon-hand-up'><strong>Top Rated FreeLancers</strong></a>
					</div>
					<div id='collapseTopEmployers' class='panel-collapse collapse in'>
						<div class='panel-body'>
                                                    <ul class='img-list col-md-12 scrollitY'>";
                                                                try
                                                                {
                                                                    if($allUsers != null)
                                                                    {
                                                                        $actualRate = 0;
                                                                        $expectedRate = 0;
                                                                        $res = 0;
                                                                        foreach($allUsers as $row)
                                                                        {
                                                                            $actualRate = 0;
                                                                            $expectedRate = 0;
                                                                            $res = 0;
                                                                            $numberOfReviews = 0;
                                                                            $allUserReviews = $userReviewModel->GetUserReviewById($row->id);
                                                                            $userId = 0;
                                                                            if($allUserReviews != null)
                                                                            {
                                                                                foreach($allUserReviews as $row1)
                                                                                {
                                                                                    $actualRate= $actualRate + $row1->punctionality + $row1->workSatisfaction + $row1->skills;
                                                                                   
                                                                                    $expectedRate = $expectedRate + 15;
                                                                                    
                                                                                    $res = ($actualRate / $expectedRate) * 5;
                                                                                    $userId = $row1->userid;
                                                                                    $numberOfReviews = $numberOfReviews + 1;
                                                                                }
                                                                                
                                                                                if($res >= 4 && $numberOfReviews >= 4)
                                                                                {
                                                                                    $result.= "<li>
                                                                                                <a href='UserReview.php?epr=review&id=".$userId."'>
                                                                                                  <img src='$row->photo' width='150' height='150' />
                                                                                                  <span class='text-content'><span>$row->firstName &nbsp&nbsp $row->lastName</span></span>
                                                                                                </a>
                                                                                                <p style='text-align:center;'><strong>Vote Data:&nbsp&nbsp</strong>";$result.=round($res, 2);$result.="/ 5.0</p>
                                                                                              </li>";
                                                                                }
                                                                            }

                                                                        }
                                                                    }
                                                                }catch(Exception $x)
                                                                {
                                                                    echo 'Caught exception: ',  $x->getMessage(), "\n";
                                                                }

                                                    $result.="</ul>"     
						."</div>"
					."</div>"
				."</div>"
			."</div>"
                . "</div>"
                ."<div class='row'>"
                . "<div class='panel-group col-md-6'>
			  <div class='panel panel-default'>
					<div class='panel-heading' style='text-align:center;'>
					<a data-toggle='collapse' data-parent='#accordion' href='#collapseCategories' class='glyphicon glyphicon-hand-up'><strong>Categories</strong></a>
					</div>
					<div id='collapseMyPlacedOffers' class='panel-collapse collapse in'>
						<div class='panel-body'>
                                                    <div class='row' style='margin:auto; width:100%; padding-top:10px;'>
							<input type='text' id='categoryInput' class='col-md-4' onkeyup='categoryFunction()' placeholder='Filter' title='Type in a job name' style='display: block; margin: auto;'>
                                                    </div>
                                                    <div class='table-responsive scrollit'>"
                                                        . "<table class='table sortable' id='categoryTable'>"
                                                        . "<tr>"
                                                        . "     <th style='text-align:center;'>Name</th>"
                                                        . "</tr>";
                                                        try
                                                        {
                                                            if($allType != null)
                                                            {
                                                                foreach($allType as $row)
                                                                {
                                                                    $countOfJobs = $jobModel->GetNumberOfJobsPerCategory($row->typeId);
                                                                    if($countOfJobs != 0)
                                                                    {
                                                                        $result.= "<tr style='text-align:center;'>"
                                                                                . "<td align='center'><a href='Home.php?epr=cat&id=".$row->typeId."'>$row->name</a> - <font color='#f60'> $countOfJobs active </font></td>"
                                                                                . "</tr>";
                                                                    }else
                                                                    {
                                                                        $result.= "<tr style='text-align:center;'>"
                                                                                . "<td align='center'><a href='Home.php?epr=cat&id=".$row->typeId."'>$row->name</a></td>"
                                                                                . "</tr>";
                                                                    }

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
                        . "<div class='panel-group col-md-6'>
			  <div class='panel panel-default'>
					<div class='panel-heading' style='text-align:center;'>
					<a data-toggle='collapse' data-parent='#accordion' href='#collapseRequiredQualifications' class='glyphicon glyphicon-hand-up'><strong>Required Qualifications</strong></a>
					</div>
					<div id='collapseRequiredQualifications' class='panel-collapse collapse in'>
						<div class='panel-body'>
                                                    <div class='row' style='margin:auto; width:100%; padding-top:10px;'>
							<input type='text' id='qualificationInput' class='col-md-4' onkeyup='qualificationFunction()' placeholder='Filter' title='Type in a job name' style='display: block; margin: auto;'>
                                                    </div>
                                                    <div class='table-responsive scrollit' id='qualificationTable'>"
                                                        . "<table class='table sortable'>"
                                                        . "<tr>"
                                                        . "     <th style='text-align:center;'>Name</th>"
                                                        . "</tr>";
                                                        try
                                                        {
                                                            if($allQualifications != null)
                                                            {
                                                                foreach($allQualifications as $row)
                                                                {
                                                                    $countOfJobs = $jobModel->GetNumberOfJobsPerQualification($row->qualificationId);
                                                                    if($countOfJobs != 0)
                                                                    {
                                                                        $result.= "<tr style='text-align:center;'>"
                                                                                . "<td align='center'><a href='Home.php?epr=qua&id=".$row->qualificationId."'>$row->qualificationName</a> - <font color='#f60'> $countOfJobs active </font></td>"
                                                                                . "</tr>";
                                                                    }else
                                                                    {
                                                                        $result.= "<tr style='text-align:center;'>"
                                                                                . "<td align='center'><a href='Home.php?epr=qua&id=".$row->qualificationId."'>$row->qualificationName</a></td>"
                                                                                . "</tr>";
                                                                    }

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
                . "<div class='row'>"
                . "<div class='panel-group col-md-6'>
			  <div class='panel panel-default'>
					<div class='panel-heading' style='text-align:center;'>
					<a data-toggle='collapse' data-parent='#accordion' href='#collapseListPlacedOffers' class='glyphicon glyphicon-hand-up'><strong>Locations:</strong></a>
					</div>
					<div id='collapseListPlacedOffers' class='panel-collapse collapse in'>
						<div class='panel-body'>
                                                    <div class='row'>
                                                        <a href='SearchJobsByMap.php' class='col-md-offset-10 col-sm-offset-10 col-xs-offset-9'> View Map </a>
                                                    </div>
                                                    <div class='row' style='margin:auto; width:100%; padding-top:10px;'>
							<input type='text' id='locationInput' class='col-md-4' onkeyup='locationFunction()' placeholder='Filter' title='Type in a job name' style='display: block; margin: auto;'>
                                                    </div>
                                                    <div class='table-responsive scrollit'>"
                                                        . "<table class='table sortable' id='locationTable'>"
                                                        . "<tr>"
                                                        . "     <th style='text-align:center;'>Name</th>"
                                                        . "</tr>";
                                                        try
                                                        {
                                                            if($allCounty != null)
                                                            {
                                                                foreach($allCounty as $row)
                                                                {
                                                                    $countOfJobs = $jobModel->GetNumberOfJobsPerLocation($row->id);
                                                                    if($countOfJobs != 0)
                                                                    {
                                                                        $result.= "<tr style='text-align:center;'>"
                                                                                . "<td align='center'><a href='Home.php?epr=location&id=".$row->id."'>$row->county</a> - <font color='#f60'> $countOfJobs active </font></td>"
                                                                                . "</tr>"; 
                                                                    }else
                                                                    {
                                                                        $result.= "<tr style='text-align:center;'>"
                                                                                . "<td align='center'><a href='Home.php?epr=location&id=".$row->id."'>$row->county</a></td>"
                                                                                . "</tr>";
                                                                    }
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
                . "<div class='panel-group col-md-6'>
			  <div class='panel panel-default'>
					<div class='panel-heading' style='text-align:center;'>
					<a data-toggle='collapse' data-parent='#accordion' href='#collapseRating' class='glyphicon glyphicon-hand-up'><strong>My Rating</strong></a>
					</div>
					<div id='collapseRating' class='panel-collapse collapse in'>
						<div class='panel-body'>"
						."</div>"
					."</div>"
				."</div>"
			."</div>"
                . "</div>"
                . "</div>"
                     . "<script>
				function topPayingJobsFunction() {
				  var input, filter, table, tr, td, i;
				  input = document.getElementById('topPayingJobsInput');
				  filter = input.value.toUpperCase();
				  table = document.getElementById('topPayingJobsTable');
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
			</script>"
                     . "<script>
				function categoryFunction() {
				  var input, filter, table, tr, td, i;
				  input = document.getElementById('categoryInput');
				  filter = input.value.toUpperCase();
				  table = document.getElementById('categoryTable');
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
			</script>"
                     . "<script>
				function qualificationFunction() {
				  var input, filter, table, tr, td, i;
				  input = document.getElementById('qualificationInput');
				  filter = input.value.toUpperCase();
				  table = document.getElementById('qualificationTable');
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
			</script>"
                     . "<script>
				function locationFunction() {
				  var input, filter, table, tr, td, i;
				  input = document.getElementById('locationInput');
				  filter = input.value.toUpperCase();
				  table = document.getElementById('locationTable');
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
    
    //Get Sum Of Jobs By Month And Year.
    function GetSumJobsByMonthYear($month,$year)
    {
        $jobModel = new JobModel();
        $jobModel->GetSumJobsByMonthYear($month, $year);
    }
    
    function CreateAdminDashboard()
    {
        $jobModel = new JobModel();
        
        $year = $_SESSION['yearDate'];
        
        $jan = $jobModel->GetSumJobsByMonthYear(1, $year);
        $feb = $jobModel->GetSumJobsByMonthYear(2, $year);
        $mar = $jobModel->GetSumJobsByMonthYear(3, $year);
        $apr = $jobModel->GetSumJobsByMonthYear(4, $year);
        $may = $jobModel->GetSumJobsByMonthYear(5, $year);
        $june = $jobModel->GetSumJobsByMonthYear(6, $year);
        $july = $jobModel->GetSumJobsByMonthYear(7, $year);
        $aug = $jobModel->GetSumJobsByMonthYear(8, $year);
        $sept = $jobModel->GetSumJobsByMonthYear(9, $year);
        $oct = $jobModel->GetSumJobsByMonthYear(10, $year);
        $nov = $jobModel->GetSumJobsByMonthYear(11, $year);
        $dec = $jobModel->GetSumJobsByMonthYear(12, $year);
        
        require_once 'Model/ActiveUsersModel.php';
        
        $activeUsersModel = new ActiveUsersModel();
        
        $janUser = $activeUsersModel->GetSumActiveUsersByMonthYear(1, $year);
        $febUser = $activeUsersModel->GetSumActiveUsersByMonthYear(2, $year);
        $marUser = $activeUsersModel->GetSumActiveUsersByMonthYear(3, $year);
        $aprUser = $activeUsersModel->GetSumActiveUsersByMonthYear(4, $year);
        $mayUser = $activeUsersModel->GetSumActiveUsersByMonthYear(5, $year);
        $juneUser = $activeUsersModel->GetSumActiveUsersByMonthYear(6, $year);
        $julyUser = $activeUsersModel->GetSumActiveUsersByMonthYear(7, $year);
        $augUser = $activeUsersModel->GetSumActiveUsersByMonthYear(8, $year);
        $septUser = $activeUsersModel->GetSumActiveUsersByMonthYear(9, $year);
        $octUser = $activeUsersModel->GetSumActiveUsersByMonthYear(10, $year);
        $novUser = $activeUsersModel->GetSumActiveUsersByMonthYear(11, $year);
        $decUser = $activeUsersModel->GetSumActiveUsersByMonthYear(12, $year);
        
        
        require_once 'Model/RevenueModel.php';
        
        $revenueModel = new RevenueModel();
        
        $janRevenueStandard = $revenueModel->GetSumRevenueByMonthYear(1, $year, 0);
        $febRevenueStandard = $revenueModel->GetSumRevenueByMonthYear(2, $year, 0);
        $marRevenueStandard = $revenueModel->GetSumRevenueByMonthYear(3, $year, 0);
        $aprRevenueStandard = $revenueModel->GetSumRevenueByMonthYear(4, $year, 0);
        $mayRevenueStandard = $revenueModel->GetSumRevenueByMonthYear(5, $year, 0);
        $juneRevenueStandard = $revenueModel->GetSumRevenueByMonthYear(6, $year, 0);
        $julyRevenueStandard = $revenueModel->GetSumRevenueByMonthYear(7, $year, 0);
        $augRevenueStandard = $revenueModel->GetSumRevenueByMonthYear(8, $year, 0);
        $septRevenueStandard = $revenueModel->GetSumRevenueByMonthYear(9, $year, 0);
        $octRevenueStandard = $revenueModel->GetSumRevenueByMonthYear(10, $year, 0);
        $novRevenueStandard = $revenueModel->GetSumRevenueByMonthYear(11, $year, 0);
        $decRevenueStandard = $revenueModel->GetSumRevenueByMonthYear(12, $year, 0);
        
        $janRevenueFeatured = $revenueModel->GetSumRevenueByMonthYear(1, $year, 1);
        $febRevenueFeatured = $revenueModel->GetSumRevenueByMonthYear(2, $year, 1);
        $marRevenueFeatured = $revenueModel->GetSumRevenueByMonthYear(3, $year, 1);
        $aprRevenueFeatured = $revenueModel->GetSumRevenueByMonthYear(4, $year, 1);
        $mayRevenueFeatured = $revenueModel->GetSumRevenueByMonthYear(5, $year, 1);
        $juneRevenueFeatured = $revenueModel->GetSumRevenueByMonthYear(6, $year, 1);
        $julyRevenueFeatured = $revenueModel->GetSumRevenueByMonthYear(7, $year, 1);
        $augRevenueFeatured = $revenueModel->GetSumRevenueByMonthYear(8, $year, 1);
        $septRevenueFeatured = $revenueModel->GetSumRevenueByMonthYear(9, $year, 1);
        $octRevenueFeatured = $revenueModel->GetSumRevenueByMonthYear(10, $year, 1);
        $novRevenueFeatured = $revenueModel->GetSumRevenueByMonthYear(11, $year, 1);
        $decRevenueFeatured = $revenueModel->GetSumRevenueByMonthYear(12, $year, 1);
        
        // Donut Chart
        require_once 'Model/ReportModel.php';
        
        $reportModel = new ReportModel();
        
        $systemFault = $reportModel->GetSumReportsByYear($year, 1);
        $userComplaint = $reportModel->GetSumReportsByYear($year, 2);
        $bugComplaint = $reportModel->GetSumReportsByYear($year, 3);
        $jobComplaint = $reportModel->GetSumReportsByYear($year, 4);
        $paymentComplaint = $reportModel->GetSumReportsByYear($year, 5);
        $others = $reportModel->GetSumReportsByYear($year, 7);
        
        $numberOfReports = $reportModel->CountReports();
        
$result = "<div class='row'>
            <form action='' method = 'POST'>
              <fieldset>
                <div class='clearfix row col-md-5 col-md-offset-4 col-xs-offset-1'>
                  <input type='text' onKeyPress='return checkIt(event)' name = 'year' id='keyword' placeholder='Search By Year' required autofocus>
                  <button class='btn primary' name = 'searchAdminDashboard' type='submit'>Submit</button>
                </div>
              </fieldset>
            </form>
          </div>
          <script>
          function checkIt(evt) {
    evt = (evt) ? evt : window.event
    var charCode = (evt.which) ? evt.which : evt.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        status = 'This field accepts numbers only.'
        return false
    }
    status = ''
    return true
}
          </script>";

        $result.="<div class='row'>"
                ."<div class='panel-group col-md-4 col-md-offset-4 col-sm-4 col-sm-offset-4'>
			  <div class='panel panel-default'>
					<div class='panel-heading' style='text-align:center;'>
					<a data-toggle='collapse' data-parent='#accordion' href='#collapseKeyTable' class='glyphicon glyphicon-hand-up'><strong>Keys:</strong></a>
					</div>
					<div id='collapseKeyTable' class='panel-collapse collapse in'>
						<div class='panel-body'>"
                                                    . "<div class='row'>"
                                                        . "<div style='background-color:lightgreen;text-align:center;font-weight:bold;font-size:13px;color:blue;' class='col-sm-4 col-sm-offset-4 col-md-4 col-md-offset-4'>Year</div>"
                                                      ."</div>"
                                                    . "<div class='row'>"
                                                        . "<div style='margin-top:10px;;text-align:center;font-weight:bold;font-size:13px;color:blue;' class='col-sm-4 col-sm-offset-4 col-md-4 col-md-offset-4'>$_SESSION[yearDate]</div>"
                                                      ."</div>"
						."</div>"
					."</div>"
                            ."</div>"
                    ."</div>"           
                . "</div>";


                $result.= "<div class='row'>"
                . "<div class='panel-group col-md-6'>
			  <div class='panel panel-default'>
					<div class='panel-heading' style='text-align:center;'>
					<a data-toggle='collapse' data-parent='#accordion' href='#collapseActiveUsers' class='glyphicon glyphicon-hand-up'><strong>Active Ads</strong></a>
					</div>
					<div id='collapseActiveUsers' class='panel-collapse collapse in'>
						<div class='panel-body'>
                                                    <div id='chartContainer' style='height: 300px; width: 100%;'>
                                                    </div>"
						."</div>"
					."</div>"
				."</div>"
			."</div>"
                        
                    . "<div class='panel-group col-md-6'>
                              <div class='panel panel-default'>
                                            <div class='panel-heading' style='text-align:center;'>
                                            <a data-toggle='collapse' data-parent='#accordion' href='#collapseRevenue' class='glyphicon glyphicon-hand-up'><strong>Revenue</strong></a>
                                            </div>
                                            <div id='collapseRevenue' class='panel-collapse collapse in'>
                                                    <div class='panel-body'>
                                                        <div id='revenueContainer' style='height: 300px; width: 100%;'>
                                                        </div>"
                                                    ."</div>"
                                            ."</div>"
                                    ."</div>"
                            ."</div>"
                    ."</div>"
                        
                        
                ."<div class='row'>"
                    . "<div class='panel-group col-md-6'>
                              <div class='panel panel-default'>
                                            <div class='panel-heading' style='text-align:center;'>
                                            <a data-toggle='collapse' data-parent='#accordion' href='#collapseTopPayingjobs' class='glyphicon glyphicon-hand-up'><strong>Active Users</strong></a>
                                            </div>
                                            <div id='collapseTopPayingjobs' class='panel-collapse collapse in'>
                                                    <div class='panel-body'>
                                                        <div id='activeUserContainer' style='height: 300px; width: 100%;'>
                                                        </div>"
                                                    ."</div>"
                                            ."</div>"
                                    ."</div>"
                        
			."</div>"
                    . "<div class='panel-group col-md-6'>
                              <div class='panel panel-default'>
                                            <div class='panel-heading' style='text-align:center;'>
                                            <a data-toggle='collapse' data-parent='#accordion' href='#collapseReports' class='glyphicon glyphicon-hand-up'><strong>Reports</strong></a>
                                            </div>
                                            <div id='collapseReports' class='panel-collapse collapse in'>
                                                    <div class='panel-body'>
                                                    <div class='row'>
                                                        <a href='ViewAdminReports.php'><p style='text-align:center;font-size:13px;'><strong>Based on $numberOfReports reports</strong></p></a>
                                                    </div>
                                                    <div class='row'>
                                                        <div id='reportsContainer' style='height: 300px; width: 100%;'>
                                                        </div>
                                                    </div>"
                                                    ."</div>"
                                            ."</div>"
                                    ."</div>"
                        ."</div>"
                . "<script  type='text/javascript'>"
                . "var year = $year;"
                . "var jan = $jan;"
                . "var feb = $feb;"
                . "var mar = $mar;"
                . "var apr = $apr;"
                . "var may = $may;"
                . "var june = $june;"
                . "var july = $july;"
                . "var aug = $aug;"
                . "var sept = $sept;"
                . "var oct = $oct;"
                . "var nov = $nov;"
                . "var dec = $dec;"
                
                . "var janUser = $janUser;"
                . "var febUser = $febUser;"
                . "var marUser = $marUser;"
                . "var aprUser = $aprUser;"
                . "var mayUser = $mayUser;"
                . "var juneUser = $juneUser;"
                . "var julyUser = $julyUser;"
                . "var augUser = $augUser;"
                . "var septUser = $septUser;"
                . "var octUser = $octUser;"
                . "var novUser = $novUser;"
                . "var decUser = $decUser;"
                        
                . "var janRevenueStandard = $janRevenueStandard;"
                . "var febUserRevenueStandard = $febRevenueStandard;"
                . "var marUserRevenueStandard = $marRevenueStandard;"
                . "var aprUserRevenueStandard = $aprRevenueStandard;"
                . "var mayUserRevenueStandard = $mayRevenueStandard;"
                . "var juneUserRevenueStandard = $juneRevenueStandard;"
                . "var julyUserRevenueStandard = $julyRevenueStandard;"
                . "var augUserRevenueStandard = $augRevenueStandard;"
                . "var septUserRevenueStandard = $septRevenueStandard;"
                . "var octUserRevenueStandard = $octRevenueStandard;"
                . "var novUserRevenueStandard = $novRevenueStandard;"
                . "var decUserRevenueStandard = $decRevenueStandard;"
                        
                . "var janRevenueFeatured = $janRevenueFeatured;"
                . "var febUserRevenueFeatured = $febRevenueFeatured;"
                . "var marUserRevenueFeatured = $marRevenueFeatured;"
                . "var aprUserRevenueFeatured = $aprRevenueFeatured;"
                . "var mayUserRevenueFeatured = $mayRevenueFeatured;"
                . "var juneUserRevenueFeatured = $juneRevenueFeatured;"
                . "var julyUserRevenueFeatured = $julyRevenueFeatured;"
                . "var augUserRevenueFeatured = $augRevenueFeatured;"
                . "var septUserRevenueFeatured = $septRevenueFeatured;"
                . "var octUserRevenueFeatured = $octRevenueFeatured;"
                . "var novUserRevenueFeatured = $novRevenueFeatured;"
                . "var decUserRevenueFeatured = $decRevenueFeatured;"   
                 
                ."systemFault = $systemFault;"
                ."userComplaint = $userComplaint;"
                ."bugComplaint = $bugComplaint;"
                ."jobComplaint = $jobComplaint;"        
                ."paymentComplaint = $paymentComplaint;"
                ."others = $others;"
                
                . " var d = new Date();
                    var n = d.getMonth();
                    if(n == 0)
                    {"
                        . "  window.onload = function () {
                                    var chart = new CanvasJS.Chart('chartContainer',
                                    {
                                      theme: 'theme2',
                                      title:{
                                        text: 'Active Ads'
                                      },
                                      animationEnabled: true,
                                      axisX: {
                                        valueFormatString: 'MMM',
                                        interval:1,
                                        intervalType: 'month'

                                      },
                                      axisY:{
                                        includeZero: false

                                      },
                                      data: [
                                      {        
                                        type: 'line',
                                        //lineThickness: 3,        
                                        dataPoints: [
                                        { x: new Date(year, 00, 1), y: jan }
                                        ]
                                      }


                                      ]
                                    });

                                chart.render();
                                
                                    var userChart = new CanvasJS.Chart('activeUserContainer',
                                    {
                                      theme: 'theme2',
                                      title:{
                                        text: 'Active Users'
                                      },
                                      animationEnabled: true,
                                      axisX: {
                                        valueFormatString: 'MMM',
                                        interval:1,
                                        intervalType: 'month'

                                      },
                                      axisY:{
                                        includeZero: false

                                      },
                                      data: [
                                      {        
                                        type: 'line',
                                        //lineThickness: 3,        
                                        dataPoints: [
                                        { x: new Date(year, 00, 1), y: janUser }
                                        ]
                                      }


                                      ]
                                    });

                                userChart.render();
                                
                                var revenueChart = new CanvasJS.Chart('revenueContainer',
                                {      
                                    title:{
                                        text: 'Revenues'
                                    },
                                    animationEnabled: true,
                                    axisY :{
                                        includeZero: false,
                                        prefix: '€ '
                                    },
                                    toolTip: {
                                        shared: true
                                    },
                                    legend: {
                                        fontSize: 13
                                    },
                                    data: [
                                    {        
                                        type: 'splineArea', 
                                        showInLegend: true,
                                        name: 'Featured Ads',
                                        color: 'rgba(54,158,173,.6)',
                                        dataPoints: [
                                        {x: new Date(year,00, 1), y: janRevenueFeatured}
                                        ]
                                    },
                                    {        
                                        type: 'splineArea', 
                                        showInLegend: true,
                                        name: 'Standard Ads',        
                                        color: 'rgba(134,180,2,.7)',
                                        dataPoints: [
                                        {x: new Date(year,00, 1), y: janRevenueStandard}

                                        ]
                                    },

                                    ]
                                });

                            revenueChart.render();
                            
                            var chart = new CanvasJS.Chart('reportsContainer',
                            {
                                    title:{
                                            text: 'Reports',
                                            verticalAlign: 'top',
                                            horizontalAlign: 'left'
                                    },
                                    animationEnabled: true,
                                    data: [
                                    {        
                                            type: 'doughnut',
                                            startAngle:20,
                                            toolTipContent: '{label}: {y} - <strong>#percent%</strong>',
                                            indexLabel: '{label} #percent%',
                                            dataPoints: [
                                                    {  y: systemFault, label: 'System Fault' },
                                                    {  y: userComplaint, label: 'User Complaint' },
                                                    {  y: bugComplaint, label: 'Bug Complaint' },
                                                    {  y: jobComplaint,  label: 'Job Complaint'},
                                                    {  y: paymentComplaint,  label: 'Payment Complaint'},
                                                    {  y: others,  label: 'Others'}
                                            ]
                                    }
                                    ]
                            });
                            chart.render();
                                }
                     }else if(n == 1)
                     {
                                window.onload = function () {
                                    var chart = new CanvasJS.Chart('chartContainer',
                                    {
                                      theme: 'theme2',
                                      title:{
                                        text: 'Active Ads'
                                      },
                                      animationEnabled: true,
                                      axisX: {
                                        valueFormatString: 'MMM',
                                        interval:1,
                                        intervalType: 'month'

                                      },
                                      axisY:{
                                        includeZero: false

                                      },
                                      data: [
                                      {        
                                        type: 'line',
                                        //lineThickness: 3,        
                                        dataPoints: [
                                        { x: new Date(year, 00, 1), y: jan },
                                        { x: new Date(year, 01, 1), y: feb }
                                        ]
                                      }


                                      ]
                                    });

                                chart.render();
                                
                                    var userChart = new CanvasJS.Chart('activeUserContainer',
                                    {
                                      theme: 'theme2',
                                      title:{
                                        text: 'Active Users'
                                      },
                                      animationEnabled: true,
                                      axisX: {
                                        valueFormatString: 'MMM',
                                        interval:1,
                                        intervalType: 'month'

                                      },
                                      axisY:{
                                        includeZero: false

                                      },
                                      data: [
                                      {        
                                        type: 'line',
                                        //lineThickness: 3,        
                                        dataPoints: [
                                        { x: new Date(year, 00, 1), y: janUser },
                                        { x: new Date(year, 01, 1), y: febUser }
                                        ]
                                      }


                                      ]
                                    });

                                userChart.render();
                                
                                var revenueChart = new CanvasJS.Chart('revenueContainer',
                                {      
                                    title:{
                                        text: 'Revenues'
                                    },
                                    animationEnabled: true,
                                    axisY :{
                                        includeZero: false,
                                        prefix: '€ '
                                    },
                                    toolTip: {
                                        shared: true
                                    },
                                    legend: {
                                        fontSize: 13
                                    },
                                    data: [
                                    {        
                                        type: 'splineArea', 
                                        showInLegend: true,
                                        name: 'Featured Ads',
                                        color: 'rgba(54,158,173,.6)',
                                        dataPoints: [
                                        {x: new Date(year,00, 1), y: janRevenueFeatured},
                                        {x: new Date(year,01, 1), y: febUserRevenueFeatured}
                                        ]
                                    },
                                    {        
                                        type: 'splineArea', 
                                        showInLegend: true,
                                        name: 'Standard Ads',        
                                        color: 'rgba(134,180,2,.7)',
                                        dataPoints: [
                                        {x: new Date(year,00, 1), y: janRevenueStandard},
                                        {x: new Date(year,01, 1), y: febUserRevenueStandard}

                                        ]
                                    },

                                    ]
                                });

                            revenueChart.render();
                            
                            var chart = new CanvasJS.Chart('reportsContainer',
                            {
                                    title:{
                                            text: 'Reports',
                                            verticalAlign: 'top',
                                            horizontalAlign: 'left'
                                    },
                                    animationEnabled: true,
                                    data: [
                                    {        
                                            type: 'doughnut',
                                            startAngle:20,
                                            toolTipContent: '{label}: {y} - <strong>#percent%</strong>',
                                            indexLabel: '{label} #percent%',
                                            dataPoints: [
                                                    {  y: systemFault, label: 'System Fault' },
                                                    {  y: userComplaint, label: 'User Complaint' },
                                                    {  y: bugComplaint, label: 'Bug Complaint' },
                                                    {  y: jobComplaint,  label: 'Job Complaint'},
                                                    {  y: paymentComplaint,  label: 'Payment Complaint'},
                                                    {  y: others,  label: 'Others'}
                                            ]
                                    }
                                    ]
                            });
                            chart.render();
                                }
                     }else if(n == 2)
                     {
                                window.onload = function () {
                                    var chart = new CanvasJS.Chart('chartContainer',
                                    {
                                      theme: 'theme2',
                                      title:{
                                        text: 'Active Ads'
                                      },
                                      animationEnabled: true,
                                      axisX: {
                                        valueFormatString: 'MMM',
                                        interval:1,
                                        intervalType: 'month'

                                      },
                                      axisY:{
                                        includeZero: false

                                      },
                                      data: [
                                      {        
                                        type: 'line',
                                        //lineThickness: 3,        
                                        dataPoints: [
                                        { x: new Date(year, 00, 1), y: jan },
                                        { x: new Date(year, 01, 1), y: feb },
                                        { x: new Date(year, 02, 1), y: mar }
                                        ]
                                      }


                                      ]
                                    });

                                chart.render();
                                
                                    var userChart = new CanvasJS.Chart('activeUserContainer',
                                    {
                                      theme: 'theme2',
                                      title:{
                                        text: 'Active Users'
                                      },
                                      animationEnabled: true,
                                      axisX: {
                                        valueFormatString: 'MMM',
                                        interval:1,
                                        intervalType: 'month'

                                      },
                                      axisY:{
                                        includeZero: false

                                      },
                                      data: [
                                      {        
                                        type: 'line',
                                        //lineThickness: 3,        
                                        dataPoints: [
                                        { x: new Date(year, 00, 1), y: janUser },
                                        { x: new Date(year, 01, 1), y: febUser },
                                        { x: new Date(year, 02, 1), y: marUser }
                                        ]
                                      }


                                      ]
                                    });

                                userChart.render();
                                
                                var revenueChart = new CanvasJS.Chart('revenueContainer',
                                {      
                                    title:{
                                        text: 'Revenues'
                                    },
                                    animationEnabled: true,
                                    axisY :{
                                        includeZero: false,
                                        prefix: '€ '
                                    },
                                    toolTip: {
                                        shared: true
                                    },
                                    legend: {
                                        fontSize: 13
                                    },
                                    data: [
                                    {        
                                        type: 'splineArea', 
                                        showInLegend: true,
                                        name: 'Featured Ads',
                                        color: 'rgba(54,158,173,.6)',
                                        dataPoints: [
                                        {x: new Date(year,00, 1), y: janRevenueFeatured},
                                        {x: new Date(year,01, 1), y: febUserRevenueFeatured},
                                        {x: new Date(year,02, 1), y: marUserRevenueFeatured}
                                        ]
                                    },
                                    {        
                                        type: 'splineArea', 
                                        showInLegend: true,
                                        name: 'Standard Ads',        
                                        color: 'rgba(134,180,2,.7)',
                                        dataPoints: [
                                        {x: new Date(year,00, 1), y: janRevenueStandard},
                                        {x: new Date(year,01, 1), y: febUserRevenueStandard},
                                        {x: new Date(year,02, 1), y: marUserRevenueStandard}

                                        ]
                                    },

                                    ]
                                });

                            revenueChart.render();
                            
                            var chart = new CanvasJS.Chart('reportsContainer',
                            {
                                    title:{
                                            text: 'Reports',
                                            verticalAlign: 'top',
                                            horizontalAlign: 'left'
                                    },
                                    animationEnabled: true,
                                    data: [
                                    {        
                                            type: 'doughnut',
                                            startAngle:20,
                                            toolTipContent: '{label}: {y} - <strong>#percent%</strong>',
                                            indexLabel: '{label} #percent%',
                                            dataPoints: [
                                                    {  y: systemFault, label: 'System Fault' },
                                                    {  y: userComplaint, label: 'User Complaint' },
                                                    {  y: bugComplaint, label: 'Bug Complaint' },
                                                    {  y: jobComplaint,  label: 'Job Complaint'},
                                                    {  y: paymentComplaint,  label: 'Payment Complaint'},
                                                    {  y: others,  label: 'Others'}
                                            ]
                                    }
                                    ]
                            });
                            chart.render();
                                }
                     }else if(n == 3)
                     {
                                window.onload = function () {
                                    var chart = new CanvasJS.Chart('chartContainer',
                                    {
                                      theme: 'theme2',
                                      title:{
                                        text: 'Active Ads'
                                      },
                                      animationEnabled: true,
                                      axisX: {
                                        valueFormatString: 'MMM',
                                        interval:1,
                                        intervalType: 'month'

                                      },
                                      axisY:{
                                        includeZero: false

                                      },
                                      data: [
                                      {        
                                        type: 'line',
                                        //lineThickness: 3,        
                                        dataPoints: [
                                        { x: new Date(year, 00, 1), y: jan },
                                        { x: new Date(year, 01, 1), y: feb },
                                        { x: new Date(year, 02, 1), y: mar },
                                        { x: new Date(year, 03, 1), y: apr }
                                        ]
                                      }


                                      ]
                                    });

                                chart.render();
                                
                                    var userChart = new CanvasJS.Chart('activeUserContainer',
                                    {
                                      theme: 'theme2',
                                      title:{
                                        text: 'Active Users'
                                      },
                                      animationEnabled: true,
                                      axisX: {
                                        valueFormatString: 'MMM',
                                        interval:1,
                                        intervalType: 'month'

                                      },
                                      axisY:{
                                        includeZero: false

                                      },
                                      data: [
                                      {        
                                        type: 'line',
                                        //lineThickness: 3,        
                                        dataPoints: [
                                        { x: new Date(year, 00, 1), y: janUser },
                                        { x: new Date(year, 01, 1), y: febUser },
                                        { x: new Date(year, 02, 1), y: marUser },
                                        { x: new Date(year, 03, 1), y: aprUser }
                                        ]
                                      }


                                      ]
                                    });

                                userChart.render();
                                
                                var revenueChart = new CanvasJS.Chart('revenueContainer',
                                {      
                                    title:{
                                        text: 'Revenues'
                                    },
                                    animationEnabled: true,
                                    axisY :{
                                        includeZero: false,
                                        prefix: '€ '
                                    },
                                    toolTip: {
                                        shared: true
                                    },
                                    legend: {
                                        fontSize: 13
                                    },
                                    data: [
                                    {        
                                        type: 'splineArea', 
                                        showInLegend: true,
                                        name: 'Featured Ads',
                                        color: 'rgba(54,158,173,.6)',
                                        dataPoints: [
                                        {x: new Date(year,00, 1), y: janRevenueFeatured},
                                        {x: new Date(year,01, 1), y: febUserRevenueFeatured},
                                        {x: new Date(year,02, 1), y: marUserRevenueFeatured},
                                        {x: new Date(year,02, 1), y: aprUserRevenueFeatured}
                                        ]
                                    },
                                    {        
                                        type: 'splineArea', 
                                        showInLegend: true,
                                        name: 'Standard Ads',        
                                        color: 'rgba(134,180,2,.7)',
                                        dataPoints: [
                                        {x: new Date(year,00, 1), y: janRevenueStandard},
                                        {x: new Date(year,01, 1), y: febUserRevenueStandard},
                                        {x: new Date(year,02, 1), y: marUserRevenueStandard},
                                        {x: new Date(year,02, 1), y: aprUserRevenueStandard}

                                        ]
                                    },

                                    ]
                                });

                            revenueChart.render();
                            
                            var chart = new CanvasJS.Chart('reportsContainer',
                            {
                                    title:{
                                            text: 'Reports',
                                            verticalAlign: 'top',
                                            horizontalAlign: 'left'
                                    },
                                    animationEnabled: true,
                                    data: [
                                    {        
                                            type: 'doughnut',
                                            startAngle:20,
                                            toolTipContent: '{label}: {y} - <strong>#percent%</strong>',
                                            indexLabel: '{label} #percent%',
                                            dataPoints: [
                                                    {  y: systemFault, label: 'System Fault' },
                                                    {  y: userComplaint, label: 'User Complaint' },
                                                    {  y: bugComplaint, label: 'Bug Complaint' },
                                                    {  y: jobComplaint,  label: 'Job Complaint'},
                                                    {  y: paymentComplaint,  label: 'Payment Complaint'},
                                                    {  y: others,  label: 'Others'}
                                            ]
                                    }
                                    ]
                            });
                            chart.render();
                                }
                     }else if(n == 4)
                     {
                                window.onload = function () {
                                    var chart = new CanvasJS.Chart('chartContainer',
                                    {
                                      theme: 'theme2',
                                      title:{
                                        text: 'Active Ads'
                                      },
                                      animationEnabled: true,
                                      axisX: {
                                        valueFormatString: 'MMM',
                                        interval:1,
                                        intervalType: 'month'

                                      },
                                      axisY:{
                                        includeZero: false

                                      },
                                      data: [
                                      {        
                                        type: 'line',
                                        //lineThickness: 3,        
                                        dataPoints: [
                                        { x: new Date(year, 00, 1), y: jan },
                                        { x: new Date(year, 01, 1), y: feb },
                                        { x: new Date(year, 02, 1), y: mar },
                                        { x: new Date(year, 03, 1), y: apr },
                                        { x: new Date(year, 04, 1), y: may }
                                        ]
                                      }


                                      ]
                                    });

                                chart.render();

                                    var userChart = new CanvasJS.Chart('activeUserContainer',
                                    {
                                      theme: 'theme2',
                                      title:{
                                        text: 'Active Users'
                                      },
                                      animationEnabled: true,
                                      axisX: {
                                        valueFormatString: 'MMM',
                                        interval:1,
                                        intervalType: 'month'

                                      },
                                      axisY:{
                                        includeZero: false

                                      },
                                      data: [
                                      {        
                                        type: 'line',
                                        //lineThickness: 3,        
                                        dataPoints: [
                                        { x: new Date(year, 00, 1), y: janUser },
                                        { x: new Date(year, 01, 1), y: febUser },
                                        { x: new Date(year, 02, 1), y: marUser },
                                        { x: new Date(year, 03, 1), y: aprUser },
                                        { x: new Date(year, 03, 1), y: mayUser }
                                        ]
                                      }


                                      ]
                                    });

                                userChart.render();
                                
                                var revenueChart = new CanvasJS.Chart('revenueContainer',
                                {      
                                    title:{
                                        text: 'Revenues'
                                    },
                                    animationEnabled: true,
                                    axisY :{
                                        includeZero: false,
                                        prefix: '€ '
                                    },
                                    toolTip: {
                                        shared: true
                                    },
                                    legend: {
                                        fontSize: 13
                                    },
                                    data: [
                                    {        
                                        type: 'splineArea', 
                                        showInLegend: true,
                                        name: 'Featured Ads',
                                        color: 'rgba(54,158,173,.6)',
                                        dataPoints: [
                                        {x: new Date(year,00, 1), y: janRevenueFeatured},
                                        {x: new Date(year,01, 1), y: febUserRevenueFeatured},
                                        {x: new Date(year,02, 1), y: marUserRevenueFeatured},
                                        {x: new Date(year,02, 1), y: aprUserRevenueFeatured},
                                        {x: new Date(year,02, 1), y: mayUserRevenueFeatured}
                                        ]
                                    },
                                    {        
                                        type: 'splineArea', 
                                        showInLegend: true,
                                        name: 'Standard Ads',        
                                        color: 'rgba(134,180,2,.7)',
                                        dataPoints: [
                                        {x: new Date(year,00, 1), y: janRevenueStandard},
                                        {x: new Date(year,01, 1), y: febUserRevenueStandard},
                                        {x: new Date(year,02, 1), y: marUserRevenueStandard},
                                        {x: new Date(year,02, 1), y: aprUserRevenueStandard},
                                        {x: new Date(year,02, 1), y: mayUserRevenueStandard}

                                        ]
                                    },

                                    ]
                                });

                            revenueChart.render();
                            
                            var chart = new CanvasJS.Chart('reportsContainer',
                            {
                                    title:{
                                            text: 'Reports',
                                            verticalAlign: 'top',
                                            horizontalAlign: 'left'
                                    },
                                    animationEnabled: true,
                                    data: [
                                    {        
                                            type: 'doughnut',
                                            startAngle:20,
                                            toolTipContent: '{label}: {y} - <strong>#percent%</strong>',
                                            indexLabel: '{label} #percent%',
                                            dataPoints: [
                                                    {  y: systemFault, label: 'System Fault' },
                                                    {  y: userComplaint, label: 'User Complaint' },
                                                    {  y: bugComplaint, label: 'Bug Complaint' },
                                                    {  y: jobComplaint,  label: 'Job Complaint'},
                                                    {  y: paymentComplaint,  label: 'Payment Complaint'},
                                                    {  y: others,  label: 'Others'}
                                            ]
                                    }
                                    ]
                            });
                            chart.render();
                                }
                     }else if(n == 5)
                     {
                                window.onload = function () {
                                    var chart = new CanvasJS.Chart('chartContainer',
                                    {
                                      theme: 'theme2',
                                      title:{
                                        text: 'Active Ads'
                                      },
                                      animationEnabled: true,
                                      axisX: {
                                        valueFormatString: 'MMM',
                                        interval:1,
                                        intervalType: 'month'

                                      },
                                      axisY:{
                                        includeZero: false

                                      },
                                      data: [
                                      {        
                                        type: 'line',
                                        //lineThickness: 3,        
                                        dataPoints: [
                                        { x: new Date(year, 00, 1), y: jan },
                                        { x: new Date(year, 01, 1), y: feb },
                                        { x: new Date(year, 02, 1), y: mar },
                                        { x: new Date(year, 03, 1), y: apr },
                                        { x: new Date(year, 04, 1), y: may },
                                        { x: new Date(year, 05, 1), y: june }
                                        ]
                                      }


                                      ]
                                    });

                                chart.render();
                                
                                    var userChart = new CanvasJS.Chart('activeUserContainer',
                                    {
                                      theme: 'theme2',
                                      title:{
                                        text: 'Active Users'
                                      },
                                      animationEnabled: true,
                                      axisX: {
                                        valueFormatString: 'MMM',
                                        interval:1,
                                        intervalType: 'month'

                                      },
                                      axisY:{
                                        includeZero: false

                                      },
                                      data: [
                                      {        
                                        type: 'line',
                                        //lineThickness: 3,        
                                        dataPoints: [
                                        { x: new Date(year, 00, 1), y: janUser },
                                        { x: new Date(year, 01, 1), y: febUser },
                                        { x: new Date(year, 02, 1), y: marUser },
                                        { x: new Date(year, 03, 1), y: aprUser },
                                        { x: new Date(year, 03, 1), y: mayUser },
                                        { x: new Date(year, 05, 1), y: juneUser }
                                        ]
                                      }


                                      ]
                                    });

                                userChart.render();
                                
                                var revenueChart = new CanvasJS.Chart('revenueContainer',
                                {      
                                    title:{
                                        text: 'Revenues'
                                    },
                                    animationEnabled: true,
                                    axisY :{
                                        includeZero: false,
                                        prefix: '€ '
                                    },
                                    toolTip: {
                                        shared: true
                                    },
                                    legend: {
                                        fontSize: 13
                                    },
                                    data: [
                                    {        
                                        type: 'splineArea', 
                                        showInLegend: true,
                                        name: 'Featured Ads',
                                        color: 'rgba(54,158,173,.6)',
                                        dataPoints: [
                                        {x: new Date(year,00, 1), y: janRevenueFeatured},
                                        {x: new Date(year,01, 1), y: febUserRevenueFeatured},
                                        {x: new Date(year,02, 1), y: marUserRevenueFeatured},
                                        {x: new Date(year,02, 1), y: aprUserRevenueFeatured},
                                        {x: new Date(year,02, 1), y: mayUserRevenueFeatured},
                                        {x: new Date(year,02, 1), y: juneUserRevenueFeatured}
                                        ]
                                    },
                                    {        
                                        type: 'splineArea', 
                                        showInLegend: true,
                                        name: 'Standard Ads',        
                                        color: 'rgba(134,180,2,.7)',
                                        dataPoints: [
                                        {x: new Date(year,00, 1), y: janRevenueStandard},
                                        {x: new Date(year,01, 1), y: febUserRevenueStandard},
                                        {x: new Date(year,02, 1), y: marUserRevenueStandard},
                                        {x: new Date(year,02, 1), y: aprUserRevenueStandard},
                                        {x: new Date(year,02, 1), y: mayUserRevenueStandard},
                                        {x: new Date(year,02, 1), y: juneUserRevenueStandard}

                                        ]
                                    },

                                    ]
                                });

                            revenueChart.render();
                            
                            var chart = new CanvasJS.Chart('reportsContainer',
                            {
                                    title:{
                                            text: 'Reports',
                                            verticalAlign: 'top',
                                            horizontalAlign: 'left'
                                    },
                                    animationEnabled: true,
                                    data: [
                                    {        
                                            type: 'doughnut',
                                            startAngle:20,
                                            toolTipContent: '{label}: {y} - <strong>#percent%</strong>',
                                            indexLabel: '{label} #percent%',
                                            dataPoints: [
                                                    {  y: systemFault, label: 'System Fault' },
                                                    {  y: userComplaint, label: 'User Complaint' },
                                                    {  y: bugComplaint, label: 'Bug Complaint' },
                                                    {  y: jobComplaint,  label: 'Job Complaint'},
                                                    {  y: paymentComplaint,  label: 'Payment Complaint'},
                                                    {  y: others,  label: 'Others'}
                                            ]
                                    }
                                    ]
                            });
                            chart.render();
                                }
                     }else if (n == 6)
                     {
                                window.onload = function () {
                                    var chart = new CanvasJS.Chart('chartContainer',
                                    {
                                      theme: 'theme2',
                                      title:{
                                        text: 'Active Ads'
                                      },
                                      animationEnabled: true,
                                      axisX: {
                                        valueFormatString: 'MMM',
                                        interval:1,
                                        intervalType: 'month'

                                      },
                                      axisY:{
                                        includeZero: false

                                      },
                                      data: [
                                      {        
                                        type: 'line',
                                        //lineThickness: 3,        
                                        dataPoints: [
                                        { x: new Date(year, 00, 1), y: jan },
                                        { x: new Date(year, 01, 1), y: feb },
                                        { x: new Date(year, 02, 1), y: mar },
                                        { x: new Date(year, 03, 1), y: apr },
                                        { x: new Date(year, 04, 1), y: may },
                                        { x: new Date(year, 05, 1), y: june },
                                        { x: new Date(year, 06, 1), y: july }
                                        ]
                                      }


                                      ]
                                    });

                                chart.render();
                                
                                    var userChart = new CanvasJS.Chart('activeUserContainer',
                                    {
                                      theme: 'theme2',
                                      title:{
                                        text: 'Active Users'
                                      },
                                      animationEnabled: true,
                                      axisX: {
                                        valueFormatString: 'MMM',
                                        interval:1,
                                        intervalType: 'month'

                                      },
                                      axisY:{
                                        includeZero: false

                                      },
                                      data: [
                                      {        
                                        type: 'line',
                                        //lineThickness: 3,        
                                        dataPoints: [
                                        { x: new Date(year, 00, 1), y: janUser },
                                        { x: new Date(year, 01, 1), y: febUser },
                                        { x: new Date(year, 02, 1), y: marUser },
                                        { x: new Date(year, 03, 1), y: aprUser },
                                        { x: new Date(year, 03, 1), y: mayUser },
                                        { x: new Date(year, 05, 1), y: juneUser },
                                        { x: new Date(year, 06, 1), y: julyUser }
                                        ]
                                      }


                                      ]
                                    });

                                userChart.render();
                                
                                var revenueChart = new CanvasJS.Chart('revenueContainer',
                                {      
                                    title:{
                                        text: 'Revenues'
                                    },
                                    animationEnabled: true,
                                    axisY :{
                                        includeZero: false,
                                        prefix: '€ '
                                    },
                                    toolTip: {
                                        shared: true
                                    },
                                    legend: {
                                        fontSize: 13
                                    },
                                    data: [
                                    {        
                                        type: 'splineArea', 
                                        showInLegend: true,
                                        name: 'Featured Ads',
                                        color: 'rgba(54,158,173,.6)',
                                        dataPoints: [
                                        {x: new Date(year,00, 1), y: janRevenueFeatured},
                                        {x: new Date(year,01, 1), y: febUserRevenueFeatured},
                                        {x: new Date(year,02, 1), y: marUserRevenueFeatured},
                                        {x: new Date(year,02, 1), y: aprUserRevenueFeatured},
                                        {x: new Date(year,02, 1), y: mayUserRevenueFeatured},
                                        {x: new Date(year,02, 1), y: juneUserRevenueFeatured},
                                        {x: new Date(year,02, 1), y: julyUserRevenueFeatured}
                                        ]
                                    },
                                    {        
                                        type: 'splineArea', 
                                        showInLegend: true,
                                        name: 'Standard Ads',        
                                        color: 'rgba(134,180,2,.7)',
                                        dataPoints: [
                                        {x: new Date(year,00, 1), y: janRevenueStandard},
                                        {x: new Date(year,01, 1), y: febUserRevenueStandard},
                                        {x: new Date(year,02, 1), y: marUserRevenueStandard},
                                        {x: new Date(year,02, 1), y: aprUserRevenueStandard},
                                        {x: new Date(year,02, 1), y: mayUserRevenueStandard},
                                        {x: new Date(year,02, 1), y: juneUserRevenueStandard},
                                        {x: new Date(year,02, 1), y: julyUserRevenueStandard}

                                        ]
                                    },

                                    ]
                                });

                            revenueChart.render();
                            
                            var chart = new CanvasJS.Chart('reportsContainer',
                            {
                                    title:{
                                            text: 'Reports',
                                            verticalAlign: 'top',
                                            horizontalAlign: 'left'
                                    },
                                    animationEnabled: true,
                                    data: [
                                    {        
                                            type: 'doughnut',
                                            startAngle:20,
                                            toolTipContent: '{label}: {y} - <strong>#percent%</strong>',
                                            indexLabel: '{label} #percent%',
                                            dataPoints: [
                                                    {  y: systemFault, label: 'System Fault' },
                                                    {  y: userComplaint, label: 'User Complaint' },
                                                    {  y: bugComplaint, label: 'Bug Complaint' },
                                                    {  y: jobComplaint,  label: 'Job Complaint'},
                                                    {  y: paymentComplaint,  label: 'Payment Complaint'},
                                                    {  y: others,  label: 'Others'}
                                            ]
                                    }
                                    ]
                            });
                            chart.render();
                                }
                     }else if(n == 7)
                     {
                                window.onload = function () {
                                    var chart = new CanvasJS.Chart('chartContainer',
                                    {
                                      theme: 'theme2',
                                      title:{
                                        text: 'Active Ads'
                                      },
                                      animationEnabled: true,
                                      axisX: {
                                        valueFormatString: 'MMM',
                                        interval:1,
                                        intervalType: 'month'

                                      },
                                      axisY:{
                                        includeZero: false

                                      },
                                      data: [
                                      {        
                                        type: 'line',
                                        //lineThickness: 3,        
                                        dataPoints: [
                                        { x: new Date(year, 00, 1), y: jan },
                                        { x: new Date(year, 01, 1), y: feb },
                                        { x: new Date(year, 02, 1), y: mar },
                                        { x: new Date(year, 03, 1), y: apr },
                                        { x: new Date(year, 04, 1), y: may },
                                        { x: new Date(year, 05, 1), y: june },
                                        { x: new Date(year, 06, 1), y: july },
                                        { x: new Date(year, 07, 1), y: aug }
                                        ]
                                      }


                                      ]
                                    });

                                chart.render();
                                
                                    var userChart = new CanvasJS.Chart('activeUserContainer',
                                    {
                                      theme: 'theme2',
                                      title:{
                                        text: 'Active Users'
                                      },
                                      animationEnabled: true,
                                      axisX: {
                                        valueFormatString: 'MMM',
                                        interval:1,
                                        intervalType: 'month'

                                      },
                                      axisY:{
                                        includeZero: false

                                      },
                                      data: [
                                      {        
                                        type: 'line',
                                        //lineThickness: 3,        
                                        dataPoints: [
                                        { x: new Date(year, 00, 1), y: janUser },
                                        { x: new Date(year, 01, 1), y: febUser },
                                        { x: new Date(year, 02, 1), y: marUser },
                                        { x: new Date(year, 03, 1), y: aprUser },
                                        { x: new Date(year, 03, 1), y: mayUser },
                                        { x: new Date(year, 05, 1), y: juneUser },
                                        { x: new Date(year, 06, 1), y: julyUser },
                                        { x: new Date(year, 07, 1), y: augUser }
                                        ]
                                      }


                                      ]
                                    });

                                userChart.render();
                                
                                var revenueChart = new CanvasJS.Chart('revenueContainer',
                                {      
                                    title:{
                                        text: 'Revenues'
                                    },
                                    animationEnabled: true,
                                    axisY :{
                                        includeZero: false,
                                        prefix: '€ '
                                    },
                                    toolTip: {
                                        shared: true
                                    },
                                    legend: {
                                        fontSize: 13
                                    },
                                    data: [
                                    {        
                                        type: 'splineArea', 
                                        showInLegend: true,
                                        name: 'Featured Ads',
                                        color: 'rgba(54,158,173,.6)',
                                        dataPoints: [
                                        {x: new Date(year,00, 1), y: janRevenueFeatured},
                                        {x: new Date(year,01, 1), y: febUserRevenueFeatured},
                                        {x: new Date(year,02, 1), y: marUserRevenueFeatured},
                                        {x: new Date(year,02, 1), y: aprUserRevenueFeatured},
                                        {x: new Date(year,02, 1), y: mayUserRevenueFeatured},
                                        {x: new Date(year,02, 1), y: juneUserRevenueFeatured},
                                        {x: new Date(year,02, 1), y: julyUserRevenueFeatured},
                                        {x: new Date(year,02, 1), y: augUserRevenueFeatured}
                                        ]
                                    },
                                    {        
                                        type: 'splineArea', 
                                        showInLegend: true,
                                        name: 'Standard Ads',        
                                        color: 'rgba(134,180,2,.7)',
                                        dataPoints: [
                                        {x: new Date(year,00, 1), y: janRevenueStandard},
                                        {x: new Date(year,01, 1), y: febUserRevenueStandard},
                                        {x: new Date(year,02, 1), y: marUserRevenueStandard},
                                        {x: new Date(year,02, 1), y: aprUserRevenueStandard},
                                        {x: new Date(year,02, 1), y: mayUserRevenueStandard},
                                        {x: new Date(year,02, 1), y: juneUserRevenueStandard},
                                        {x: new Date(year,02, 1), y: julyUserRevenueStandard},
                                        {x: new Date(year,02, 1), y: augUserRevenueStandard}

                                        ]
                                    },

                                    ]
                                });

                            revenueChart.render();
                            
                            var chart = new CanvasJS.Chart('reportsContainer',
                            {
                                    title:{
                                            text: 'Reports',
                                            verticalAlign: 'top',
                                            horizontalAlign: 'left'
                                    },
                                    animationEnabled: true,
                                    data: [
                                    {        
                                            type: 'doughnut',
                                            startAngle:20,
                                            toolTipContent: '{label}: {y} - <strong>#percent%</strong>',
                                            indexLabel: '{label} #percent%',
                                            dataPoints: [
                                                    {  y: systemFault, label: 'System Fault' },
                                                    {  y: userComplaint, label: 'User Complaint' },
                                                    {  y: bugComplaint, label: 'Bug Complaint' },
                                                    {  y: jobComplaint,  label: 'Job Complaint'},
                                                    {  y: paymentComplaint,  label: 'Payment Complaint'},
                                                    {  y: others,  label: 'Others'}
                                            ]
                                    }
                                    ]
                            });
                            chart.render();
                                }
                     }else if(n == 8)
                     {
                                window.onload = function () {
                                    var chart = new CanvasJS.Chart('chartContainer',
                                    {
                                      theme: 'theme2',
                                      title:{
                                        text: 'Active Ads'
                                      },
                                      animationEnabled: true,
                                      axisX: {
                                        valueFormatString: 'MMM',
                                        interval:1,
                                        intervalType: 'month'

                                      },
                                      axisY:{
                                        includeZero: false

                                      },
                                      data: [
                                      {        
                                        type: 'line',
                                        //lineThickness: 3,        
                                        dataPoints: [
                                        { x: new Date(year, 00, 1), y: jan },
                                        { x: new Date(year, 01, 1), y: feb },
                                        { x: new Date(year, 02, 1), y: mar },
                                        { x: new Date(year, 03, 1), y: apr },
                                        { x: new Date(year, 04, 1), y: may },
                                        { x: new Date(year, 05, 1), y: june },
                                        { x: new Date(year, 06, 1), y: july },
                                        { x: new Date(year, 07, 1), y: aug },
                                        { x: new Date(year, 08, 1), y: sept }
                                        ]
                                      }


                                      ]
                                    });

                                chart.render();
                                
                                    var userChart = new CanvasJS.Chart('activeUserContainer',
                                    {
                                      theme: 'theme2',
                                      title:{
                                        text: 'Active Users'
                                      },
                                      animationEnabled: true,
                                      axisX: {
                                        valueFormatString: 'MMM',
                                        interval:1,
                                        intervalType: 'month'

                                      },
                                      axisY:{
                                        includeZero: false

                                      },
                                      data: [
                                      {        
                                        type: 'line',
                                        //lineThickness: 3,        
                                        dataPoints: [
                                        { x: new Date(year, 00, 1), y: janUser },
                                        { x: new Date(year, 01, 1), y: febUser },
                                        { x: new Date(year, 02, 1), y: marUser },
                                        { x: new Date(year, 03, 1), y: aprUser },
                                        { x: new Date(year, 03, 1), y: mayUser },
                                        { x: new Date(year, 05, 1), y: juneUser },
                                        { x: new Date(year, 06, 1), y: julyUser },
                                        { x: new Date(year, 07, 1), y: augUser },
                                        { x: new Date(year, 08, 1), y: septUser }
                                        ]
                                      }


                                      ]
                                    });

                                userChart.render();
                                
                                var revenueChart = new CanvasJS.Chart('revenueContainer',
                                {      
                                    title:{
                                        text: 'Revenues'
                                    },
                                    animationEnabled: true,
                                    axisY :{
                                        includeZero: false,
                                        prefix: '€ '
                                    },
                                    toolTip: {
                                        shared: true
                                    },
                                    legend: {
                                        fontSize: 13
                                    },
                                    data: [
                                    {        
                                        type: 'splineArea', 
                                        showInLegend: true,
                                        name: 'Featured Ads',
                                        color: 'rgba(54,158,173,.6)',
                                        dataPoints: [
                                        {x: new Date(year,00, 1), y: janRevenueFeatured},
                                        {x: new Date(year,01, 1), y: febUserRevenueFeatured},
                                        {x: new Date(year,02, 1), y: marUserRevenueFeatured},
                                        {x: new Date(year,02, 1), y: aprUserRevenueFeatured},
                                        {x: new Date(year,02, 1), y: mayUserRevenueFeatured},
                                        {x: new Date(year,02, 1), y: juneUserRevenueFeatured},
                                        {x: new Date(year,02, 1), y: julyUserRevenueFeatured},
                                        {x: new Date(year,02, 1), y: augUserRevenueFeatured},
                                        {x: new Date(year,02, 1), y: septUserRevenueFeatured}
                                        ]
                                    },
                                    {        
                                        type: 'splineArea', 
                                        showInLegend: true,
                                        name: 'Standard Ads',        
                                        color: 'rgba(134,180,2,.7)',
                                        dataPoints: [
                                        {x: new Date(year,00, 1), y: janRevenueStandard},
                                        {x: new Date(year,01, 1), y: febUserRevenueStandard},
                                        {x: new Date(year,02, 1), y: marUserRevenueStandard},
                                        {x: new Date(year,02, 1), y: aprUserRevenueStandard},
                                        {x: new Date(year,02, 1), y: mayUserRevenueStandard},
                                        {x: new Date(year,02, 1), y: juneUserRevenueStandard},
                                        {x: new Date(year,02, 1), y: julyUserRevenueStandard},
                                        {x: new Date(year,02, 1), y: augUserRevenueStandard},
                                        {x: new Date(year,02, 1), y: septUserRevenueStandard}

                                        ]
                                    },

                                    ]
                                });

                            revenueChart.render();
                            
                            var chart = new CanvasJS.Chart('reportsContainer',
                            {
                                    title:{
                                            text: 'Reports',
                                            verticalAlign: 'top',
                                            horizontalAlign: 'left'
                                    },
                                    animationEnabled: true,
                                    data: [
                                    {        
                                            type: 'doughnut',
                                            startAngle:20,
                                            toolTipContent: '{label}: {y} - <strong>#percent%</strong>',
                                            indexLabel: '{label} #percent%',
                                            dataPoints: [
                                                    {  y: systemFault, label: 'System Fault' },
                                                    {  y: userComplaint, label: 'User Complaint' },
                                                    {  y: bugComplaint, label: 'Bug Complaint' },
                                                    {  y: jobComplaint,  label: 'Job Complaint'},
                                                    {  y: paymentComplaint,  label: 'Payment Complaint'},
                                                    {  y: others,  label: 'Others'}
                                            ]
                                    }
                                    ]
                            });
                            chart.render();
                                }
                     }else if(n == 9)
                     {
                                window.onload = function () {
                                    var chart = new CanvasJS.Chart('chartContainer',
                                    {
                                      theme: 'theme2',
                                      title:{
                                        text: 'Active Ads'
                                      },
                                      animationEnabled: true,
                                      axisX: {
                                        valueFormatString: 'MMM',
                                        interval:1,
                                        intervalType: 'month'

                                      },
                                      axisY:{
                                        includeZero: false

                                      },
                                      data: [
                                      {        
                                        type: 'line',
                                        //lineThickness: 3,        
                                        dataPoints: [
                                        { x: new Date(year, 00, 1), y: jan },
                                        { x: new Date(year, 01, 1), y: feb },
                                        { x: new Date(year, 02, 1), y: mar },
                                        { x: new Date(year, 03, 1), y: apr },
                                        { x: new Date(year, 04, 1), y: may },
                                        { x: new Date(year, 05, 1), y: june },
                                        { x: new Date(year, 06, 1), y: july },
                                        { x: new Date(year, 07, 1), y: aug },
                                        { x: new Date(year, 08, 1), y: sept },
                                        { x: new Date(year, 09, 1), y: oct }
                                        ]
                                      }


                                      ]
                                    });

                                chart.render();
                                
                                    var userChart = new CanvasJS.Chart('activeUserContainer',
                                    {
                                      theme: 'theme2',
                                      title:{
                                        text: 'Active Users'
                                      },
                                      animationEnabled: true,
                                      axisX: {
                                        valueFormatString: 'MMM',
                                        interval:1,
                                        intervalType: 'month'

                                      },
                                      axisY:{
                                        includeZero: false

                                      },
                                      data: [
                                      {        
                                        type: 'line',
                                        //lineThickness: 3,        
                                        dataPoints: [
                                        { x: new Date(year, 00, 1), y: janUser },
                                        { x: new Date(year, 01, 1), y: febUser },
                                        { x: new Date(year, 02, 1), y: marUser },
                                        { x: new Date(year, 03, 1), y: aprUser },
                                        { x: new Date(year, 03, 1), y: mayUser },
                                        { x: new Date(year, 05, 1), y: juneUser },
                                        { x: new Date(year, 06, 1), y: julyUser },
                                        { x: new Date(year, 07, 1), y: augUser },
                                        { x: new Date(year, 08, 1), y: septUser },
                                        { x: new Date(year, 09, 1), y: octUser }
                                        ]
                                      }


                                      ]
                                    });

                                userChart.render();
                                
                                var revenueChart = new CanvasJS.Chart('revenueContainer',
                                {      
                                    title:{
                                        text: 'Revenues'
                                    },
                                    animationEnabled: true,
                                    axisY :{
                                        includeZero: false,
                                        prefix: '€ '
                                    },
                                    toolTip: {
                                        shared: true
                                    },
                                    legend: {
                                        fontSize: 13
                                    },
                                    data: [
                                    {        
                                        type: 'splineArea', 
                                        showInLegend: true,
                                        name: 'Featured Ads',
                                        color: 'rgba(54,158,173,.6)',
                                        dataPoints: [
                                        {x: new Date(year,00, 1), y: janRevenueFeatured},
                                        {x: new Date(year,01, 1), y: febUserRevenueFeatured},
                                        {x: new Date(year,02, 1), y: marUserRevenueFeatured},
                                        {x: new Date(year,02, 1), y: aprUserRevenueFeatured},
                                        {x: new Date(year,02, 1), y: mayUserRevenueFeatured},
                                        {x: new Date(year,02, 1), y: juneUserRevenueFeatured},
                                        {x: new Date(year,02, 1), y: julyUserRevenueFeatured},
                                        {x: new Date(year,02, 1), y: augUserRevenueFeatured},
                                        {x: new Date(year,02, 1), y: septUserRevenueFeatured},
                                        {x: new Date(year,02, 1), y: octUserRevenueFeatured}
                                        ]
                                    },
                                    {        
                                        type: 'splineArea', 
                                        showInLegend: true,
                                        name: 'Standard Ads',        
                                        color: 'rgba(134,180,2,.7)',
                                        dataPoints: [
                                        {x: new Date(year,00, 1), y: janRevenueStandard},
                                        {x: new Date(year,01, 1), y: febUserRevenueStandard},
                                        {x: new Date(year,02, 1), y: marUserRevenueStandard},
                                        {x: new Date(year,02, 1), y: aprUserRevenueStandard},
                                        {x: new Date(year,02, 1), y: mayUserRevenueStandard},
                                        {x: new Date(year,02, 1), y: juneUserRevenueStandard},
                                        {x: new Date(year,02, 1), y: julyUserRevenueStandard},
                                        {x: new Date(year,02, 1), y: augUserRevenueStandard},
                                        {x: new Date(year,02, 1), y: septUserRevenueStandard},
                                        {x: new Date(year,02, 1), y: octUserRevenueStandard}

                                        ]
                                    },

                                    ]
                                });

                            revenueChart.render();
                            
                            var chart = new CanvasJS.Chart('reportsContainer',
                            {
                                    title:{
                                            text: 'Reports',
                                            verticalAlign: 'top',
                                            horizontalAlign: 'left'
                                    },
                                    animationEnabled: true,
                                    data: [
                                    {        
                                            type: 'doughnut',
                                            startAngle:20,
                                            toolTipContent: '{label}: {y} - <strong>#percent%</strong>',
                                            indexLabel: '{label} #percent%',
                                            dataPoints: [
                                                    {  y: systemFault, label: 'System Fault' },
                                                    {  y: userComplaint, label: 'User Complaint' },
                                                    {  y: bugComplaint, label: 'Bug Complaint' },
                                                    {  y: jobComplaint,  label: 'Job Complaint'},
                                                    {  y: paymentComplaint,  label: 'Payment Complaint'},
                                                    {  y: others,  label: 'Others'}
                                            ]
                                    }
                                    ]
                            });
                            chart.render();
                                }
                     }else if(n == 10)
                     {
                                window.onload = function () {
                                    var chart = new CanvasJS.Chart('chartContainer',
                                    {
                                      theme: 'theme2',
                                      title:{
                                        text: 'Active Ads'
                                      },
                                      animationEnabled: true,
                                      axisX: {
                                        valueFormatString: 'MMM',
                                        interval:1,
                                        intervalType: 'month'

                                      },
                                      axisY:{
                                        includeZero: false

                                      },
                                      data: [
                                      {        
                                        type: 'line',
                                        //lineThickness: 3,        
                                        dataPoints: [
                                        { x: new Date(year, 00, 1), y: jan },
                                        { x: new Date(year, 01, 1), y: feb },
                                        { x: new Date(year, 02, 1), y: mar },
                                        { x: new Date(year, 03, 1), y: apr },
                                        { x: new Date(year, 04, 1), y: may },
                                        { x: new Date(year, 05, 1), y: june },
                                        { x: new Date(year, 06, 1), y: july },
                                        { x: new Date(year, 07, 1), y: aug },
                                        { x: new Date(year, 08, 1), y: sept },
                                        { x: new Date(year, 09, 1), y: oct },
                                        { x: new Date(year, 10, 1), y: nov }
                                        ]
                                      }


                                      ]
                                    });

                                chart.render();
                                
                                    var userChart = new CanvasJS.Chart('activeUserContainer',
                                    {
                                      theme: 'theme2',
                                      title:{
                                        text: 'Active Users'
                                      },
                                      animationEnabled: true,
                                      axisX: {
                                        valueFormatString: 'MMM',
                                        interval:1,
                                        intervalType: 'month'

                                      },
                                      axisY:{
                                        includeZero: false

                                      },
                                      data: [
                                      {        
                                        type: 'line',
                                        //lineThickness: 3,        
                                        dataPoints: [
                                        { x: new Date(year, 00, 1), y: janUser },
                                        { x: new Date(year, 01, 1), y: febUser },
                                        { x: new Date(year, 02, 1), y: marUser },
                                        { x: new Date(year, 03, 1), y: aprUser },
                                        { x: new Date(year, 03, 1), y: mayUser },
                                        { x: new Date(year, 05, 1), y: juneUser },
                                        { x: new Date(year, 06, 1), y: julyUser },
                                        { x: new Date(year, 07, 1), y: augUser },
                                        { x: new Date(year, 08, 1), y: septUser },
                                        { x: new Date(year, 09, 1), y: octUser },
                                        { x: new Date(year, 10, 1), y: novUser }
                                        ]
                                      }


                                      ]
                                    });

                                userChart.render();
                                
                                var revenueChart = new CanvasJS.Chart('revenueContainer',
                                {      
                                    title:{
                                        text: 'Revenues'
                                    },
                                    animationEnabled: true,
                                    axisY :{
                                        includeZero: false,
                                        prefix: '€ '
                                    },
                                    toolTip: {
                                        shared: true
                                    },
                                    legend: {
                                        fontSize: 13
                                    },
                                    data: [
                                    {        
                                        type: 'splineArea', 
                                        showInLegend: true,
                                        name: 'Featured Ads',
                                        color: 'rgba(54,158,173,.6)',
                                        dataPoints: [
                                        {x: new Date(year,00, 1), y: janRevenueFeatured},
                                        {x: new Date(year,01, 1), y: febUserRevenueFeatured},
                                        {x: new Date(year,02, 1), y: marUserRevenueFeatured},
                                        {x: new Date(year,02, 1), y: aprUserRevenueFeatured},
                                        {x: new Date(year,02, 1), y: mayUserRevenueFeatured},
                                        {x: new Date(year,02, 1), y: juneUserRevenueFeatured},
                                        {x: new Date(year,02, 1), y: julyUserRevenueFeatured},
                                        {x: new Date(year,02, 1), y: augUserRevenueFeatured},
                                        {x: new Date(year,02, 1), y: septUserRevenueFeatured},
                                        {x: new Date(year,02, 1), y: octUserRevenueFeatured},
                                        {x: new Date(year,02, 1), y: novUserRevenueFeatured}
                                        ]
                                    },
                                    {        
                                        type: 'splineArea', 
                                        showInLegend: true,
                                        name: 'Standard Ads',        
                                        color: 'rgba(134,180,2,.7)',
                                        dataPoints: [
                                        {x: new Date(year,00, 1), y: janRevenueStandard},
                                        {x: new Date(year,01, 1), y: febUserRevenueStandard},
                                        {x: new Date(year,02, 1), y: marUserRevenueStandard},
                                        {x: new Date(year,02, 1), y: aprUserRevenueStandard},
                                        {x: new Date(year,02, 1), y: mayUserRevenueStandard},
                                        {x: new Date(year,02, 1), y: juneUserRevenueStandard},
                                        {x: new Date(year,02, 1), y: julyUserRevenueStandard},
                                        {x: new Date(year,02, 1), y: augUserRevenueStandard},
                                        {x: new Date(year,02, 1), y: septUserRevenueStandard},
                                        {x: new Date(year,02, 1), y: octUserRevenueStandard},
                                        {x: new Date(year,02, 1), y: novUserRevenueStandard}

                                        ]
                                    },

                                    ]
                                });

                            revenueChart.render();
                            
                            var chart = new CanvasJS.Chart('reportsContainer',
                            {
                                    title:{
                                            text: 'Reports',
                                            verticalAlign: 'top',
                                            horizontalAlign: 'left'
                                    },
                                    animationEnabled: true,
                                    data: [
                                    {        
                                            type: 'doughnut',
                                            startAngle:20,
                                            toolTipContent: '{label}: {y} - <strong>#percent%</strong>',
                                            indexLabel: '{label} #percent%',
                                            dataPoints: [
                                                    {  y: systemFault, label: 'System Fault' },
                                                    {  y: userComplaint, label: 'User Complaint' },
                                                    {  y: bugComplaint, label: 'Bug Complaint' },
                                                    {  y: jobComplaint,  label: 'Job Complaint'},
                                                    {  y: paymentComplaint,  label: 'Payment Complaint'},
                                                    {  y: others,  label: 'Others'}
                                            ]
                                    }
                                    ]
                            });
                            chart.render();
                                }
                     }else if(n == 11)
                     {
                                window.onload = function () {
                                    var chart = new CanvasJS.Chart('chartContainer',
                                    {
                                      theme: 'theme2',
                                      title:{
                                        text: 'Active Ads'
                                      },
                                      animationEnabled: true,
                                      axisX: {
                                        valueFormatString: 'MMM',
                                        interval:1,
                                        intervalType: 'month'

                                      },
                                      axisY:{
                                        includeZero: false

                                      },
                                      data: [
                                      {        
                                        type: 'line',
                                        //lineThickness: 3,        
                                        dataPoints: [
                                        { x: new Date(year, 00, 1), y: jan },
                                        { x: new Date(year, 01, 1), y: feb },
                                        { x: new Date(year, 02, 1), y: mar },
                                        { x: new Date(year, 03, 1), y: apr },
                                        { x: new Date(year, 04, 1), y: may },
                                        { x: new Date(year, 05, 1), y: june },
                                        { x: new Date(year, 06, 1), y: july },
                                        { x: new Date(year, 07, 1), y: aug },
                                        { x: new Date(year, 08, 1), y: sept },
                                        { x: new Date(year, 09, 1), y: oct },
                                        { x: new Date(year, 10, 1), y: nov },
                                        { x: new Date(year, 11, 1), y: dec }
                                        ]
                                      }


                                      ]
                                    });

                                chart.render();
                                
                                    var userChart = new CanvasJS.Chart('activeUserContainer',
                                    {
                                      theme: 'theme2',
                                      title:{
                                        text: 'Active Users'
                                      },
                                      animationEnabled: true,
                                      axisX: {
                                        valueFormatString: 'MMM',
                                        interval:1,
                                        intervalType: 'month'

                                      },
                                      axisY:{
                                        includeZero: false

                                      },
                                      data: [
                                      {        
                                        type: 'line',
                                        //lineThickness: 3,        
                                        dataPoints: [
                                        { x: new Date(year, 00, 1), y: janUser },
                                        { x: new Date(year, 01, 1), y: febUser },
                                        { x: new Date(year, 02, 1), y: marUser },
                                        { x: new Date(year, 03, 1), y: aprUser },
                                        { x: new Date(year, 03, 1), y: mayUser },
                                        { x: new Date(year, 05, 1), y: juneUser },
                                        { x: new Date(year, 06, 1), y: julyUser },
                                        { x: new Date(year, 07, 1), y: augUser },
                                        { x: new Date(year, 08, 1), y: septUser },
                                        { x: new Date(year, 09, 1), y: octUser },
                                        { x: new Date(year, 10, 1), y: novUser },
                                        { x: new Date(year, 11, 1), y: decUser }
                                        ]
                                      }


                                      ]
                                    });

                                userChart.render();
                                
                                var revenueChart = new CanvasJS.Chart('revenueContainer',
                                {      
                                    title:{
                                        text: 'Revenues'
                                    },
                                    animationEnabled: true,
                                    axisY :{
                                        includeZero: false,
                                        prefix: '€ '
                                    },
                                    toolTip: {
                                        shared: true
                                    },
                                    legend: {
                                        fontSize: 13
                                    },
                                    data: [
                                    {        
                                        type: 'splineArea', 
                                        showInLegend: true,
                                        name: 'Featured Ads',
                                        color: 'rgba(54,158,173,.6)',
                                        dataPoints: [
                                        {x: new Date(year,00, 1), y: janRevenueFeatured},
                                        {x: new Date(year,01, 1), y: febUserRevenueFeatured},
                                        {x: new Date(year,02, 1), y: marUserRevenueFeatured},
                                        {x: new Date(year,02, 1), y: aprUserRevenueFeatured},
                                        {x: new Date(year,02, 1), y: mayUserRevenueFeatured},
                                        {x: new Date(year,02, 1), y: juneUserRevenueFeatured},
                                        {x: new Date(year,02, 1), y: julyUserRevenueFeatured},
                                        {x: new Date(year,02, 1), y: augUserRevenueFeatured},
                                        {x: new Date(year,02, 1), y: septUserRevenueFeatured},
                                        {x: new Date(year,02, 1), y: octUserRevenueFeatured},
                                        {x: new Date(year,02, 1), y: novUserRevenueFeatured},
                                        {x: new Date(year,02, 1), y: decRevenueFeatured},
                                        ]
                                    },
                                    {        
                                        type: 'splineArea', 
                                        showInLegend: true,
                                        name: 'Standard Ads',        
                                        color: 'rgba(134,180,2,.7)',
                                        dataPoints: [
                                        {x: new Date(year,00, 1), y: janRevenueStandard},
                                        {x: new Date(year,01, 1), y: febUserRevenueStandard},
                                        {x: new Date(year,02, 1), y: marUserRevenueStandard},
                                        {x: new Date(year,02, 1), y: aprUserRevenueStandard},
                                        {x: new Date(year,02, 1), y: mayUserRevenueStandard},
                                        {x: new Date(year,02, 1), y: juneUserRevenueStandard},
                                        {x: new Date(year,02, 1), y: julyUserRevenueStandard},
                                        {x: new Date(year,02, 1), y: augUserRevenueStandard},
                                        {x: new Date(year,02, 1), y: septUserRevenueStandard},
                                        {x: new Date(year,02, 1), y: octUserRevenueStandard},
                                        {x: new Date(year,02, 1), y: novUserRevenueStandard},
                                        {x: new Date(year,02, 1), y: decRevenueStandard},

                                        ]
                                    },

                                    ]
                                });

                            revenueChart.render();
                            
                            var chart = new CanvasJS.Chart('reportsContainer',
                            {
                                    title:{
                                            text: 'Reports',
                                            verticalAlign: 'top',
                                            horizontalAlign: 'left'
                                    },
                                    animationEnabled: true,
                                    data: [
                                    {        
                                            type: 'doughnut',
                                            startAngle:20,
                                            toolTipContent: '{label}: {y} - <strong>#percent%</strong>',
                                            indexLabel: '{label} #percent%',
                                            dataPoints: [
                                                    {  y: systemFault, label: 'System Fault' },
                                                    {  y: userComplaint, label: 'User Complaint' },
                                                    {  y: bugComplaint, label: 'Bug Complaint' },
                                                    {  y: jobComplaint,  label: 'Job Complaint'},
                                                    {  y: paymentComplaint,  label: 'Payment Complaint'},
                                                    {  y: others,  label: 'Others'}
                                            ]
                                    }
                                    ]
                            });
                            chart.render();
                                }
                     }"
                . "</script>";
        return $result;
    }
    
     //Get All Job Addresses.
    function GetJobAddresses()
    {
         $jobModel = new JobModel();
         return $jobModel->GetJobAddresses();
    }
    
     //Get All Job Names.
    function GetJobNames()
    {
        $jobModel = new JobModel();
        return $jobModel->GetJobNames();
    }
    
     //Get All Job Ids.
    function GetJobIds()
    {
        $jobModel = new JobModel();
        return $jobModel->GetJobIds(); 
    }
    
     //Get All Descriptions.
    function GetJobDescription()
    {
        $jobModel = new JobModel();
        return $jobModel->GetJobDescription();   
    }    
    function MapSearchContent()
    {
        $jobModel = new JobModel();
        
        $typeModel = new TypeModel();
        
        $allCategories = $typeModel->GetTypes();
        
        $alljobsaddress = $jobModel->GetJobAddresses();
        // Convert PHP Array to JSON Array.
        $alljobsaddress = json_encode($alljobsaddress);
        
        $allJobNames = $jobModel->GetJobNames();
        // Convert PHP Array to JSON Array.
        $allJobNames = json_encode($allJobNames);
        
        $allJobId = $jobModel->GetJobIds();
        // Convert PHP Array to JSON Array.
        $allJobId = json_encode($allJobId);
        
        $allJobDescriptions = $jobModel->GetJobDescription();
        // Convert PHP Array to JSON Array.
        $allJobDescriptions = json_encode($allJobDescriptions);
        $result = "<div class='row'>"
                . "<p style='background-color:white; text-align:center; font-size:23px;'>Map Search</p>"
                . "<a href='#' data-toggle='modal' id='placeAnOfferButton' style='margin-bottom:8px;' class='btn btn-success col-xs-6 col-xs-offset-3 col-sm-6 col-sm-offset-3 col-md-6 col-md-offset-3' data-target='#placeAnOfferModal'>
                            <i class='glyphicon glyphicon-filter'></i>
                            Filter </a>"
                . "</div>"
                . "<div class='row'>"
                . "<div id='map' style='height:420px;'></div>"
                . "</div>"
. "<script>
    var geocoder;
    var map;
    // Initialize the address with a JSON object array to contain list of Geolocation address.
    var address = $alljobsaddress;
    var jobIds = $allJobId;
    var jobDescriptions = $allJobDescriptions;
    var des;
    var pos;
    var index = address.length;
    var markers;
  // Initialize the map
  function initMap() {
      
    geocoder = new google.maps.Geocoder();
    var latlng = new google.maps.LatLng(-34.397, 150.644);
    var mapOptions = {
      zoom: 6,
      center: latlng,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    map = new google.maps.Map(document.getElementById('map'), mapOptions);
    codeAddress();
  }
    // A JSON Array Where the locations are stored
      var locations = [
      ]
    
    // A JSON Array containing names of Jobs
    var infowindowsNames = $allJobNames;
    
  // Method that contains a Geocoder to convert an address into Geolocation.
  function codeAddress() {
    for (i in address)
    {
         console.log(address[i]);

        geocoder.geocode( { 'address': address[i]}, function(results, status) {
          if (status == google.maps.GeocoderStatus.OK) {
            des = results[0].geometry.location;

            // Add A New Item
            locations.push(
                {lat: des.lat(), lng: des.lng()}
            );

            map.setCenter(new google.maps.LatLng(53.514257, -7.914886)); 

            // Create an array of alphabetical characters used to label the markers.
            var labels = 'J';

            // Add some markers to the map.
            // Note: The code uses the JavaScript Array.prototype.map() method to
            // create an array of markers based on a given locations array.
            // The map() method here has nothing to do with the Google Maps API.

            markers = locations.map(function(location, i) {
              return new google.maps.Marker({
                position: location,
                label: labels[i % labels.length],
                title:'Job'
              });
            });
            // Add a marker clusterer to manage the markers.
            var markerCluster = new MarkerClusterer(map, markers,
                {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});
            
           // alert('Index: ' + index + ' ' + 'Locations: ' + locations.length);

            if (index == locations.length)
            {
                for (var i = 0; i < markers.length; i++) {
                ( function(i){
                    var marker = markers[i];
                    var infowindow = null;

                     /* now inside your initialise function */
                     infowindow = new google.maps.InfoWindow({
                     content: '<p style=".'font-size:20px;'."><a href=ViewJob.php?epr=view&jobid=' + jobIds[i] + '>' + infowindowsNames[i] + '</a></p>' +
                              '<p style=".'font-size:14px;'.">Description:</p>' +
                              '<p style=".'font-size:14px;'.">' + jobDescriptions[i] + '</p>'
                     });
                     
                google.maps.event.addListener(marker, 'click', function() {
                  infowindow.open(map,this);
                });
                })(i);
              }
            }

          } else {  
          this.index = this.index - 1;
        }
      });
    }

  }
    </script>
    <script async defer
        src='https://maps.googleapis.com/maps/api/js?key=AIzaSyDn-XDOkmKcNjVjNbgRIP41yIjE-ZS7-Sk&callback=initMap'>
    </script>
    
    <script src='https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js'>
    </script>";
                
        return $result;
    }
    
    function CheckUser($username)
    {
        
        $userModel = new UserModel();
        
        return $userModel->CheckUser($username);
    }
    
    function GetUserByJobId($id)
    {
        $jobController = $this->GetJobsByID($id);
        
        $userModel = new UserModel();
        
        return $userModel->GetUserById($jobController->id);
    }
    
    function CategoryModal()
    {
        $typeModel = new TypeModel();
        
                $result = "<div class='modal fade col-xs-11' id='myModal' role='dialog'>
			<div class='modal-dialog'>
			
			  <!-- Modal content-->
			  <div class='modal-content'>
				<div class='modal-header'>
				  <button type='button' class='close' data-dismiss='modal'>&times;</button>
				  <h4 class='modal-title'>List Of Categories</h4>
				</div>
				<div class='modal-body scrollitY'>
                                <div class='row'>
                                    <ul class='nav col-md-12 col-xs-12' style='text-align:center;'>";
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
    
    function AdminCategoryModal()
    {
        $typeModel = new TypeModel();
        
                $result = "<div class='modal fade col-xs-11' id='adminCategoryModal' role='dialog'>
			<div class='modal-dialog'>
			
			  <!-- Modal content-->
			  <div class='modal-content'>
				<div class='modal-header'>
				  <button type='button' class='close' data-dismiss='modal'>&times;</button>
				  <h4 class='modal-title'>List Of Categories</h4>
				</div>
				<div class='modal-body scrollitY'>
                                <div class='row'>
                                    <ul class='nav col-md-12 col-xs-12' style='text-align:center;'>";
                                        try
                                        {
                                            $types = $typeModel->GetTypes();
                                            foreach($types as $row)
                                            {
                                                $result.= "<li class='active'>
                                            <a href='Home.php?epr=AdminCat&id=".$row->typeId."'>
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
                $result = "<div class='modal fade col-xs-11' id='priceModal' role='dialog'>
			<div class='modal-dialog'>
			
			  <!-- Modal content-->
			  <div class='modal-content col-md-8 col-sm-8'>
				<div class='modal-header'>
				  <button type='button' class='close' data-dismiss='modal'>&times;</button>
				  <h4 class='modal-title'>Search By Price</h4>
				</div>
				<div class='modal-body'>
                                        <form action='' method = 'POST'>
                                          <fieldset>
                                            <div class='row' style='padding-bottom:10px;'>
                                                <input type='text' name = 'min' id='min' style='width:50%;' class='col-md-6 col-sm-6 col-xs-6'placeholder='max' required autofocus>
                                                <input type='text' name = 'max' id='max' style='width:50%;' class='col-md-6 col-sm-6 col-xs-6'  placeholder='max' required autofocus>
                                            </div>
                                            <div class='row'>
                                            <button class='btn btn-info col-xs-4 col-xs-offset-8 col-sm-4 col-sm-offset-8 col-md-4 col-md-offset-8' name = 'searchByPrice' type='submit'>Search</button>
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
    
    function AdminPriceModal()
    {
                $result = "<div class='modal fade col-xs-11' id='AdminPriceModal' role='dialog'>
			<div class='modal-dialog'>
			
			  <!-- Modal content-->
			  <div class='modal-content col-md-8 col-sm-8'>
				<div class='modal-header'>
				  <button type='button' class='close' data-dismiss='modal'>&times;</button>
				  <h4 class='modal-title'>Search By Price</h4>
				</div>
				<div class='modal-body'>
                                        <form action='' method = 'POST'>
                                          <fieldset>
                                            <div class='row' style='padding-bottom:10px;'>
                                                <input type='text' name = 'min' id='min' style='width:50%;' class='col-md-6 col-sm-6 col-xs-6'placeholder='max' required autofocus>
                                                <input type='text' name = 'max' id='max' style='width:50%;' class='col-md-6 col-sm-6 col-xs-6'  placeholder='max' required autofocus>
                                            </div>
                                            <div class='row'>
                                            <button class='btn btn-info col-xs-4 col-xs-offset-8 col-sm-4 col-sm-offset-8 col-md-4 col-md-offset-8' name = 'AdminSearchByPrice' type='submit'>Search</button>
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
    
   // View to display user profile sidebar
    function ViewUserProfileSideBar($id)
    {
        $userModel = new UserModel();
        
        $user = $userModel->GetUserById($id);
        $followingModel = new FollowingModel();
        $followed = $followingModel->CheckIfUserAlreadyFollowedAnotherUser($_SESSION['id'], $user->id);
                
        $result = "<div class='col-md-12'>
			<div class='profile-sidebar'>
				<!-- SIDEBAR USERPIC -->
				<div class='profile-userpic'>
					<img src='$user->photo' class='img-responsive' alt=''>
				</div>
				<!-- END SIDEBAR USERPIC -->
				<!-- SIDEBAR USER TITLE -->
				<div class='profile-usertitle'>
					<div class='profile-usertitle-name'>
						$user->username
					</div>
				</div>
				<!-- END SIDEBAR USER TITLE -->
				<!-- SIDEBAR BUTTONS -->
				<div class='profile-userbuttons'>";
                                    if($followed != NULL)
                                    {
                                        $result.= "<a href='Following.php?epr=unfollowfromjobposted&followinguserId=$user->id' style='margin-bottom:10px;' class='btn btn-success btn-sm'>
                                        Un-Follow </a>";
                                    }else
                                    {
                                        $result.= "<a href='Following.php?epr=followfromjobposted&followinguserId=$user->id' style='margin-bottom:10px;' class='btn btn-success btn-sm'>
                                        Follow </a>";
                                    }
                                        
                                        $result.= "<div class='row'>
                                            <a href='#' data-toggle='modal' class='btn btn-success btn-sm' data-target='#sendMessageModal' onclick='$(#sendMessageModal).modal({backdrop: static});'>
                                            Message </a>
                                        </div>
				</div>
				<!-- END SIDEBAR BUTTONS -->
				<!-- SIDEBAR MENU -->
				<div class='profile-usermenu'>
					<ul class='nav'>
						<li>
							<a href='ViewUserProfile.php?epr=view&id=".$id."' style='text-align:center;'>
							<i class='glyphicon glyphicon-user'></i>
							Overview </a>
						</li>
						<li class='active'>
							<a href='#' style='text-align:center;'>
							<i class='glyphicon glyphicon-list'></i>
							Jobs Posted </a>
						</li>
						<li>
							<a href='UserReview.php?epr=review&id=".$id."' style='text-align:center;'>
							<i class='glyphicon glyphicon-comment'></i>
							Review </a>
						</li>
						<li>
							<a href='ReportUser.php?epr=reportuser&id=".$id."' target='_blank' style='text-align:center;'>
							<i class='glyphicon glyphicon-flag'></i>
							Report </a>
						</li>
					</ul>
				</div>
				<!-- END MENU -->
			</div>
		</div>";
                
        return $result;
    } 
   
    function CreateHomeSideBar()
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
                                                                                    <li class='active'>
                                                                                            <a href='Home.php' style='text-align:center;'>
                                                                                            <i class='glyphicon glyphicon-home'></i>
                                                                                            Home </a>
                                                                                    </li>
                                                                                    <li>
                                                                                            <a href='Search.php' style='text-align:center;'>
                                                                                            <i class='glyphicon glyphicon-search'></i>
                                                                                            Search </a>
                                                                                    </li>
                                                                                    <li>
                                                                                            <a href='#' data-toggle='modal' data-target='#myModal' style='text-align:center;'>
                                                                                            <i class='glyphicon glyphicon-book'></i>
                                                                                            Categories </a>
                                                                                    </li>
                                                                                    <li>
                                                                                            <a href='#' data-toggle='modal' data-target='#priceModal' style='text-align:center;'>
                                                                                            <i class='glyphicon glyphicon-usd'></i>
                                                                                            Price </a>
                                                                                    </li>
                                                                                    <li>
                                                                                            <a href='SearchResult.php?epr=myJobs' style='text-align:center;'>
                                                                                            <i class='gglyphicon glyphicon-pencil'></i>
                                                                                            My Jobs </a>
                                                                                    </li>
                                                                                    <li>
                                                                                            <a href='JobsOverview.php' style='text-align:center;'>
                                                                                            <i class='glyphicon glyphicon-pencil'></i>
                                                                                            Job Offers </a>
                                                                                    </li>
                                                                                    <li>
                                                                                            <a href='FavoriteJobs.php' style='text-align:center;'>
                                                                                            <i class='glyphicon glyphicon-heart'></i>
                                                                                            Favorite </a>
                                                                                    </li>
                                                                                    <li>
                                                                                            <a href='#' target='_blank' style='text-align:center;'>
                                                                                            <i class='glyphicon glyphicon-italic'></i>
                                                                                            About Us </a>
                                                                                    </li>
                                                                                    <li>
                                                                                            <a href='#' target='_blank' style='text-align:center;'>
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
               // . "<div class='row'>"
               // . "     <a href='Report.php' class='glyphicon glyphicon-exclamation-sign col-xs-12 col-md-12 col-sm-12' style='text-align:center;'>Report</a>"
              //  . "</div>";
       
                
        return $result;
    }
    
    function CreateAdminHomeSideBar()
    {
        require_once 'Model/MessagesModel.php';
        $messagesModel = new MessagesModel();
        $myMessages = $messagesModel->CountAllMyMessages($_SESSION['username']);
        
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
                                                                                    <li class='active'>
                                                                                            <a href='Home.php' style='text-align:center;'>
                                                                                            <i class='glyphicon glyphicon-home'></i>
                                                                                            Home </a>
                                                                                    </li>";
                                                                                if($myMessages != null)
                                                                                {
                                                                                    $result.="<li>
                                                                                            <a href='Messages.php' style='text-align:center;'>
                                                                                            <i class='glyphicon glyphicon-envelope'></i>
                                                                                             Inbox &nbsp<span class='badge'>$myMessages</span></a>
                                                                                    </li>";
                                                                                }else
                                                                                {
                                                                                    $result.="<li>
                                                                                            <a href='Messages.php' style='text-align:center;'>
                                                                                            <i class='glyphicon glyphicon-envelope'></i>
                                                                                             Inbox</a>
                                                                                    </li>";
                                                                                }
                                                                                    $result.="<li>
                                                                                            <a href='JobAdmin.php' style='text-align:center;'>
                                                                                            <i class='glyphicon glyphicon-wrench'></i>
                                                                                            Job </a>
                                                                                    </li>
                                                                                    <li>
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
    
    function CreateAdminJobSideBar()
    {
        require 'Model/MessagesModel.php';
        $messagesModel = new MessagesModel();
        $myMessages = $messagesModel->CountAllMyMessages($_SESSION['username']);
        
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
                                                                                    </li>";
                                                                                    if($myMessages != null)
                                                                                    {
                                                                                            $result.="<li>
                                                                                                            <a href='Messages.php' style='text-align:center;'>
                                                                                                            <i class='glyphicon glyphicon-envelope'></i>
                                                                                                             Inbox &nbsp<span class='badge'>$myMessages</span></a>
                                                                                            </li>";
                                                                                    }else
                                                                                    {
                                                                                            $result.="<li>
                                                                                                            <a href='Messages.php' style='text-align:center;'>
                                                                                                            <i class='glyphicon glyphicon-envelope'></i>
                                                                                                             Inbox</a>
                                                                                            </li>";
                                                                                    }
                                                                                    $result.="<li class='active'>
                                                                                            <a href='JobAdmin.php' style='text-align:center;'>
                                                                                            <i class='glyphicon glyphicon-wrench'></i>
                                                                                            Job </a>
                                                                                    </li>
                                                                                    <li>
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
    
    function AdminJobContent()
    {
        $result = "<div class='row'>
            <div class='panel-group col-md-6'>
			  <div class='panel panel-default'>
					<div class='panel-heading' style='text-align:center;'>
					<a data-toggle='collapse' data-parent='#accordion' href='#collapseBrowse' class='glyphicon glyphicon-hand-up'><strong>Browse:</strong></a>
					</div>
					<div id='collapseBrowse' class='panel-collapse collapse in'>
						<div class='panel-body'>"
                                                    . "<div class='row'>
                                                        <a href='SearchResult.php?epr=allJobs' class='col-sm-12 col-xs-12' style='text-align:center;'>
                                                    <i class='glyphicon glyphicon-search'></i>
                                                            View All Jobs </a>
                                                       </div>
                                                        <div class='row'>                            
                                                            <a href='#' data-toggle='modal' class='col-sm-12 col-xs-12'  data-target='#adminCategoryModal' style='text-align:center;'>
                                                            <i class='glyphicon glyphicon-book'></i>
                                                            Categories </a>
                                                        </div>
                                                        <div class='row'>
                                                            <a href='#' data-toggle='modal'  class='col-sm-12 col-xs-12' data-target='#AdminPriceModal' style='text-align:center;'>
                                                            <i class='glyphicon glyphicon-usd'></i>
                                                            Price </a>
                                                        </div>";
                                                
						$result.="</div>"
					."</div>"
                            ."</div>"
                   ."</div>"
                    ."<div class='panel-group col-md-6'>
			  <div class='panel panel-default'>
					<div class='panel-heading' style='text-align:center;'>
					<a data-toggle='collapse' data-parent='#accordion' href='#collapseJobConfig' class='glyphicon glyphicon-hand-up'><strong>Configuration:</strong></a>
					</div>
					<div id='collapseJobConfig' class='panel-collapse collapse in'>
						<div class='panel-body'>
                                                    <div class='row'>
                                                       <a href='AddEditNotificationType.php' class='col-sm-12 col-xs-12' style='text-align:center;'>
                                                    <i class='glyphicon glyphicon-upload'></i>
                                                            Add / Edit Job Notification Type </a>
                                                    </div>"
                                                    . "<div class='row'>
                                                        <a href='AddEditQualification.php' class='col-sm-12 col-xs-12' style='text-align:center;'>
                                                    <i class='glyphicon glyphicon-upload'></i>
                                                            Add / Edit Job Qualification </a>
                                                       </div>
                                                    <div class='row'>
                                                       <a href='AddEditType.php' class='col-sm-12 col-xs-12' style='text-align:center;'>
                                                    <i class='glyphicon glyphicon-upload'></i>
                                                            Add / Edit Job Category </a>
                                                    </div>
                                                    <div class='row'>
                                                       <a href='AddEditCounty.php' class='col-sm-12 col-xs-12' style='text-align:center;'>
                                                    <i class='glyphicon glyphicon-upload'></i>
                                                            Add / Edit Job County </a>
                                                    </div>"
						."</div>"
					."</div>"
                            ."</div>"
                   ."</div>"
              . "</div>"
      ."<div class='row'>
            <div class='panel-group col-md-6'>
			  <div class='panel panel-default'>
					<div class='panel-heading' style='text-align:center;'>
					<a data-toggle='collapse' data-parent='#accordion' href='#collapseBrowse' class='glyphicon glyphicon-hand-up'><strong>Job Offers:</strong></a>
					</div>
					<div id='collapseBrowse' class='panel-collapse collapse in'>
						<div class='panel-body'>"
                                                    . "<div class='row'>
                                                            <a href='AdminPlacedOffers.php' class='col-sm-12 col-xs-12' style='text-align:center;'>
                                                            <i class='glyphicon glyphicon-flag'></i>
                                                                View All Placed Offers </a>
                                                       </div>
                                                       <div class='row'>
                                                            <a href='AdminPlacedOffers.php?epr=accepted' class='col-sm-12 col-xs-12' style='text-align:center;'>
                                                            <i class='glyphicon glyphicon-ok'></i>
                                                                Accepted Placed Offers </a>
                                                       </div>
                                                       <div class='row'>
                                                            <a href='AdminPlacedOffers.php?epr=denied' class='col-sm-12 col-xs-12' style='text-align:center;'>
                                                            <i class='glyphicon glyphicon-remove'></i>
                                                                Denied Placed Offers </a>
                                                       </div>
                                                       <div class='row'>
                                                            <a href='AdminCancelOfferRequest.php' class='col-sm-12 col-xs-12' style='text-align:center;'>
                                                            <i class='glyphicon glyphicon-trash'></i>
                                                                Offers Cancellation Request </a>
                                                       </div> ";
                                                
						$result.="</div>"
					."</div>"
                            ."</div>"
                   ."</div>"
                    ."<div class='panel-group col-md-6'>
			  <div class='panel panel-default'>
					<div class='panel-heading' style='text-align:center;'>
					<a data-toggle='collapse' data-parent='#accordion' href='#collapseJobConfig' class='glyphicon glyphicon-hand-up'><strong>Payments:</strong></a>
					</div>
					<div id='collapseJobConfig' class='panel-collapse collapse in'>
						<div class='panel-body'>"
                                                    . "<div class='row'>
                                                        <a href='AdminPaymentHistory.php' class='col-sm-12 col-xs-12' style='text-align:center;'>
                                                    <i class='glyphicon glyphicon-euro'></i>
                                                            View Payment History </a>
                                                       </div>
                                                        <div class='row'>
                                                        <a href='AdminUserAttendance.php' class='col-sm-12 col-xs-12' style='text-align:center;'>
                                                    <i class='glyphicon glyphicon-user'></i>
                                                            Job Attendance </a>
                                                       </div>"
						."</div>"
					."</div>"
                            ."</div>"
                   ."</div>"
              . "</div>";

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
					<a data-toggle='collapse' data-parent='#accordion' href='#collapseMyJobsSidebar' class='glyphicon glyphicon glyphicon-th-list'><strong> Menu</strong></a>
					</div>
					<div id='collapseMyJobsSidebar' class='panel-collapse collapse'>
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
                                                                                            <a href='Search.php' style='text-align:center;'>
                                                                                            <i class='glyphicon glyphicon-search'></i>
                                                                                            Search </a>
                                                                                    </li>
                                                                                    <li>
                                                                                            <a href='#' data-toggle='modal' data-target='#myModal' style='text-align:center;'>
                                                                                            <i class='glyphicon glyphicon-book'></i>
                                                                                            Categories </a>
                                                                                    </li>
                                                                                    <li>
                                                                                            <a href='#' data-toggle='modal' data-target='#priceModal' style='text-align:center;'>
                                                                                            <i class='glyphicon glyphicon-usd'></i>
                                                                                            Price </a>
                                                                                    </li>
                                                                                    <li>
                                                                                            <a href='SearchResult.php?epr=myJobs' style='text-align:center;'>
                                                                                            <i class='gglyphicon glyphicon-pencil'></i>
                                                                                            My Jobs </a>
                                                                                    </li>
                                                                                    <li>
                                                                                            <a href='JobsOverview.php' style='text-align:center;'>
                                                                                            <i class='glyphicon glyphicon-usd'></i>
                                                                                            Job Offers </a>
                                                                                    </li>
                                                                                    <li>
                                                                                            <a href='FavoriteJobs.php' style='text-align:center;'>
                                                                                            <i class='glyphicon glyphicon-save'></i>
                                                                                            Favorite </a>
                                                                                    </li>
                                                                                    <li>
                                                                                            <a href='#' data-toggle='modal' data-target='#aboutFreelanceMeModal' style='text-align:center;'>
                                                                                            <i class='glyphicon glyphicon-italic'></i>
                                                                                            About Us </a>
                                                                                    </li>
                                                                                    <li>
                                                                                            <a href='#' target='_blank' style='text-align:center;'>
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
    
    function SearchByCategoryResult($id)
    {
        $jobModel = new JobModel();
        $qualificationModel = new QualificationModel();
        
        $search = $jobModel->GetJobsByCategory($id);
        $count = $jobModel->CountJobsByCategory($id);
        $typeModel = new TypeModel();
        $typeName = $typeModel->GetTypeByID($id)->name;
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
                                                    <div class='row' style='margin-top:10px;'>";
                                                    if($count != NULL)
                                                    {
                                                        
                                                       $result.="<hgroup class='mb20'>
                                                            <h1>Search Results</h1>
                                                            <h2 class='lead'><strong class='text-danger'>$count</strong> results were found for the category <strong class='text-danger'>$typeName</strong></h2>								
                                                        </hgroup>";
                                                    }else
                                                    {
                                                       $result.="<hgroup class='mb20'>
                                                            <h1>Search Results</h1>
                                                            <h2 class='lead'><strong class='text-danger'>0</strong> results were found for the category <strong class='text-danger'>$typeName</strong></h2>								
                                                        </hgroup>"; 
                                                    }
                                                   $result.=" </div>";
                                                    try
                                                    {
                                                        if($search != null)
                                                        {
                                                            foreach($search as $row)
                                                            {       
                                                                $dateT = new DateTime($row->date);
                                                                $dateposted = $dateT->format("d/m/Y");
                                                                
                                                                $timeposted = $dateT->format("H:i");
                                                                if($row->adtype == 1)
                                                                {
                                                                    $result.="<div class='row' style='margin-top:10px;margin-bottom:10px;'>
                                                                        <section class='col-xs-12 col-sm-6 col-md-12'>
                                                                                    <article class='search-result row' style='background-color: #FFFCBB;'>
                                                                                            <div class='col-xs-12 col-sm-12 col-md-3'>
                                                                                                    <a href='SearchResult.php?epr=view&id=".$row->jobid."&typeId=".$row->type."' title='$row->name' class='thumbnail'><img src='Images/AcceptedCards.png' alt='$row->name' /></a>
                                                                                            </div>
                                                                                            <div class='col-xs-12 col-sm-12 col-md-2'>
                                                                                                    <ul class='meta-search'>";
                                                                                                    $var = $row->date;
                                                                                                    if(time() - ((60 * 60 * 24) * 10) >= strtotime($var))
                                                                                                    {
                                                                                                        $result.="<li><i class='glyphicon glyphicon-ok'></i> <span style='color:grey;'><strong>Sponsored</strong></span></li>"
                                                                                                                . "<li><i class='glyphicon glyphicon-calendar'></i> <span>$dateposted</span></li>
                                                                                                                  <li><i class='glyphicon glyphicon-time'></i> <span>$timeposted</span></li>
                                                                                                                  <li><i class='glyphicon glyphicon-tags'></i> <span>$typeName</span></li>";
                                                                                                    }else
                                                                                                    {
                                                                                                        $result.="<li><i class='glyphicon glyphicon-ok'></i> <span style='color:grey;'><strong>Sponsored</strong></span></li>"
                                                                                                                . "<li style='color:red'><strong>New</strong></li>"
                                                                                                                . "<li><i class='glyphicon glyphicon-calendar'></i> <span>$dateposted</span></li>
                                                                                                                  <li><i class='glyphicon glyphicon-time'></i> <span>$timeposted</span></li>
                                                                                                                  <li><i class='glyphicon glyphicon-tags'></i> <span>$typeName</span></li>";
                                                                                                    }
                                                                                                    $result.="</ul>
                                                                                            </div>
                                                                                            <div class='col-xs-12 col-sm-12 col-md-7 excerpet'>
                                                                                                    <h3><a href='SearchResult.php?epr=view&id=".$row->jobid."&typeId=".$row->type."' title=''>$row->name</a></h3>
                                                                                                    <p>$row->description</p>						
                                                                                            </div>
                                                                                            <span class='clearfix borda'></span>
                                                                                    </article>	
                                                                        </section>
                                                                    </div>";
                                                                }
                                                            }
                                                        }
                                                    }catch(Exception $x)
                                                    {
                                                        echo 'Caught exception: ',  $x->getMessage(), "\n";
                                                    }
                                                    
                                                    
                                                    try
                                                    {
                                                        if($search != null)
                                                        {
                                                            foreach($search as $row)
                                                            {       
                                                                $dateT = new DateTime($row->date);
                                                                $dateposted = $dateT->format("d/m/Y");
                                                                
                                                                $timeposted = $dateT->format("H:i");
                                                                if($row->adtype == 0)
                                                                {
                                                                    $result.="<div class='row'>
                                                                        <section class='col-xs-12 col-sm-6 col-md-12'>
                                                                                    <article class='search-result row'>
                                                                                            <div class='col-xs-12 col-sm-12 col-md-3'>
                                                                                                    <a href='SearchResult.php?epr=view&id=".$row->jobid."&typeId=".$row->type."' title='$row->name' class='thumbnail'><img src='Images/AcceptedCards.png' alt='$row->name' /></a>
                                                                                            </div>
                                                                                            <div class='col-xs-12 col-sm-12 col-md-2'>
                                                                                                    <ul class='meta-search'>";
                                                                                                    $var = $row->date;
                                                                                                    if(time() - ((60 * 60 * 24) * 10) >= strtotime($var))
                                                                                                    {
                                                                                                        $result.="<li><i class='glyphicon glyphicon-calendar'></i> <span>$dateposted</span></li>
                                                                                                                  <li><i class='glyphicon glyphicon-time'></i> <span>$timeposted</span></li>
                                                                                                                  <li><i class='glyphicon glyphicon-tags'></i> <span>$typeName</span></li>";
                                                                                                    }else
                                                                                                    {
                                                                                                        $result.="<li style='color:red'><strong>New</strong></li>"
                                                                                                                . "<li><i class='glyphicon glyphicon-calendar'></i> <span>$dateposted</span></li>
                                                                                                                  <li><i class='glyphicon glyphicon-time'></i> <span>$timeposted</span></li>
                                                                                                                  <li><i class='glyphicon glyphicon-tags'></i> <span>$typeName</span></li>";
                                                                                                    }
                                                                                                    $result.="</ul>
                                                                                            </div>
                                                                                            <div class='col-xs-12 col-sm-12 col-md-7 excerpet'>
                                                                                                    <h3><a href='SearchResult.php?epr=view&id=".$row->jobid."&typeId=".$row->type."' title=''>$row->name</a></h3>
                                                                                                    <p>$row->description</p>						
                                                                                            </div>
                                                                                            <span class='clearfix borda'></span>
                                                                                    </article>	
                                                                        </section>
                                                                    </div>";
                                                                }
                                                            }
                                                        }
                                                    }catch(Exception $x)
                                                    {
                                                        echo 'Caught exception: ',  $x->getMessage(), "\n";
                                                    }      
						$result.="</div>"
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
    
    function SearchByQualificationResult($id)
    {
        $jobModel = new JobModel();
        $qualificationModel = new QualificationModel();
        
        $search = $jobModel->GetJobsByQualification($id);

        $count = $jobModel->GetNumberOfJobsPerQualification($id);

        $qualificationName = $qualificationModel->GetQualificationByID($id)->qualificationName;
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
                                                    <div class='row' style='margin-top:10px;'>";
                                                    if($count != NULL)
                                                    {
                                                        
                                                       $result.="<hgroup class='mb20'>
                                                            <h1>Search Results</h1>
                                                            <h2 class='lead'><strong class='text-danger'>$count</strong> results were found for the qualification <strong class='text-danger'>$qualificationName</strong></h2>								
                                                        </hgroup>";
                                                    }else
                                                    {
                                                       $result.="<hgroup class='mb20'>
                                                            <h1>Search Results</h1>
                                                            <h2 class='lead'><strong class='text-danger'>0</strong> results were found for the category <strong class='text-danger'>$qualificationName</strong></h2>								
                                                        </hgroup>"; 
                                                    }
                                                   $result.=" </div>";
                                                    try
                                                    {
                                                        if($search != null)
                                                        {
                                                            foreach($search as $row)
                                                            {       
                                                                $dateT = new DateTime($row->date);
                                                                $dateposted = $dateT->format("d/m/Y");
                                                                
                                                                $timeposted = $dateT->format("H:i");
                                                                
                                                                if($row->adtype == 1)
                                                                {
                                                                    $result.="<div class='row' style='margin-top:10px;margin-bottom:10px;'>
                                                                        <section class='col-xs-12 col-sm-6 col-md-12'>
                                                                                    <article class='search-result row' style='background-color: #FFFCBB;'>
                                                                                            <div class='col-xs-12 col-sm-12 col-md-3'>
                                                                                                    <a href='SearchResult.php?epr=view&id=".$row->jobid."&typeId=".$row->type."' title='$row->name' class='thumbnail'><img src='Images/jobsbanner.jpg' alt='$row->name' /></a>
                                                                                            </div>
                                                                                            <div class='col-xs-12 col-sm-12 col-md-2'>
                                                                                                    <ul class='meta-search'>
                                                                                                            <li><i class='glyphicon glyphicon-ok'></i> <span style='color:grey;'><strong>Sponsored</strong></span></li>
                                                                                                            <li><i class='glyphicon glyphicon-calendar'></i> <span>$dateposted</span></li>
                                                                                                            <li><i class='glyphicon glyphicon-time'></i> <span>$timeposted</span></li>
                                                                                                            <li><i class='glyphicon glyphicon-tags'></i> <span>$qualificationName</span></li>
                                                                                                    </ul>
                                                                                            </div>
                                                                                            <div class='col-xs-12 col-sm-12 col-md-7 excerpet'>
                                                                                                    <h3><a href='SearchResult.php?epr=view&id=".$row->jobid."&typeId=".$row->type."' title=''>$row->name</a></h3>
                                                                                                    <p>$row->description</p>						
                                                                                            </div>
                                                                                            <span class='clearfix borda'></span>
                                                                                    </article>	
                                                                        </section>
                                                                    </div>";
                                                                }
                                                            }
                                                        }
                                                    }catch(Exception $x)
                                                    {
                                                        echo 'Caught exception: ',  $x->getMessage(), "\n";
                                                    }
                                                   
                                                   
                                                    try
                                                    {
                                                        if($search != null)
                                                        {
                                                            foreach($search as $row)
                                                            {       
                                                                $dateT = new DateTime($row->date);
                                                                $dateposted = $dateT->format("d/m/Y");
                                                                
                                                                $timeposted = $dateT->format("H:i");
                                                                $result.="<div class='row'>
                                                                    <section class='col-xs-12 col-sm-6 col-md-12'>
                                                                                <article class='search-result row'>
                                                                                        <div class='col-xs-12 col-sm-12 col-md-3'>
                                                                                                <a href='SearchResult.php?epr=view&id=".$row->jobid."&typeId=".$row->type."' title='$row->name' class='thumbnail'><img src='Images/jobsbanner.jpg' alt='$row->name' /></a>
                                                                                        </div>
                                                                                        <div class='col-xs-12 col-sm-12 col-md-2'>
                                                                                                <ul class='meta-search'>
                                                                                                        <li><i class='glyphicon glyphicon-calendar'></i> <span>$dateposted</span></li>
                                                                                                        <li><i class='glyphicon glyphicon-time'></i> <span>$timeposted</span></li>
                                                                                                        <li><i class='glyphicon glyphicon-tags'></i> <span>$qualificationName</span></li>
                                                                                                </ul>
                                                                                        </div>
                                                                                        <div class='col-xs-12 col-sm-12 col-md-7 excerpet'>
                                                                                                <h3><a href='SearchResult.php?epr=view&id=".$row->jobid."&typeId=".$row->type."' title=''>$row->name</a></h3>
                                                                                                <p>$row->description</p>						
                                                                                        </div>
                                                                                        <span class='clearfix borda'></span>
                                                                                </article>	
                                                                    </section>
                                                                </div>";
                                                            }
                                                        }
                                                    }catch(Exception $x)
                                                    {
                                                        echo 'Caught exception: ',  $x->getMessage(), "\n";
                                                    }
                                                    
						$result.="</div>
						</div>"
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
    
    // Get Jobs By Location
    function GetJobsByLocation($id)
    {
        $jobModel = new JobModel();
        $jobModel->GetJobsByLocation($id);
    }
    
    // Get Number Of Jobs Per Category
    function GetNumberOfJobsPerCategory($id)
    {
        $jobModel = new JobModel();
        $jobModel->GetNumberOfJobsPerCategory($id); 
    }
    
    //Get All Jobs In DB.
    function GetAllJobs()
    {
        $jobModel = new JobModel();
        return $jobModel->GetAllJobs();
    }
    
   function SearchByLocationResult($id)
    {
        $jobModel = new JobModel();
        $countyModel = new CountyModel();
        
        $search = $jobModel->GetJobsByLocation($id);
        $typeModel = new TypeModel();
        
        $count = $jobModel->GetNumberOfJobsPerLocation($id);
        $countyName = $countyModel->GetCountyById($id)->county;
        
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
                                                    <div class='row' style='margin-top:10px;'>";
                                                    if($count != NULL)
                                                    {
                                                        
                                                       $result.="<hgroup class='mb20'>
                                                            <h1>Search Results</h1>
                                                            <h2 class='lead'><strong class='text-danger'>$count</strong> results were found in <strong class='text-danger'>$countyName</strong></h2>								
                                                        </hgroup>";
                                                    }else
                                                    {
                                                       $result.="<hgroup class='mb20'>
                                                            <h1>Search Results</h1>
                                                            <h2 class='lead'><strong class='text-danger'>0</strong> results were found for the category <strong class='text-danger'>$countyName</strong></h2>								
                                                        </hgroup>"; 
                                                    }
                                                   $result.=" </div>";
                                                    try
                                                    {
                                                        if($search != null)
                                                        {
                                                            foreach($search as $row)
                                                            {       
                                                                $dateT = new DateTime($row->date);
                                                                $dateposted = $dateT->format("d/m/Y");
                                                                
                                                                $timeposted = $dateT->format("H:i");
                                                                
                                                                $typeName = $typeModel->GetTypeByID($row->type)->name;
                                                                if($row->adtype == 1)
                                                                {
                                                                    $result.="<div class='row' style='margin-top:10px;margin-bottom:10px;'>
                                                                        <section class='col-xs-12 col-sm-6 col-md-12'>
                                                                                    <article class='search-result row' style='background-color: #FFFCBB;'>
                                                                                            <div class='col-xs-12 col-sm-12 col-md-3'>
                                                                                                    <a href='SearchResult.php?epr=view&id=".$row->jobid."&typeId=".$row->type."' title='$row->name' class='thumbnail'><img src='Images/jobsbanner.jpg' alt='$row->name' /></a>
                                                                                            </div>
                                                                                            <div class='col-xs-12 col-sm-12 col-md-2'>
                                                                                                    <ul class='meta-search'>
                                                                                                            <li><i class='glyphicon glyphicon-ok'></i> <span style='color:grey;'><strong>Sponsored</strong></span></li>
                                                                                                            <li><i class='glyphicon glyphicon-calendar'></i> <span>$dateposted</span></li>
                                                                                                            <li><i class='glyphicon glyphicon-time'></i> <span>$timeposted</span></li>
                                                                                                            <li><i class='glyphicon glyphicon-tags'></i> <span>$typeName</span></li>
                                                                                                    </ul>
                                                                                            </div>
                                                                                            <div class='col-xs-12 col-sm-12 col-md-7 excerpet'>
                                                                                                    <h3><a href='SearchResult.php?epr=view&id=".$row->jobid."&typeId=".$row->type."' title=''>$row->name</a></h3>
                                                                                                    <p>$row->description</p>						
                                                                                            </div>
                                                                                            <span class='clearfix borda'></span>
                                                                                    </article>	
                                                                        </section>
                                                                    </div>";
                                                                }
                                                            }
                                                        }
                                                    }catch(Exception $x)
                                                    {
                                                        echo 'Caught exception: ',  $x->getMessage(), "\n";
                                                    }
                                                   
                                                    try
                                                    {
                                                        if($search != null)
                                                        {
                                                            foreach($search as $row)
                                                            {       
                                                                $dateT = new DateTime($row->date);
                                                                $dateposted = $dateT->format("d/m/Y");
                                                                
                                                                $timeposted = $dateT->format("H:i");
                                                                
                                                                $typeName = $typeModel->GetTypeByID($row->type)->name;
                                                                
                                                                if($row->adtype == 0)
                                                                {
                                                                    $result.="<div class='row'>
                                                                        <section class='col-xs-12 col-sm-6 col-md-12'>
                                                                                    <article class='search-result row'>
                                                                                            <div class='col-xs-12 col-sm-12 col-md-3'>
                                                                                                    <a href='SearchResult.php?epr=view&id=".$row->jobid."&typeId=".$row->type."' title='$row->name' class='thumbnail'><img src='Images/jobsbanner.jpg' alt='$row->name' /></a>
                                                                                            </div>
                                                                                            <div class='col-xs-12 col-sm-12 col-md-2'>
                                                                                                    <ul class='meta-search'>
                                                                                                            <li><i class='glyphicon glyphicon-calendar'></i> <span>$dateposted</span></li>
                                                                                                            <li><i class='glyphicon glyphicon-time'></i> <span>$timeposted</span></li>
                                                                                                            <li><i class='glyphicon glyphicon-tags'></i> <span>$typeName</span></li>
                                                                                                    </ul>
                                                                                            </div>
                                                                                            <div class='col-xs-12 col-sm-12 col-md-7 excerpet'>
                                                                                                    <h3><a href='SearchResult.php?epr=view&id=".$row->jobid."&typeId=".$row->type."' title=''>$row->name</a></h3>
                                                                                                    <p>$row->description</p>						
                                                                                            </div>
                                                                                            <span class='clearfix borda'></span>
                                                                                    </article>	
                                                                        </section>
                                                                    </div>";
                                                                }
                                                            }
                                                        }
                                                    }catch(Exception $x)
                                                    {
                                                        echo 'Caught exception: ',  $x->getMessage(), "\n";
                                                    }
                                                    
						$result.="</div>
						</div>"
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
    
    //Get Job By Name.
    function CountJobsByName($name)
    {
        $jobModel = new JobModel();
        return $jobModel->CountJobsByName($name);
    }
    
    function SearchResult($name)
    {
        $jobModel = new JobModel();
        
        $search = $jobModel->GetJobsByName($name);
        
        $count = $jobModel->CountJobsByName($name);
        
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
                                                    <div class='row' style='margin-top:10px;'>";
                                                    if($count != NULL)
                                                    {
                                                        
                                                       $result.="<hgroup class='mb20'>
                                                            <h1>Search Results</h1>
                                                            <h2 class='lead'><strong class='text-danger'>$count</strong> results were found for the category <strong class='text-danger'>$name</strong></h2>								
                                                        </hgroup>";
                                                    }else
                                                    {
                                                       $result.="<hgroup class='mb20'>
                                                            <h1>Search Results</h1>
                                                            <h2 class='lead'><strong class='text-danger'>0</strong> results were found for the category <strong class='text-danger'>$name</strong></h2>								
                                                        </hgroup>"; 
                                                    }
                                                   $result.=" </div>";
                                                    try
                                                    {
                                                        if($search != null)
                                                        {
                                                            foreach($search as $row)
                                                            {      
                                                                if($row->adtype == 1)
                                                                {
                                                                    $dateT = new DateTime($row->date);
                                                                    $dateposted = $dateT->format("d/m/Y");

                                                                    $timeposted = $dateT->format("H:i");
                                                                    $result.="<div class='row' style='margin-top:10px;margin-bottom:10px;'>
                                                                        <section class='col-xs-12 col-sm-6 col-md-12'>
                                                                                    <article class='search-result row' style='background-color: #FFFCBB;'>
                                                                                            <div class='col-xs-12 col-sm-12 col-md-3'>
                                                                                                    <a href='SearchResult.php?epr=view&id=".$row->jobid."&typeId=".$row->type."' title='$row->name' class='thumbnail'><img src='Images/jobsbanner.jpg' alt='$row->name' /></a>
                                                                                            </div>
                                                                                            <div class='col-xs-12 col-sm-12 col-md-2'>
                                                                                                    <ul class='meta-search'>
                                                                                                            <li><i class='glyphicon glyphicon-ok'></i> <span style='color:grey;'><strong>Sponsored</strong></span></li>
                                                                                                            <li><i class='glyphicon glyphicon-calendar'></i> <span>$dateposted</span></li>
                                                                                                            <li><i class='glyphicon glyphicon-time'></i> <span>$timeposted</span></li>
                                                                                                            <li><i class='glyphicon glyphicon-tags'></i> <span>$name</span></li>
                                                                                                    </ul>
                                                                                            </div>
                                                                                            <div class='col-xs-12 col-sm-12 col-md-7 excerpet'>
                                                                                                    <h3><a href='SearchResult.php?epr=view&id=".$row->jobid."&typeId=".$row->type."' title=''>$row->name</a></h3>
                                                                                                    <p>$row->description</p>						
                                                                                            </div>
                                                                                            <span class='clearfix borda'></span>
                                                                                    </article>	
                                                                        </section>
                                                                    </div>";
                                                                }
                                                            }
                                                        }
                                                    }catch(Exception $x)
                                                    {
                                                        echo 'Caught exception: ',  $x->getMessage(), "\n";
                                                    }
                                                   
                                                   
                                                    try
                                                    {
                                                        if($search != null)
                                                        {
                                                            foreach($search as $row)
                                                            {       
                                                                $dateT = new DateTime($row->date);
                                                                $dateposted = $dateT->format("d/m/Y");
                                                                
                                                                $timeposted = $dateT->format("H:i");
                                                                
                                                                if($row->adtype == 0)
                                                                {
                                                                    $result.="<div class='row'>
                                                                        <section class='col-xs-12 col-sm-6 col-md-12'>
                                                                                    <article class='search-result row'>
                                                                                            <div class='col-xs-12 col-sm-12 col-md-3'>
                                                                                                    <a href='SearchResult.php?epr=view&id=".$row->jobid."&typeId=".$row->type."' title='$row->name' class='thumbnail'><img src='Images/jobsbanner.jpg' alt='$row->name' /></a>
                                                                                            </div>
                                                                                            <div class='col-xs-12 col-sm-12 col-md-2'>
                                                                                                    <ul class='meta-search'>
                                                                                                            <li><i class='glyphicon glyphicon-calendar'></i> <span>$dateposted</span></li>
                                                                                                            <li><i class='glyphicon glyphicon-time'></i> <span>$timeposted</span></li>
                                                                                                            <li><i class='glyphicon glyphicon-tags'></i> <span>$name</span></li>
                                                                                                    </ul>
                                                                                            </div>
                                                                                            <div class='col-xs-12 col-sm-12 col-md-7 excerpet'>
                                                                                                    <h3><a href='SearchResult.php?epr=view&id=".$row->jobid."&typeId=".$row->type."' title=''>$row->name</a></h3>
                                                                                                    <p>$row->description</p>						
                                                                                            </div>
                                                                                            <span class='clearfix borda'></span>
                                                                                    </article>	
                                                                        </section>
                                                                    </div>";
                                                                }
                                                            }
                                                        }
                                                    }catch(Exception $x)
                                                    {
                                                        echo 'Caught exception: ',  $x->getMessage(), "\n";
                                                    }
                                                    
						$result.="</div>     
                                                </div>"
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
    
    function RecommendedJobsResult($cat1,$cat2,$cat3,$cat4)
    {
        $jobModel = new JobModel();
        
        $search = $jobModel->GetJobsByTop4Category($cat1, $cat2, $cat3, $cat4);
        $typeModel = new TypeModel();
        
        $count = $jobModel->CountJobsByTop4Category($cat1, $cat2, $cat3, $cat4);
        
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
                                                    <div class='row' style='margin-top:10px;'>";
                                                    if($count != NULL)
                                                    {
                                                        
                                                       $result.="<hgroup class='mb20'>
                                                            <h1>Search Results</h1>
                                                            <h2 class='lead'><strong class='text-danger'>$count</strong> Recomended jobs were found.</h2>								
                                                        </hgroup>";
                                                    }else
                                                    {
                                                       $result.="<hgroup class='mb20'>
                                                            <h1>Search Results</h1>
                                                            <h2 class='lead'><strong class='text-danger'>0</strong> Recomended jobs were found.</h2>								
                                                        </hgroup>"; 
                                                    }
                                                   $result.=" </div>";
                                                    try
                                                    {
                                                        if($search != null)
                                                        {
                                                            foreach($search as $row)
                                                            {       
                                                                $dateT = new DateTime($row->date);
                                                                $dateposted = $dateT->format("d/m/Y");
                                                                
                                                                $timeposted = $dateT->format("H:i");
                                                                
                                                                $typeName = $typeModel->GetTypeByID($row->type)->name;
                                                                
                                                                if($row->adtype == 1)
                                                                {
                                                                    $result.="<div class='row' style='margin-top:10px;margin-bottom:10px;'>
                                                                        <section class='col-xs-12 col-sm-6 col-md-12'>
                                                                                    <article class='search-result row' style='background-color: #FFFCBB;'>
                                                                                            <div class='col-xs-12 col-sm-12 col-md-3'>
                                                                                                    <a href='SearchResult.php?epr=view&id=".$row->jobid."&typeId=".$row->type."' title='$row->name' class='thumbnail'><img src='Images/jobsbanner.jpg' alt='$row->name' /></a>
                                                                                            </div>
                                                                                            <div class='col-xs-12 col-sm-12 col-md-2'>
                                                                                                    <ul class='meta-search'>
                                                                                                            <li><i class='glyphicon glyphicon-ok'></i> <span style='color:grey;'><strong>Sponsored</strong></span></li>
                                                                                                            <li><i class='glyphicon glyphicon-calendar'></i> <span>$dateposted</span></li>
                                                                                                            <li><i class='glyphicon glyphicon-time'></i> <span>$timeposted</span></li>
                                                                                                            <li><i class='glyphicon glyphicon-tags'></i> <span>$typeName</span></li>
                                                                                                    </ul>
                                                                                            </div>
                                                                                            <div class='col-xs-12 col-sm-12 col-md-7 excerpet'>
                                                                                                    <h3><a href='SearchResult.php?epr=view&id=".$row->jobid."&typeId=".$row->type."' title=''>$row->name</a></h3>
                                                                                                    <p>$row->description</p>						
                                                                                            </div>
                                                                                            <span class='clearfix borda'></span>
                                                                                    </article>	
                                                                        </section>
                                                                    </div>";
                                                                }
                                                            }
                                                        }
                                                    }catch(Exception $x)
                                                    {
                                                        echo 'Caught exception: ',  $x->getMessage(), "\n";
                                                    }
                                                    
                                                    try
                                                    {
                                                        if($search != null)
                                                        {
                                                            foreach($search as $row)
                                                            {       
                                                                $dateT = new DateTime($row->date);
                                                                $dateposted = $dateT->format("d/m/Y");
                                                                
                                                                $timeposted = $dateT->format("H:i");
                                                                
                                                                $typeName = $typeModel->GetTypeByID($row->type)->name;
                                                                
                                                                if($row->adtype == 0)
                                                                {
                                                                    $result.="<div class='row'>
                                                                        <section class='col-xs-12 col-sm-6 col-md-12'>
                                                                                    <article class='search-result row'>
                                                                                            <div class='col-xs-12 col-sm-12 col-md-3'>
                                                                                                    <a href='SearchResult.php?epr=view&id=".$row->jobid."&typeId=".$row->type."' title='$row->name' class='thumbnail'><img src='Images/jobsbanner.jpg' alt='$row->name' /></a>
                                                                                            </div>
                                                                                            <div class='col-xs-12 col-sm-12 col-md-2'>
                                                                                                    <ul class='meta-search'>
                                                                                                            <li><i class='glyphicon glyphicon-calendar'></i> <span>$dateposted</span></li>
                                                                                                            <li><i class='glyphicon glyphicon-time'></i> <span>$timeposted</span></li>
                                                                                                            <li><i class='glyphicon glyphicon-tags'></i> <span>$typeName</span></li>
                                                                                                    </ul>
                                                                                            </div>
                                                                                            <div class='col-xs-12 col-sm-12 col-md-7 excerpet'>
                                                                                                    <h3><a href='SearchResult.php?epr=view&id=".$row->jobid."&typeId=".$row->type."' title=''>$row->name</a></h3>
                                                                                                    <p>$row->description</p>						
                                                                                            </div>
                                                                                            <span class='clearfix borda'></span>
                                                                                    </article>	
                                                                        </section>
                                                                    </div>";
                                                                }
                                                            }
                                                        }
                                                    }catch(Exception $x)
                                                    {
                                                        echo 'Caught exception: ',  $x->getMessage(), "\n";
                                                    }
						$result.="</div>
						</div>"
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
    
    // Get All Jobs
    function GetAllJobsContent()
    {
        $jobModel = new JobModel();
        
        $search = $jobModel->GetAllJobs();
        $typeModel = new TypeModel();
        require_once 'Model/QualificationModel.php';
        $qualificationModel = new QualificationModel();
        
        require_once 'Model/UserModel.php';
        $userModel = new UserModel();
        
        $result = "<div class='panel-group col-md-12'>
			  <div class='panel panel-default'>
					<div class='panel-heading' style='text-align:center;'>
					<a data-toggle='collapse' data-parent='#accordion' href='#collapseSearchResult' class='glyphicon glyphicon-hand-up'><strong>Search Result</strong></a>
					</div>
					<div id='collapseSearchResult' class='panel-collapse collapse in'>
						<div class='panel-body'>
                                                    <div class='row' style='margin:auto; width:100%; padding-top:10px;'>
							<input type='text' id='myjobInput' class='col-md-4' onkeyup='myJobTableFunction()' placeholder='Search for Jobs' title='Type in a job name' style='display: block; margin: auto;'>
                                                    </div>"
                                                    ."<div class='table-responsive col-xs-12'>"
                                                        . "<table class='sortable table' id='myJobTable'>"
                                                        . "<tr style='text-align:center;'>"
                                                        . "     <th style='text-align:center;'>Name</th>"
                                                        . "     <th style='text-align:center;'>Description</th>"
                                                        . "     <th style='text-align:center;'>Owner</th>"
                                                        . "     <th style='text-align:center;'>Category</th>"
                                                        . "     <th style='text-align:center;'>Qualificaion</th>"
                                                        . "     <th style='text-align:center;'>Address</th>"
                                                        . "     <th style='text-align:center;'>Number Of Days</th>"
                                                        . "     <th style='text-align:center;'>Number Of People Required</th>"
                                                        . "     <th style='text-align:center;'>Price: </th>"
                                                        . "     <th>Date Posted: </th>"
                                                        . "     <th>Status: </th>"
                                                        . "     <th style='text-align:center;'>Action: </th>"
                                                        . "</tr>";
                                                        try
                                                        {
                                                            if ($search != null)
                                                            {
                                                                foreach($search as $row)
                                                                {
                                                                    $owner = $userModel->GetUserById($row->id)->username;
                                                                    $type = $typeModel->GetTypeByID($row->type);
                                                                    $qualification = $qualificationModel->GetQualificationByID($row->qualification);
                                                                    $result.= "<tr>"
                                                                            . "<td align='center'><a href='SearchResult.php?epr=view&id=".$row->jobid."&typeId=".$row->type."' target='_blank'>$row->name</a></td>"
                                                                            . "<td align='center'>$row->description</td>"
                                                                            . "<td align='center'><a href='ViewUserProfile.php?epr=view&id=$row->id'>$owner</a></td>"
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
                                                                                if($row->isActive == 1)
                                                                                {
                                                                                    $result.="<td align='center'>Active</td>"
                                                                                            . "<td>"
                                                                                            . "     <a href='DeactivateJob.php?epr=deactivateFromViewAllJobs&id=".$row->jobid."'>Deactivate</a>"
                                                                                            . "</td>";
                                                                                }else
                                                                                {
                                                                                   $result.="<td align='center'>De-Activated</td>"; 
                                                                                }
                                                                            $result.="</tr>";
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
    
    //Get All Job By Category.
    function GetAllJobsByCategory($typeId)
    {
        $jobModel = new JobModel();
        return $jobModel->GetAllJobsByCategory($typeId);
    }
    
    // Get All Jobs
    function GetJobsByCategoryContentAdmin($typeId)
    {
        $jobModel = new JobModel();
        
        $search = $jobModel->GetAllJobsByCategory($typeId);
        $typeModel = new TypeModel();
        require_once 'Model/QualificationModel.php';
        $qualificationModel = new QualificationModel();
        
        require_once 'Model/UserModel.php';
        $userModel = new UserModel();
        
        $result = "<div class='panel-group col-md-12'>
			  <div class='panel panel-default'>
					<div class='panel-heading' style='text-align:center;'>
					<a data-toggle='collapse' data-parent='#accordion' href='#collapseSearchResult' class='glyphicon glyphicon-hand-up'><strong>Search Result</strong></a>
					</div>
					<div id='collapseSearchResult' class='panel-collapse collapse in'>
						<div class='panel-body'>
                                                    <div class='row' style='margin:auto; width:100%; padding-top:10px;'>
							<input type='text' id='myjobInput' class='col-md-4' onkeyup='myJobTableFunction()' placeholder='Search for Jobs' title='Type in a job name' style='display: block; margin: auto;'>
                                                    </div>"
                                                    ."<div class='table-responsive col-xs-12'>"
                                                        . "<table class='sortable table' id='myJobTable'>"
                                                        . "<tr style='text-align:center;'>"
                                                        . "     <th style='text-align:center;'>Name</th>"
                                                        . "     <th style='text-align:center;'>Description</th>"
                                                        . "     <th style='text-align:center;'>Owner</th>"
                                                        . "     <th style='text-align:center;'>Category</th>"
                                                        . "     <th style='text-align:center;'>Qualificaion</th>"
                                                        . "     <th style='text-align:center;'>Address</th>"
                                                        . "     <th style='text-align:center;'>Number Of Days</th>"
                                                        . "     <th style='text-align:center;'>Number Of People Required</th>"
                                                        . "     <th style='text-align:center;'>Price: </th>"
                                                        . "     <th>Date Posted: </th>"
                                                        . "     <th>Status: </th>"
                                                        . "     <th style='text-align:center;'>Action: </th>"
                                                        . "</tr>";
                                                        try
                                                        {
                                                            if ($search != null)
                                                            {
                                                                foreach($search as $row)
                                                                {
                                                                    $owner = $userModel->GetUserById($row->id)->username;
                                                                    $type = $typeModel->GetTypeByID($row->type);
                                                                    $qualification = $qualificationModel->GetQualificationByID($row->qualification);
                                                                    $result.= "<tr>"
                                                                            . "<td align='center'><a href='SearchResult.php?epr=view&id=".$row->jobid."&typeId=".$row->type."' target='_blank'>$row->name</a></td>"
                                                                            . "<td align='center'>$row->description</td>"
                                                                            . "<td align='center'><a href='ViewUserProfile.php?epr=view&id=$row->id'>$owner</a></td>"
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
                                                                                if($row->isActive == 1)
                                                                                {
                                                                                    $result.="<td align='center'>Active</td>"
                                                                                            . "<td>"
                                                                                            . "     <a href='DeactivateJob.php?epr=deactivateFromViewAllJobs&id=".$row->jobid."'>Deactivate</a>"
                                                                                            . "</td>";
                                                                                }else
                                                                                {
                                                                                   $result.="<td align='center'>De-Activated</td>"; 
                                                                                }
                                                                            $result.="</tr>";
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
        $jobModel = new JobModel();
        
        $search = $jobModel->GetJobsBetweenPrices($min, $max);
        $count = $jobModel->CountJobsBetweenPrices($min, $max);
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
                                                    </br>
                                                    <div class='row' style='margin-top:10px;'>";
                                                    if($count != NULL)
                                                    {
                                                        
                                                       $result.="<hgroup class='mb20'>
                                                            <h1>Search Results</h1>
                                                            <h2 class='lead'><strong class='text-danger'>$count</strong> results were found for the prices between <strong class='text-danger'>$min - $max</strong></h2>								
                                                        </hgroup>";
                                                    }else
                                                    {
                                                       $result.="<hgroup class='mb20'>
                                                            <h1>Search Results</h1>
                                                            <h2 class='lead'><strong class='text-danger'>0</strong> results were found for the prices between <strong class='text-danger'>$min - $max</strong></h2>								
                                                        </hgroup>"; 
                                                    }
                                                   $result.=" </div>";
                                                    try
                                                    {
                                                        if($search != null)
                                                        {
                                                            foreach($search as $row)
                                                            {       
                                                                $dateT = new DateTime($row->date);
                                                                $dateposted = $dateT->format("d/m/Y");
                                                                
                                                                $timeposted = $dateT->format("H:i");
                                                                
                                                                $typeName = $typeModel->GetTypeByID($row->type)->name;
                                                                
                                                                if($row->adtype == 1)
                                                                {
                                                                    $result.="<div class='row' style='margin-top:10px;margin-bottom:10px;'>
                                                                        <section class='col-xs-12 col-sm-6 col-md-12'>
                                                                                    <article class='search-result row' style='background-color: #FFFCBB;'>
                                                                                            <div class='col-xs-12 col-sm-12 col-md-3'>
                                                                                                    <a href='SearchResult.php?epr=view&id=".$row->jobid."&typeId=".$row->type."' title='$row->name' class='thumbnail'><img src='Images/jobsbanner.jpg' alt='$row->name' /></a>
                                                                                            </div>
                                                                                            <div class='col-xs-12 col-sm-12 col-md-2'>
                                                                                                    <ul class='meta-search'>
                                                                                                            <li><i class='glyphicon glyphicon-ok'></i> <span style='color:grey;'><strong>Sponsored</strong></span></li>
                                                                                                            <li><i class='glyphicon glyphicon-calendar'></i> <span>$dateposted</span></li>
                                                                                                            <li><i class='glyphicon glyphicon-time'></i> <span>$timeposted</span></li>
                                                                                                            <li><i class='glyphicon glyphicon-tags'></i> <span>$typeName</span></li>
                                                                                                    </ul>
                                                                                            </div>
                                                                                            <div class='col-xs-12 col-sm-12 col-md-7 excerpet'>
                                                                                                    <h3><a href='SearchResult.php?epr=view&id=".$row->jobid."&typeId=".$row->type."' title=''>$row->name</a></h3>
                                                                                                    <p>$row->description</p>						
                                                                                            </div>
                                                                                            <span class='clearfix borda'></span>
                                                                                    </article>	
                                                                        </section>
                                                                    </div>";
                                                                }
                                                            }
                                                        }
                                                    }catch(Exception $x)
                                                    {
                                                        echo 'Caught exception: ',  $x->getMessage(), "\n";
                                                    }                                                
                                                   
                                                    try
                                                    {
                                                        if($search != null)
                                                        {
                                                            foreach($search as $row)
                                                            {       
                                                                $dateT = new DateTime($row->date);
                                                                $dateposted = $dateT->format("d/m/Y");
                                                                
                                                                $timeposted = $dateT->format("H:i");
                                                                
                                                                $typeName = $typeModel->GetTypeByID($row->type)->name;
                                                                
                                                                if($row->adtype == 0)
                                                                {
                                                                    $result.="<div class='row'>
                                                                        <section class='col-xs-12 col-sm-6 col-md-12'>
                                                                                    <article class='search-result row'>
                                                                                            <div class='col-xs-12 col-sm-12 col-md-3'>
                                                                                                    <a href='SearchResult.php?epr=view&id=".$row->jobid."&typeId=".$row->type."' title='$row->name' class='thumbnail'><img src='Images/jobsbanner.jpg' alt='$row->name' /></a>
                                                                                            </div>
                                                                                            <div class='col-xs-12 col-sm-12 col-md-2'>
                                                                                                    <ul class='meta-search'>
                                                                                                            <li><i class='glyphicon glyphicon-calendar'></i> <span>$dateposted</span></li>
                                                                                                            <li><i class='glyphicon glyphicon-time'></i> <span>$timeposted</span></li>
                                                                                                            <li><i class='glyphicon glyphicon-tags'></i> <span>$typeName</span></li>
                                                                                                    </ul>
                                                                                            </div>
                                                                                            <div class='col-xs-12 col-sm-12 col-md-7 excerpet'>
                                                                                                    <h3><a href='SearchResult.php?epr=view&id=".$row->jobid."&typeId=".$row->type."' title=''>$row->name</a></h3>
                                                                                                    <p>$row->description</p>						
                                                                                            </div>
                                                                                            <span class='clearfix borda'></span>
                                                                                    </article>	
                                                                        </section>
                                                                    </div>";
                                                                }
                                                            }
                                                        }
                                                    }catch(Exception $x)
                                                    {
                                                        echo 'Caught exception: ',  $x->getMessage(), "\n";
                                                    }
						$result.="</div>"
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
    
    //Get All Jobs By between prices.
    function GetAllJobsBetweenPrices($minPrice,$maxPrice)
    {
        $jobModel = new JobModel();
        $jobModel->GetAllJobsBetweenPrices($minPrice, $maxPrice);
    }
    
    function AdminSearchResultPrice($min,$max)
    {
        $jobModel = new JobModel();
        
        $search = $jobModel->GetAllJobsBetweenPrices($min, $max);
        $typeModel = new TypeModel();
        require_once 'Model/QualificationModel.php';
        $qualificationModel = new QualificationModel();
        
        require_once 'Model/UserModel.php';
        $userModel = new UserModel();
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
                                                    ."<div class='table-responsive col-xs-12'>"
                                                        . "<table class='sortable table' id='myJobTable'>"
                                                        . "<tr style='text-align:center;'>"
                                                        . "     <th style='text-align:center;'>Name</th>"
                                                        . "     <th style='text-align:center;'>Description</th>"
                                                        . "     <th style='text-align:center;'>Owner</th>"
                                                        . "     <th style='text-align:center;'>Category</th>"
                                                        . "     <th style='text-align:center;'>Qualificaion</th>"
                                                        . "     <th style='text-align:center;'>Address</th>"
                                                        . "     <th style='text-align:center;'>Number Of Days</th>"
                                                        . "     <th style='text-align:center;'>Number Of People Required</th>"
                                                        . "     <th style='text-align:center;'>Price: </th>"
                                                        . "     <th>Date Posted: </th>"
                                                        . "     <th>Status: </th>"
                                                        . "     <th style='text-align:center;'>Action: </th>"
                                                        . "</tr>";
                                                        try
                                                        {
                                                            if ($search != null)
                                                            {
                                                                foreach($search as $row)
                                                                {
                                                                    $owner = $userModel->GetUserById($row->id)->username;
                                                                    $type = $typeModel->GetTypeByID($row->type);
                                                                    $qualification = $qualificationModel->GetQualificationByID($row->qualification);
                                                                    $result.= "<tr>"
                                                                            . "<td align='center'><a href='SearchResult.php?epr=view&id=".$row->jobid."&typeId=".$row->type."' target='_blank'>$row->name</a></td>"
                                                                            . "<td align='center'>$row->description</td>"
                                                                            . "<td align='center'><a href='ViewUserProfile.php?epr=view&id=$row->id'>$owner</a></td>"
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
                                                                                if($row->isActive == 1)
                                                                                {
                                                                                    $result.="<td align='center'>Active</td>"
                                                                                            . "<td>"
                                                                                            . "     <a href='DeactivateJob.php?epr=deactivateFromViewAllJobs&id=".$row->jobid."'>Deactivate</a>"
                                                                                            . "</td>";
                                                                                }else
                                                                                {
                                                                                   $result.="<td align='center'>De-Activated</td>"; 
                                                                                }
                                                                            $result.="</tr>";
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
        $jobModel = new JobModel();
        $qualificationModel = new QualificationModel();
        
        $search = $jobModel->GetJobsByUserID($id);
        $typeModel = new TypeModel();
        
        $userModel = new UserModel();
        
        $placedOffersModel = new PlacedOffersModel();
        $myAcceptedOffers = $placedOffersModel->GetAllAcceptedPlacedOffersByUserID($id);
        $OffersIAccepted = $placedOffersModel->GetAllPlacedOffersIAccepted($id);
        $result = "<div class='row'>"
                . "<div class='panel-group col-md-6'>
			  <div class='panel panel-default'>
					<div class='panel-heading' style='text-align:center;'>
					<a data-toggle='collapse' data-parent='#accordion' href='#collapseListPlacedOffers' class='glyphicon glyphicon-hand-up'><strong>Offers I Accepted</strong></a>
					</div>
					<div id='collapseListPlacedOffers' class='panel-collapse collapse in'>
						<div class='panel-body'>"
                                                        . "<table class='table sortable'>"
                                                        . "<tr>"
                                                        . "     <th style='text-align:center;'>Job</th>"
                                                        . "     <th style='text-align:center;'>User</th>" 
                                                        . "     <th style='text-align:center;'>Price</th>"
                                                        . "     <th style='text-align:center;'>Date</th>"
                                                        . "     <th style='text-align:center;'>Bid Type:</th>"
                                                        . "</tr>";
                                                        try
                                                        {
                                                            if($OffersIAccepted != null)
                                                            {
                                                                foreach($OffersIAccepted as $row)
                                                                {
                                                                    $bidType = $row->bidType;
                                                                    $job = $jobModel->GetJobsByID($row->jobid);
                                                                    $result.= "<tr>"
                                                                            . "<td align='center'><a href='SearchResult.php?epr=view&id=".$row->jobid."&typeId=".$job->type."'>".$jobModel->GetJobsByID($row->jobid)->name."</a></td>"
                                                                            . "<td align='center'><a href='ViewUserProfile.php?epr=view&id=".$userModel->GetUserById($row->userID)->id."'>".$userModel->GetUserById($row->userID)->username."</a></td>"
                                                                            . "<td align='center'>$row->offerPrice</td>"
                                                                            . "<td align='center'>$row->placementDate</td>";
                                                                            if($bidType == 1)
                                                                            {
                                                                                $result.= "<td align='center'>Part Time</td>";
                                                                            }else if($bidType == 0)
                                                                            {
                                                                                $result.= "<td align='center'>Full Time</td>";
                                                                            }
                                                                            
                                                                            $result.="</tr>";
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
                . "<div class='panel-group col-md-6 col-xs-12'>
			  <div class='panel panel-default'>
					<div class='panel-heading' style='text-align:center;'>
					<a data-toggle='collapse' data-parent='#accordion' href='#collapseRating' class='glyphicon glyphicon-hand-up'><strong>My Accepted Offers</strong></a>
					</div>
					<div id='collapseRating' class='panel-collapse collapse in'>
						<div class='panel-body'>"
                                                        . "<table class='table sortable'>"
                                                        . "<tr>"
                                                        . "     <th style='text-align:center;'>Job</th>"
                                                       // . "     <th style='text-align:center;'>User</th>" 
                                                        . "     <th style='text-align:center;'>Price</th>"
                                                        . "     <th style='text-align:center;'>Date</th>"
                                                        . "     <th style='text-align:center;'>Bid Type:</th>"
                                                        . "</tr>";
                                                        try
                                                        {
                                                            if($myAcceptedOffers != null)
                                                            {
                                                                foreach($myAcceptedOffers as $row)
                                                                {
                                                                    $bidType = $row->bidType;
                                                                    $job = $jobModel->GetJobsByID($row->jobid);
                                                                    $result.= "<tr>"
                                                                            . "<td align='center'><a href='SearchResult.php?epr=view&id=".$row->jobid."&typeId=".$job->type."'>".$jobModel->GetJobsByID($row->jobid)->name."</a></td>"
                                                                           // . "<td align='center'><a href='ViewUserProfile.php?epr=view&id=".$userModel->GetUserById($row->userID)->id."'>".$userModel->GetUserById($row->userID)->username."</a></td>"
                                                                            . "<td align='center'>$row->offerPrice</td>"
                                                                            . "<td align='center'>$row->placementDate</td>";
                                                                            if($bidType == 1)
                                                                            {
                                                                                $result.= "<td align='center'>Part Time</td>";
                                                                            }else if($bidType == 0)
                                                                            {
                                                                                $result.= "<td align='center'>Full Time</td>";
                                                                            }
                                                                            
                                                                            $result.="</tr>";
                                                                }
                                                            }
                                                        }catch(Exception $x)
                                                        {
                                                            echo 'Caught exception: ',  $x->getMessage(), "\n";
                                                        }
                                                    $result.= "</table>"
					."</div>"
				."</div>"
			."</div>
                     </div>";
        $result.="<div class='row'>"
                ."<div class='panel-group col-md-4 col-md-offset-4 col-sm-4 col-sm-offset-4'>
			  <div class='panel panel-default'>
					<div class='panel-heading' style='text-align:center;'>
					<a data-toggle='collapse' data-parent='#accordion' href='#collapseKeyTable' class='glyphicon glyphicon-hand-up'><strong>Keys:</strong></a>
					</div>
					<div id='collapseKeyTable' class='panel-collapse collapse in'>
						<div class='panel-body'>"
                                                    . "<div class='row'>"
                                                        . "<div style='background-color:lightgreen;text-align:center;font-weight:bold;font-size:13px;color:blue;' class='col-sm-4 col-sm-offset-4 col-md-4 col-md-offset-4'>Active</div>"
                                                      ."</div>"
                                                    . "<div class='row'>"
                                                        . "<div style='margin-top:10px;background-color:#ffcc66;text-align:center;font-weight:bold;font-size:13px;color:blue;' class='col-sm-4 col-sm-offset-4 col-md-4 col-md-offset-4'>Deactivated</div>"
                                                      ."</div>"
						."</div>"
					."</div>"
                            ."</div>"
                    ."</div>"           
                . "</div>";
            $result.="<div class='panel-group col-md-12 col-xs-12'>
			  <div class='panel panel-default'>
					<div class='panel-heading' style='text-align:center;'>
					<a data-toggle='collapse' data-parent='#accordion' href='#collapseSearchResult' class='glyphicon glyphicon-hand-up'><strong>Search Result</strong></a>
					</div>
					<div id='collapseSearchResult' class='panel-collapse collapse in'>
						<div class='panel-body'>
                                                    <div class='row' style='margin:auto; width:100%; padding-top:10px;'>
							<input type='text' id='myjobInput' class='col-md-4' onkeyup='myJobTableFunction()' placeholder='Search for Jobs' title='Type in a job name' style='display: block; margin: auto;'>
                                                    </div>
                                                    <div class='table-responsive col-xs-12'>"
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
                                                                    if($row->isActive == 1)
                                                                    {
                                                                        $result.= "<tr>"
                                                                                . "<td bgcolor='lightgreen' align='center'><a href='SearchResult.php?epr=view&id=".$row->jobid."&typeId=".$row->type."' target='_blank'>$row->name</a></td>"
                                                                                . "<td bgcolor='lightgreen' align='center'>$row->description</td>"
                                                                                . "<td bgcolor='lightgreen' align='center'>$type->name</td>"
                                                                                . "<td bgcolor='lightgreen' align='center'>$qualification->qualificationName</td>"
                                                                                . "<td bgcolor='lightgreen' align='center'>$row->address</td>"
                                                                                . "<td bgcolor='lightgreen' align='center'>$row->numberOfDays</td>"
                                                                                . "<td bgcolor='lightgreen' align='center'>$row->numberOfPeopleRequired</td>"
                                                                                . "<td bgcolor='lightgreen' align='center'>$row->price</td>";
                                                                                    $var = $row->date;
                                                                                    if(time() - ((60 * 60 * 24) * 10) >= strtotime($var))
                                                                                    {
                                                                                        $result.="<td bgcolor='lightgreen' align='center'>$row->date</td>";
                                                                                    }else
                                                                                    {
                                                                                        $result.="<td bgcolor='lightgreen' align='center' style='color:red'><strong>New</strong></td>";
                                                                                    }
                                                                                $result.="<td bgcolor='lightgreen'>"
                                                                                . "     <a href='EditJob.php?epr=delete&id=".$row->jobid."'>Deactivate</a>&nbsp|"
                                                                                . "     <a href='EditJob.php?epr=update&id=".$row->jobid."'>Update</a>"
                                                                                . "</td>"
                                                                                . "</tr>";
                                                                        }else if($row->isActive == 0)
                                                                        {
                                                                        $result.= "<tr>"
                                                                                . "<td bgcolor='#ffcc66' align='center'><a href='SearchResult.php?epr=view&id=".$row->jobid."&typeId=".$row->type."' target='_blank'>$row->name</a></td>"
                                                                                . "<td bgcolor='#ffcc66' align='center'>$row->description</td>"
                                                                                . "<td bgcolor='#ffcc66' align='center'>$type->name</td>"
                                                                                . "<td bgcolor='#ffcc66' align='center'>$qualification->qualificationName</td>"
                                                                                . "<td bgcolor='#ffcc66' align='center'>$row->address</td>"
                                                                                . "<td bgcolor='#ffcc66' align='center'>$row->numberOfDays</td>"
                                                                                . "<td bgcolor='#ffcc66' align='center'>$row->numberOfPeopleRequired</td>"
                                                                                . "<td bgcolor='#ffcc66' align='center'>$row->price</td>";
                                                                                    $var = $row->date;
                                                                                    if(time() - ((60 * 60 * 24) * 10) >= strtotime($var))
                                                                                    {
                                                                                        $result.="<td bgcolor='#ffcc66' align='center'>$row->date</td>";
                                                                                    }else
                                                                                    {
                                                                                        $result.="<td bgcolor='#ffcc66' align='center' style='color:red'><strong>New</strong></td>";
                                                                                    }
                                                                                $result.="<td bgcolor='#ffcc66'>"
                                                                                . "     <a href='EditJob.php?epr=delete&id=".$row->jobid."'>Deactivate</a>&nbsp|"
                                                                                . "     <a href='EditJob.php?epr=update&id=".$row->jobid."'>Update</a>"
                                                                                . "</td>"
                                                                                . "</tr>";
                                                                        }
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
        
        $countyModel = new CountyModel();
        $allCounties = $countyModel->GetAllCounties();
        
        $qualificationModel = new QualificationModel();
        $allQualification = $qualificationModel->GetQualifications();
        
        $re= " <div class='insertJob-form'>
          <div class='row'>
            <h2 class='col-md-12 col-sm-12 col-xs-12' style='text-align:center;color:blue;'>Upload A New Job</h2>
          </div>
          <div class='row'>
            <p class='col-md-4 col-sm-4 col-xs-12' style='margin-left:5px;color:blue;'>Please ensure that each field is populated</p>
          </div>
          <form action='' method = 'POST'>
            <div class='row'>
            <p style='text-align:center; font-size:23px;color:green;'>Posting Type</p>
            </div>
            <div class='row col-md-offset-5 col-xs-offset-3'>
                <input type='radio' style='margin-bottom:20px;' name='adType' value='0' required> Standard
                &nbsp&nbsp&nbsp&nbsp&nbsp<input type='radio' name='adType' value='1' required> Featured 
            </div>
            <fieldset>
              <div class='clearfix'>
                <label for='name' class='col-md-2 col-sm-2 col-xs-3'> Name: </label>
                <input type='text' name = 'name' id='name' class='col-md-8 col-sm-8 col-xs-8' value='$name' placeholder='Name' required autofocus>
              </div>
              <div class='clearfix'>
              <label for='description' class='col-md-2 col-sm-2 col-xs-3'> Des: </label>
                <input type='text' name = 'description' id='description' class='col-md-8 col-sm-8 col-xs-8' placeholder='Description' required autofocus>
              </div>
              <div class='clearfix'>
                <div class='form-group'>
                  <label for='type' class='col-md-2 col-sm-2 col-xs-4'>Category:</label>
                  <select class='form-control col-md-8 col-sm-8 col-xs-7' id='type' name = 'typeId' style='width:200px;'>";
                    foreach($allType as $row)
                    { 
                      $re .= '<option value='.$row->typeId.'>'.$row->name.'</option>';
                    }
                 $re .=" </select>
                </div>
              </div>
              <div class='clearfix'>
                <div class='form-group'>
                  <label for='qualificationId' class='col-md-2 col-sm-2 col-xs-4'>Qualification:</label>
                  <select class='form-control col-md-8 col-sm-8' id='qualificationId' name = 'qualificationId' style='width:200px;'>";
                    foreach($allQualification as $row)
                    { 
                      $re .= '<option value='.$row->qualificationId.'>'.$row->qualificationName.'</option>';
                    }
                 $re.= " </select>
                </div>
              </div>
              <div class='clearfix'>
              <label for='address' class='col-md-2 col-sm-2 col-xs-3'> Address: </label>
                <input type='text' class='col-md-8 col-sm-8 col-xs-8' name = 'address' value='$address' placeholder='Address' required>
              </div>
              <div class='clearfix'>
                <div class='form-group'>
                  <label for='county' class='col-md-2 col-sm-2 col-xs-4'>County:</label>
                  <select class='form-control col-md-8 col-sm-8' id='county' name = 'county' style='width:200px;'>";
                    foreach($allCounties as $row)
                    { 
                      $re .= '<option value='.$row->id.'>'.$row->county.'</option>';
                    }
                 $re .=" </select>
                </div>
              </div>
              <div class='clearfix'>
                <label for='numberOfDays' class='col-md-2 col-sm-2 col-xs-4'> Number Of Days: </label>
                <select class='form-control col-md-2 col-sm-8 col-xs-8'id='numberOfDays' name = 'numberOfDays' style='width:200px;'>
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
                <label for='numberOfPeopleRequired' class='col-md-2 col-sm-2 col-xs-4'> Number Of People Required: </label>
                <select class='form-control col-md-2 col-sm-2' id='numberOfPeopleRequired' name = 'numberOfPeopleRequired' style='width:200px;'>
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
                <label for='startDate' class='col-md-2 col-sm-2 col-xs-3'> Start Date: </label>
                <input type='date' name = 'startDate' class='col-md-8 col-sm-8 col-xs-8' placeholder=Job Start Date' required autofocus>
              </div>  
              <div class='clearfix'>
                <label for='price' class='col-md-2 col-sm-2 col-xs-3'> Price: </label>
                <input type='text' class='col-md-8 col-sm-8 col-xs-8' name = 'price' value='$price' placeholder='Price' required>
              </div>
              <div class='row'>
              <button class='btn primary col-sm-2 col-sm-offset-9 col-md-2 col-md-offset-9' Style='margin-left:185px;' name = 'insertANewJob' type='submit'>Upload</button>
              </div>
            </fieldset>
          </form>
        </div>";
                
       return $re;
    }
    
    function EditANewJobForm($id)
    {
        $typeModel = new TypeModel();
        $allType = $typeModel->GetTypes();
        
        $qualificationModel = new QualificationModel();
        $allQualification = $qualificationModel->GetQualifications();
        
        $countyModel = new CountyModel();
        $allCounties = $countyModel->GetAllCounties();
        
        $jobController = $this->GetJobsByID($id);
        
        $name = $jobController->name;
        $description = $jobController->description;
        $typeId = $jobController->type;
        $qualificationId = $jobController->qualification;
        $address = $jobController->address;
        $county = $jobController->county;
        $numberOfDays = $jobController->numberOfDays;
        $numberOfPeopleRequired = $jobController->numberOfPeopleRequired;
        $price = $jobController->price;
        $userId = $jobController->id;
        $startDate = $jobController->startDate;

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
               <input type='text' name = 'description' id='description' class='col-md-8' placeholder='Description' value='$description' required autofocus>
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
                <div class='form-group'>
                  <label for='county' class='col-md-2'>County:</label>
                  <select class='form-control col-md-8' value='$county' id='county' name = 'county' style='width:200px;'>";
                    foreach($allCounties as $row)
                    { 
                        if($jobController->county == $row->id)
                        {
                            $re .= '<option selected value='.$row->id.'>'.$row->county.'</option>';
                        }else
                        {
                            $re .= '<option value='.$row->id.'>'.$row->county.'</option>';
                        }   
                    }
                 $re.= " </select>
                </div>
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
                <label for='startDateUpdate' class='col-md-2'> Start Date: </label>
                <input type='date' name = 'startDateUpdate' class='col-md-8' value='$startDate' placeholder=Job Start Date' required autofocus>
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
    
    //Get User By Id
    function GetUserById($id)
    {
        $userModel = new UserModel();
        return $userModel->GetUserById($id);
    }
    
   //Code to create the user profile sidebar
    function CreateJobOverviewSidebar()
    {
        $userModel = new UserModel();
        $user = $userModel->CheckUser($_SESSION['username']);
        $notificationModel = new NotificationModel();
        $userNotification = $notificationModel->CountNotificationByToUsername($_SESSION['username']);
        
        require 'Model/MessagesModel.php';
	$messagesModel = new MessagesModel();
	$myMessages = $messagesModel->CountAllMyMessages($_SESSION['username']);
        require 'Model/RequestModel.php';
        $requestModel = new RequestModel();
        $myRequest = $requestModel->CountRequestsByTargetUserId($_SESSION['id']);
        
        require_once 'Model/CancelRequestModel.php';
        $cancelRequestModel = new CancelRequestModel();
        $myOfferCancellationRequest = $cancelRequestModel->CountCancelRequestByTargetUserId($_SESSION['id']);
        $result = "<div class='col-md-12 col-sm-12'>
			<div class='profile-sidebar'>
				<!-- SIDEBAR USERPIC -->
				<div class='profile-userpic'>
					<img src='$user->photo' class='img-responsive' alt=''>
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
				<div class='nav-button-sidebar'>";
                                   try
                                   {
                                        if($userNotification != null && $myMessages != null && $myRequest != null)
                                        {

                                                $result.="<div class='row' style='padding-bottom:4px;'>
                                                        <a href='Request.php' class='btn btn-warning btn-sm' role='button'>Request &nbsp<span class='badge'>$myRequest</span></a>
                                                    </div>"
                                                        . "<a href='Messages.php' style='margin-bottom:5px;' class='btn btn-success btn-sm' role='button'>Inbox &nbsp<span class='badge'>$myMessages</span></a>&nbsp
                                                    <div class='row'>
                                                <a href='Notification.php' class='btn btn-danger btn-sm' role='button'>Notification &nbsp<span class='badge'>$userNotification</span></a>"
                                                . "</div>";
                                        }else if($userNotification != null && $myMessages != null && $myRequest == null)
                                        {
                                                $result.="<div class='row' style='padding-bottom:4px;'>
                                                        <a href='Request.php' class='btn btn-warning btn-sm' role='button'>Request</a>
                                                    </div>"
                                                        . "<a href='Messages.php' style='margin-bottom:5px;' class='btn btn-success btn-sm' role='button'>Inbox &nbsp<span class='badge'>$myMessages</span></a>&nbsp
                                                    <div class='row'>
                                                <a href='Notification.php' class='btn btn-danger btn-sm' role='button'>Notification &nbsp<span class='badge'>$userNotification</span></a>"
                                                . "</div>";  
                                        }else if($userNotification == null && $myMessages != null && $myRequest != null)
                                        {
                                                $result.="<div class='row' style='padding-bottom:4px;'>
                                                        <a href='Request.php' class='btn btn-warning btn-sm' role='button'>Request &nbsp<span class='badge'>$myRequest</span></a>
                                                    </div>"
                                                        . "<a href='Messages.php' style='margin-bottom:5px;' class='btn btn-success btn-sm' role='button'>Inbox &nbsp<span class='badge'>$myMessages</span></a>&nbsp
                                                    <div class='row'>
                                                <a href='Notification.php' class='btn btn-danger btn-sm' role='button'>Notification</a>"
                                                . "</div>";  
                                        }else if($userNotification != null && $myMessages == null && $myRequest != null)
                                        {
                                                $result.="<div class='row' style='padding-bottom:4px;'>
                                                        <a href='Request.php' class='btn btn-warning btn-sm' role='button'>Request &nbsp<span class='badge'>$myRequest</span></a>
                                                    </div>"
                                                        . "<a href='Messages.php' style='margin-bottom:5px;' class='btn btn-success btn-sm' role='button'>Inbox</a>&nbsp
                                                    <div class='row'>
                                                <a href='Notification.php' class='btn btn-danger btn-sm' role='button'>Notification &nbsp<span class='badge'>$userNotification</span></a>"
                                                . "</div>";  
                                        }else if($userNotification == null && $myMessages == null && $myRequest != null)
                                        {
                                                $result.="<div class='row' style='padding-bottom:4px;'>
                                                        <a href='Request.php' class='btn btn-warning btn-sm' role='button'>Request &nbsp<span class='badge'>$myRequest</span></a>
                                                    </div>"
                                                        . "<a href='Messages.php' style='margin-bottom:5px;' class='btn btn-success btn-sm' role='button'>Inbox</a>&nbsp
                                                    <div class='row'>
                                                <a href='Notification.php' class='btn btn-danger btn-sm' role='button'>Notification</a>"
                                                . "</div>";  
                                        }else if($userNotification == null && $myMessages != null && $myRequest == null)
                                        {
                                                $result.="<div class='row' style='padding-bottom:4px;'>
                                                        <a href='Request.php' class='btn btn-warning btn-sm' role='button'>Request</a>
                                                    </div>"
                                                        . "<a href='Messages.php' style='margin-bottom:5px;' class='btn btn-success btn-sm' role='button'>Inbox &nbsp<span class='badge'>$myMessages</span></a>&nbsp
                                                    <div class='row'>
                                                <a href='Notification.php' class='btn btn-danger btn-sm' role='button'>Notification</a>"
                                                . "</div>";  
                                        }else if($userNotification != null && $myMessages == null && $myRequest == null)
                                        {
                                                $result.="<div class='row' style='padding-bottom:4px;'>
                                                        <a href='Request.php' class='btn btn-warning btn-sm' role='button'>Request</a>
                                                    </div>"
                                                        . "<a href='Messages.php' style='margin-bottom:5px;' class='btn btn-success btn-sm' role='button'>Inbox</a>&nbsp
                                                    <div class='row'>
                                                <a href='Notification.php' class='btn btn-danger btn-sm' role='button'>Notification &nbsp<span class='badge'>$userNotification</span></a>"
                                                . "</div>";  
                                        }else if($userNotification == null && $myMessages == null && $myRequest == null)
                                        {
                                                $result.="<a href='Messages.php' class='btn btn-success btn-sm' role='button'>Inbox</a>
                                                    <div class='row' style='margin-top:10px;'>
                                                    <a href='Request.php' class='btn btn-warning btn-sm' role='button'>Request</a>
                                                    <a href='Notification.php' class='btn btn-danger btn-sm' role='button'>Notification</a>
                                                    </div>
                                                "; 
                                        }
                                    }catch(Exception $x)
                                    {
                                        echo 'Caught exception: ',  $x->getMessage(), "\n";
                                    }
				$result.="</div>
				<!-- END SIDEBAR BUTTONS -->
				<!-- SIDEBAR MENU -->
				<div class='profile-usermenu'>
					<ul class='nav'>
						<li>
							<a href='UserAccount.php' style='text-align:center;'>
							<i class='glyphicon glyphicon-home'></i>
							Overview </a>
						</li>
						<li>
							<a href='AccountSettings.php' style='text-align:center;'>
							<i class='glyphicon glyphicon-user'></i>
							Account Settings </a>
						</li>
						<li class='active'>";
                                                    if($myOfferCancellationRequest != NULL)
                                                    {
							$result.="<a href='JobsOverview.php' style='text-align:center;'>
                                                                    <i class='glyphicon glyphicon-ok'></i>
                                                                    Jobs &nbsp<span class='badge'>$myOfferCancellationRequest</span></a>";
                                                    }else
                                                    {
							$result.="<a href='JobsOverview.php' style='text-align:center;'>
                                                                    <i class='glyphicon glyphicon-ok'></i>
                                                                    Jobs </a>";
                                                    }
						$result.="</li>
						<li>
							<a href='UserReview.php?epr=review&id=".$_SESSION['id']."' style='text-align:center;'>
							<i class='glyphicon glyphicon-comment'></i>
							My Review </a>
						</li>
						<li>
							<a href='Following.php' style='text-align:center;'>
							<i class='glyphicon glyphicon-star-empty'></i>
							Followers </a>
						</li>
                                                <li>
							<a href='Logout.php' style='text-align:center;'>
							<i class='glyphicon glyphicon-log-out'></i>
							Logout </a>
						</li>
						<li>
							<a href='Help.php' target='_blank' style='text-align:center;'>
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
        require_once 'Model/CancelRequestModel.php';
        $cancelRequestModel = new CancelRequestModel();
        $myOfferCancellationRequest = $cancelRequestModel->CountCancelRequestByTargetUserId($_SESSION['id']);
        
        require_once 'Model/PaymentModel.php';
        $paymentModel = new PaymentModel();
        $payment = $paymentModel->CountPaymentByTargetUserId($_SESSION['id']);
        
        $result = "<H4 Style='text-align:center'>Job Overview Page: </H4>"
                  . "<div class='panel-group col-md-6'>
			  <div class='panel panel-default'>
					<div class='panel-heading' style='text-align:center;'>
					<a data-toggle='collapse' data-parent='#accordion' href='#collapseJObOverviewPage' class='glyphicon glyphicon-hand-up'><strong>Overview:</strong></a>
					</div>
					<div id='collapseadvertisedjobs' class='panel-collapse collapse in'>
						<div class='panel-body'>"
                                                    . "<div class='row'>
                                                        <a href='InsertANewJob.php' class='col-sm-12 col-xs-12' style='text-align:center;'>
                                                    <i class='glyphicon glyphicon-upload'></i>
                                                            Upload A New Job </a>
                                                       </div>";
                                                if($payment != NULL)
                                                {
                                                    $result.="<div class='row'>
                                                        <a href='PaymentConfirmation.php' class='col-sm-12 col-xs-12' style='text-align:center;'>
                                                    <i class='glyphicon glyphicon-euro'></i>
                                                            Payment Confirmation &nbsp<span class='badge'>$payment</span> </a>
                                                    </div>";
                                                }else
                                                {
                                                    $result.="<div class='row'>
                                                        <a href='PaymentConfirmation.php' class='col-sm-12 col-xs-12' style='text-align:center;'>
                                                    <i class='glyphicon glyphicon-euro'></i>
                                                            Payment Confirmation </a>
                                                    </div>";
                                                }
                                                
                                                if($myOfferCancellationRequest != NULL)
                                                {
                                                    $result.="<div class='row'>
                                                        <a href='CancelOfferRequest.php' class='col-sm-12 col-xs-12' style='text-align:center;'>
                                                    <i class='glyphicon glyphicon-time'></i>
                                                            Offer Cancellation Request &nbsp<span class='badge'>$myOfferCancellationRequest</span> </a>
                                                    </div>";
                                                        
                                                }else
                                                {
                                                    $result.="<div class='row'>
                                                        <a href='CancelOfferRequest.php' class='col-sm-12 col-xs-12' style='text-align:center;'>
                                                    <i class='glyphicon glyphicon-time'></i>
                                                            Offer Cancellation Request </a>
                                                    </div>";
                                                }
                                                
						$result.="</div>"
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
                                                        <a href='AddEditQualification.php' class='col-sm-12 col-xs-12' style='text-align:center;'>
                                                    <i class='glyphicon glyphicon-upload'></i>
                                                            Add / Edit Qualification </a>
                                                       </div>
                                                    <div class='row'>
                                                       <a href='AddEditType.php' class='col-sm-12 col-xs-12' style='text-align:center;'>
                                                    <i class='glyphicon glyphicon-upload'></i>
                                                            Add / Edit Job Category </a>
                                                    </div>"
						."</div>"
					."</div>"
                            ."</div>"
                   ."</div>";
                
        return $result;
    }

   // Modal To Enable The User To Place An Offer
   function PlaceAnOfferModal()
    {
                $result = "<div class='modal fade col-md-12 col-xs-11' id='placeAnOfferModal' role='dialog'>
			<div class='modal-dialog'>
			
			  <!-- Modal content-->
			  <div class='modal-content'>
				<div class='modal-header'>
				  <button type='button' class='close' data-dismiss='modal'>&times;</button>
				  <h4 class='modal-title'>Place An Offer</h4>
				</div>
				<div class='modal-body'>
                                <div class='row'>
                                    <div id='register' class='register-form'>
                                             <div class='row'>
                                               <h2 class='col-md-12 col-sm-12' style='text-align:center;'>Place An Offer</h2>
                                             </div>
                                             <form action='' method = 'POST'>
                                             <div class='row'>
                                                <input type='radio' onclick = 'fullTimeBid()' style='margin-left:30%; margin-bottom:20px;' name='gender' value='0' required> Full Time 
                                                &nbsp&nbsp&nbsp&nbsp&nbsp<input type='radio' onclick = 'partTimeBid()' name='gender' value='1' required> Part Time 
                                             </div>
                                             
                                               <fieldset>
                                                 <div class='clearfix'>
                                                   <label for='offerPrice' class='col-md-2 col-sm-2 col-xs-3'> Price: </label>
                                                   <input type='text' name = 'offerPrice' id='offerPrice' class='col-md-8 col-sm-8 col-xs-8' placeholder='Enter Price' required autofocus>
                                                 </div>
                                                 <div class='clearfix'>
                                                 <label for='comment' class='col-md-2 col-sm-2 col-xs-3'> Comment: </label>
                                                   <input type='text' name = 'comment' class='col-md-8 col-sm-8 col-xs-8' placeholder='Comment' required autofocus>
                                                 </div>
                                                 <script>
                                                    function fullTimeBid() {
                                                    $('#register').load('fullTimeBid.php?epr=view&select=38');
                                                    }
                                                </script>
                                                
                                                 <script>
                                                    function partTimeBid() {
                                                    $('#register').load('PartTimeBid.php?epr=view&select=38');
                                                    }
                                                </script>
                                                
                                                <button class='btn primary col-xs-3 col-xs-offset-8 col-sm-2 col-sm-offset-8 col-md-2 col-md-offset-8' name = 'placeOffer' type='submit'>Submit</button>
                                               </fieldset>
                                             </form>
                                   </div>
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
    
   // Modal To State That The Job Has Already Started
   function JobAlreadyStartedModal()
    {
                $result = "<div class='modal fade col-md-12 col-xs-11' id='jobAlreadyStartedModal' role='dialog'>
			<div class='modal-dialog'>
			
			  <!-- Modal content-->
			  <div class='modal-content'>
				<div class='modal-header'>
				  <button type='button' class='close' data-dismiss='modal'>&times;</button>
				  <h4 class='modal-title'>WooPS!!!!</h4>
				</div>
				<div class='modal-body'>
                                    <div class='alert alert-info' style='text-align:center;'>
                                      <strong>Sorry,</strong><p style='font-size:13px;'> jobs cannot be updated once it has passed the start date :)</p>
                                    </div>
                                </div>
			  </div>
			  
			</div>
	  </div>";
        return $result;
    }
    
   // Modal To View All Workers Attendance
   function ViewAllWorkerAttendanceModal()
    {
       
        require_once 'Controller/SignInController.php';
        $signInController = new SignInController();
        
        // List Of Signed In Workers Today
        $listOfSignedInWorkers = $signInController->GetAllSignInRecordsByJobId($_SESSION['jobId']);
        
                $result = "<div class='modal fade col-md-12 col-xs-11' id='viewAllWorkerAttendanceModal' role='dialog'>
			<div class='modal-dialog'>
			
			  <!-- Modal content-->
			  <div class='modal-content'>
				<div class='modal-header'>
				  <button type='button' class='close' data-dismiss='modal'>&times;</button>
				  <h4 class='modal-title'>User Attendance</h4>
				</div>
				<div class='modal-body'>
                                    <div class='alert alert-info' style='text-align:center;'>
                                      <strong>User Attendance</strong>
                                    </div>
                                    <div class='row' style='margin:auto; width:100%; padding-top:10px;'>
                                            <input type='text' id='allWorkersAttendanceInput' class='col-md-4' onkeyup='allWorkersAttendanceFunction()' placeholder='Filter' title='Type in a worker name' style='display: block; margin: auto;'>
                                    </div>";
                                                         try
                                                          {
                                                             if($listOfSignedInWorkers != NULL)
                                                             {
                                                            $result.='
                                                                        <div class="table-responsive scrollitY" id="allWorkersAttendanceTable">
                                                                            <table class="table sortable">
                                                                             <tr>
                                                                                 <th style="text-align:center;">User</th>
                                                                                 <th style="text-align:center;">Arrived</th>
                                                                            </tr>';
                                                                                  $userModel = new UserModel();
                                                                                    foreach($listOfSignedInWorkers as $row)
                                                                                    {
                                                                                            $user = $userModel->GetUserById($row->userId);
                                                                                            $nameOfUser = $user->firstName.' '.$user->lastName;
                                                                                            $dateT = new DateTime($row->date);
                                                                                            $dateposted = $dateT->format("H:i:s");
                                                                                            $result.= '<tr>'
                                                                                                    . '<td align="center"><a href="ViewUserProfile.php?epr=view&id='.$row->userId.'">'.$nameOfUser.'</a></td>'
                                                                                                    . '<td align="center"><a href="#">'.$dateposted.'</a></td>';       
                                                                                            $result.='</tr>';

                                                                                    }

                                                                        $result.= '</table>'
                                                                                . '</div>';
                                                             }
                                                          }catch(Exception $x)
                                                          {
                                                              echo 'Caught exception: ',  $x->getMessage(), "\n";
                                                          }
                     $result.="</div>
			  </div>
			  
			</div>
	  </div>
<script>
function allWorkersAttendanceFunction() {
  var input, filter, table, tr, td, i;
  input = document.getElementById('allWorkersAttendanceInput');
  filter = input.value.toUpperCase();
  table = document.getElementById('allWorkersAttendanceTable');
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
    
   // Modal To Sign In A Worker
   function SignInWorkerModal()
    {
                $result = "<div class='modal fade col-md-12 col-xs-11' id='signInWorkerModal' role='dialog'>
			<div class='modal-dialog'>
			
			  <!-- Modal content-->
			  <div class='modal-content'>
				<div class='modal-header'>
				  <button type='button' class='close' data-dismiss='modal'>&times;</button>
				  <h4 class='modal-title'>Worker Sign In</h4>
				</div>
				<div class='modal-body'>
                                <div class='row'>
                                    <div id='register' class='register-form'>
                                             <div class='row'>
                                               <h2 class='col-md-12 col-sm-12' style='text-align:center;'>Sign In</h2>
                                             </div>
                                             <form action='' method = 'POST'>
                                               <fieldset>
                                               
                                                <div class='clearfix row'>
                                                  <input type='text' class='col-md-8 col-md-offset-1 col-sm-8 col-sm-offset-1 col-xs-8 col-xs-offset-1' name='username' placeholder='Username' required autofocus>
                                                </div>
                                                <div class='clearfix row'>
                                                  <input type='password' class='col-md-8 col-md-offset-1 col-sm-8 col-sm-offset-1 col-xs-8 col-xs-offset-1' name='password' placeholder='Password' required>
                                                </div>
                                                
                                                <div class='row'>
                                                    <button class='btn primary col-md-2 col-sm-2 col-xs-3 col-md-offset-7 col-sm-offset-7  col-xs-offset-6' type='submit' name = 'login'>Sign in</button>
                                                </div>
                                                
                                               </fieldset>
                                             </form>
                                   </div>
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
    
    
     // Modal To Enable The User To Place An Offer
   function JobSubscriptionStatusModal()
    {
       $jobid = $_SESSION['jobId'];
       $job = $this->GetJobsByID($jobid);
       
       $dateT = new DateTime($job->date);

       $dateT->modify('+5 day');
       $To= $dateT->format("d/m/Y");
        
       $dateT = new DateTime($job->date);
       $From= $dateT->format("d/m/Y");
                $result = "<div class='modal fade' id='jobSubscriptionStatusModal' role='dialog'>
			<div class='modal-dialog'>
			
			  <!-- Modal content-->
			  <div class='modal-content col-sm-10 col-md-8 col-md-offset-2 col-sm-offset-1'>
				<div class='modal-header'>
				  <button type='button' class='close' data-dismiss='modal'>&times;</button>
				  <h4 class='modal-title'>Subscription Status</h4>
				</div>
				<div class='modal-body'>
                                <div class='row'>
                                    <p style='color:blue; text-align:center; font-size:18px; margin-top:5px;'>Valid From:</p>
                                </div>
                                    <div class='clearfix'>
                                       <p class='col-md-12' style='font-size:18px; text-align:center; color:green;'>$From &nbsp&nbsp&nbsp&nbsp - &nbsp&nbsp&nbsp&nbsp $To</p>    
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
     // Modal To Enable The User Renew A Job Subscription
   function RenewJobSubscriptionModal()
    {
                $result = "<div class='modal fade' id='renewJobSubscriptionModal' role='dialog'>
			<div class='modal-dialog'>
			
			  <!-- Modal content-->
			  <div class='modal-content col-sm-10 col-md-8 col-md-offset-2 col-sm-offset-1'>
				<div class='modal-header'>
				  <button type='button' class='close' data-dismiss='modal'>&times;</button>
				  <h4 class='modal-title'>Renew Job Subscription</h4>
				</div>
				<div class='modal-body'>
                                    <form action='' method = 'POST'>   
                                        <div class='row'>
                                            <p style='color:blue; text-align:center; font-size:18px; margin-top:5px;'>Select Subscription Type:</p>
                                        </div>
                                        <div class='row'>
                                            <input type='radio' style='margin-left:25%; margin-bottom:20px;' name='subscType' value='0' required> Standard 
                                            &nbsp&nbsp&nbsp&nbsp&nbsp<input type='radio' name='subscType' value='1' required> Featured 
                                        </div>
                                        <div class='row'>
                                            <button class='btn primary col-sm-2 col-sm-offset-8 col-md-3 col-md-offset-8' name = 'subscribeButton' type='submit'>Submit</button>
                                        </div>
                                    </form>
				</div>
				<div class='modal-footer'>
				  <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
				</div>
			  </div>
			  
			</div>
	  </div>";
        return $result;
    }
    
     // Modal To Enable The User Renew A Job Subscription
   function AcceptOfferModal()
    {
                $result = "<div class='modal fade' id='acceptOfferModal' role='dialog'>
			<div class='modal-dialog'>
			
			  <!-- Modal content-->
			  <div class='modal-content col-sm-10 col-md-8 col-md-offset-2 col-sm-offset-1'>
				<div class='modal-header'>
				  <button type='button' class='close' data-dismiss='modal'>&times;</button>
				  <h4 class='modal-title'>Accept this offer</h4>
				</div>
				<div class='modal-body'>
                                    <form action='' method = 'POST'>   
                                        <div class='row'>
                                            <p style='color:blue; text-align:center; font-size:18px; margin-top:5px;'>Are You Sure You Want To Accept The Offer From This User?</p>
                                        </div>
                                        <div class='row'>
                                            <button class='btn primary col-sm-2 col-sm-offset-8 col-md-3 col-md-offset-8' name = 'confirmOfferButton' type='submit'>Confirm</button>
                                        </div>
                                    </form>
				</div>
				<div class='modal-footer'>
				  <button type='button' class='btn btn-default' data-dismiss='modal'>Cancel</button>
				</div>
			  </div>
			  
			</div>
	  </div>";
        return $result;
    }
    
   // Modal To Enable The User To Update An Offer
   function UpdateAnOfferModal()
    {
       $placedOffersModel = new PlacedOffersModel();
       $placedOffer = $placedOffersModel->GetPlacedOffersByJobIdAndUserId($_SESSION['jobId'], $_SESSION['id']);
       
       $result = "";

        $job = $this->GetJobsByID($_SESSION['jobId']);
        
        // Job Start Date
        $starttime = strtotime($job->startDate);
        $startDate = new DateTime(date('Y-m-d',$starttime));
        
        // Job End Date
        $endtime = strtotime($job->startDate);
        $dateFinished = new DateTime(date('Y-m-d',$endtime));
        $dateFinished->modify('+'.$job->numberOfDays.' day');
        
       if($placedOffer != null)
       {
            if($placedOffer->bidType == 0)
            {
                 if($placedOffer != null)
                 {
                  $comment = $placedOffer->comment;
                  $offerPrice = $placedOffer->offerPrice;
                 }else
                 {
                     $comment = "";
                     $offerPrice = "";
                 }

                          $result = "<div class='modal fade' id='updateAnOfferModal' role='dialog'>
                                  <div class='modal-dialog'>

                                    <!-- Modal content-->
                                    <div class='modal-content'>
                                          <div class='modal-header'>
                                            <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                            <h4 class='modal-title'>Update Your Offer</h4>
                                          </div>
                                          <div class='modal-body'>
                                          <div class='row'>
                                              <div class='register-form'>
                                                       <div class='row'>
                                                         <h2 class='col-md-12' style='text-align:center;'>Update Your Offer</h2>
                                                       </div>
                                                       <form action='' method = 'POST'>
                                                         <fieldset>
                                                           <div class='clearfix'>
                                                             <label for='offerPrice' class='col-md-2'> Price: </label>
                                                             <input type='text' name = 'updateOfferPrice' id='offerPrice' value=$offerPrice class='col-md-8' placeholder='Enter Price' required autofocus>
                                                           </div>
                                                           <div class='clearfix'>
                                                           <label for='comment' class='col-md-2'> Comment: </label>
                                                             <input type='text' name = 'updateComment' class='col-md-8' value='$comment' placeholder='Comment' required autofocus>
                                                           </div>
                                                           <button class='btn primary col-md-2 col-md-offset-8' name = 'updateOfferFB' type='submit'>Submit</button>
                                                         </fieldset>
                                                       </form>
                                             </div>
                                          </div>
                                          </div>
                                          <div class='modal-footer'>
                                            <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
                                          </div>
                                    </div>

                                  </div>
                    </div>";
            }else if($placedOffer->bidType == 1)
            {
                 if($placedOffer != null)
                 {
                  $comment = $placedOffer->comment;
                  $offerPrice = $placedOffer->offerPrice;
                  $prefferedCommenceDate = $placedOffer->prefferedCommenceDate;
                  $numberOfDays = $placedOffer->numberOfDays;
                 }else
                 {
                     $comment = "";
                     $offerPrice = "";
                 }

                          $result = "<div class='modal fade' id='updateAnOfferModal' role='dialog'>
                                  <div class='modal-dialog'>

                                    <!-- Modal content-->
                                    <div class='modal-content'>
                                          <div class='modal-header'>
                                            <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                            <h4 class='modal-title'>Update Your Offer</h4>
                                          </div>
                                          <div class='modal-body'>
                                          <div class='row'>
                                              <div class='register-form'>
                                                       <div class='row'>
                                                         <h2 class='col-md-12' style='text-align:center;'>Update Your Offer</h2>
                                                       </div>
                                                       <form action='' method = 'POST'>
                                                         <fieldset>
                                                           <div class='clearfix'>
                                                             <label for='offerPrice' class='col-md-2 col-sm-2'> Price: </label>
                                                             <input type='text' name = 'updateOfferPrice' id='offerPrice' value=$offerPrice class='col-md-8 col-sm-7' placeholder='Enter Price' required autofocus>
                                                           </div>
                                                           <div class='clearfix'>
                                                           <label for='comment' class='col-md-2 col-sm-2'> Comment: </label>
                                                             <input type='text' name = 'updateComment' class='col-md-8 col-sm-7' value='$comment' placeholder='Comment' required autofocus>
                                                           </div>
                                                            <div class='clearfix'>
                                                              <label for='numberOfDaysUpdate' class='col-md-2 col-sm-2'> Number Of Days: </label>
                                                              <select class='form-control col-sm-2'id='numberOfDaysUpdate' name = 'numberOfDaysUpdate' value=$numberOfDays style='width:200px;'>";
                                                                for ($x = 1; $x <= 7; $x++) {
                                                                    if($numberOfDays == $x)
                                                                    {
                                                                        $result .="<option selected value=$x>$x</option>";
                                                                    }else
                                                                    {
                                                                        $result .="<option value=$x>$x</option>";
                                                                    }

                                                                }  
                                                                $x = 14;
                                                                while ( $x <= 28) {
                                                                    if($x == 14)
                                                                    {
                                                                        if($numberOfDays == $x)
                                                                        {
                                                                            $result .="<option selected value=$x>2 Weeks</option>";
                                                                        }else
                                                                        {
                                                                            $result .="<option value=$x>2 Weeks</option>";
                                                                        }
                                                                    }else if($x == 21)
                                                                    {
                                                                        if($numberOfDays == $x)
                                                                        {
                                                                            $result .="<option selected value=$x>3 Weeks</option>";
                                                                        }else
                                                                        {
                                                                            $result .="<option value=$x>3 Weeks</option>";
                                                                        }

                                                                    }else
                                                                    {
                                                                        if($numberOfDays == $x)
                                                                        {
                                                                             $result .="<option selected value=$x>4 Weeks</option>";
                                                                        }else
                                                                        {
                                                                            $result .="<option value=$x>4 Weeks</option>";
                                                                        }

                                                                    }
                                                                    $x= $x + 7;
                                                                }
                                                    $result .=" </select>
                                                            </div>
                                                            <div class='clearfix'>
                                                               <p class='col-md-12' style='color:green;text-align:center;font-size:13px;'> Select a date between: </p> 
                                                               <p class='col-md-12' style='color:blue;font-weight:bold;text-align:center;font-size:13px;'><font style='color:green;'>Job Start Date: </font>".$startDate->format("d-m-Y")."  &nbsp &nbsp  -  &nbsp &nbsp  <font style='color:green;'>Job End Date: </font>".$dateFinished->format("d-m-Y")."</p>  
                                                            </div>
                                                            <div class='clearfix'>
                                                            <label for='prefferedCommenceDateUpdate' class='col-md-2'> Preffered Commence Date: </label> 
                                                              <input type='date' name = 'prefferedCommenceDateUpdate' class='col-md-8' value=$prefferedCommenceDate placeholder='Preferred Commence Date' required autofocus>
                                                            </div>
                                                           <button class='btn primary col-sm-2 col-sm-offset-8 col-md-2 col-md-offset-8' name = 'updateOfferPB' type='submit'>Submit</button>
                                                         </fieldset>
                                                       </form>
                                             </div>
                                          </div>
                                          </div>
                                          <div class='modal-footer'>
                                            <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
                                          </div>
                                    </div>

                                  </div>
                    </div>";
            }
       }
        return $result;
    }
    
    // View the Job Details
    function ViewJobDetails($id)
    {
        $favoriteJobsModel = new FavoriteJobsModel();
        
        $jobController = $this->GetJobsByID($id);
        
        $qualificationModel = new QualificationModel();
        $qualification = $qualificationModel->GetQualificationByID($jobController->qualification)->qualificationName;
        
        $typeModel = new TypeModel();
        $typeName = $typeModel->GetTypeByID($jobController->type)->name;
        
        $placedOffersModel = new PlacedOffersModel();
        
        $search = $placedOffersModel->GetAllFullTimeBidPlacedOffersByJobId($_SESSION['jobId']);
        
        $lowestBid = $placedOffersModel->GetLowestPlacedOffersByJobId($_SESSION['jobId']);
        
        $partTimeBids = $placedOffersModel->GetAllPartTimeBidPlacedOffersByJobId($_SESSION['jobId']);
        
        $userModel = new UserModel();
        
        $offer_placed = $placedOffersModel->GetAllPlacedOffersByJobIdAndUserId($_SESSION['jobId'], $_SESSION['id']);
        
        $countyModel = new CountyModel();
        $county =$countyModel->GetCountyById($jobController->county)->county;
        
        require_once 'Controller/SignInController.php';
        $signInController = new SignInController();
        
        // List Of Signed In Workers Today
        $listOfSignedInWorkers = $signInController->GetAllSignInRecordsByJobId($_SESSION['jobId']);
        $jobStartDate = $jobController->startDate;
        $result = '<div class="row col-md-12 text-center" style="padding-bottom:20px;">';
                        if(($jobController->id == $_SESSION['id']) && ($jobController->adtype == 1) && ($jobController->isActive == 1))
                        {
                            $result .='
                                      <div class="row">
                                        <a href="#" data-toggle="modal" id="featureInfoButton" class="btn btn-info col-xs-6 col-xs-offset-3 col-sm-6 col-sm-offset-3 col-md-6 col-md-offset-3" data-target="#jobSubscriptionStatusModal">
                                        <i class="glyphicon glyphicon-star-empty"></i>
                                        Featured Job </a>
                                      </div>';
                                      
                                      if((time() >= strtotime($jobStartDate)))
                                      {
                                                $result.='<div class="row" style="margin-top:10px;">
                                                      <a href="#" data-toggle="modal" id="signInWorkerUserButton" class="btn btn-primary col-xs-6 col-xs-offset-3 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4" data-target="#signInWorkerModal">
                                                  <i class="glyphicon glyphicon-user"></i>
                                                  Sign In Worker </a>
                                                 </div>';
                                      }

                                               $result.='<div class="row" style="margin-top:10px;">
                                                      <div class="col-md-6 col-md-offset-3" style="background-color: white;" id="workersToday">';
                                                          try
                                                          {
                                                             if($listOfSignedInWorkers != NULL)
                                                             {
                                                                  $result.='<div class="panel-group col-md-12" style="margin-top:20px;">
                                                                        <div class="panel panel-default ">
                                                                                      <div class="panel-heading" style="text-align:center;">
                                                                                      <a data-toggle="collapse" data-parent="#accordion" href="#collapseListWorkersToday" class="glyphicon glyphicon-hand-up"><strong>Today'."'s".' Workers</strong></a>
                                                                                      </div>
                                                                                      <div id="collapseListWorkersToday" class="panel-collapse collapse in">
                                                                                             <div class="alert alert-info">
                                                                                                <a href="#" data-toggle="modal" data-target="#viewAllWorkerAttendanceModal">View All Attendance.</a>
                                                                                              </div>
                                                                                              <div class="panel-body">
                                                                                                  <div style="overflow-x:hidden;overflow-y:auto;height:140px;">
                                                                                                      <table class="table sortable">
                                                                                                       <tr>
                                                                                                           <th style="text-align:center;">User</th>
                                                                                                           <th style="text-align:center;">Arrived</th>
                                                                                                      </tr>';

                                                                                                              foreach($listOfSignedInWorkers as $row)
                                                                                                              {
                                                                                                                  $lastSignInDate = $row->date;
                                                                                                                  if((time() - ((60 * 60 * 24) * 1) < strtotime($lastSignInDate)))
                                                                                                                  {
                                                                                                                      $user = $userModel->GetUserById($row->userId);
                                                                                                                      $nameOfUser = $user->firstName.' '.$user->lastName;
                                                                                                                      $dateT = new DateTime($row->date);
                                                                                                                      $dateposted = $dateT->format("H:i:s");
                                                                                                                      $result.= '<tr>'
                                                                                                                              . '<td align="center"><a href="ViewUserProfile.php?epr=view&id='.$row->userId.'">'.$nameOfUser.'</a></td>'
                                                                                                                              . '<td align="center"><a href="#">'.$dateposted.'</a></td>';       
                                                                                                                      $result.='</tr>';
                                                                                                                  }
                                                                                                              }

                                                                                                  $result.= '</table>'
                                                                                                          . '</div>'
                                                                                              .'</div>'
                                                                                      .'</div>'
                                                                              .'</div>'
                                                                      .'</div>';
                                                             }
                                                          }catch(Exception $x)
                                                          {
                                                              echo 'Caught exception: ',  $x->getMessage(), "\n";
                                                          }
                                            $result.='</div>'
                                             . '</div>';
                                      
                        
                        }else if(($jobController->id == $_SESSION['id']) && ($jobController->adtype == 0) && ($jobController->isActive == 1))
                        {
                            $result .='<div class="row">
                                            <a href="UpgradeFeatureJob.php" id="featureAJobButton" class="btn btn-info col-xs-9 col-xs-offset-1 col-sm-6 col-sm-offset-3 col-md-6 col-md-offset-3">
                                                <i class="glyphicon glyphicon glyphicon-plus"></i>
                                            Upgrade This Job To Be Featured </a>
                                       </div>';
                                      $jobStartDate = $jobController->startDate;
                                      
                                      if((time() >= strtotime($jobStartDate)))
                                      {
                                                $result.='<div class="row" style="margin-top:10px;">
                                                      <a href="#" data-toggle="modal" id="signInWorkerUserButton" class="btn btn-primary col-xs-6 col-xs-offset-3 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4" data-target="#signInWorkerModal">
                                                  <i class="glyphicon glyphicon-user"></i>
                                                  Sign In Worker </a>
                                                 </div>';
                                      }

                                               $result.='<div class="row" style="margin-top:10px;">
                                                      <div class="col-md-6 col-md-offset-3" style="background-color: white;" id="workersToday">';
                                                          try
                                                          {
                                                             if($listOfSignedInWorkers != NULL)
                                                             {
                                                                  $result.='<div class="panel-group col-md-12" style="margin-top:20px;">
                                                                        <div class="panel panel-default"> 
                                                                                      <div class="panel-heading" style="text-align:center;">
                                                                                      <a data-toggle="collapse" data-parent="#accordion" href="#collapseListWorkersToday" class="glyphicon glyphicon-hand-up"><strong>Today'."'s".' Workers</strong></a>
                                                                                      </div>
                                                                                      <div id="collapseListWorkersToday" class="panel-collapse collapse in">
                                                                                              <div class="alert alert-info">
                                                                                                <a href="#" data-toggle="modal" data-target="#viewAllWorkerAttendanceModal">View All Attendance.</a>
                                                                                              </div>
                                                                                              <div class="panel-body">
                                                                                                  <div style="overflow-x:hidden;overflow-y:auto;height:140px;">
                                                                                                      <table class="table sortable">
                                                                                                       <tr>
                                                                                                           <th style="text-align:center;">User</th>
                                                                                                           <th style="text-align:center;">Arrived</th>
                                                                                                      </tr>';

                                                                                                              foreach($listOfSignedInWorkers as $row)
                                                                                                              {
                                                                                                                  $lastSignInDate = $row->date;
                                                                                                                  if((time() - ((60 * 60 * 24) * 1) < strtotime($lastSignInDate)))
                                                                                                                  {
                                                                                                                      $user = $userModel->GetUserById($row->userId);
                                                                                                                      $nameOfUser = $user->firstName.' '.$user->lastName;
                                                                                                                      $dateT = new DateTime($row->date);
                                                                                                                      $dateposted = $dateT->format("H:i:s");
                                                                                                                      $result.= '<tr>'
                                                                                                                              . '<td align="center"><a href="ViewUserProfile.php?epr=view&id='.$row->userId.'">'.$nameOfUser.'</a></td>'
                                                                                                                              . '<td align="center"><a href="#">'.$dateposted.'</a></td>';       
                                                                                                                      $result.='</tr>';
                                                                                                                  }
                                                                                                              }

                                                                                                  $result.= '</table>'
                                                                                                          . '</div>'
                                                                                              .'</div>'
                                                                                      .'</div>'
                                                                              .'</div>'
                                                                      .'</div>';
                                                             }
                                                          }catch(Exception $x)
                                                          {
                                                              echo 'Caught exception: ',  $x->getMessage(), "\n";
                                                          }
                                            $result.='</div>'
                                                . '</div>';
                        }else if(($jobController->id == $_SESSION['id']) && ($jobController->isActive == 0))
                        {
                            $result .='<a href="#" data-toggle="modal" id="renewJobSubscriptionButton" class="btn btn-warning col-xs-6 col-xs-offset-3 col-sm-6 col-sm-offset-3 col-md-6 col-md-offset-3" data-target="#renewJobSubscriptionModal">
                            <i class="glyphicon glyphicon-wrench"></i>
                            Renew This Job </a>';
                        }
                        
                        if ($offer_placed == 0 && ($jobController->id != $_SESSION['id']))
                        {
                            if($placedOffersModel->CountNoPlacedOffersByJobId($_SESSION['jobId']) != 0)
                            {
                                if($placedOffersModel->CountNoPlacedOffersByJobId($_SESSION['jobId']) < $jobController->numberOfPeopleRequired)
                                {
                                    $result .='
                                        <a href="#" data-toggle="modal" id="placeAnOfferButton" class="btn btn-success col-xs-6 col-xs-offset-3 col-sm-6 col-sm-offset-3 col-md-6 col-md-offset-3" data-target="#placeAnOfferModal">
                                     <i class="glyphicon glyphicon-book"></i>
                                     Place An Offer </a>';
                                }else
                                {
                                    // Position - Number Of People Required has been filled
                                    $result.='<div class="alert alert-info">
                                                This Position Has Been Filled :)
                                              </div>';
                                }
                            }else
                            {
                                // No Offer Has Been Placed Yet
                                    $result .='
                                        <a href="#" data-toggle="modal" id="placeAnOfferButton" class="btn btn-success col-xs-6 col-xs-offset-3 col-sm-6 col-sm-offset-3 col-md-6 col-md-offset-3" data-target="#placeAnOfferModal">
                                     <i class="glyphicon glyphicon-book"></i>
                                     Place An Offer </a>';
                            }
                        }else if($offer_placed == 1 && ($jobController->id != $_SESSION['id']) && $placedOffersModel->GetUsersPlacedOffer($jobController->jobid, $_SESSION['id'])->bidStatus == 0)
                        {
                            $result .='<a href="#" data-toggle="modal" id="placeAnOfferButton" class="btn btn-success col-xs-6 col-xs-offset-3 col-sm-6 col-sm-offset-3 col-md-6 col-md-offset-3" data-target="#updateAnOfferModal">
                            <i class="glyphicon glyphicon-book"></i>
                            Update Your Offer </a>';
                        }
        $result .=   '</div>';

        $result .= "<div class='row'>"
                  ."<div class='panel-group col-md-6 col-sm-12'>
			  <div class='panel panel-default'>
					<div class='panel-heading' style='text-align:center;'>
					<a data-toggle='collapse' data-parent='#accordion' href='#collapseJobDescription' class='glyphicon glyphicon-hand-up'><strong>Description:</strong></a>
					</div>
					<div id='collapseJobDescription' class='panel-collapse collapse in'>
						<div class='panel-body'>"
                                                    . "<div class='row'>
                                                        <p class='col-md-12' id='description' style='font-size:13px;'><font face='arial'>$jobController->description</font></p>
                                                       </div>"
                                                    . "<div class='row'>"
                                                        . "<div id='map' class='col-md-10 col-sm-12' style='height: 380px;'></div>"
                                                    . "</div>"
                                                    . "<div class='row'>
                                                        </p>
                                                        <p id='ad' style='text-align:center; font-weight:bold;'>$jobController->address</p>
                                                        <div id='right-panel' class='scrollitY'>
                                                          <p>Total Distance: <span id='total'></span></p>
                                                        </div>
                                                       </div>"
						."</div>"
					."</div>"
                            ."</div>"
                    ."</div>"
    . "<script>
    var geocoder;
    var map;
    var address;
    var des;
    var pos;
  function initMap() {
      
    geocoder = new google.maps.Geocoder();
    var latlng = new google.maps.LatLng(-34.397, 150.644);
    var mapOptions = {
      zoom: 7,
      center: latlng,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    map = new google.maps.Map(document.getElementById('map'), mapOptions);
    codeAddress();
}
      
  function codeAddress() {
     var address = document.getElementById('ad').innerHTML;

     console.log(address);
    geocoder.geocode( { 'address': address}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        des = results[0].geometry.location;
        map.setCenter(results[0].geometry.location);
        var marker = new google.maps.Marker({
            map: map,
            position: results[0].geometry.location

        });
        var jdata = 'Job Location';
        var jinfowindow = new google.maps.InfoWindow({
          content: jdata
        });
        google.maps.event.addListener(marker, 'click', function() {
          jinfowindow.open(map,marker);
        });
    
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            pos = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };

            var marker1 = new google.maps.Marker({
                map: map,
                draggable: true,
                animation: google.maps.Animation.DROP,
                position: pos,
                title:'Your Location!'
            });
            var data = 'Estimation Of Your Location. Drag And Drop [A] To get route to job location.';
            var infowindow = new google.maps.InfoWindow({
              content: data
            });
            google.maps.event.addListener(marker1, 'click', function() {
              infowindow.open(map,marker1);
            });
            var directionsService = new google.maps.DirectionsService;
            var directionsDisplay = new google.maps.DirectionsRenderer({
              draggable: true,
              map: map,
              panel: document.getElementById('right-panel')
            });

            directionsDisplay.addListener('directions_changed', function() {
              computeTotalDistance(directionsDisplay.getDirections());
            });

            displayRoute(pos, des, directionsService,
                directionsDisplay);
            
          }, function() {
            handleLocationError(true, infoWindow, map.getCenter());
          });
        } else {
          // Browser doesn't support Geolocation
          handleLocationError(false, infoWindow, map.getCenter());
        }
            
      } else {
        alert('Address could not be displayed: ');
}

      function displayRoute(origin, destination, service, display) {
        service.route({
          origin: origin,
          destination: destination,
          travelMode: 'DRIVING',
          avoidTolls: false
        }, function(response, status) {
          if (status === 'OK') {
            display.setDirections(response);
          } else {
            alert('Could not display directions due to: ' + status);
          }
        });
}

      function computeTotalDistance(result) {
        var total = 0;
        var myroute = result.routes[0];
        for (var i = 0; i < myroute.legs.length; i++) {
          total += myroute.legs[i].distance.value;
        }
        total = total / 1000;
        document.getElementById('total').innerHTML = total + ' km';
}
    });
  }
    </script>
    <script async defer
        src='https://maps.googleapis.com/maps/api/js?key=AIzaSyDn-XDOkmKcNjVjNbgRIP41yIjE-ZS7-Sk&callback=initMap'>
    </script>"
                
                
                  ."<div class='panel-group col-md-6 col-sm-12'>
			  <div class='panel panel-default'>
					<div class='panel-heading' style='text-align:center;'>
					<a data-toggle='collapse' data-parent='#accordion' href='#collapseJobProperties' class='glyphicon glyphicon-hand-up'><strong>Job Properties:</strong></a>
					</div>
					<div id='collapseJobProperties' class='panel-collapse collapse in'>
						<div class='panel-body'>
                                                <div class='row'>";
                                                if (($favoriteJobsModel->GetFavoriteJobsByJobIdANDUserId($jobController->jobid,$_SESSION['id']) == 0) &&($jobController->id != $_SESSION['id']))
                                                {
                                                    $result.="<a href='FavoriteJobs.php?epr=add&jobId=$jobController->jobid&typeId=$jobController->type' id='addFavorite' class='btn btn-primary col-xs-6 col-xs-offset-3 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4'>
                                                        <i class='glyphicon glyphicon-heart'></i>
                                                    Favorite </a>";
                                                }else if($jobController->id != $_SESSION['id'])
                                                {
                                                    $result.="<a href='FavoriteJobs.php?epr=remove&jobId=$jobController->jobid&typeId=$jobController->type' id='addFavorite' class='btn btn-danger col-xs-6 col-xs-offset-3 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4'>
                                                        <i class='glyphicon glyphicon-remove-sign'></i>
                                                    Favorite </a>";
                                                }
                                                    
                                                $result.="</div>"
                                                    . "<div class='row'>
                                                            <div class='table-responsive'>
                                                                <table class='sortable table' id='myJobTable'>
                                                                    <tr>
                                                                        <td style='text-align:center;'><strong>Job Start Date:</strong> $jobController->startDate </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style='text-align:center;'><strong>Name:</strong> $jobController->name</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style='text-align:center;'><strong>Qualification:</strong>$qualification</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style='text-align:center;'><strong>Category:</strong>$typeName</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style='text-align:center;'><strong>Address:</strong> $jobController->address</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style='text-align:center;'><strong>County:</strong> $county</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style='text-align:center;'><strong>Number Of Days:</strong> $jobController->numberOfDays</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style='text-align:center;'><strong>Number Of People Required:</strong> $jobController->numberOfPeopleRequired </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style='text-align:center;'><strong>Date Posted:</strong> $jobController->date </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style='text-align:center;'><strong>Price (Per Day) / Maximum Bid:</strong> $jobController->price </td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                       </div>"
						."</div>"
					."</div>"
                            ."</div>"
                    ."</div>"
                . "</div>";
       
        $result.="<div class='row'>"
                ."<div class='panel-group col-md-4 col-md-offset-4 col-sm-4 col-sm-offset-4'>
			  <div class='panel panel-default'>
					<div class='panel-heading' style='text-align:center;'>
					<a data-toggle='collapse' data-parent='#accordion' href='#collapseKeyTable' class='glyphicon glyphicon-hand-up'><strong>Keys:</strong></a>
					</div>
					<div id='collapseKeyTable' class='panel-collapse collapse in'>
						<div class='panel-body'>"
                                                    . "<div class='row'>"
                                                        . "<div style='background-color:lightgreen;text-align:center;font-weight:bold;font-size:13px;color:blue;' class='col-sm-4 col-sm-offset-4 col-md-4 col-md-offset-4'>Accepted</div>"
                                                      ."</div>"
                                                    . "<div class='row'>"
                                                        . "<div style='margin-top:10px;background-color:#ffcc66;text-align:center;font-weight:bold;font-size:13px;color:blue;' class='col-sm-4 col-sm-offset-4 col-md-4 col-md-offset-4'>Declined</div>"
                                                      ."</div>"
						."</div>"
					."</div>"
                            ."</div>"
                    ."</div>"           
                . "</div>";
        
        $result .= "<div class='row'>"
                  ."<div class='panel-group col-md-6'>
			  <div class='panel panel-default'>
					<div class='panel-heading' style='text-align:center;'>
					<a data-toggle='collapse' data-parent='#accordion' href='#collapseBiddingTable' class='glyphicon glyphicon-hand-up'><strong>Full Time Bidding Table:</strong></a>
					</div>
					<div id='collapseBiddingTable' class='panel-collapse collapse in'>
						<div class='panel-body'>"
                                                    . "<div class='row'>
                                                        <div class='table-responsive scrollit'>"
                                                            . "<table class='table sortable'>"
                                                            . "<tr>"
                                                            . "     <th style='text-align:center'>Name</th>"
                                                            . "     <th style='text-align:center'>Comment</th>"
                                                            . "     <th style='text-align:center'>Date Posted</th>"
                                                            . "     <th style='text-align:center'>Price</th>"
                                                            . "     <th style='text-align:center'>Action: </th>"
                                                            . "</tr>";
                                                           try
                                                            {
                                                               if($search != 0)
                                                               {
                                                                    foreach($search as $row)
                                                                    {
                                                                        $name = $userModel->GetUserById($row->userID)->firstName;
                                                                        $name .= " " .$userModel->GetUserById($row->userID)->lastName;
                                                                        if(($row->seen == 1 || $row->seen == 0) && ($row->userID == $_SESSION['id']) && ($jobController->id != $_SESSION['id']) && $row->bidStatus == 1)
                                                                        {
                                                                            $result.= "<tr>"
                                                                                    . "<td bgcolor='lightgreen' align='center'><a href='ViewUserProfile.php?epr=view&id=".$userModel->GetUserById($row->userID)->id."'>$name</a></td>"
                                                                                    . "<td bgcolor='lightgreen' align='center'>$row->comment</td>"
                                                                                    . "<td bgcolor='lightgreen' align='center'>$row->placementDate</td>"
                                                                                    . "<td bgcolor='lightgreen' align='center'>$row->offerPrice</td>"
                                                                                    . "<td bgcolor='lightgreen' align='center'>"
                                                                                    . "     "
                                                                                    . "</td>"
                                                                                    . "</tr>";
                                                                            
                                                                        }else if(($row->seen == 1 || $row->seen == 0) && ($row->userID == $_SESSION['id']) && ($jobController->id != $_SESSION['id']) && $row->bidStatus == NULL)
                                                                        {
                                                                            $result.= "<tr>"
                                                                                    . "<td align='center'><a href='ViewUserProfile.php?epr=view&id=".$userModel->GetUserById($row->userID)->id."'>$name</a></td>"
                                                                                    . "<td align='center'>$row->comment</td>"
                                                                                    . "<td align='center'>$row->placementDate</td>"
                                                                                    . "<td align='center'>$row->offerPrice</td>"
                                                                                    . "<td align='center'>"
                                                                                    . "     <a href='#' onclick='deleteOffer(".$userModel->GetUserById($row->userID)->id.")'>Delete</a>"
                                                                                    . "</td>"
                                                                                    . "</tr>"; 
                                                                        }else if(($row->seen == 1 || $row->seen == 0) && ($row->userID == $_SESSION['id']) && ($jobController->id != $_SESSION['id']) && $row->bidStatus == 0)
                                                                        {
                                                                            $result.= "<tr>"
                                                                                    . "<td bgcolor='#ffcc66' align='center'><a href='ViewUserProfile.php?epr=view&id=".$userModel->GetUserById($row->userID)->id."'>$name</a></td>"
                                                                                    . "<td bgcolor='#ffcc66' align='center'>$row->comment</td>"
                                                                                    . "<td bgcolor='#ffcc66' align='center'>$row->placementDate</td>"
                                                                                    . "<td bgcolor='#ffcc66' align='center'>$row->offerPrice</td>"
                                                                                    . "<td bgcolor='#ffcc66' align='center'>"
                                                                                    . "     "
                                                                                    . "</td>"
                                                                                    . "</tr>"; 
                                                                        }else if($row->seen == 0 && $jobController->id == $_SESSION['id'] && $row->bidStatus == NULL)
                                                                        {
                                                                            $result.= "<tr>"
                                                                                    . "<td bgcolor='#ccd7ea' align='center'><a href='ViewUserProfile.php?epr=viewAndSetBidSeen&id=".$userModel->GetUserById($row->userID)->id."&jobId=".$jobController->jobid."'>$name</a></td>"
                                                                                    . "<td bgcolor='#ccd7ea' align='center'>$row->comment</td>"
                                                                                    . "<td bgcolor='#ccd7ea' align='center'>$row->placementDate</td>"
                                                                                    . "<td bgcolor='#ccd7ea' align='center'>$row->offerPrice</td>"
                                                                                    . "<td bgcolor='#ccd7ea' align='center'>"
                                                                                    ."      <a href='#' onclick='acceptOffer(".$userModel->GetUserById($row->userID)->id.")'>Accept</a>&nbsp|"
                                                                                    . "     <a href='#' onclick='declineOffer(".$userModel->GetUserById($row->userID)->id.")'>Decline</a>"
                                                                                    . "</td>"
                                                                                    . "</tr>";
                                                                        }else if($row->seen == 1 && $jobController->id == $_SESSION['id'] && $row->bidStatus == NULL)
                                                                        {
                                                                            $result.= "<tr>"
                                                                                    . "<td align='center'><a href='ViewUserProfile.php?epr=view&id=".$userModel->GetUserById($row->userID)->id."'>$name</a></td>"
                                                                                    . "<td align='center'>$row->comment</td>"
                                                                                    . "<td align='center'>$row->placementDate</td>"
                                                                                    . "<td align='center'>$row->offerPrice</td>"
                                                                                    . "<td align='center'>"
                                                                                    ."      <a href='#' onclick='acceptOffer(".$userModel->GetUserById($row->userID)->id.")'>Accept</a>&nbsp|"
                                                                                    . "     <a href='#' onclick='declineOffer(".$userModel->GetUserById($row->userID)->id.")'>Decline</a>"
                                                                                    . "</td>"
                                                                                    . "</tr>";
                                                                        }else if($row->seen == 0 && $jobController->id == $_SESSION['id'] && $row->bidStatus == 1)
                                                                        {
                                                                            $time = strtotime($jobStartDate);
                                                                            $jobEndDate = new DateTime(date('Y-m-d',$time));
                                                                            $jobEndDate->modify('+'.$jobController->numberOfDays.' day');
                                                                            $result.= "<tr>"
                                                                                    . "<td bgcolor='lightgreen' align='center'><a href='ViewUserProfile.php?epr=viewAndSetBidSeen&id=".$userModel->GetUserById($row->userID)->id."&jobId=".$jobController->jobid."'>$name</a></td>"
                                                                                    . "<td bgcolor='lightgreen' align='center'>$row->comment</td>"
                                                                                    . "<td bgcolor='lightgreen' align='center'>$row->placementDate</td>"
                                                                                    . "<td bgcolor='lightgreen' align='center'>$row->offerPrice</td>";
                                                                                    if(!(time() >= strtotime($jobStartDate)))
                                                                                    {
                                                                                        $result.= "<td bgcolor='lightgreen' align='center'>"
                                                                                        ."      <a href='#' onclick='cancelOffer(".$userModel->GetUserById($row->userID)->id.",".$jobController->jobid.")'>Cancel</a>"
                                                                                        . "</td>"
                                                                                        . "</tr>";
                                                                                    }else if((time() >= strtotime($jobEndDate->format("Y-m-d H:i:s"))))
                                                                                    {
                                                                                        require_once 'Model/PaymentModel.php';
                                                                                        
                                                                                        $paymentModel = new PaymentModel();
                                                                                        $paymentConfirmed = $paymentModel->GetPaymentMeAccountByUserIdTargetUserIdAndJobId($_SESSION['id'], $row->userID, $_SESSION['jobId']);
                                                                                        if($paymentConfirmed != NULL)
                                                                                        {
                                                                                            if($paymentConfirmed->status == 2)
                                                                                            {
                                                                                                $result.= "<td bgcolor='lightgreen' align='center'>"
                                                                                                        ."Paid"
                                                                                                . "</td>"
                                                                                                . "</tr>"; 
                                                                                            }else if($paymentConfirmed->status == 1)
                                                                                            {
                                                                                                $result.= "<td bgcolor='lightgreen' align='center'>"
                                                                                                        ."      <a href='PayUser.php?epr=pay&userId=$row->userID'>Pay</a>"
                                                                                                . "</td>"
                                                                                                . "</tr>"; 
                                                                                            }
                                                                                        }else
                                                                                        {
                                                                                            $result.= "<td bgcolor='lightgreen' align='center'>"
                                                                                                    ."      <a href='PayUser.php?epr=pay&userId=$row->userID'>Pay</a>"
                                                                                            . "</td>"
                                                                                            . "</tr>"; 
                                                                                        }

                                                                                    }else
                                                                                    {
                                                                                        $result.= "<td bgcolor='lightgreen' align='center'>"
                                                                                        . "</td>"
                                                                                        . "</tr>"; 
                                                                                    }
                                                                        }else if($row->seen == 1 && $jobController->id == $_SESSION['id'] && $row->bidStatus == 1)
                                                                        {
                                                                            $time = strtotime($jobStartDate);
                                                                            $jobEndDate = new DateTime(date('Y-m-d',$time));
                                                                            $jobEndDate->modify('+'.$jobController->numberOfDays.' day');
                                                                           
                                                                            $result.= "<tr>"
                                                                                    . "<td bgcolor='lightgreen' align='center'><a href='ViewUserProfile.php?epr=viewAndSetBidSeen&id=".$userModel->GetUserById($row->userID)->id."&jobId=".$jobController->jobid."'>$name</a></td>"
                                                                                    . "<td bgcolor='lightgreen' align='center'>$row->comment</td>"
                                                                                    . "<td bgcolor='lightgreen' align='center'>$row->placementDate</td>"
                                                                                    . "<td bgcolor='lightgreen' align='center'>$row->offerPrice</td>"
                                                                                    . "<td bgcolor='lightgreen' align='center'>";
                                                                                    if(!(time() >= strtotime($jobStartDate)))
                                                                                    {
                                                                                        $result.= 
                                                                                        "      <a href='#' onclick='cancelOffer(".$userModel->GetUserById($row->userID)->id.",".$jobController->jobid.")'>Cancel</a>"
                                                                                        . "</td>"
                                                                                        . "</tr>";
                                                                                    }else if((time() >= strtotime($jobEndDate->format("Y-m-d H:i:s"))))
                                                                                    {
                                                                                        require_once 'Model/PaymentModel.php';
                                                                                        
                                                                                        $paymentModel = new PaymentModel();
                                                                                        $paymentConfirmed = $paymentModel->GetPaymentMeAccountByUserIdTargetUserIdAndJobId($_SESSION['id'], $row->userID, $_SESSION['jobId']);
                                                                                        if($paymentConfirmed != NULL)
                                                                                        {
                                                                                            if($paymentConfirmed->status == 2)
                                                                                            {
                                                                                                $result.= "<td bgcolor='lightgreen' align='center'>"
                                                                                                        ."Paid"
                                                                                                . "</td>"
                                                                                                . "</tr>"; 
                                                                                            }else if($paymentConfirmed->status == 1)
                                                                                            {
                                                                                                $result.= "<td bgcolor='lightgreen' align='center'>"
                                                                                                        ."      <a href='PayUser.php?epr=pay&userId=$row->userID'>Pay</a>"
                                                                                                . "</td>"
                                                                                                . "</tr>"; 
                                                                                            }
                                                                                        }else
                                                                                        {
                                                                                            $result.= "<td bgcolor='lightgreen' align='center'>"
                                                                                                    ."      <a href='PayUser.php?epr=pay&userId=$row->userID'>Pay</a>"
                                                                                            . "</td>"
                                                                                            . "</tr>"; 
                                                                                        }
                                                                                    }else
                                                                                    {
                                                                                        $result.= 
                                                                                         "</td>"
                                                                                        . "</tr>"; 
                                                                                    }
                                                                        }else if($row->seen == 0 && $jobController->id == $_SESSION['id'] && $row->bidStatus == 0)
                                                                        {
                                                                            $result.= "<tr>"
                                                                                    . "<td bgcolor='#ffcc66' align='center'><a href='ViewUserProfile.php?epr=viewAndSetBidSeen&id=".$userModel->GetUserById($row->userID)->id."&jobId=".$jobController->jobid."'>$name</a></td>"
                                                                                    . "<td bgcolor='#ffcc66' align='center'>$row->comment</td>"
                                                                                    . "<td bgcolor='#ffcc66' align='center'>$row->placementDate</td>"
                                                                                    . "<td bgcolor='#ffcc66' align='center'>$row->offerPrice</td>"
                                                                                    . "<td bgcolor='#ffcc66' align='center'>"
                                                                                    ."      "
                                                                                    . "</td>"
                                                                                    . "</tr>";
                                                                        }else if($row->seen == 1 && $jobController->id == $_SESSION['id'] && $row->bidStatus == 0)
                                                                        {
                                                                            $result.= "<tr>"
                                                                                    . "<td bgcolor='#ffcc66' align='center'><a href='ViewUserProfile.php?epr=viewAndSetBidSeen&id=".$userModel->GetUserById($row->userID)->id."&jobId=".$jobController->jobid."'>$name</a></td>"
                                                                                    . "<td bgcolor='#ffcc66' align='center'>$row->comment</td>"
                                                                                    . "<td bgcolor='#ffcc66' align='center'>$row->placementDate</td>"
                                                                                    . "<td bgcolor='#ffcc66' align='center'>$row->offerPrice</td>"
                                                                                    . "<td bgcolor='#ffcc66' align='center'>"
                                                                                    ."      "
                                                                                    . "</td>"
                                                                                    . "</tr>";
                                                                        }else
                                                                        {
                                                                            $result.= "<tr>"
                                                                                    . "<td align='center'></td>"
                                                                                    . "<td align='center'>$row->comment</td>"
                                                                                    . "<td align='center'>$row->placementDate</td>"
                                                                                    . "<td align='center'>$row->offerPrice</td>"
                                                                                    . "</tr>";
                                                                        }
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
                    ."</div>"                  
                
                    ."<div class='panel-group col-md-6'>
			  <div class='panel panel-default'>
					<div class='panel-heading' style='text-align:center;'>
					<a data-toggle='collapse' data-parent='#accordion' href='#collapseHighestBid' class='glyphicon glyphicon-hand-up'><strong>Part Time Bidding Table:</strong></a>
					</div>
					<div id='collapseHighestBid' class='panel-collapse collapse in'>
						<div class='panel-body'>"
                                                    . "<div class='row'>
                                                        <div class='table-responsive scrollit'>"
                                                        . "<table class='table sortable'>"
                                                            . "<tr>"
                                                            . "     <th style='text-align:center'>Name</th>"
                                                            . "     <th style='text-align:center'>Comment</th>"
                                                            . "     <th style='text-align:center'>Date Posted</th>"
                                                            . "     <th style='text-align:center'>Preffered Start Date</th>"
                                                            . "     <th style='text-align:center'>Price</th>"
                                                            . "     <th style='text-align:center'>No. Days</th>"    
                                                            . "     <th style='text-align:center'>Action: </th>"
                                                            . "</tr>";
                                                           try
                                                            {
                                                               if($partTimeBids != 0)
                                                               {
                                                                    foreach($partTimeBids as $row)
                                                                    {
                                                                        $name = $userModel->GetUserById($row->userID)->firstName;
                                                                        $name .= " " .$userModel->GetUserById($row->userID)->lastName;
                                                                        if(($row->seen == 1 || $row->seen == 0) && ($row->userID == $_SESSION['id']) && ($jobController->id != $_SESSION['id']) && $row->bidStatus == 1)
                                                                        {
                                                                            $result.= "<tr>"
                                                                                    . "<td bgcolor='lightgreen' align='center'><a href='ViewUserProfile.php?epr=view&id=".$userModel->GetUserById($row->userID)->id."'>$name</a></td>"
                                                                                    . "<td bgcolor='lightgreen' align='center'>$row->comment</td>"
                                                                                    . "<td bgcolor='lightgreen' align='center'>$row->placementDate</td>"
                                                                                    . "<td bgcolor='lightgreen' align='center'>$row->prefferedCommenceDate</td>"
                                                                                    . "<td bgcolor='lightgreen' align='center'>$row->offerPrice</td>"
                                                                                    . "<td bgcolor='lightgreen' align='center'>$row->numberOfDays</td>"
                                                                                    . "<td bgcolor='lightgreen' align='center'>"
                                                                                    . "     "
                                                                                    . "</td>"
                                                                                    . "</tr>";
                                                                        }else if(($row->seen == 1 || $row->seen == 0) && ($row->userID == $_SESSION['id']) && ($jobController->id != $_SESSION['id']) && $row->bidStatus == NULL)
                                                                        {
                                                                            $result.= "<tr>"
                                                                                    . "<td align='center'><a href='ViewUserProfile.php?epr=view&id=".$userModel->GetUserById($row->userID)->id."'>$name</a></td>"
                                                                                    . "<td align='center'>$row->comment</td>"
                                                                                    . "<td align='center'>$row->placementDate</td>"
                                                                                    . "<td align='center'>$row->prefferedCommenceDate</td>"
                                                                                    . "<td align='center'>$row->offerPrice</td>"
                                                                                    . "<td align='center'>$row->numberOfDays</td>"
                                                                                    . "<td align='center'>"
                                                                                    . "     <a href='#' onclick='deleteOffer(".$userModel->GetUserById($row->userID)->id.")'>Delete</a>"
                                                                                    . "</td>"
                                                                                    . "</tr>";
                                                                        }else if(($row->seen == 1 || $row->seen == 0) && ($row->userID == $_SESSION['id']) && ($jobController->id != $_SESSION['id']) && $row->bidStatus == 0)
                                                                        {
                                                                            $result.= "<tr>"
                                                                                    . "<td bgcolor='#ffcc66' align='center'><a href='ViewUserProfile.php?epr=view&id=".$userModel->GetUserById($row->userID)->id."'>$name</a></td>"
                                                                                    . "<td bgcolor='#ffcc66' align='center'>$row->comment</td>"
                                                                                    . "<td bgcolor='#ffcc66' align='center'>$row->placementDate</td>"
                                                                                    . "<td bgcolor='#ffcc66' align='center'>$row->prefferedCommenceDate</td>"
                                                                                    . "<td bgcolor='#ffcc66' align='center'>$row->offerPrice</td>"
                                                                                    . "<td bgcolor='#ffcc66' align='center'>$row->numberOfDays</td>"
                                                                                    . "<td bgcolor='#ffcc66' align='center'>"
                                                                                    . "     "
                                                                                    . "</td>"
                                                                                    . "</tr>"; 
                                                                        }else if($row->seen == 0 && $jobController->id == $_SESSION['id'] && $row->bidStatus == NULL)
                                                                        {
                                                                            $result.= "<tr>"
                                                                                    . "<td bgcolor='#ccd7ea' align='center'><a href='ViewUserProfile.php?epr=viewAndSetBidSeen&id=".$userModel->GetUserById($row->userID)->id."&jobId=".$jobController->jobid."'>$name</a></td>"
                                                                                    . "<td bgcolor='#ccd7ea' align='center'>$row->comment</td>"
                                                                                    . "<td bgcolor='#ccd7ea' align='center'>$row->placementDate</td>"
                                                                                    . "<td bgcolor='#ccd7ea' align='center'>$row->prefferedCommenceDate</td>"
                                                                                    . "<td bgcolor='#ccd7ea' align='center'>$row->offerPrice</td>"
                                                                                    . "<td bgcolor='#ccd7ea' align='center'>$row->numberOfDays</td>"
                                                                                    . "<td bgcolor='#ccd7ea' align='center'>"
                                                                                    ."      <a href='#' onclick='acceptOffer(".$userModel->GetUserById($row->userID)->id.")'>Accept</a>&nbsp|"
                                                                                    . "     <a href='#' onclick='declineOffer(".$userModel->GetUserById($row->userID)->id.")'>Decline</a>"
                                                                                    . "</td>"
                                                                                    . "</tr>";
                                                                        } else if($row->seen == 1 && $jobController->id == $_SESSION['id'] && $row->bidStatus == NULL)
                                                                        {
                                                                            $result.= "<tr>"
                                                                                    . "<td align='center'><a href='ViewUserProfile.php?epr=view&id=".$userModel->GetUserById($row->userID)->id."'>$name</a></td>"
                                                                                    . "<td align='center'>$row->comment</td>"
                                                                                    . "<td align='center'>$row->placementDate</td>"
                                                                                    . "<td align='center'>$row->prefferedCommenceDate</td>"
                                                                                    . "<td align='center'>$row->offerPrice</td>"
                                                                                    . "<td align='center'>$row->numberOfDays</td>"
                                                                                    . "<td align='center'>"
                                                                                    ."     <a href='#' onclick='acceptOffer(".$userModel->GetUserById($row->userID)->id.")'>Accept</a>&nbsp|"
                                                                                    . "     <a href='#' onclick='declineOffer(".$userModel->GetUserById($row->userID)->id.")'>Decline</a>"
                                                                                    . "</td>"
                                                                                    . "</tr>";
                                                                        }else if($row->seen == 0 && $jobController->id == $_SESSION['id'] && $row->bidStatus == 1)
                                                                        {
                                                                            $result.= "<tr>"
                                                                                    . "<td bgcolor='lightgreen' align='center'><a href='ViewUserProfile.php?epr=viewAndSetBidSeen&id=".$userModel->GetUserById($row->userID)->id."&jobId=".$jobController->jobid."'>$name</a></td>"
                                                                                    . "<td bgcolor='lightgreen' align='center'>$row->comment</td>"
                                                                                    . "<td bgcolor='lightgreen' align='center'>$row->placementDate</td>"
                                                                                    . "<td bgcolor='lightgreen' align='center'>$row->prefferedCommenceDate</td>"
                                                                                    . "<td bgcolor='lightgreen' align='center'>$row->offerPrice</td>"
                                                                                    . "<td bgcolor='lightgreen' align='center'>$row->numberOfDays</td>";
                                                                            
                                                                                    $time = strtotime($jobStartDate);
                                                                                    $jobEndDate = new DateTime(date('Y-m-d',$time));
                                                                                    $jobEndDate->modify('+'.$jobController->numberOfDays.' day');
                                                                                    
                                                                                    if(!(time() >= strtotime($jobStartDate)))
                                                                                    {
                                                                                        $result.= "<td bgcolor='lightgreen' align='center'>"
                                                                                        ."      <a href='#' onclick='cancelOffer(".$userModel->GetUserById($row->userID)->id.",".$jobController->jobid.")'>Cancel</a>"
                                                                                        . "</td>"
                                                                                        . "</tr>";
                                                                                    }else if((time() >= strtotime($jobEndDate->format("Y-m-d H:i:s"))))
                                                                                    {
                                                                                        require_once 'Model/PaymentModel.php';
                                                                                        
                                                                                        $paymentModel = new PaymentModel();
                                                                                        $paymentConfirmed = $paymentModel->GetPaymentMeAccountByUserIdTargetUserIdAndJobId($_SESSION['id'], $row->userID, $_SESSION['jobId']);
                                                                                        if($paymentConfirmed != NULL)
                                                                                        {
                                                                                            if($paymentConfirmed->status == 2)
                                                                                            {
                                                                                                $result.= "<td bgcolor='lightgreen' align='center'>"
                                                                                                        ."Paid"
                                                                                                . "</td>"
                                                                                                . "</tr>"; 
                                                                                            }else if($paymentConfirmed->status == 1)
                                                                                            {
                                                                                                $result.= "<td bgcolor='lightgreen' align='center'>"
                                                                                                        ."      <a href='PayUser.php?epr=pay&userId=$row->userID'>Pay</a>"
                                                                                                . "</td>"
                                                                                                . "</tr>"; 
                                                                                            }
                                                                                        }else
                                                                                        {
                                                                                            $result.= "<td bgcolor='lightgreen' align='center'>"
                                                                                                    ."      <a href='PayUser.php?epr=pay&userId=$row->userID'>Pay</a>"
                                                                                            . "</td>"
                                                                                            . "</tr>"; 
                                                                                        }
                                                                                    }else
                                                                                    {
                                                                                        $result.= "<td bgcolor='lightgreen' align='center'>"
                                                                                        . "</td>"
                                                                                        . "</tr>"; 
                                                                                    }
                                                                        }else if($row->seen == 1 && $jobController->id == $_SESSION['id'] && $row->bidStatus == 1)
                                                                        {
                                                                            $result.= "<tr>"
                                                                                    . "<td bgcolor='lightgreen' align='center'><a href='ViewUserProfile.php?epr=viewAndSetBidSeen&id=".$userModel->GetUserById($row->userID)->id."&jobId=".$jobController->jobid."'>$name</a></td>"
                                                                                    . "<td bgcolor='lightgreen' align='center'>$row->comment</td>"
                                                                                    . "<td bgcolor='lightgreen' align='center'>$row->placementDate</td>"
                                                                                    . "<td bgcolor='lightgreen' align='center'>$row->prefferedCommenceDate</td>"
                                                                                    . "<td bgcolor='lightgreen' align='center'>$row->offerPrice</td>"
                                                                                    . "<td bgcolor='lightgreen' align='center'>$row->numberOfDays</td>";
                                                                            
                                                                                    $time = strtotime($jobStartDate);
                                                                                    $jobEndDate = new DateTime(date('Y-m-d',$time));
                                                                                    $jobEndDate->modify('+'.$jobController->numberOfDays.' day');
                                                                                    
                                                                                    if(!(time() >= strtotime($jobStartDate)))
                                                                                    {
                                                                                        $result.= "<td bgcolor='lightgreen' align='center'>"
                                                                                        ."      <a href='#' onclick='cancelOffer(".$userModel->GetUserById($row->userID)->id.",".$jobController->jobid.")'>Cancel</a>"
                                                                                        . "</td>"
                                                                                        . "</tr>";
                                                                                    }else if((time() >= strtotime($jobEndDate->format("Y-m-d H:i:s"))))
                                                                                    {
                                                                                        require_once 'Model/PaymentModel.php';
                                                                                        
                                                                                        $paymentModel = new PaymentModel();
                                                                                        $paymentConfirmed = $paymentModel->GetPaymentMeAccountByUserIdTargetUserIdAndJobId($_SESSION['id'], $row->userID, $_SESSION['jobId']);
                                                                                        if($paymentConfirmed != NULL)
                                                                                        {
                                                                                            if($paymentConfirmed->status == 2)
                                                                                            {
                                                                                                $result.= "<td bgcolor='lightgreen' align='center'>"
                                                                                                        ."Paid"
                                                                                                . "</td>"
                                                                                                . "</tr>"; 
                                                                                            }else if($paymentConfirmed->status == 1)
                                                                                            {
                                                                                                $result.= "<td bgcolor='lightgreen' align='center'>"
                                                                                                        ."      <a href='PayUser.php?epr=pay&userId=$row->userID'>Pay</a>"
                                                                                                . "</td>"
                                                                                                . "</tr>"; 
                                                                                            }
                                                                                        }else
                                                                                        {
                                                                                            $result.= "<td bgcolor='lightgreen' align='center'>"
                                                                                                    ."      <a href='PayUser.php?epr=pay&userId=$row->userID'>Pay</a>"
                                                                                            . "</td>"
                                                                                            . "</tr>"; 
                                                                                        }
                                                                                    }else
                                                                                    {
                                                                                        $result.= "<td bgcolor='lightgreen' align='center'>"
                                                                                        . "</td>"
                                                                                        . "</tr>"; 
                                                                                    }
                                                                        }else if($row->seen == 0 && $jobController->id == $_SESSION['id'] && $row->bidStatus == 0)
                                                                        {
                                                                            $result.= "<tr>"
                                                                                    . "<td bgcolor='#ffcc66' align='center'><a href='ViewUserProfile.php?epr=viewAndSetBidSeen&id=".$userModel->GetUserById($row->userID)->id."&jobId=".$jobController->jobid."'>$name</a></td>"
                                                                                    . "<td bgcolor='#ffcc66' align='center'>$row->comment</td>"
                                                                                    . "<td bgcolor='#ffcc66' align='center'>$row->placementDate</td>"
                                                                                    . "<td bgcolor='#ffcc66' align='center'>$row->prefferedCommenceDate</td>"
                                                                                    . "<td bgcolor='#ffcc66' align='center'>$row->offerPrice</td>"
                                                                                    . "<td bgcolor='#ffcc66' align='center'>$row->numberOfDays</td>"
                                                                                    . "<td bgcolor='#ffcc66' align='center'>"
                                                                                    ."      "
                                                                                    . "</td>"
                                                                                    . "</tr>"; 
                                                                        }else if($row->seen == 1 && $jobController->id == $_SESSION['id'] && $row->bidStatus == 0)
                                                                        {
                                                                            $result.= "<tr>"
                                                                                    . "<td bgcolor='#ffcc66' align='center'><a href='ViewUserProfile.php?epr=viewAndSetBidSeen&id=".$userModel->GetUserById($row->userID)->id."&jobId=".$jobController->jobid."'>$name</a></td>"
                                                                                    . "<td bgcolor='#ffcc66' align='center'>$row->comment</td>"
                                                                                    . "<td bgcolor='#ffcc66' align='center'>$row->placementDate</td>"
                                                                                    . "<td bgcolor='#ffcc66' align='center'>$row->prefferedCommenceDate</td>"
                                                                                    . "<td bgcolor='#ffcc66' align='center'>$row->offerPrice</td>"
                                                                                    . "<td bgcolor='#ffcc66' align='center'>$row->numberOfDays</td>"
                                                                                    . "<td bgcolor='#ffcc66' align='center'>"
                                                                                    ."      "
                                                                                    . "</td>"
                                                                                    . "</tr>"; 
                                                                        }else
                                                                        {
                                                                            $result.= "<tr>"
                                                                                    . "<td align='center'></td>"
                                                                                    . "<td align='center'>$row->comment</td>"
                                                                                    . "<td align='center'>$row->placementDate</td>"
                                                                                    . "<td align='center'>$row->prefferedCommenceDate</td>"
                                                                                    . "<td align='center'>$row->offerPrice</td>"
                                                                                    . "<td align='center'>$row->numberOfDays</td>"
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
                    ."</div>"
                . "</div>"
            . "</div>";
        
        return $result;
    }
    
    // View the Job Details
    function ViewJobDetailsSideBar($id)
    {
        $jobController = $this->GetJobsByID($id);
        
        $userModel = new UserModel();
        
        $userName = $userModel->GetUserById($jobController->id)->username;
        $user = $userModel->GetUserById($jobController->id);
        
        $followingModel = new FollowingModel();
        $followed = $followingModel->CheckIfUserAlreadyFollowedAnotherUser($_SESSION['id'], $user->id);
        
        $result = "<div class='col-md-12'>
			<div class='profile-sidebar'>
				<!-- SIDEBAR USERPIC -->
				<div class='profile-userpic'>
					<img src='$user->photo' class='img-responsive' alt=''>
				</div>
				<!-- END SIDEBAR USERPIC -->
				<!-- SIDEBAR USER TITLE -->
				<div class='profile-usertitle'>
					<div class='profile-usertitle-name'>
						$userName
					</div>
					<div class='profile-usertitle-job'>
						Developer
					</div>
				</div>
				<!-- END SIDEBAR USER TITLE -->
				<!-- SIDEBAR BUTTONS -->
				<div class='nav-button-sidebar'>";
                                    if($followed != NULL)
                                    {
                                        $result.= "<a href='Following.php?epr=unfollowfromViewJob&followinguserId=$user->id' style='margin-bottom:10px;' class='btn btn-success btn-sm'>
                                        Un-Follow </a>";
                                    }else
                                    {
                                        $result.= "<a href='Following.php?epr=followfromviewjob&followinguserId=$user->id' style='margin-bottom:10px;' class='btn btn-success btn-sm'>
                                        Follow </a>";
                                    }
                                    $result.= "<div class='row'>
                                        <a href='#' data-toggle='modal' class='btn btn-success btn-sm' data-target='#sendMessageModal' onclick='$(#sendMessageModal).modal({backdrop: static});'>
                                        Message </a>
                                    </div>
				</div>
				<!-- END SIDEBAR BUTTONS -->
				<!-- SIDEBAR MENU -->
				<div class='profile-usermenu'>
					<ul class='nav'>
						<li class='active'>
							<a href='ViewUserProfile.php?epr=view&id=".$jobController->id."'style='text-align:center;'>
							<i class='glyphicon glyphicon-home'></i>
							View Profile </a>
						</li>
						<li>
							<a href='#' style='text-align:center;'>
							<i class='glyphicon glyphicon-user'></i>
							Contact </a>
						</li>
						<li>
							<a href='ReportJob.php?epr=reportjob&jobId=$jobController->jobid' target='_blank' style='text-align:center;'>
							<i class='glyphicon glyphicon-flag'></i>
							Report </a>
						</li>
					</ul>
				</div>
				<!-- END MENU -->
			</div>
		</div>";
                
        return $result;
    }
    
    // Modal To Send A New Messages
    function SendMessageModal($id)
    {
        $jobController = $this->GetJobsByID($id);
        
        $userModel = new UserModel();
        
        $userName = $userModel->GetUserById($jobController->id)->username;
        $_SESSION['SendUsername']=$userName;
                $result = "
                    <div class='modal fade' id='sendMessageModal' role='dialog'>
			<div class='modal-dialog'>
			
			  <!-- Modal content-->
			  <div class='modal-content'>
				<div class='modal-header'>
				  <button type='button' class='close' data-dismiss='modal'>&times;</button>
				  <h4 class='modal-title'>Send User a Message</h4>
				</div>
				<div class='modal-body'>
                                <div class='row'>
                                    <form action='' method = 'POST'>
                                                    <div class='msg-container'>
                                                        <div class='msg-area' id='msg-area'>";
                                                            $result.="<div class='msgc' style='margin-bottom: 30px;'> 
                                                                    <div class='msg msgfrom'> Send A New Message :) </div> 
                                                                    <div class='msgarr msgarrfrom'></div>
                                                                    <div class='msgsentby msgsentbyfrom'>Type your message in the message box and click send.</div> 
                                                                    </div>";

                                                            $result.="<div class='msgc'> 
                                                                      <div class='msg'> <a href='Messages.php?epr=view&fromusername=".$userName."'> View Previous Conversation </a> </div>
                                                                      <div class='msgarr'></div>
                                                                      <div class='msgsentby'>View your previous conversation between this user</div>
                                                                      </div>";
                                             $result.="</div>
                                                        
                                                          <fieldset>
                                                          
                                                            <div class='clearfix'>
                                                            <label for='messages' class='col-md-2 col-sm-2'> Message: </label>
                                                              <textarea class='col-md-8 col-sm-8' rows='5' id='messages' name = 'messages' placeholder='Message' required autofocus></textarea>
                                                            </div>

                                                            <div class='row'>
                                                            <button class='btn primary col-sm-2 col-sm-offset-2 col-md-2 col-md-offset-9' Style='margin-left:185px;' name = 'sendMessage' type='submit'>Send</button>
                                                            </div>
                                                          </fieldset>
                                    </form>
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
    
    // Modal To Send A New Messages
    function SendMessageFromUserJobPostedModal($id)
    {
        $userModel = new UserModel();
        
        $userName = $userModel->GetUserById($id)->username;
        $_SESSION['SendUsername']=$userName;
                $result = "
                    <div class='modal fade col-xs-11' id='sendMessageModal' role='dialog'>
			<div class='modal-dialog'>
			
			  <!-- Modal content-->
			  <div class='modal-content'>
				<div class='modal-header'>
				  <button type='button' class='close' data-dismiss='modal'>&times;</button>
				  <h4 class='modal-title'>Send User a Message</h4>
				</div>
				<div class='modal-body'>
                                <div class='row'>
                                    <form action='' method = 'POST'>
                                                    <div class='msg-container'>
                                                        <div class='msg-area' id='msg-area'>";
                                                            $result.="<div class='msgc' style='margin-bottom: 30px;'> 
                                                                    <div class='msg msgfrom'> Send A New Message :) </div> 
                                                                    <div class='msgarr msgarrfrom'></div>
                                                                    <div class='msgsentby msgsentbyfrom'>Type your message in the message box and click send.</div> 
                                                                    </div>";

                                                            $result.="<div class='msgc'> 
                                                                      <div class='msg'> <a href='Messages.php?epr=view&fromusername=".$userName."'> View Previous Conversation </a> </div>
                                                                      <div class='msgarr'></div>
                                                                      <div class='msgsentby'>View your previous conversation between this user</div>
                                                                      </div>";
                                             $result.="</div>
                                                        
                                                          <fieldset>
                                                          
                                                            <div class='clearfix'>
                                                            <label for='messages' class='col-md-2 col-sm-2 col-xs-3'> Message: </label>
                                                              <textarea class='col-md-8 col-sm-8 col-xs-8' rows='5' id='messages' name = 'messages' placeholder='Message' required autofocus></textarea>
                                                            </div>

                                                            <div class='row'>
                                                            <button class='btn primary col-sm-2 col-sm-offset-9 col-md-2 col-md-offset-9' Style='margin-left:185px;' name = 'sendMessage' type='submit'>Send</button>
                                                            </div>
                                                          </fieldset>
                                    </form>
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
    
   // View the Job Details
    function ViewJobDetailsOfYourJobSideBar()
    {
        $jobModel = new JobModel();
        $job= $jobModel->GetJobsByID($_SESSION['jobId']);
        $jobStartDate = $job->startDate;
        
        $result = "<div class='col-md-12 col-sm-12'>
			<div class='profile-sidebar'>
				<!-- SIDEBAR MENU -->
				<div class='profile-usermenu'>
					<ul class='nav'>";
                                            if(!(time() >= strtotime($jobStartDate)))
                                            {
						$result.="<li class='active'>
							<a href='EditJob.php?epr=update&id=".$_SESSION['jobId']."' style='text-align:center;'>
							<i class='glyphicon glyphicon-edit'></i>
							Update This Job </a>
						</li>";
                                            
						$result.="<li>
							<a href='#' style='text-align:center;'>
							<i class='glyphicon glyphicon-remove'></i>
							De-Activate This Job </a>
						</li>";
                                            }else
                                            {
						$result.="<li class='active'>
							<a href='#' data-toggle='modal' data-target='#jobAlreadyStartedModal' style='text-align:center;'>
							<i class='glyphicon glyphicon-edit'></i>
							Update This Job </a>
						</li>";
                                            
						$result.="<li>
							<a href='#' style='text-align:center;'>
							<i class='glyphicon glyphicon-remove'></i>
							De-Activate This Job </a>
						</li>"; 
                                            }
						$result.="<li>
							<a href='#' target='_blank' style='text-align:center;'>
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
    
   // View the Job Details
    function JobPostedContent($id)
    {
        
        $userModel = new UserModel();
        
        $jobModel = new JobModel();
        $qualificationModel = new QualificationModel();
        
        $search = $jobModel->GetActiveJobsByUserID($id);
        $typeModel = new TypeModel();
        
        $placedOffersModel = new PlacedOffersModel();
        $allOfUsersPlacedOffers = $placedOffersModel->GetAllPlacedOffersByUserID($id);
        
        $result = "<div class='row'>"
                    . "<div class='panel-group col-md-7'>
			  <div class='panel panel-default'>
					<div class='panel-heading' style='text-align:center;'>
					<a data-toggle='collapse' data-parent='#accordion' href='#collapseadvertisedjobs' class='glyphicon glyphicon-hand-up'><strong>Active Jobs</strong></a>
					</div>
					<div id='collapseadvertisedjobs' class='panel-collapse collapse in'>
						<div class='panel-body'>
                                                    <div class='table-responsive scrollit'>"
                                                        . "<table class='table sortable'>"
                                                        . "<tr>"
                                                        . "     <th style='text-align:center;'>Job</th>"
                                                        . "     <th style='text-align:center;'>Description</th>"
                                                        . "     <th style='text-align:center;'>Category</th>"
                                                        . "     <th style='text-align:center;'>Qualificaion</th>"
                                                        . "     <th style='text-align:center;'>No. Offers</th>"
                                                        . "</tr>";
                                                        try
                                                        {
                                                            if($search != null)
                                                            {
                                                                foreach($search as $row)
                                                                {
                                                                    $type = $typeModel->GetTypeByID($row->type);
                                                                    $qualification = $qualificationModel->GetQualificationByID($row->qualification);
                                                                    $noOffers = $placedOffersModel->CountViewUserJobNoPlacedOffersByJobId($row->jobid);
                                                                    $result.= "<tr>"
                                                                            . "<td align='center'><a href='SearchResult.php?epr=view&id=".$row->jobid."&typeId=".$row->type."'>$row->name</a></td>"
                                                                            . "<td align='center'>$row->description</td>"
                                                                            . "<td align='center'>$type->name</td>"
                                                                            . "<td align='center'>$qualification->qualificationName</td>"
                                                                            . "<td align='center'>$noOffers</td>"
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
                . "<div class='panel-group col-md-5'>
			  <div class='panel panel-default'>
					<div class='panel-heading' style='text-align:center;'>
					<a data-toggle='collapse' data-parent='#accordion' href='#collapseMyPlacedOffers' class='glyphicon glyphicon-hand-up'><strong>Offer Placed This User</strong></a>
					</div>
					<div id='collapseMyPlacedOffers' class='panel-collapse collapse in'>
						<div class='panel-body'>"
                                                        . "<table class='table sortable'>"
                                                        . "<tr>"
                                                        . "     <th style='text-align:center;'>Job</th>"
                                                        . "     <th style='text-align:center;'>Price</th>"
                                                        . "     <th style='text-align:center;'>Date</th>"
                                                        . "</tr>";
                                                        try
                                                        {
                                                            if($allOfUsersPlacedOffers != null)
                                                            {
                                                                foreach($allOfUsersPlacedOffers as $row)
                                                                {
                                                                    $result.= "<tr>"
                                                                            . "<td align='center'><a href='SearchResult.php?epr=view&id=".$row->jobid."'>".$jobModel->GetJobsByID($row->jobid)->name."</a></td>"
                                                                            . "<td align='center'>$row->offerPrice</td>"
                                                                            . "<td align='center'>$row->placementDate</td>"
                                                                            . "</tr>";
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
                . "</div>";
                
        return $result;
    }
    
    //Get Jobs By Number of Days Required.
    function GetLastpostedJobs()
    {
        $jobModel = new JobModel();
        return $jobModel->GetLastpostedJobs();
    }
    
    //Insert a new admin user into the database
    function InsertAJob($id)
    {
        $name = $_POST["name"];
        $description = $_POST["description"];
        $type = $_POST["typeId"];
        $qualification = $_POST["qualificationId"];
        $address = $_POST["address"];
        $county = $_POST["county"];
        $numberOfDays = $_POST["numberOfDays"];
        $numberOfPeopleRequired = $_POST["numberOfPeopleRequired"];
        $price = $_POST["price"];
        $isActive = 1;
        
        //Today's date
        $date = new DateTime();
        $dateTime = $date->format('d-m-Y H:i:s');
        
        $startDate = $_POST["startDate"];

        $job = new JobEntities(-1, $name, $description, $type, $qualification, $address, $county, $numberOfDays, $numberOfPeopleRequired, $price, $isActive, $id, $dateTime,$startDate,$_SESSION['adType']);
        $jobModel = new JobModel();
        $jobModel->InsertANewJob($job);
    }
    
    //Insert a new job into the database
    function InsertANewJobPaymentCompleted($name, $description, $type, $qualification, $address, $county, $numberOfDays, $numberOfPeopleRequired, $price, $isActive, $id, $dateTime,$startDate, $adType)
    {
         $jobModel = new JobModel();
         $jobModel->InsertANewJobPaymentCompleted($name, $description, $type, $qualification, $address, $county, $numberOfDays, $numberOfPeopleRequired, $price, $isActive, $id, $dateTime, $startDate, $adType);
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
    
    //Update a job
    function updateJob($name,$description1,$type,$qualification,$address,$county,$numberOfDays,$numberOfPeopleRequired,$price,$jobid,$startDate)
    {
        $jobModel = new JobModel();
        return $jobModel->updateJob($name,$description1,$type,$qualification,$address,$county,$numberOfDays,$numberOfPeopleRequired,$price,$jobid,$startDate);
    }
    
    //Update a job to be a featured job
    function updateStandardJobToFeaturedJob($jobid,$adType)
    {
        $jobModel = new JobModel();
        $jobModel->updateStandardJobToFeaturedJob($jobid, $adType);
    }
    
    //Update a job posted date
    function updateJobPostedDate($jobid,$date)
    {
        $jobModel = new JobModel();
        $jobModel->updateJobPostedDate($jobid, $date);
    }
    
    //Update a job active status
    function updateJobActiveStatus($jobid,$activeStatus)
    {
        $jobModel = new JobModel();
        $jobModel->updateJobActiveStatus($jobid, $activeStatus);  
    }
    
    //Update a job Ad Type
    function updateJobAdType($jobid,$adType)
    {
        $jobModel = new JobModel();
        $jobModel->updateJobAdType($jobid, $adType);
    }
    
    //Update a job Date
    function updateJobDate($jobid,$date)
    {
        $jobModel = new JobModel();
        $jobModel->updateJobDate($jobid, $date); 
    }
    
    //Update a job Start Date
    function updateJobStartDate($jobid,$date)
    {
        $jobModel = new JobModel();
        $jobModel->updateJobStartDate($jobid, $date); 
    }
    
    //Delete a job
    function deleteJob($id)
    {
        $jobModel = new JobModel();
        $jobModel->deleteJob($id);
    }
    
}
