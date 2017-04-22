<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RecommenderTest
 *
 * @author Jake Valino
 */
require ("Controller/RecommenderController.php");
class RecommenderTest extends \PHPUnit_Framework_TestCase
{
    //Insert a new record
    public function testInsertANewRecord()
    {
        $recommenderController = new RecommenderController();
        
        $beforeInsertion = $recommenderController->GetAllRecords();
        
        $recommenderController->InsertANewRecord(1, 36, 69, "TEST DATE");
        
        $afterInsertion = $recommenderController->GetAllRecords();
        
        $this->assertEquals(count($beforeInsertion)+1,count($afterInsertion));
    }
    
    // Get Record By userId
    public function testGetRecordByUserId()
    {
        $recommenderController = new RecommenderController();
        
        $record = $recommenderController->GetRecordByUserId(36);
        
        $this->assertNotEquals(0,count($record));
    }
    
    // Update qty by catId and userId
    public function testUpdateQtyByCatIdAndUserId()
    {
        $recommenderController = new RecommenderController();
        
        $recommenderController->updateQtyByCatIdAndUserId(99, 1, 36);
        
        $record = $recommenderController->GetRecordByCatIdAndUserId(1, 36);
        
        $this->assertEquals(99,$record->qty);
    }
}
