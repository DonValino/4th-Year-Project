<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RecommenderController
 *
 * @author Jake Valino
 */

require ("Model/RecommenderModel.php");
class RecommenderController {

    //Insert a new record
    function InsertANewRecord($catId,$userId,$qty,$date)
    {
        $recommenderModel = new RecommenderModel();
        $recommenderModel->InsertANewRecord($catId, $userId,$qty, $date);
    } 
    
    // Get Record By userId
    function GetRecordByUserId($userId)
    {
        $recommenderModel = new RecommenderModel();
        return $recommenderModel->GetRecordByUserId($userId); 
    }
    
    // Get Record By userId
    function GetRecordByCatIdAndUserId($catId,$userId)
    {
        $recommenderModel = new RecommenderModel();
        return $recommenderModel->GetRecordByCatIdAndUserId($catId, $userId); 
    }
    
    // Update qty by catId and userId
    function updateQtyByCatIdAndUserId($qty,$catId,$userId)
    {
        $recommenderModel = new RecommenderModel();
        $recommenderModel->updateQtyByCatIdAndUserId($qty, $catId, $userId);  
    }
    
    // Get All Records
    function GetAllRecords()
    {
        $recommenderModel = new RecommenderModel();
        return $recommenderModel->GetAllRecords(); 
    }
}
