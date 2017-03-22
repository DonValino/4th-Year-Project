<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SignInController
 *
 * @author Jake Valino
 */

require 'Model/SignInModel.php';

class SignInController {
    
    //Insert a user sign in
    function InsertAUserSignIn($userId,$jobId,$date,$latest)
    {
        $signInModel = new SignInModel();
        $signInModel->InsertAUserSignIn($userId, $jobId, $date, $latest);
    }
    
    //Get All Sign In Records by jobId.
    function GetAllSignInRecordsByJobId($jobId)
    {
        $signInModel = new SignInModel();
        return $signInModel->GetAllSignInRecordsByJobId($jobId);
    }
    
    //Get Sign In Records by userId And jobId.
    function GetSignInRecordsByUserIdAndJobId($userId,$jobId)
    {
       $signInModel = new SignInModel();
       return $signInModel->GetSignInRecordsByUserIdAndJobId($userId, $jobId);
    }
    
    // Count Attendance To A Job
    function CountAttendanceToAJob($userId,$jobId)
    {
        $signInModel = new SignInModel();
        $signInModel->CountAttendanceToAJob($userId, $jobId);
    }
    
    //Update latest status
    function updateLatestStatus($latest,$userId,$jobId)
    {
        $signInModel = new SignInModel();
        $signInModel->updateLatestStatus($latest, $userId, $jobId);
    }
    
}
