<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RevenueTest
 *
 * @author Jake Valino
 */
require ("Controller/RevenueController.php");
class RevenueTest extends \PHPUnit_Framework_TestCase
{
    // Test Insert A New Revenue
    public function testInsertANewRevenue()
    {
        $revenueController = new RevenueController();
       
        $beforeInsertingANewRevenue = $revenueController->GetRevenues();
        
        $revenueController->InsertANewRevenue(100, "Test Date", 36, 0);
        
        $afterInsertingANewRevenue = $revenueController->GetRevenues();
        
        $this->assertEquals(count($beforeInsertingANewRevenue)+1,count($afterInsertingANewRevenue));
    }
    
    // Test Get Revenue User By Id
    public function testGetRevenueByUserId()
    {
        $revenueController = new RevenueController();
        
        $revenues = $revenueController->GetRevenueByUserId(36);
        
        $this->assertNotEquals(0,count($revenues));
    }
    
    // Test Get Sum Of Revenue By Month And Year.
    public function testGetSumRevenueByMonthYear()
    {
        $revenueController = new RevenueController();
        
        $revenues = $revenueController->GetSumRevenueByMonthYear(04, 2017,0);
        
        $this->assertNotEquals(0,count($revenues));
    }
    
    // Test Get Revenues
    public function testGetRevenues()
    {
        $revenueController = new RevenueController();
        
        $revenues = $revenueController->GetRevenues();
        
        $this->assertNotEquals(0,count($revenues));
    }
}
