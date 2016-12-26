<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PlacedOffersController
 *
 * @author Jake Valino
 */
require 'Model/PlacedOffersModel.php';

class PlacedOffersController {

    // Place An Offer To A Job
    function PlaceAnOffer($jobId, $userId, $comment, $date, $offerPrice)
    {
        $placedOffersModel = new PlacedOffersModel();
        $placedOffersModel->PlaceAnOffer($jobId, $userId, $comment, $date, $offerPrice);
    }
    
    //Update an offer
    function updateAnOffer($jobid,$userId,$newDate,$offerPrice,$comment)
    {
        $placedOffersModel = new PlacedOffersModel();
        $placedOffersModel->updateAnOffer($jobid, $userId, $newDate, $offerPrice, $comment);
    }
    
   // Modal To Enable The User To Place An Offer
   function PlaceAnOfferModal()
    {
                $result = "<div class='modal fade' id='placeAnOfferModal' role='dialog'>
			<div class='modal-dialog'>
			
			  <!-- Modal content-->
			  <div class='modal-content'>
				<div class='modal-header'>
				  <button type='button' class='close' data-dismiss='modal'>&times;</button>
				  <h4 class='modal-title'>Place An Offer</h4>
				</div>
				<div class='modal-body'>
                                <div class='row'>
                                    <div class='register-form'>
                                             <div class='row'>
                                               <h2 class='col-md-12' style='text-align:center;'>Place An Offer</h2>
                                             </div>
                                             <form action='' method = 'POST'>
                                               <fieldset>
                                                 <div class='clearfix'>
                                                   <label for='offerPrice' class='col-md-2'> Price: </label>
                                                   <input type='text' name = 'offerPrice' id='offerPrice' class='col-md-8' placeholder='Enter Price' required autofocus>
                                                 </div>
                                                 <div class='clearfix'>
                                                 <label for='comment' class='col-md-2'> Comment: </label>
                                                   <input type='text' name = 'comment' class='col-md-8' placeholder='Comment' required autofocus>
                                                 </div>
                                                 <button class='btn primary col-md-2 col-md-offset-8' name = 'placeOffer' type='submit'>Submit</button>
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
    
   // Modal To Enable The User To Update An Offer
   function UpdateAnOfferModal()
    {
       $placedOffersModel = new PlacedOffersModel();
       $placedOffer = $placedOffersModel->GetPlacedOffersByJobIdAndUserId($_SESSION['jobId'], $_SESSION['id']);
       
       $comment = $placedOffer->comment;
       $offerPrice = $placedOffer->offerPrice;
       
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
                                                 <button class='btn primary col-md-2 col-md-offset-8' name = 'updateOffer' type='submit'>Submit</button>
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
}
