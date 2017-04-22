<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FollowingTimeline
 *
 * @author Jake Valino
 */
class FollowingTimelineEntities {
  public $id;
  public $userid;
  public $typeid;
  public $dateposted;
  public $jobid;
  
  // Constructor
  function __construct($id, $userid, $typeid, $dateposted, $jobid) {
      $this->id = $id;
      $this->userid = $userid;
      $this->typeid = $typeid;
      $this->dateposted = $dateposted;
      $this->jobid = $jobid;
  }
  
  // Getters
  function getId() {
      return $this->id;
  }

  function getUserid() {
      return $this->userid;
  }

  function getTypeid() {
      return $this->typeid;
  }

  function getDateposted() {
      return $this->dateposted;
  }

  function getJobid() {
      return $this->jobid;
  }

  // Setters
  function setId($id) {
      $this->id = $id;
  }

  function setUserid($userid) {
      $this->userid = $userid;
  }

  function setTypeid($typeid) {
      $this->typeid = $typeid;
  }

  function setDateposted($dateposted) {
      $this->dateposted = $dateposted;
  }

  function setJobid($jobid) {
      $this->jobid = $jobid;
  }



}
