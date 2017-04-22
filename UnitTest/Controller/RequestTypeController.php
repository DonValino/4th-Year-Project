<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RequestTypeController
 *
 * @author Jake Valino
 */
require 'Model/RequestTypeModel.php';

class RequestTypeController {
    
    //Insert a new request type
    function InsertARequestType($name)
    {
        $requestTypeModel = new RequestTypeModel();
        $requestTypeModel->InsertARequestType($name);
    }
    
    //Get Request Type.
    function GetRequestTypes()
    {
        $requestTypeModel = new RequestTypeModel();
        return $requestTypeModel->GetRequestTypes();
    }
    
    //Get A Request Type By Id.
    function GetARequestTypeById($id)
    {
        $requestTypeModel = new RequestTypeModel(); 
        return $requestTypeModel->GetARequestTypeById($id);
    }
}
