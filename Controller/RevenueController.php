<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RevenueController
 *
 * @author Jake Valino
 */

require ("Model/RevenueModel.php");

class RevenueController {
    
    // Insert A New Revenue
    function InsertANewRevenue($amount,$date,$userId, $adType)
    {
        $RevenueModel = new RevenueModel();
        $RevenueModel->InsertANewRevenue($amount, $date, $userId, $adType);
    }
    
    // Get Revenue User By Id
    function GetRevenueByUserId($userId)
    {
        $RevenueModel = new RevenueModel();
        return $RevenueModel->GetRevenueByUserId($userId);
    }
    
    //Get Sum Of Revenue By Month And Year.
    function GetSumRevenueByMonthYear($month,$year,$adType)
    {
        $RevenueModel = new RevenueModel();
        return $RevenueModel->GetSumRevenueByMonthYear($month, $year, $adType);
    }
    
    // Get Revenues
    function GetRevenues()
    {
        $revenueModel = new RevenueModel();
        return $revenueModel->GetRevenues();
    }
}
