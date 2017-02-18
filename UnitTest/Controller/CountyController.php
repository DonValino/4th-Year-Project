<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CountyController
 *
 * @author Jake Valino
 */

require ("Model/CountyModel.php");
class CountyController {

    // Insert A new County
    function InsertANewCounty($county)
    {
        $countyModel = new CountyModel();
        $countyModel->InsertANewCounty($county);
    }
    
    // Get County By Id
    function GetCountyById($id)
    {
        $countyModel = new CountyModel();
        $countyModel->GetCountyById($id);
    }
    
    // Get County By Name
    function GetCountyByName($name)
    {
        $countyModel = new CountyModel();
        $countyModel->GetCountyByName($name);
    }
    
    // Update A County By Id
    function updateACountyById($county,$id)
    {
        $countyModel = new CountyModel();
        $countyModel->updateACountyById($county, $id);
    }
    
    // Delete A County By Id
    function deleteACountyByID($id)
    {
        $countyModel = new CountyModel();
        $countyModel->deleteACountyByID($id);
    }
    
    // Get All The Counties
    function GetAllCounties()
    {
      $countyModel = new CountyModel(); 
      $countyModel->GetAllCounties();
    }
}
