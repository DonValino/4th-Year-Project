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
    function InsertANewReview($reviewer,$userdid,$description,$rating, $date)
    {
        $userReviewModel = new UserReviewModel();
        $userReviewModel->InsertANewReview($reviewer, $userdid, $description, $rating, $date);
    }
    
    // Get All Reviews From A Specific User
    function GetUserReviewById($id)
    {
        $userReviewModel = new UserReviewModel();
        return $userReviewModel->GetUserReviewById($id);
    }
    
    // View to display user profile
    function UserReviewContent($id)
    {
        $review = $this->GetUserReviewById($id);

        $result="<div class='row'>"
                    . "<div class='panel-group col-md-12'>
			  <div class='panel panel-default'>
                                    <div class='panel-heading' style='text-align:center;'>
					<a data-toggle='collapse' data-parent='#accordion' href='#collapseusersummary' class='glyphicon glyphicon-hand-up'><strong>Summary</strong></a>
					</div>
					<div id='collapseusersummary' class='panel-collapse collapse in'>
						<div class='panel-body'>
                                                   
                                                            <div class='movie_choice col-md-6'>
                                                                Rate: Raiders of the Lost Ark
                                                                <div id='r1' class='rate_widget'>
                                                                    <div class='star_1 ratings_stars'></div>
                                                                    <div class='star_2 ratings_stars'></div>
                                                                    <div class='star_3 ratings_stars'></div>
                                                                    <div class='star_4 ratings_stars'></div>
                                                                    <div class='star_5 ratings_stars'></div>
                                                                    <div class='total_votes'>vote data</div>
                                                                </div>
                                                            </div>

                                                            <div class='movie_choice col-md-6'>
                                                                Rate: The Hunt for Red October
                                                                <div id='r2' class='rate_widget'>
                                                                    <div class='star_1 ratings_stars'></div>
                                                                    <div class='star_2 ratings_stars'></div>
                                                                    <div class='star_3 ratings_stars'></div>
                                                                    <div class='star_4 ratings_stars'></div>
                                                                    <div class='star_5 ratings_stars'></div>
                                                                    <div class='total_votes'>vote data</div>
                                                                </div>
                                                            </div>
                                                            
       <script>                                                     
        $('.ratings_stars').hover(
            // Handles the mouseover
            function() {
                $(this).prevAll().andSelf().addClass('ratings_over');
                $(this).nextAll().removeClass('ratings_vote'); 
            },
            // Handles the mouseout
            function() {
                $(this).prevAll().andSelf().removeClass('ratings_over');
                set_votes($(this).parent());
            }
        );
        </script>
                                                       "

                                             . "</div>"         
						."</div>"
					."</div>"
				."</div>"
			."</div>"
                
                    ."<div class='row'>"
                           . "<div class='panel-group col-md-12'>
                                <div class='panel panel-default'>
                                            <div class='panel-heading' style='text-align:center;'>
                                                <a data-toggle='collapse' data-parent='#accordion' href='#collapseuserrating' class='glyphicon glyphicon-hand-up'><strong>Reviews</strong></a>
                                            </div>
                                            <div id='collapseuserrating' class='panel-collapse collapse in'>
                                                    <div class='panel-body'>
                                                    <div class='row'>
                                                        <a href='#' style='width:20%; margin-bottom:10px; margin:auto; display:block;' data-toggle='modal' class='btn btn-success btn-sm' data-target='#addUserReviewModal' onclick='$(#addUserReviewModal).modal({backdrop: static});'>
                                                        Add Review </a>
                                                    </div>"
                                                . "<table class='table sortable'>"
                                                        . "<tr>"
                                                        . "     <th>Reviewer</th>"
                                                        . "     <th>Description</th>"
                                                        . "     <th>Rating</th>"
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
                                                                                    <td><p>$row->rating</p></td>
                                                                                    <td><p>$row->date</p></td>
                                                                                    <td><p class='glyphicon glyphicon-plus' style='text-align:center;'></p></td>
                                                                                    </tr>
                                                                                    <tr><td colspan='5'>                                                                                 
                                                                                    <h4>Description</h4>
                                                                                    <p>$row->description</p>
                                                                                        
                                                                             </td>
                                                    </tr>";
                                                                }
                                                            }
                                                        }catch(Exception $x)
                                                        {
                                                            echo 'Caught exception: ',  $x->getMessage(), "\n";
                                                        } 
                                                $result.="</table>
<script>
$(function() {
    $('td[colspan=5]').find('p').hide();
    $('td[colspan=5]').find('h4').hide();
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
