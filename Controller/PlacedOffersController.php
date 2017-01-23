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
    function PlaceAnOffer($jobId, $userId, $comment, $date, $offerPrice,$fromusername,$tousername)
    {
        $placedOffersModel = new PlacedOffersModel();
        $placedOffersModel->PlaceAnOffer($jobId, $userId, $comment, $date, $offerPrice);
                
        //Today's date
        $date = new DateTime();
        $dateTime = $date->format('Y-m-d H:i:s');
        
        $notificationModel = new NotificationModel();
        $notificationModel->InsertNotification($fromusername, $tousername, 2, 0, $dateTime,$jobId);
    }
    
    //Update an offer
    function updateAnOffer($jobid,$userId,$newDate,$offerPrice,$comment,$fromusername,$tousername)
    {
        $placedOffersModel = new PlacedOffersModel();
        $placedOffersModel->updateAnOffer($jobid, $userId, $newDate, $offerPrice, $comment);
        
        //Today's date
        $date = new DateTime();
        $dateTime = $date->format('Y-m-d H:i:s');
        
        $notificationModel = new NotificationModel();
        $notificationModel->InsertNotification($fromusername, $tousername, 5, 0, $dateTime,$jobid);
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
}
