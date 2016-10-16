<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserModel
 *
 * @author Jake Valino
 */
require ("Entities/UserEntities.php");

class UserModel {
    //put your code here
    
    //Check if a user exist in the database.
    function CheckUser($username)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM users WHERE username='$username'") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);

        if($numrows != 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                $dbfirstName= $row['firstName'];
                $dblastName= $row['lastName'];
                $dbusername = $row['username'];
                $dbpassword = $row['password'];
                $dbemail = $row['email'];
                $dbphone = $row['phone'];
                $admin = $row['admin'];
                
                $userEntities = new UserEntities(-1,$dbfirstName,$dblastName,$dbusername,$dbpassword,$dbemail,$dbphone,$admin);
            }
            
            return $userEntities;
        }else
        {
            return 0;
        }
    }
    
    //Check if an email exist in the database.
    function CheckEmail($email)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        $result = mysqli_query($connection," SELECT * FROM users WHERE email='$email'") or die(mysql_error());
        
        $numrows = mysqli_num_rows($result);

        if($numrows != 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                $dbfirstName= $row['firstName'];
                $dblastName= $row['lastName'];
                $dbusername = $row['username'];
                $dbpassword = $row['password'];
                $dbemail = $row['email'];
                $dbphone = $row['phone'];
                $admin = $row['admin'];
                
                $userEntities = new UserEntities(-1,$dbfirstName,$dblastName,$dbusername,$dbpassword,$dbemail,$dbphone,$admin);
            }
            
            return $userEntities;
        }else
        {
            return 0;
        }
    }
    
    //Insert a new user into the database
    function InsertANewUser($userParameter)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        

            $query = sprintf("INSERT INTO users"
                . "(firstName,lastName,username,password,email,phone,admin)"
                . "VALUES('%s','%s','%s','%s','%s','%s','%s')",
                mysqli_real_escape_string($connection,$userParameter->firstName),
                mysqli_real_escape_string($connection,$userParameter->lastName),
                mysqli_real_escape_string($connection,$userParameter->username),
                mysqli_real_escape_string($connection,$userParameter->password),
                mysqli_real_escape_string($connection,$userParameter->email),
                mysqli_real_escape_string($connection,$userParameter->phone),
                mysqli_real_escape_string($connection,$userParameter->admin));
            
        //Define and execute query
        $result = mysqli_query($connection,$query) or die(mysql_error());
        mysqli_close($connection);
    }
    
    //Update a user
    function updateUser($id,UserEntities $user)
    {
        $query = sprintf("UPDATE users"
                . "SET firstName = '%s', lastName = '%s', username = '%s'"
                . "password = '%s', email = '%s', phone = '%s', admin = '%s' "
                . "WHERE id = $id",
                mysqli_real_escape_string($user->firstName),
                mysqli_real_escape_string($user->lastName),
                mysqli_real_escape_string($user->username),
                mysqli_real_escape_string($user->password),
                mysqli_real_escape_string($user->email),
                mysqli_real_escape_string($user->phone),
                mysqli_real_escape_string($user->admin));
                
        $this->PerformQuery($query);
    }
    
    //Delete a user
    function deleteUser($id)
    {
        $query = "DELETE FROM users WHERE id = $id";
        $this->PerformQuery($query);
    } 
            
    function PerformQuery($query)
    {
        require 'Model/Credentials.php';
        
        //Open connection and Select database
        $connection = mysqli_connect($host, $user, $passwd, $database);
        
        //Define and execute query
        $result = mysqli_query($connection,$query) or die(mysql_error());
        mysqli_close($connection);
    }
}
