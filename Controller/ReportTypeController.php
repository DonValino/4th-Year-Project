<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ReportTypeController
 *
 * @author Jake Valino
 */
require 'Model/ReportTypeModel.php';
class ReportTypeController {
    
    //Insert a new report type
    function InsertANewReportType($name)
    {
        $reportTypeModel = new ReportTypeModel();
        $reportTypeModel->InsertANewReportType($name);
    }
    
    //Get Report Type By Id.
    function GetReportTypeById($id)
    {
        $reportTypeModel = new ReportTypeModel();
        return $reportTypeModel->GetReportTypeById($id);
    }
    
    //Get All Report Types.
    function GetAllReportTypes()
    {
        $reportTypeModel = new ReportTypeModel();
        return $reportTypeModel->GetAllReportTypes();
    }
}
