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

  //Constructor    
  function __construct($id,$firstName,$lastName, $username, $password, $email, $phone, $admin) {
      $this->id = $id;
      $this->firstName = $firstName;
      $this->lastName = $lastName;
      $this->username = $username;
      $this->password = $password;
      $this->email = $email;
      $this->phone = $phone;
      $this->admin = $admin;
  }

}

?>

