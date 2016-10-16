<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RegisterController
 *
 * @author Jake Valino
 */
require 'Model/UserModel.php';

class RegisterController {
    //put your code here
    
    function CreateRegisterForm()
    {
        $firstName = '';
        $lastName = '';
        $usernameRegister = '';
        $password = '';
        $email = '';
        $phone = '';
        $result = " <div class='register-form'>
          <h2>Register A New Account</h2>
          <p>Not yet registered?</p>
          <form action='' method = 'POST'>
            <fieldset>
              <div class='clearfix'>
                <label for='firstName'> First Name: </label>
                <input type='text' name = 'firstName' id='firstName' value='$firstName' size='55' placeholder='First Name' required autofocus>
              </div>
              <div class='clearfix'>
              <label for='lastName'> Last Name: </label>
                <input type='text' name = 'lastName' value='$lastName' size='55' style='margin-left: 1px;' placeholder='Last Name' required autofocus>
              </div>
              <div class='clearfix'>
              <label for='usernameRegister'> Username: </label>
                    <input type='text' id='usernameRegister' name = 'usernameRegister' value='$usernameRegister' size='55' style='margin-left: 6px;' placeholder='Username' required autofocus>
                    <?php echo error_for('usernameRegister') ?>
              </div>
              <div class='clearfix'>
              <label for='password'> Password: </label>
                <input type='password' name = 'password' value='$password' size='55' style='margin-left: 7px;' placeholder='Password' required>
              </div>
              <div class='clearfix'>
              <label for='email'> Email: </label>
                <input type='text' name = 'email' value='$email' size='55' style='margin-left: 36px;' placeholder='email' required>
              </div>
              <div class='clearfix'>
                <label for='phone'> Phone: </label>
                <input type='text' name = 'phone' value='$phone' size='55' style='margin-left: 29px;' placeholder='phone' required>
              </div>
              <button class='btn primary' name = 'register' style='margin-left: 530px;' type='submit'>Register</button>
            </fieldset>
          </form>
        </div>";
                
        return $result;
    }
    
    //Use this form when an invalid Username occurs
    function CreateRegisterFormInvalidUsername($errors,$firstName,$lastName,$usernameRegister,$password,$email,$phone)
    {
        $result = " <div class='register-form'>
          <h2>Register A New Account</h2>
          <p>Not yet registered?</p>
          <form action='' method = 'POST'>
            <fieldset>
              <div class='clearfix'>
                <label for='firstName'> First Name: </label>
                <input type='text' name = 'firstName' id='firstName' value='$firstName' size='55' placeholder='First Name' required autofocus>
              </div>
              <div class='clearfix'>
              <label for='lastName'> Last Name: </label>
                <input type='text' name = 'lastName' value='$lastName' size='55' style='margin-left: 1px;' placeholder='Last Name' required autofocus>
              </div>
              <div class='clearfix'>
              <label for='usernameRegister' style='color:red'> Username: </label>
                    <input type='text' id='usernameRegister' name = 'usernameRegister' value='$usernameRegister' size='55' style='margin-left: 6px;' placeholder='Username' required autofocus>
                    <?php echo error_for('usernameRegister') ?>
                    <p for='usernameRegister' style='color:red; margin-left: 335px;'> $errors[usernameRegister] </p> 
              </div>
              <div class='clearfix'>
              <label for='password'> Password: </label>
                <input type='password' name = 'password' value='$password' size='55' style='margin-left: 7px;' placeholder='Password' required>
              </div>
              <div class='clearfix'>
              <label for='email'> Email: </label>
                <input type='text' name = 'email' value='$email' size='55' style='margin-left: 36px;' placeholder='email' required>
              </div>
              <div class='clearfix'>
                <label for='phone'> Phone: </label>
                <input type='text' name = 'phone' value='$phone' size='55' style='margin-left: 29px;' placeholder='phone' required>
              </div>
              <button class='btn primary' name = 'register' style='margin-left: 530px;' type='submit'>Register</button>
            </fieldset>
          </form>
        </div>"; //This ensures that the data entered by the user retains retains 
                
        return $result;
    }
    
    //Use this form when an invalid Email occurs
    function CreateRegisterFormInvalidEmail($errors,$firstName,$lastName,$usernameRegister,$password,$email,$phone)
    {
        $result = " <div class='register-form'>
              <h2>Register A New Account</h2>
              <p>Not yet registered?</p>
              <form action='' method = 'POST'>
                <fieldset>
                  <div class='clearfix'>
                    <label for='firstName'> First Name: </label>
                    <input type='text' name = 'firstName' id='firstName' value='$firstName' size='55' placeholder='First Name' required autofocus>
                  </div>
                  <div class='clearfix'>
                  <label for='lastName'> Last Name: </label>
                    <input type='text' name = 'lastName' value='$lastName' size='55' style='margin-left: 1px;' placeholder='Last Name' required autofocus>
                  </div>
                  <div class='clearfix'>
                  <label for='usernameRegister'> Username: </label>
                        <input type='text' id='usernameRegister' name = 'usernameRegister' value='$usernameRegister' size='55' style='margin-left: 6px;' placeholder='Username' required autofocus>
                  </div>
                  <div class='clearfix'>
                  <label for='password'> Password: </label>
                    <input type='password' name = 'password' value='$password' size='55' style='margin-left: 7px;' placeholder='Password' required>
                  </div>
                  <div class='clearfix'>
                  <label for='email' style='color:red'> Email: </label>
                    <input type='text' name = 'email' value='$email' size='55' style='margin-left: 36px;' placeholder='email' required>
                    <p for='email' style='color:red; margin-left: 315px;'> $errors[email] </p> 
                  </div>
                  <div class='clearfix'>
                    <label for='phone'> Phone: </label>
                    <input type='text' name = 'phone' value='$phone' size='55' style='margin-left: 29px;' placeholder='phone' required>
                  </div>
                  <button class='btn primary' name = 'register' style='margin-left: 530px;' type='submit'>Register</button>
                </fieldset>
              </form>
            </div>"; //This ensures that the data entered by the user retains retains 
                
        return $result;
    }
    
    function CreateRegisterFormInvalidPhone($errors,$firstName,$lastName,$usernameRegister,$password,$email,$phone)
    {
        $result = " <div class='register-form'>
                        <h2>Register A New Account</h2>
                        <p>Not yet registered?</p>
                        <form action='' method = 'POST'>
                          <fieldset>
                            <div class='clearfix'>
                              <label for='firstName'> First Name: </label>
                              <input type='text' name = 'firstName' id='firstName' value='$firstName' size='55' placeholder='First Name' required autofocus>
                            </div>
                            <div class='clearfix'>
                            <label for='lastName'> Last Name: </label>
                              <input type='text' name = 'lastName' value='$lastName' size='55' style='margin-left: 1px;' placeholder='Last Name' required autofocus>
                            </div>
                            <div class='clearfix'>
                            <label for='usernameRegister'> Username: </label>
                                  <input type='text' id='usernameRegister' name = 'usernameRegister' value='$usernameRegister' size='55' style='margin-left: 6px;' placeholder='Username' required autofocus>
                            </div>
                            <div class='clearfix'>
                            <label for='password'> Password: </label>
                              <input type='password' name = 'password' value='$password' size='55' style='margin-left: 7px;' placeholder='Password' required>
                            </div>
                            <div class='clearfix'>
                            <label for='email'> Email: </label>
                              <input type='text' name = 'email' value='$email' size='55' style='margin-left: 36px;' placeholder='email' required>
                            </div>
                            <div class='clearfix'>
                              <label for='phone' style='color:red'> Phone: </label>
                              <input type='text' name = 'phone' value='$phone' size='55' style='margin-left: 29px;' placeholder='phone' required>
                              <p for='phone' style='color:red; margin-left: 335px;'> $errors[phone] </p> 
                            </div>
                            <button class='btn primary' name = 'register' style='margin-left: 530px;' type='submit'>Register</button>
                          </fieldset>
                        </form>
                      </div>"; //This ensures that the data entered by the user retains retains 
                
        return $result;
    }
    
    //Insert a new admin user into the database
    function InsertANewUser()
    {
        $firstName = $_POST["firstName"];
        $lastName = $_POST["lastName"];
        $userName = $_POST["usernameRegister"];
        $password = $_POST["password"];
        $email = $_POST["email"];
        $phone = $_POST["phone"];
        
        $user = new UserEntities(-1, $firstName, $lastName, $userName, $password, $email, $phone, 0);
        $userModel = new UserModel();
        $userModel->InsertANewUser($user);
    }
    
    //Check if a user exist using the model and return the object
    function CheckUser($username)
    {
        $userModel = new UserModel();
        return $userModel->CheckUser($username);
    }
    
    //Check if an email already exist in the database
    function CheckEmail($email)
    {
        $userModel = new UserModel();
        return $userModel->CheckEmail($email);
    }
}
