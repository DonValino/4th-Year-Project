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
          <div class='row'>
            <h2 class='col-md-12 col-sm-12' style='text-align:center;'>Register A New Account</h2>
          </div>
          <div class='row'>
            <p class='col-md-3 col-sm-3'>Not yet registered?</p>
          </div>
          <form action='' method = 'POST'>
            <fieldset>
              <div class='clearfix'>
                <label for='firstName' class='col-md-2 col-sm-2'> First Name: </label>
                <input type='text' name = 'firstName' id='firstName' value='$firstName' class='col-md-8 col-sm-8' placeholder='First Name' required autofocus>
              </div>
              <div class='clearfix'>
              <label for='lastName' class='col-md-2 col-sm-2'> Last Name: </label>
                <input type='text' name = 'lastName' value='$lastName' class='col-md-8 col-sm-8' placeholder='Last Name' required autofocus>
              </div>
              <div class='clearfix'>
              <label for='usernameRegister' class='col-md-2 col-sm-2'> Username: </label>
                    <input type='text' id='usernameRegister' class='col-md-8 col-sm-8' name = 'usernameRegister' value='$usernameRegister' placeholder='Username' required autofocus>
                    <?php echo error_for('usernameRegister') ?>
              </div>
              <div class='clearfix'>
              <label for='password' class='col-md-2 col-sm-2'> Password: </label>
                <input type='password' class='col-md-8 col-sm-8' name = 'password' value='$password' placeholder='Password' required>
              </div>
              <div class='clearfix'>
              <label for='email' class='col-md-2 col-sm-2'> Email: </label>
                <input type='text' name = 'email' class='col-md-8 col-sm-8' value='$email' placeholder='email' required>
              </div>
              <div class='clearfix'>
                <label for='phone' class='col-md-2 col-sm-2'> Phone: </label>
                <input type='text' name = 'phone' class='col-md-8 col-sm-8' value='$phone' placeholder='phone' required>
              </div>
              <button class='btn primary col-sm-2 col-sm-offset-8 col-md-2 col-md-offset-8' name = 'register' type='submit'>Register</button>
            </fieldset>
          </form>
        </div>";
                
        return $result;
    }
    
    //Use this form when an invalid Username occurs
    function CreateRegisterFormInvalidUsername($errors,$firstName,$lastName,$usernameRegister,$password,$email,$phone)
    {
        $result = " <div class='register-form'>
          <div class='row'>
            <h2 class='col-md-12' style='text-align:center;'>Register A New Account</h2>
          </div>
          <div class='row'>
            <p class='col-md-3'>Not yet registered?</p>
          </div>
          <form action='' method = 'POST'>
            <fieldset>
              <div class='clearfix'>
                <label for='firstName' class='col-md-2'> First Name: </label>
                <input type='text' name = 'firstName' id='firstName' class='col-md-8' value='$firstName' placeholder='First Name' required autofocus>
              </div>
              <div class='clearfix'>
              <label for='lastName' class='col-md-2'> Last Name: </label>
                <input type='text' class='col-md-8' name = 'lastName' value='$lastName' placeholder='Last Name' required autofocus>
              </div>
              <div class='clearfix'>
              <label for='usernameRegister' class='col-md-2' style='color:red'> Username: </label>
                    <input type='text' id='usernameRegister' class='col-md-6' name = 'usernameRegister' value='$usernameRegister' placeholder='Username' required autofocus>
                    <?php echo error_for('usernameRegister') ?>
                    <p for='usernameRegister'class='col-md-2' style='color:red;'> $errors[usernameRegister] </p> 
              </div>
              <div class='clearfix'>
              <label for='password' class='col-md-2'> Password: </label>
                <input type='password' class='col-md-8' name = 'password' value='$password' placeholder='Password' required>
              </div>
              <div class='clearfix'>
              <label for='email' class='col-md-2'> Email: </label>
                <input type='text' class='col-md-8' name = 'email' value='$email' placeholder='email' required>
              </div>
              <div class='clearfix'>
                <label for='phone' class='col-md-2'> Phone: </label>
                <input type='text' class='col-md-8' name = 'phone' value='$phone' placeholder='phone' required>
              </div>
              <button class='btn primary col-md-2 col-md-offset-8' name = 'register' type='submit'>Register</button>
            </fieldset>
          </form>
        </div>"; //This ensures that the data entered by the user retains retains 
                
        return $result;
    }
    
    //Use this form when an invalid Email occurs
    function CreateRegisterFormInvalidEmail($errors,$firstName,$lastName,$usernameRegister,$password,$email,$phone)
    {
        $result = " <div class='register-form'>
            <div class='row'>
                <h2 class='col-md-12' style='text-align:center;'>Register A New Account</h2>
            </div>
            <div class='row'>
                <p class='col-md-3'>Not yet registered?</p>
            </div>
              <form action='' method = 'POST'>
                <fieldset>
                  <div class='clearfix'>
                    <label for='firstName' class='col-md-2'> First Name: </label>
                    <input type='text' name = 'firstName' class='col-md-8' id='firstName' value='$firstName' placeholder='First Name' required autofocus>
                  </div>
                  <div class='clearfix'>
                  <label for='lastName' class='col-md-2'> Last Name: </label>
                    <input type='text' name = 'lastName'  class='col-md-8' value='$lastName' placeholder='Last Name' required autofocus>
                  </div>
                  <div class='clearfix'>
                  <label for='usernameRegister' class='col-md-2'> Username: </label>
                        <input type='text' id='usernameRegister' class='col-md-8' name = 'usernameRegister' value='$usernameRegister' placeholder='Username' required autofocus>
                  </div>
                  <div class='clearfix'>
                  <label for='password' class='col-md-2'> Password: </label>
                    <input type='password' name = 'password' class='col-md-8' value='$password' placeholder='Password' required>
                  </div>
                  <div class='clearfix'>
                  <label for='email' class='col-md-2' style='color:red'> Email: </label>
                    <input type='text' name = 'email' class='col-md-6' value='$email' placeholder='email' required>
                    <p for='email' class='col-md-2' style='color:red;'> $errors[email] </p> 
                  </div>
                  <div class='clearfix'>
                    <label for='phone' class='col-md-2'> Phone: </label>
                    <input type='text' name = 'phone' class='col-md-8' value='$phone' placeholder='phone' required>
                  </div>
                  <button class='btn primary col-md-2 col-md-offset-8' name = 'register' type='submit'>Register</button>
                </fieldset>
              </form>
            </div>"; //This ensures that the data entered by the user retains retains 
                
        return $result;
    }
    
    function CreateRegisterFormInvalidPhone($errors,$firstName,$lastName,$usernameRegister,$password,$email,$phone)
    {
        $result = " <div class='register-form'>
                    <div class='row'>
                        <h2 class='col-md-12' style='text-align:center;'>Register A New Account</h2>
                    </div>
                    <div class='row'>
                        <p class='col-md-3'>Not yet registered?</p>
                    </div>
                        <form action='' method = 'POST'>
                          <fieldset>
                            <div class='clearfix'>
                              <label for='firstName' class='col-md-2'> First Name: </label>
                              <input type='text' name = 'firstName' class='col-md-8' id='firstName' value='$firstName'placeholder='First Name' required autofocus>
                            </div>
                            <div class='clearfix'>
                            <label for='lastName' class='col-md-2'> Last Name: </label>
                              <input type='text' name = 'lastName' class='col-md-8' value='$lastName' placeholder='Last Name' required autofocus>
                            </div>
                            <div class='clearfix'>
                            <label for='usernameRegister' class='col-md-2'> Username: </label>
                                  <input type='text' id='usernameRegister' class='col-md-8' name = 'usernameRegister' value='$usernameRegister' placeholder='Username' required autofocus>
                            </div>
                            <div class='clearfix'>
                            <label for='password' class='col-md-2'> Password: </label>
                              <input type='password' name = 'password' class='col-md-8' value='$password' placeholder='Password' required>
                            </div>
                            <div class='clearfix'>
                            <label for='email' class='col-md-2'> Email: </label>
                              <input type='text' name = 'email' class='col-md-8' value='$email' placeholder='email' required>
                            </div>
                            <div class='clearfix'>
                              <label for='phone' style='color:red' class='col-md-2'> Phone: </label>
                              <input type='text' name = 'phone' class='col-md-6' value='$phone' placeholder='phone' required>
                              <p for='phone' class='col-md-2' style='color:red;'> $errors[phone] </p> 
                            </div>
                            <button class='btn primary col-md-2 col-md-offset-8' name = 'register' style='margin-left: 530px;' type='submit'>Register</button>
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
        $password = password_hash($password, PASSWORD_DEFAULT, ['cost' => 12]);
        $email = $_POST["email"];
        $phone = $_POST["phone"];
        
        $user = new UserEntities(-1, $firstName, $lastName, $userName, $password, $email, $phone, 0,'','','');
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
