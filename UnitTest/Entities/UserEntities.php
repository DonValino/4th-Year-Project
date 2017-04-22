<?php
class UserEntities 
{ 
  public $id;
  public $firstName;
  public $lastName;
  public $username;
  public $password;
  public $email;
  public $phone;
  public $admin;
  public $cv;
  public $coverletter;
  public $photo;
  
  function getId() {
      return $this->id;
  }

  function getUsername() {
      return $this->username;
  }

  function getPassword() {
      return $this->password;
  }

  function getEmail() {
      return $this->email;
  }

  function getPhone() {
      return $this->phone;
  }
  function getFirstName() {
      return $this->firstName;
  }

  function getLastName() {
      return $this->lastName;
  }

  function getAdmin() {
      return $this->admin;
  }
  
  function getCv() {
      return $this->cv;
  }

  function getCoverletter() {
      return $this->coverletter;
  }
  
  function getPhoto() {
      return $this->photo;
  }

    
  // Setters
  function setId($id) {
      $this->id = $id;
  }

  function setFirstName($firstName) {
      $this->firstName = $firstName;
  }

  function setLastName($lastName) {
      $this->lastName = $lastName;
  }

  function setUsername($username) {
      $this->username = $username;
  }

  function setPassword($password) {
      $this->password = $password;
  }

  function setEmail($email) {
      $this->email = $email;
  }

  function setPhone($phone) {
      $this->phone = $phone;
  }

  function setAdmin($admin) {
      $this->admin = $admin;
  }

  function setCv($cv) {
      $this->cv = $cv;
  }

  function setCoverletter($coverletter) {
      $this->coverletter = $coverletter;
  }
  
  function setPhoto($photo) {
      $this->photo = $photo;
  }

    //Constructor    
    function __construct($id, $firstName, $lastName, $username, $password, $email, $phone, $admin, $cv, $coverletter, $photo) {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->phone = $phone;
        $this->admin = $admin;
        $this->cv = $cv;
        $this->coverletter = $coverletter;
        $this->photo = $photo;
    }



}

?>

