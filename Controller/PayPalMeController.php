<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PayPalMeController
 *
 * @author Jake Valino
 */

require 'Model/PayPalMeModel.php';

class PayPalMeController {
    
    // Insert A New User Pay Pal Me Account
    function InsertANewPayPalMeAccount($userId, $payPalMeUrl)
    {
        $payPalMeModel = new PayPalMeModel();
        $payPalMeModel->InsertANewPayPalMeAccount($userId, $payPalMeUrl);
    }
    
    // Get PayPalMe Account by userId
    function GetPayPalMeAccountByUserId($userId)
    {
        $payPalMeModel = new PayPalMeModel();
        $payPalMeModel->GetPayPalMeAccountByUserId($userId);
    }
    
    //Update a user's PayPalMe Account
    function updateUserPayPalMeAccount($payPalMeUrl,$userId)
    {
        $payPalMeModel = new PayPalMeModel();
        $payPalMeModel->updateUserPayPalMeAccount($payPalMeUrl,$userId);
    }
    
    //Code for default content 
    function CreatePaymentContent($id)
    {
        require_once 'Model/UserModel.php';
        $userModel = new UserModel();
        
        $user = $userModel->GetUserById($id);
        
        $payPalMeModel = new PayPalMeModel();
        
        // Checking if this user has configured their PayPalMe Account
        $payPalMeAccount = $payPalMeModel->GetPayPalMeAccountByUserId($id);
        $result = "<div class='alert alert-info'>
                    <p style='font-size:16px; text-align:center;'><strong>Choose Payment Option :</strong></p>
                  </div>"
                . "<div class='row'>"
                . "<div class='panel-group col-md-6'>
			  <div class='panel panel-default'>
					<div class='panel-heading' style='text-align:center;'>
					<a data-toggle='collapse' data-parent='#accordion' href='#collapsePayPalMePaymentOption' class='glyphicon glyphicon-hand-up'><strong>PayPalMe</strong></a>
					</div>
					<div id='collapsePayPalMePaymentOption' class='panel-collapse collapse in'>
						<div class='panel-body'>";
                                                if($payPalMeAccount != NULL)
                                                {
                                                    $result.="<p style='color:blue; font-size:16px; text-align:center'> Pay <font color='black'>$user->firstName $user->lastName</font> using its PayPalMe Account:</p>"
                                                       
                                                            . '<img src="Images/paypal.jpg" class="col-md-1 col-sm-1" style="width:100%; display: block; margin: auto; text-align:center;"/>'
                                                            . '<div class="row">
                                                                <a href="#" data-toggle="modal" id="paypalButton" data-target="#PaymentConfirmationModal" class="col-xs-7 col-xs-offset-3 col-sm-6 col-sm-offset-3 col-md-6 col-md-offset-3"><img src="Images/payWithPayPal.png" class="col-md-1 col-sm-1 col-xs-1" style="width: 205px;"/>
                                                                      <i></i>
                                                                       </a>
                                                               </div>';
                                                }else
                                                {
                                                    $result.="<p style='color:red; font-size:16px; text-align:center'><font color='black'>$user->firstName $user->lastName</font> has not yet configured its PayPalMe Account</p>";
                                                }
                                                    
						$result.="</div>"
					."</div>"
				."</div>"
			."</div>"
                . "<div class='panel-group col-md-6'>
			  <div class='panel panel-default'>
					<div class='panel-heading' style='text-align:center;'>
					<a data-toggle='collapse' data-parent='#accordion' href='#collapseCashPaymentOption' class='glyphicon glyphicon-hand-up'><strong>Cash</strong></a>
					</div>
					<div id='collapseCashPaymentOption' class='panel-collapse collapse in'>
						<div class='panel-body'>
                                                    <div class='row alert alert-info'>
                                                        <p style='color:blue; font-size:16px; text-align:center'> Notify <font color='black'>$user->firstName $user->lastName</font> - Cash Payment:</p>
                                                    </div>
                                                    <div class='row'>
                                                        <a href='#' data-toggle='modal' id='featureInfoButton' class='btn btn-info col-xs-6 col-xs-offset-3 col-sm-6 col-sm-offset-3 col-md-6 col-md-offset-3' data-target='#PaymentCashConfirmationModal'>
                                                            <i class='glyphicon glyphicon-euro'></i>
                                                        Cash </a>
                                                    </div>"
						."</div>"
					."</div>"
				."</div>"
			."</div>"
                . "</div>";
                
        return $result;
    }
    
   // Modal To State That The Job Has Already Started
   function JobAlreadyStartedModal()
    {
                $result = "<div class='modal fade col-md-12 col-xs-11' id='jobAlreadyStartedModal' role='dialog'>
			<div class='modal-dialog'>
			
			  <!-- Modal content-->
			  <div class='modal-content'>
				<div class='modal-header'>
				  <button type='button' class='close' data-dismiss='modal'>&times;</button>
				  <h4 class='modal-title'>WooPS!!!!</h4>
				</div>
				<div class='modal-body'>
                                    <div class='alert alert-info' style='text-align:center;'>
                                      <strong>Sorry,</strong><p style='font-size:13px;'> jobs cannot be updated once it has passed the start date :)</p>
                                    </div>
                                </div>
			  </div>
			  
			</div>
	  </div>";
        return $result;
    }
    
   // Modal For PayPal Payment Confimation
   function PaymentConfirmationModal($id)
    {
       require_once 'Model/PlacedOffersModel.php';
       require_once 'Model/SignInModel.php';
       require_once 'Model/JobModel.php';
       
       $jobModel = new JobModel();
       $job = $jobModel->GetJobsByID($_SESSION['jobId']);
       
        require_once 'Model/UserModel.php';
        $userModel = new UserModel();
        
        $user = $userModel->GetUserById($id);
       
       $payPalMeModel = new PayPalMeModel();
       $PlacedOffersModel = new PlacedOffersModel();
       $signInModel = new SignInModel();
       
       $placedOffer = $PlacedOffersModel->GetUsersPlacedOffer($_SESSION['jobId'], $id);
       
       // Variables To Calculate How Much To Pay
       $bidPrice = $placedOffer->offerPrice;
       $amountOfDays = $placedOffer->numberOfDays;
       $numberOfDaysPresent = $signInModel->CountAttendanceToAJob($id, $_SESSION['jobId']);
       
       $total = ($bidPrice) * ($numberOfDaysPresent);
       $_SESSION['paymentTotal'] = $total;

                $result = "<div class='modal fade col-md-12 col-xs-11' id='PaymentConfirmationModal' role='dialog'>
			<div class='modal-dialog'>
			
			  <!-- Modal content-->
			  <div class='modal-content'>
				<div class='modal-header'>
				  <button type='button' class='close' data-dismiss='modal'>&times;</button>
				  <h4 class='modal-title'>Payment Confirmation</h4>
				</div>
				<div class='modal-body'>
                                    <div class='alert alert-warning'>
                                        <p style='color:blue; font-size:16px; text-align:center;'><u>Job</u></p>
                                        <p style='color:black; font-size:16px;'><font color='green'>Job Name:</font> $job->name</p>
                                            
                                        <p style='color:blue; font-size:16px; text-align:center;'><u>User</u></p>
                                        <p style='color:black; font-size:16px;'><font color='green'>Name:</font> $user->firstName $user->lastName</p>
                                        <p style='color:black; font-size:16px;'><font color='green'>Email:</font> $user->email</p>
                                        <p style='color:black; font-size:16px;'><font color='green'>Phone:</font> $user->phone</p>
                                            
                                        <p style='color:blue; font-size:16px; text-align:center;'><u>Amount to Pay</u></p>
                                        <p style='color:black; font-size:16px;'><font color='green'>Expected Number Of Days:</font> $amountOfDays</p>
                                        <p style='color:black; font-size:16px;'><font color='green'>Number Of Days Present:</font> $numberOfDaysPresent</p>
                                        <p style='color:black; font-size:16px;'><font color='green'>Bid Price:</font> $bidPrice</p>
                                        <p style='color:black; font-size:16px; text-align:center;'><font color='green'>Amount To Pay</font> = Bid Price * Number Of Days Present</p>
                                        <p style='color:black; font-size:16px; text-align:center;'>= <font color='blue'>€ $total</font></p>
                                    </div>
                                    <form action='' method = 'POST'>
                                      <fieldset>
                                       <button class='btn primary col-xs-3 col-xs-offset-8 col-sm-2 col-sm-offset-8 col-md-2 col-md-offset-10' name = 'confirmAmounToPay' type='submit'>Continue</button>
                                      </fieldset>
                                    </form>
                                </div>
			  </div>
			  
			</div>
	  </div>";
        return $result;
    } 
    
    
   // Modal To Add A New PayPalMe Account
   function PaymentConfirmationModalCash($id)
    {
       require_once 'Model/PlacedOffersModel.php';
       require_once 'Model/SignInModel.php';
       require_once 'Model/JobModel.php';
       
       $jobModel = new JobModel();
       $job = $jobModel->GetJobsByID($_SESSION['jobId']);
       
        require_once 'Model/UserModel.php';
        $userModel = new UserModel();
        
        $user = $userModel->GetUserById($id);
       
       $payPalMeModel = new PayPalMeModel();
       $PlacedOffersModel = new PlacedOffersModel();
       $signInModel = new SignInModel();
       
       $placedOffer = $PlacedOffersModel->GetUsersPlacedOffer($_SESSION['jobId'], $id);
       
       // Variables To Calculate How Much To Pay
       $bidPrice = $placedOffer->offerPrice;
       $amountOfDays = $placedOffer->numberOfDays;
       $numberOfDaysPresent = $signInModel->CountAttendanceToAJob($id, $_SESSION['jobId']);
       
       $total = ($bidPrice) * ($numberOfDaysPresent);
       $_SESSION['paymentTotal'] = $total;

                $result = "<div class='modal fade col-md-12 col-xs-11' id='PaymentCashConfirmationModal' role='dialog'>
			<div class='modal-dialog'>
			
			  <!-- Modal content-->
			  <div class='modal-content'>
				<div class='modal-header'>
				  <button type='button' class='close' data-dismiss='modal'>&times;</button>
				  <h4 class='modal-title'>Payment Confirmation</h4>
				</div>
				<div class='modal-body'>
                                    <div class='alert alert-warning'>
                                        <p style='color:blue; font-size:16px; text-align:center;'><u>Job</u></p>
                                        <p style='color:black; font-size:16px;'><font color='green'>Job Name:</font> $job->name</p>
                                            
                                        <p style='color:blue; font-size:16px; text-align:center;'><u>User</u></p>
                                        <p style='color:black; font-size:16px;'><font color='green'>Name:</font> $user->firstName $user->lastName</p>
                                        <p style='color:black; font-size:16px;'><font color='green'>Email:</font> $user->email</p>
                                        <p style='color:black; font-size:16px;'><font color='green'>Phone:</font> $user->phone</p>
                                            
                                        <p style='color:blue; font-size:16px; text-align:center;'><u>Amount to Pay</u></p>
                                        <p style='color:black; font-size:16px;'><font color='green'>Expected Number Of Days:</font> $amountOfDays</p>
                                        <p style='color:black; font-size:16px;'><font color='green'>Number Of Days Present:</font> $numberOfDaysPresent</p>
                                        <p style='color:black; font-size:16px;'><font color='green'>Bid Price:</font> $bidPrice</p>
                                        <p style='color:black; font-size:16px; text-align:center;'><font color='green'>Amount To Pay</font> = Bid Price * Number Of Days Present</p>
                                        <p style='color:black; font-size:16px; text-align:center;'>= <font color='blue'>€ $total</font></p>
                                    </div>
                                    <form action='' method = 'POST'>
                                      <fieldset>
                                       <button class='btn primary col-xs-3 col-xs-offset-8 col-sm-2 col-sm-offset-8 col-md-2 col-md-offset-10' name = 'confirmCashAmounToPay' type='submit'>Send</button>
                                      </fieldset>
                                    </form>
                                </div>
			  </div>
			  
			</div>
	  </div>";
        return $result;
    } 
    
    function CreateAdminUserSideBar()
    {
        $result = "<div class='panel panel-default'>
					<div class='panel-heading' style='text-align:center;'>
					<a data-toggle='collapse' data-parent='#accordion' href='#collapseJObOverviewPage' class='glyphicon glyphicon glyphicon-th-list'><strong> Menu</strong></a>
					</div>
					<div id='collapseJObOverviewPage' class='panel-collapse collapse in'>
						<div class='panel-body'>"
                                    ."<div class='col-md-12'>
                                                            <div class='profile-sidebar'>
                                                                    <!-- SIDEBAR MENU -->
                                                                    <div class='home-usermenu'>
                                                                            <ul class='nav'>
                                                                                    <li>
                                                                                            <a href='Home.php' style='text-align:center;'>
                                                                                            <i class='glyphicon glyphicon-home'></i>
                                                                                            Home </a>
                                                                                    </li>
                                                                                    <li>
                                                                                            <a href='SearchResult.php?epr=myJobs' style='text-align:center;'>
                                                                                            <i class='glyphicon glyphicon-envelope'></i>
                                                                                             Inbox</a>
                                                                                    </li>
                                                                                    <li>
                                                                                            <a href='JobAdmin.php' style='text-align:center;'>
                                                                                            <i class='glyphicon glyphicon-wrench'></i>
                                                                                            Job </a>
                                                                                    </li>
                                                                                    <li class='active'>
                                                                                            <a href='UserAdmin.php' style='text-align:center;'>
                                                                                            <i class='glyphicon glyphicon-user'></i>
                                                                                            Users </a>
                                                                                    </li>
                                                                                    <li>
                                                                                            <a href='#' data-toggle='modal' data-target='#priceModal' style='text-align:center;'>
                                                                                            <i class='glyphicon glyphicon-flag'></i>
                                                                                            Reports </a>
                                                                                    </li>
                                                                            </ul>
                                                                    </div>
                                                                    <!-- END MENU -->
                                                            </div>
                                                    </div>"
						."</div>"
					."</div>"
                            ."</div>";

        return $result;
    }
    
    // Get PayPalMe Accounts
    function GetPayPalMeAccounts()
    {
        $payPalMeModel = new PayPalMeModel();
        return $payPalMeModel->GetPayPalMeAccounts();
    }
    
    // View PayPalMe Accounts
    function ViewPayPalMeAccounts()
    {
        $payPalMeModel = new PayPalMeModel();
        
        $search = $payPalMeModel->GetPayPalMeAccounts();
        
        require_once 'Model/UserModel.php';
        $userModel = new UserModel();
        
        $result = "<div class='row'>"
                . "<div class='panel-group col-md-12'>
			  <div class='panel panel-default'>
					<div class='panel-heading' style='text-align:center;'>
					<a data-toggle='collapse' data-parent='#accordion' href='#collapseListPlacedOffers' class='glyphicon glyphicon-hand-up'><strong>Payment Confirmations</strong></a>
					</div>
					<div id='collapseListPlacedOffers' class='panel-collapse collapse in'>
						<div class='panel-body'>
                                                    <div class='row' style='margin:auto; width:100%; padding-top:10px;'>
							<input type='text' id='myInput' class='col-md-4' onkeyup='placedOfferTableFunction()' placeholder='Search for Users' title='Type in a user' style='display: block; margin: auto;'>
                                                    </div>"
                                                        . "<table class='table sortable' id='placedOffersTable'>"
                                                        . "<tr>"
                                                        . "     <th style='text-align:center;'>User</th>"
                                                        . "     <th style='text-align:center;'>URL</th>" 
                                                        . "</tr>";
                                                        try
                                                        {
                                                            if($search != null)
                                                            {
                                                                foreach($search as $row)
                                                                {
                                                                    $user = $userModel->GetUserById($row->userId);
                                                                    $result.= "<tr>"
                                                                            . "<td align='center'><a href='ViewUserProfile.php?epr=view&id=".$row->userId."'>$user->firstName $user->lastName</a></td>"
                                                                            ."<td align='center'>$row->payPalMeUrl</td>";
                                                                }
                                                            }
                                                        }catch(Exception $x)
                                                        {
                                                            echo 'Caught exception: ',  $x->getMessage(), "\n";
                                                        }
                                                    $result.= "</table>"
						."</div>"
					."</div>"
				."</div>"
			."</div>"
                        . "<script>
				function placedOfferTableFunction() {
				  var input, filter, table, tr, td, i;
				  input = document.getElementById('myInput');
				  filter = input.value.toUpperCase();
				  table = document.getElementById('placedOffersTable');
				  tr = table.getElementsByTagName('tr');
				  for (i = 0; i < tr.length; i++) {
					td = tr[i].getElementsByTagName('td')[0];
					if (td) {
					  if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
						tr[i].style.display = '';
					  } else {
						tr[i].style.display = 'none';
					  }
					}       
				  }
				}
			</script>";
                return $result; 
    }
}
