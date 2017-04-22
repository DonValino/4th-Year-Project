<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserReviewController
 *
 * @author Jake Valino
 */
require ("Model/UserReviewModel.php");

class UserReviewController {
    
    //Insert a new review into the database
    function InsertANewReview($reviewer,$userdid,$description,$punctionalities,$workSatisfaction,$skill, $date)
    {
        $userReviewModel = new UserReviewModel();
        $userReviewModel->InsertANewReview($reviewer,$userdid,$description,$punctionalities,$workSatisfaction,$skill, $date);
    }
    
    // Get All Reviews From A Specific User
    function GetUserReviewById($id)
    {
        $userReviewModel = new UserReviewModel();
        return $userReviewModel->GetUserReviewById($id);
    }
    // Number of reviews per user
    function GetNumberOfUserReviewById($id)
    {
        $userReviewModel = new UserReviewModel();
        return $userReviewModel->GetNumberOfUserReviewById($id); 
    }
    // View to display user profile
    function UserReviewContent($id)
    {
        $review = $this->GetUserReviewById($id);
        $count = $this->GetNumberOfUserReviewById($id);
        $result="<div class='row'>"
                    . "<div class='panel-group col-md-12 col-sm-12 col-xs-12'>
			  <div class='panel panel-default alert alert-info'>
                                    <div class='panel-heading' style='text-align:center;'>
					<a data-toggle='collapse' data-parent='#accordion' href='#collapseusersummary' class='glyphicon glyphicon-hand-up'><strong>Summary</strong></a>
					</div>
					<div id='collapseusersummary' class='panel-collapse collapse in'>
						<div class='panel-body'>
                                                <div class='col-md-12 col-sm-12 col-xs-12'>
                                                    <div class='row'>
                                                    <p style='text-align:center;'><strong>Based on $count reviews</strong></p>
                                                    </div>
                                                            <div class='col-xs-1 col-sm-1 col-sm-offset-2 col-md-1 col-md-offset-2'>";
                                                                try
                                                                {
                                                                            $actualRate = 0;
                                                                            $expectedRate = 0;
                                                                            $res = 0;
                                                                            if($review != null)
                                                                            {
                                                                                foreach($review as $row1)
                                                                                {
                                                                                    $actualRate= $actualRate + $row1->punctionality;
                                                                                   
                                                                                    $expectedRate = $expectedRate + 5;
                                                                                    
                                                                                    $res = ($actualRate / $expectedRate) * 100;
                                                                                    $res = (int)$res;
                                                                                }
                                                                               
                                                                                $result.="<div class='row'>
                                                                                        <div class='c100 p$res'>
                                                                                          <span>$res%</span>
                                                                                          <div class='slice'>
                                                                                                <div class='bar'></div>
                                                                                                <div class='fill'></div>
                                                                                          </div>
                                                                                        </div>
                                                                                </div>
                                                                                <div class='row'>
                                                                                    <p class='col-md-12 col-sm-12'>Punctionality</p>
                                                                                </div> 
                                                                            </div>";
                                                                                
                                                                                foreach($review as $row1)
                                                                                {
                                                                                    $actualRate= $actualRate + $row1->workSatisfaction;
                                                                                   
                                                                                    $expectedRate = $expectedRate + 5;
                                                                                    
                                                                                    $res = ($actualRate / $expectedRate) * 100;
                                                                                    $res = (int)$res;
                                                                                }
                                                                            
                                                                            $result.="<div class='col-xs-1 col-xs-offset-3 col-sm-1 col-sm-offset-2 col-md-1 col-md-offset-2' style='padding-left:20px;'>
                                                                                <div class='row'>
                                                                                        <div class='c100 p$res'>
                                                                                          <span>$res%</span>
                                                                                          <div class='slice'>
                                                                                                <div class='bar'></div>
                                                                                                <div class='fill'></div>
                                                                                          </div>
                                                                                        </div>
                                                                                </div>
                                                                                <div class='row'>
                                                                                    <p class='col-md-12 col-sm-12'>Work Satisfaction</p>
                                                                                </div>
                                                                            </div>";
                                                                            
                                                                                foreach($review as $row1)
                                                                                {
                                                                                    $actualRate= $actualRate + $row1->skills;
                                                                                   
                                                                                    $expectedRate = $expectedRate + 5;
                                                                                    
                                                                                    $res = ($actualRate / $expectedRate) * 100;
                                                                                    $res = (int)$res;
                                                                                }
                                                                            $result.="<div class='col-xs-1 col-xs-offset-3 col-sm-1 col-sm-offset-2 col-md-1 col-md-offset-2' style='padding-left:20px;'>
                                                                                <div class='row'>
                                                                                        <div class='c100 p$res'>
                                                                                          <span>$res%</span>
                                                                                          <div class='slice'>
                                                                                                <div class='bar'></div>
                                                                                                <div class='fill'></div>
                                                                                          </div>
                                                                                        </div>
                                                                                </div>
                                                                                <div class='row'>
                                                                                    <p class='col-md-12 col-sm-12'>Skills</p>
                                                                                </div>
                                                                            </div>
                                                                        </div>";
                                                                        }
                                                                }catch(Exception $x)
                                                                {
                                                                    echo 'Caught exception: ',  $x->getMessage(), "\n";
                                                                }
                                             $result.= "</div>"         
						."</div>"
					."</div>"
				."</div>"
			."</div>"
                
                    ."<div class='row'>"
                           . "<div class='panel-group col-md-12 col-sm-12 col-xs-12'>
                                <div class='panel panel-default alert alert-info'>
                                            <div class='panel-heading' style='text-align:center;'>
                                                <a data-toggle='collapse' data-parent='#accordion' href='#collapseuserrating' class='glyphicon glyphicon-hand-up'><strong>Reviews</strong></a>
                                            </div>
                                            <div id='collapseuserrating' class='panel-collapse collapse in'>
                                                    <div class='panel-body'>
                                                    <div class='row'>
                                                        <a href='#' style='width:26%; margin-bottom:10px; margin:auto; display:block;' data-toggle='modal' class='btn btn-success btn-sm' data-target='#addUserReviewModal' onclick='$(#addUserReviewModal).modal({backdrop: static});'>
                                                        Add Review </a>
                                                    </div>
                                                <div class='table-responsive scrollit'>"
                                                . "<table class='table sortable col-xs-12'>"
                                                        . "<tr>"
                                                        . "     <th>Reviewer</th>"
                                                        . "     <th>Description</th>"
                                                        . "     <th>Punctionality</th>"
                                                        . "     <th>Work Satisfaction</th>"
                                                        . "     <th>Skill</th>"
                                                        . "     <th>Date</th>"
                                                        . "     <th>Action: </th>"
                                                        . "</tr>
                                                    <tr>";
                                                        try
                                                        {
                                                            if($review != null)
                                                            {
                                                                foreach($review as $row)
                                                                {
                                                                    $result.="<td>  <p>$row->reviewer</p></td>
                                                                                    <td><p>";$result.=$this->limit_text($row->description,2); $result.="</p></td>
                                                                                    <td><p>$row->punctionality</p></td>
                                                                                    <td><p>$row->workSatisfaction</p></td>
                                                                                    <td><p>$row->skills</p></td>
                                                                                    <td><p>$row->date</p></td>
                                                                                    <td><p class='glyphicon glyphicon-plus' style='text-align:center;'></p></td>
                                                                                    </tr>
                                                                                    <tr><td colspan='7'>                                                                                 
                                                                                    <h4>Description</h4>
                                                                                    <p>$row->description</p>
                                                                                        
                                                                             </td>
                                                    </tr>"
                                                                                            . "</div>";
                                                                }
                                                            }
                                                        }catch(Exception $x)
                                                        {
                                                            echo 'Caught exception: ',  $x->getMessage(), "\n";
                                                        } 
                                                $result.="</table>
<script>
$(function() {
    $('td[colspan=7]').find('p').hide();
    $('td[colspan=7]').find('h4').hide();
    $('table').click(function(event) {
        event.stopPropagation();
        
        if ( $(event.target).closest('td').attr('colspan') > 1 ) {
            $(event.target).slideUp();
        } else {
            $(event.target).closest('tr').next().find('p').slideToggle();
            $(event.target).closest('tr').next().find('h4').slideToggle();
        }                    
    });
});</script>"
                                                    ."</div>"
                                            ."</div>"
                                    ."</div>"
                            ."</div>"
                . "</div>"
               . "</div>";
        
        return $result;
    }
    
function limit_text($text, $limit) {
      if (str_word_count($text, 0) > $limit) {
          $words = str_word_count($text, 2);
          $pos = array_keys($words);
          $text = substr($text, 0, $pos[$limit]) . '...';
      }
      return $text;
    }
}
