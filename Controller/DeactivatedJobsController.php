<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DeactivatedJobsController
 *
 * @author Jake Valino
 */

require ("Model/DeactivatedJobsModel.php");

class DeactivatedJobsController {
    
    // Insert A De-Activated Job
    function InsertANewDeactivatedJob($jobId,$userId,$reason,$date)
    {
        $deactivatedJobsModel = new DeactivatedJobsModel();
        $deactivatedJobsModel->InsertANewDeactivatedJob($jobId, $userId, $reason, $date);
    }
    
    // Get All The Deactivated Jobs
    function GetAllDeactivatedJobs()
    {
        $deactivatedJobsModel = new DeactivatedJobsModel();
        return $deactivatedJobsModel->GetAllDeactivatedJobs();
    }
    
    function CreateAdminJobSideBar()
    {
        $result = "<div class='panel panel-default'>
					<div class='panel-heading' style='text-align:center;'>
					<a data-toggle='collapse' data-parent='#accordion' href='#collapseJObOverviewPage' class='glyphicon glyphicon glyphicon-th-list'><strong> Menu</strong></a>
					</div>
					<div id='collapseJObOverviewPage' class='panel-collapse collapse in'>
						<div class='panel-body'>"
                                    ."<div class='col-md-12'>
                                                            <div class='profile-sidebar'>
                                                                    <!-- SIDEBAR MENU -->
                                                                    <div class='home-usermenu'>
                                                                            <ul class='nav'>
                                                                                    <li>
                                                                                            <a href='Home.php' style='text-align:center;'>
                                                                                            <i class='glyphicon glyphicon-home'></i>
                                                                                            Home </a>
                                                                                    </li>
                                                                                    <li>
                                                                                            <a href='SearchResult.php?epr=myJobs' style='text-align:center;'>
                                                                                            <i class='glyphicon glyphicon-envelope'></i>
                                                                                             Inbox</a>
                                                                                    </li>
                                                                                    <li class='active'>
                                                                                            <a href='JobAdmin.php' style='text-align:center;'>
                                                                                            <i class='glyphicon glyphicon-wrench'></i>
                                                                                            Job </a>
                                                                                    </li>
                                                                                    <li>
                                                                                            <a href='#' data-toggle='modal' data-target='#myModal' style='text-align:center;'>
                                                                                            <i class='glyphicon glyphicon-user'></i>
                                                                                            Users </a>
                                                                                    </li>
                                                                                    <li>
                                                                                            <a href='#' data-toggle='modal' data-target='#priceModal' style='text-align:center;'>
                                                                                            <i class='glyphicon glyphicon-flag'></i>
                                                                                            Reports </a>
                                                                                    </li>
                                                                            </ul>
                                                                    </div>
                                                                    <!-- END MENU -->
                                                            </div>
                                                    </div>"
						."</div>"
					."</div>"
                            ."</div>";

        return $result;
    }
    
    function DeactivateJobForm()
    {
        $re= "<div class='row'>
            <div class='insertJob-form col-md-6 col-md-offset-3'>
          <div class='row'>
            <h2 class='col-md-12 col-sm-12 col-xs-12' style='text-align:center;color:blue;'>Job De-Activation</h2>
          </div>
          <form action='' method = 'POST'>
            <fieldset>
              <div class='clearfix'>
              <label for='reason' class='col-md-4 col-sm-2 col-xs-3'> Reason: </label>
                <textarea name = 'reason' style='height:150px;' id='reason' class='col-md-12 col-sm-10 col-xs-9' placeholder='Reason For Job Deactivation' required autofocus></textarea>
              </div>
              <div class='row'>
              <button class='btn primary col-sm-2 col-sm-offset-9 col-xs-offset-9 col-md-3 col-md-offset-8' name = 'submitJobDeactivation' type='submit'>Submit</button>
              </div>
            </fieldset>
          </form>
        </div>
      </div>";
                
       return $re;
    }
    
}
