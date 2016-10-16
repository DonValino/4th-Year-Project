<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require 'Model/UserModel.php';

class LoginController {
    
    //put your code here
    function CreateLoginForm()
    {
        $result = "                . <div class='login-form'>
          <h2>Login</h2>
          </br>
          <form action = '' method = 'POST' >
            <fieldset>
              <div class='clearfix'>
                <input type='text' size='65' name='username' placeholder='Username' required autofocus>
              </div>
              <div class='clearfix'>
                <input type='password' size='65' name = 'password' placeholder='Password' required>
              </div>
              <a href='Register.php' class='registerANewAccount' style='margin-left: 289px;'> Register A New Account </a>
              <button class='btn primary' type='submit' style='margin-left: 25px;'  name = 'login'>Sign in</button>
            </fieldset>
          </form>
        </div>";
                
        return $result;
    }
    
    //Check if a user exist using the model and return the object
    function CheckUser($username)
    {
        $userModel = new UserModel();
        return $userModel->CheckUser($username);
    }
}



