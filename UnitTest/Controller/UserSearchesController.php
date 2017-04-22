<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserSearchesController
 *
 * @author Jake Valino
 */
require ("Model/UserSearchesModel.php");

class UserSearchesController {
    
    //Insert user searches in database
    function InsertANewReview($userId,$keyword,$dateofsearch,$numResult)
    {
        $userSearchesModel = new UserSearchesModel();
        $userSearchesModel->InsertANewReview($userId, $keyword, $dateofsearch, $numResult);
    }
    
    // Number of keyword search per user
    function CountNumberOfUserSearhesById($id)
    {
        $userSearchesModel = new UserSearchesModel();
        return $userSearchesModel->CountNumberOfUserSearhesById($id);
    }
    
    // Get All keyword search From A Specific User
    function GetUserSearhesById($id)
    {
        $userSearchesModel = new UserSearchesModel();
        return $userSearchesModel->GetUserSearhesById($id);
    }
    
    //Update date fo search
    function updateDateOfSearch($id,$dateOfSearch)
    {
        $userSearchesModel = new UserSearchesModel();
        $userSearchesModel->updateDateOfSearch($id, $dateOfSearch);
    }
    
    //Update date fo search
    function updateNumResult($id,$numResult)
    {
        $userSearchesModel = new UserSearchesModel();
        $userSearchesModel->updateNumResult($id, $numResult);
    }
    
    //Delete all user keyword searches
    function deleteKeywordSearches($id)
    {
        $userSearchesModel = new UserSearchesModel();
        $userSearchesModel->deleteKeywordSearches($id);
    }
    
    
}
