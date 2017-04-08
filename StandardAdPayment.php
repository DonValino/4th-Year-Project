<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
require_once 'Stripe/Config.php'; 
session_start();

$epr='';
$title = "home";

$content = '';

$loginStatus= "Login";
$log = "";
$errorMessage = "";
$sidebar = "<div class='col-md-12'>
			<div class='profile-sidebar'>
				<!-- SIDEBAR MENU -->
				<div class='profile-usermenu'>
					<ul class='nav'>
						<li class='active'>
							<a href='Home.php' style='text-align:center;'>
							<i class='glyphicon glyphicon-remove'></i>
							Cancel </a>
						</li>
						<li>
							<a href='#' target='_blank' style='text-align:center;'>
							<i class='glyphicon glyphicon-flag'></i>
							Help </a>
						</li>
					</ul>
				</div>
				<!-- END MENU -->
			</div>
		</div>";

if(isset($_SESSION['username']))
{
   $loginStatus=$_SESSION['username'];
   $log = $_SESSION['log'];
}else
{
    header('Location: index.php');
}

if(isset($_GET['epr']))
{
    $epr=$_GET['epr'];
}

if($epr == 'pay')
{
    $jobid =$_GET['jobid'];
    $name =$_GET['name'];
    $description =$_GET['description'];
    $typeId =$_GET['typeId'];
    $qualificationId =$_GET['qualificationId'];
    $address =$_GET['address'];
    $county =$_GET['county'];
    $numberOfDays =$_GET['numberOfDays'];
    $numberOfPeopleRequired =$_GET['numberOfPeopleRequired'];
    $startDate =$_GET['startDate'];
    $price =$_GET['price'];
    $userid =$_GET['userid'];
    
    $content = 
        '<div class="row col-md-6 col-sm-6 col-sm-offset-3" style="background-color:white; margin-bottom:10px;">
                <h1 style="font-weight:bold; font-size:52px;">stripe</h1>
                <p style="font-size:13px;">Connect with Stripe to accept payments </p>
                <p style="font-size:13px;">stripe is the easiest way to accept credit cards. Process major international debt or credit cards, including Visa, MasterCard and American Express. You do not need a 
                    mechant account, so you can start paying / accepting payments today</p>
                    <img src="Images/AcceptedCards.png" class="col-md-1 col-sm-1" style="width:100%; display: block; margin: auto; text-align:center;"/>
            </div>
            <div class="row">
             <div class="panel-group col-md-4 col-sm-4 col-sm-offset-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-heading" style="text-align:center;">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseadvertisedjobs" class="glyphicon glyphicon-hand-up"><strong>Payment By Stripe</strong></a>
                    </div>
                <div id="collapseadvertisedjobs" class="panel-collapse collapse in">
                    <div class="panel-body">
                        <div class="row col-md-offset-3 col-sm-offset-3 col-xs-offset-4">'
                            . '<form action="Standard_Charge.php?epr=pay&jobid='.$jobid.'&name='.$name.'&description='.$description.'&typeId='.$typeId.'&qualificationId='.$qualificationId.'&address='.$address
                                .'&county='.$county.'&numberOfDays='.$numberOfDays.'&numberOfPeopleRequired='.$numberOfPeopleRequired.'&startDate='.$startDate.'&price='.$price.'&userid='.$userid.'" method="POST">
                                    <script
                                      src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                                      data-key="'.$stripe['publishable_key'].'"
                                      data-amount="100"
                                      data-name="FreelanceMe"
                                      data-description="Standard Ad Posting"
                                      data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                                      data-locale="auto"
                                      data-zip-code="true"
                                      data-currency="eur">
                                    </script>
                              </form>
                        </div>
                    </div>
                </div>
            </div>
          </div>';
}

 include 'Template.php'
 ?>

