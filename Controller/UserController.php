<script>
//Display a confirmation box when trying to delete an object
function showConfirm()
{
    // build the confirmation box
    var c = confirm("Are you sure you wish to delete your account?");
    
    // if true, delete item and refresh
    if(c)
        window.location = "AccountSettings.php?delete=" + 0;
}
</script>
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
        $result = "<div class='col-md-12'>
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
				<div style='margin-left:20px;'>
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
							<a href='AccountSettings.php'>
							<i class='glyphicon glyphicon-user'></i>
							Account Settings </a>
						</li>
						<li>
							<a href='JobsOverview.php'>
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
    
    //Code to create the user profile sidebar
    function CreateUserAccSettingsProfileSidebar()
    {
        $result = "<div class='col-md-12'>
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
						<li>
							<a href='UserAccount.php'>
							<i class='glyphicon glyphicon-home'></i>
							Overview </a>
						</li>
						<li class='active'>
							<a href='AccountSettings.php'>
							<i class='glyphicon glyphicon-user'></i>
							Account Settings </a>
						</li>
						<li>
							<a href='JobsOverview.php'>
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
    
    //Code To Create Form to allow user change account details
    function CreateUserUpdateForm($firstName,$lastName,$usernameRegister,$password,$email,$phone)
    {
        $result = " <div class='register-form'>
          <div class='row'>
            <h2 class='col-md-12' style='text-align:center;'>Change Account Details</h2>
          </div>
          <div class='row'>
            <p class='col-md-3'>e.g. Change FirstName and Save</p>
          </div>
          <div class='row'>
           &nbsp&nbsp<a href='' onclick='showConfirm()' class='btn btn-info col-md-2 col-md-offset-9'>Delete Account</a>
          </div>
          </br>
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
                    <?php echo error_for('usernameRegister') ?>
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
                <label for='phone' class='col-md-2'> Phone: </label>
                <input type='text' name = 'phone' class='col-md-8' value='$phone' placeholder='phone' required>
              </div>
              <button class='btn primary col-md-2 col-md-offset-8' name = 'save' type='submit'>Save</button>
            </fieldset>
          </form>
        </div>"; //This ensures that the data entered by the user retains retains 
                
        return $result;
    }
    
    //Use this form when an invalid Email occurs
    function CreateUserUpdateFormInvalidEmail($errors,$firstName,$lastName,$usernameRegister,$password,$email,$phone)
    {
        $result = " <div class='register-form'>
                <div class='row'>
                  <h2 class='col-md-12' style='text-align:center;'>Change Account Details</h2>
                </div>
                <div class='row'>
                  <p class='col-md-3'>e.g. Change FirstName and Save</p>
                </div>
                <div class='row'>
                 &nbsp&nbsp<a href='' onclick='showConfirm()' class='btn btn-info col-md-2 col-md-offset-9'>Delete Account</a>
                </div>
                </br>
              <form action='' method = 'POST'>
                <fieldset>
                  <div class='clearfix'>
                    <label for='firstName' class='col-md-2'> First Name: </label>
                    <input type='text' class='col-md-8' name = 'firstName' id='firstName' value='$firstName'placeholder='First Name' required autofocus>
                  </div>
                  <div class='clearfix'>
                  <label for='lastName' class='col-md-2'> Last Name: </label>
                    <input type='text' class='col-md-8' name = 'lastName' value='$lastName' placeholder='Last Name' required autofocus>
                  </div>
                  <div class='clearfix'>
                  <label for='usernameRegister' class='col-md-2'> Username: </label>
                        <input type='text' class='col-md-8' id='usernameRegister' name = 'usernameRegister' value='$usernameRegister' placeholder='Username' required autofocus>
                  </div>
                  <div class='clearfix'>
                  <label for='password' class='col-md-2'> Password: </label>
                    <input type='password' class='col-md-8' name = 'password' value='$password' placeholder='Password' required>
                  </div>
                  <div class='clearfix'>
                  <label for='email' class='col-md-2' style='color:red'> Email: </label>
                    <input type='text' name = 'email' class='col-md-6' value='$email' placeholder='email' required>
                    <p for='email' class='col-md-2' style='color:red;'> $errors[email] </p> 
                  </div>
                  <div class='clearfix'>
                    <label for='phone' class='col-md-2'> Phone: </label>
                    <input type='text' class='col-md-8' name = 'phone' value='$phone' placeholder='phone' required>
                  </div>
                  <button class='btn primary col-md-2 col-md-offset-8' name = 'save' type='submit'>Save</button>
                </fieldset>
              </form>
            </div>"; //This ensures that the data entered by the user retains retains 
                
        return $result;
    }
    
    function CreateUserUpdateFormInvalidPhone($errors,$firstName,$lastName,$usernameRegister,$password,$email,$phone)
    {
        $result = " <div class='register-form'>
                    <div class='row'>
                      <h2 class='col-md-12' style='text-align:center;'>Change Account Details</h2>
                    </div>
                    <div class='row'>
                      <p class='col-md-3'>e.g. Change FirstName and Save</p>
                    </div>
                    <div class='row'>
                     &nbsp&nbsp<a href='' onclick='showConfirm()' class='btn btn-info col-md-2 col-md-offset-9'>Delete Account</a>
                    </div>
                    </br>
                        <form action='' method = 'POST'>
                          <fieldset>
                            <div class='clearfix'>
                              <label for='firstName' class='col-md-2'> First Name: </label>
                              <input type='text' class='col-md-8' name = 'firstName' id='firstName' value='$firstName'placeholder='First Name' required autofocus>
                            </div>
                            <div class='clearfix'>
                            <label for='lastName' class='col-md-2'> Last Name: </label>
                              <input type='text' class='col-md-8' name = 'lastName' value='$lastName'placeholder='Last Name' required autofocus>
                            </div>
                            <div class='clearfix'>
                            <label for='usernameRegister' class='col-md-2'> Username: </label>
                                  <input type='text' class='col-md-8' id='usernameRegister' name = 'usernameRegister' value='$usernameRegister' placeholder='Username' required autofocus>
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
                              <label for='phone' style='color:red' class='col-md-2'> Phone: </label>
                              <input type='text' name = 'phone' class='col-md-6' value='$phone' placeholder='phone' required>
                              <p for='phone' class='col-md-2' style='color:red;'> $errors[phone] </p> 
                            </div>
                            <button class='btn primary col-md-2 col-md-offset-8' name = 'save' type='submit'>Save</button>
                          </fieldset>
                        </form>
                      </div>"; //This ensures that the data entered by the user retains retains 
                
        return $result;
    }
    
    //Use this form when an invalid Username occurs
    function CreateUserUpdateFormInvalidUsername($errors,$firstName,$lastName,$usernameRegister,$password,$email,$phone)
    {
        $result = " <div class='register-form'>
                <div class='row'>
                  <h2 class='col-md-12' style='text-align:center;'>Change Account Details</h2>
                </div>
                <div class='row'>
                  <p class='col-md-3'>e.g. Change FirstName and Save</p>
                </div>
                <div class='row'>
                 &nbsp&nbsp<a href='' onclick='showConfirm()' class='btn btn-info col-md-2 col-md-offset-9'>Delete Account</a>
                </div>
                </br>
          <form action='' method = 'POST'>
            <fieldset>
              <div class='clearfix'>
                <label for='firstName' class='col-md-2'> First Name: </label>
                <input type='text' class='col-md-8' name = 'firstName' id='firstName' value='$firstName' placeholder='First Name' required autofocus>
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
              <button class='btn primary col-md-2 col-md-offset-1' name = 'save' type='submit'>Save</button>
            </fieldset>
          </form>
        </div>"; //This ensures that the data entered by the user retains retains 
                
        return $result;
    }
    
    //Code for default content 
    function CreateOverviewContent($id)
    {
        require 'Model/TypeModel.php';
        require 'Model/QualificationModel.php';
        require 'Model/JobModel.php';
        
        $jobModel = new JobModel();
        $qualificationModel = new QualificationModel();
        
        $search = $jobModel->GetJobsByUserID($id);
        $typeModel = new TypeModel();
        
        $result = "<H4 Style='text-align:center;'>Welcome to the User Account Page: </H4>"
                . "<div class='row'>"
                . "<div class='panel-group col-md-7'>
			  <div class='panel panel-default'>
					<div class='panel-heading' style='text-align:center;'>
					<a data-toggle='collapse' data-parent='#accordion' href='#collapseadvertisedjobs' class='glyphicon glyphicon-hand-up'><strong>My Advertised Jobs</strong></a>
					</div>
					<div id='collapseadvertisedjobs' class='panel-collapse collapse in'>
						<div class='panel-body'>
                                                    <div class='table-responsive scrollit'>"
                                                        . "<table class='table sortable'>"
                                                        . "<tr>"
                                                        . "     <th>Name</th>"
                                                        . "     <th>Description</th>"
                                                        . "     <th>Category</th>"
                                                        . "     <th>Qualificaion</th>"
                                                        . "     <th>Action: </th>"
                                                        . "</tr>";
                                                        try
                                                        {
                                                            foreach($search as $row)
                                                            {
                                                                $type = $typeModel->GetTypeByID($row->type);
                                                                $qualification = $qualificationModel->GetQualificationByID($row->qualification);
                                                                $result.= "<tr>"
                                                                        . "<td align='center'><a href='SearchResult.php?epr=view&id=".$row->jobid."'>$row->name</a></td>"
                                                                        . "<td align='center'>$row->description</td>"
                                                                        . "<td align='center'>$type->name</td>"
                                                                        . "<td align='center'>$qualification->qualificationName</td>"
                                                                        . "<td>"
                                                                        . "     <a href='EditJob.php?epr=delete&id=".$row->jobid."'>Delete</a>&nbsp|"
                                                                        . "     <a href='EditJob.php?epr=update&id=".$row->jobid."'>Update</a>"
                                                                        . "</td>"
                                                                        . "</tr>";
                                                            }
                                                        }catch(Exception $x)
                                                        {
                                                            echo 'Caught exception: ',  $x->getMessage(), "\n";
                                                        }
                                                    $result.= "</table>"
                                                            . "</div>"
						."</div>"
					."</div>"
				."</div>"
			."</div>"
                . "<div class='panel-group col-md-5'>
			  <div class='panel panel-default'>
					<div class='panel-heading' style='text-align:center;'>
					<a data-toggle='collapse' data-parent='#accordion' href='#collapseMyPlacedOffers' class='glyphicon glyphicon-hand-up'><strong>My Placed Offer</strong></a>
					</div>
					<div id='collapseMyPlacedOffers' class='panel-collapse collapse in'>
						<div class='panel-body'>"
						."</div>"
					."</div>"
				."</div>"
			."</div>"
                . "</div>"
                . "<div class='row'>"
                . "<div class='panel-group col-md-6'>
			  <div class='panel panel-default'>
					<div class='panel-heading' style='text-align:center;'>
					<a data-toggle='collapse' data-parent='#accordion' href='#collapseMyPlacedOffers' class='glyphicon glyphicon-hand-up'><strong>List Of Offer</strong></a>
					</div>
					<div id='collapseMyPlacedOffers' class='panel-collapse collapse in'>
						<div class='panel-body'>"
						."</div>"
					."</div>"
				."</div>"
			."</div>"
                . "<div class='panel-group col-md-6'>
			  <div class='panel panel-default'>
					<div class='panel-heading' style='text-align:center;'>
					<a data-toggle='collapse' data-parent='#accordion' href='#collapseMyPlacedOffers' class='glyphicon glyphicon-hand-up'><strong>Notifications</strong></a>
					</div>
					<div id='collapseMyPlacedOffers' class='panel-collapse collapse in'>
						<div class='panel-body'>"
						."</div>"
					."</div>"
				."</div>"
			."</div>"
                . "</div>"
                . "</div>";
                
        return $result;
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
    
    //Update a user
    function updateUser($id,$firstName,$lastName,$usernameRegister,$password,$email,$phone)
    {
        $userModel = new UserModel();
        return $userModel->updateUser($id, $firstName,$lastName,$usernameRegister,$password,$email,$phone);
    }
    
    //Delete a user
    function deleteUser($id)
    {
        $userModel = new UserModel();
        $userModel->deleteUser($id);
    } 
}
