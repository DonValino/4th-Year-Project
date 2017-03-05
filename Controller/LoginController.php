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
        $result = "<div class='login-form col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2'>
          <div class='row'>
            <h2 style='text-align:center;'>Login</h2>
          </div>
          </br>
          <form action = '' method = 'POST' >
            <fieldset>
              <div class='clearfix row'>
                <input type='text' class='col-md-10 col-sm-10 col-xs-11' name='username' placeholder='Username' required autofocus>
              </div>
              <div class='clearfix row'>
                <input type='password' class='col-md-10 col-sm-10 col-xs-11' name='password' placeholder='Password' required>
              </div>
              <div class='row'>
              <a href='Register.php' class='col-xs-6 col-xs-offset-3 col-sm-4 col-sm-offset-4 col-md-4 col-md-offset-4'> Register A New Account </a>
              <button class='btn primary col-md-2 col-sm-2' type='submit' name = 'login'>Sign in</button>
              </div>
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



