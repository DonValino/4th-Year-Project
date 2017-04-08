<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ActiveUserController
 *
 * @author Jake Valino
 */
require ("Model/ActiveUsersModel.php");
class ActiveUsersController {

    // Insert A New Active User
    function InsertANewActiveUser($userId, $date, $latest)
    {
        $activeUsersModel = new ActiveUsersModel();
        $activeUsersModel->InsertANewActiveUser($userId, $date, $latest);
        
    }
    
    // Get Active User By Id
    function GetActiveUserByUserId($userId)
    {
        $activeUsersModel = new ActiveUsersModel();
        return $activeUsersModel->GetActiveUserByUserId($userId);
    }
    
    // Get All Active Users
    function GetAllActiveUsers()
    {
        $activeUsersModel = new ActiveUsersModel();
        return $activeUsersModel->GetAllActiveUsers();
    }
    
    //Get Sum Of Active Users By Month And Year.
    function GetSumActiveUsersByMonthYear($month,$year)
    {
        $activeUsersModel = new ActiveUsersModel();
        return $activeUsersModel->GetSumActiveUsersByMonthYear($month, $year);
    }
    
    // Update Latest Active User By UserId
    function updateLatestActiveUserByUserId($latest,$userId)
    {
        $activeUsersModel = new ActiveUsersModel();
        $activeUsersModel->updateLatestActiveUserByUserId($latest, $userId);
    }
}
