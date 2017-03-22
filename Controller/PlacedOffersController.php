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
require 'Model/NotificationModel.php';

class PlacedOffersController {

    // Place An Offer To A Job
    function PlaceAnOffer($jobId, $userId, $comment, $date, $offerPrice,$fromusername,$tousername,$bidType,$numberOfDays,$prefferedCommenceDate)
    {
        $placedOffersModel = new PlacedOffersModel();
        $placedOffersModel->PlaceAnOffer($jobId, $userId, $comment, $date, $offerPrice,$bidType,$numberOfDays,$prefferedCommenceDate);
        
        $notificationModel = new NotificationModel();
        $notificationModel->InsertNotification($fromusername, $tousername, 2, 0, $date,$jobId);
    }
    
    //Update an offer
    function updateAnOffer($jobid,$userId,$newDate,$offerPrice,$comment,$fromusername,$tousername,$numberOfDays,$prefferedCommenceDate)
    {
        $placedOffersModel = new PlacedOffersModel();
        $placedOffersModel->updateAnOffer($jobid, $userId, $newDate, $offerPrice, $comment, $numberOfDays, $prefferedCommenceDate);
        
        //Today's date
        $date = new DateTime();
        $dateTime = $date->format('Y-m-d H:i:s');
        
        $notificationModel = new NotificationModel();
        $notificationModel->InsertNotification($fromusername, $tousername, 5, 0, $dateTime,$jobid);
    }
    
    //Update seen
    function updateSeen($seen,$jobid,$userId)
    {
        $placedOffersModel = new PlacedOffersModel();
        $placedOffersModel->updateSeen($seen, $jobid, $userId);
    }
    
    //Update Bid Status
    function updateBidStatus($status,$jobid,$userId)
    {
        $placedOffersModel = new PlacedOffersModel();
        $placedOffersModel->updateBidStatus($status, $jobid, $userId); 
    }
    
    // Get The Lowest Placed Offers Price in a specific job
    function GetLowestPlacedOffersByJobId($jobid)
    {
        $placedOffersModel = new PlacedOffersModel();
        return $placedOffersModel->GetLowestPlacedOffersByJobId($jobid);
    }
    
    // Get All Placed Offers By UserID
    function GetAllPlacedOffersByUserID($UserID)
    {
        $placedOffersModel = new PlacedOffersModel();
        return $placedOffersModel->GetAllPlacedOffersByUserID($UserID);
    }
    
    // Get All Placed Offers By UserID
    function GetAllPlacedOffersToUsersJob($id)
    {
        $placedOffersModel = new PlacedOffersModel();
        return $placedOffersModel->GetAllPlacedOffersToUsersJob($id);
    }
    
    // Get All Placed Offers in a specific job
    function GetAllPlacedOffers()
    {
        $placedOffersModel = new PlacedOffersModel();
        $placedOffersModel->GetAllPlacedOffers();
    }
    
    // Get All Accepted Placed Offers By UserID
    function GetAllAcceptedPlacedOffersByUserID($UserID)
    {
        $placedOffersModel = new PlacedOffersModel();
        $placedOffersModel->GetAllAcceptedPlacedOffersByUserID($UserID);
    }
    
    // Get All Placed Offers by other users I accepted
    function GetAllPlacedOffersIAccepted($userId)
    {
        $placedOffersModel = new PlacedOffersModel();
        $placedOffersModel->GetAllPlacedOffersIAccepted($userId);
    }
    
    // Get Users Placed Offers
    function GetUsersPlacedOffer($jobid,$userId)
    {
        $placedOffersModel = new PlacedOffersModel();
        $placedOffersModel->GetUsersPlacedOffer($jobid, $userId);
    }
    
    // Get All User Placed Offers in a specific job by a specific person and return a boolean value
    function GetUserlacedOffersByJobIdAndUserId($jobid,$userId)
    {
        $placedOffersModel = new PlacedOffersModel();
        $placedOffersModel->GetUserlacedOffersByJobIdAndUserId($jobid, $userId);
    }
    
    // Get All Placed Offers By jobId
    function GetAllPlacedOffersByJobID($jobId)
    {
        $placedOffersModel = new PlacedOffersModel();
        return $placedOffersModel->GetAllPlacedOffersByJobID($jobId);
    }
    
    // Get All Placed In User Profile Offers in a specific job
    function CountViewUserJobNoPlacedOffersByJobId($jobid)
    {
        $placedOffersModel = new PlacedOffersModel();
        return $placedOffersModel->CountViewUserJobNoPlacedOffersByJobId($jobid);
    }
    
    //Delete an Offer
    function deleteAnOffer($jobid,$userId)
    {
        $placedOffersModel = new PlacedOffersModel();
        $placedOffersModel->deleteAnOffer($jobid, $userId);
    }
}
