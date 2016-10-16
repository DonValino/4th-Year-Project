<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserController
 *
 * @author Jake Valino
 */

require 'Model/UserModel.php';

class UserController {

    //put your code here
    
    //Code to create the user profile sidebar
    function CreateUserProfileSidebar()
    {
        $result = "<div class='col-md-3'>
			<div class='profile-sidebar'>
				<!-- SIDEBAR USERPIC -->
				<div class='profile-userpic'>
					<img src='Images/jobsbanner.jpg' class='img-responsive' alt=''>
				</div>
				<!-- END SIDEBAR USERPIC -->
				<!-- SIDEBAR USER TITLE -->
				<div class='profile-usertitle'>
					<div class='profile-usertitle-name'>
						$_SESSION[username]
					</div>
					<div class='profile-usertitle-job'>
						Developer
					</div>
				</div>
				<!-- END SIDEBAR USER TITLE -->
				<!-- SIDEBAR BUTTONS -->
				<div class='profile-userbuttons'>
					<button type='button' class='btn btn-success btn-sm'>Follow</button>
					<button type='button' class='btn btn-danger btn-sm'>Message</button>
				</div>
				<!-- END SIDEBAR BUTTONS -->
				<!-- SIDEBAR MENU -->
				<div class='profile-usermenu'>
					<ul class='nav'>
						<li class='active'>
							<a href='UserAccount.php'>
							<i class='glyphicon glyphicon-home'></i>
							Overview </a>
						</li>
						<li>
							<a href='#'>
							<i class='glyphicon glyphicon-user'></i>
							Account Settings </a>
						</li>
						<li>
							<a href='#'>
							<i class='glyphicon glyphicon-ok'></i>
							Jobs </a>
						</li>
                                                <li>
							<a href='Logout.php'>
							<i class='glyphicon glyphicon-log-out'></i>
							Logout </a>
						</li>
						<li>
							<a href='#' target='_blank'>
							<i class='glyphicon glyphicon-flag'></i>
							Help </a>
						</li>
					</ul>
				</div>
				<!-- END MENU -->
			</div>
		</div>";
                
        return $result;
    }
    
    //Code for default content 
    function CreateOverviewContent()
    {
        $result = "<H4>Welcome to the User Account Page: </H4>"
                . "<div id='overviewContent'>"
                . ""
                . "</div>";
                
        return $result;
    }
}
