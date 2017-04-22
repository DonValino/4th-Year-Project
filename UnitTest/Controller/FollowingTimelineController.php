<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FollowingTimelineController
 *
 * @author Jake Valino
 */
require ("Model/FollowingTimelineModel.php");
class FollowingTimelineController {
    
    // Post a new event in the timeline
    function InsertTimeline($userid,$typeid, $dateposted, $jobid)
    {
        $followingTimelineModel = new FollowingTimelineModel();
        $followingTimelineModel->InsertTimeline($userid, $typeid, $dateposted, $jobid);
    }
    
    //Get All Timeline Events
    function GetAllTimelineEvents()
    {
        $followingTimelineModel = new FollowingTimelineModel();
        $followingTimelineModel->GetAllTimelineEvents();
    }
}
