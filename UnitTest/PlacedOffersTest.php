<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PlacedOffersTest
 *
 * @author Jake Valino
 */
require ("Controller/PlacedOffersController.php");
class PlacedOffersTest extends \PHPUnit_Framework_TestCase
{
    // Test Place An Offer To A Job
    public function testPlaceAnOffer()
    {
        $placedOffersController = new PlacedOffersController();
        
        $offersBeforeInsertion = $placedOffersController->GetAllAcceptedPlacedOffers();
        
        $placedOffersController->PlaceAnOffer(138, 36, "Test Comment", "Test Update", 100, "donvalino", "a", 1, 1, "Test Start Date");
        
        $offersAfterInsertion = $placedOffersController->GetAllAcceptedPlacedOffers();
        
        $this->assertEquals(count($offersBeforeInsertion),count($offersAfterInsertion));
    }
    
    // Test Update An Offer
    public function testUpdateAnOffer()
    {
        $placedOffersController = new PlacedOffersController();
        
        $placedOffersController->updateAnOffer(138, 36, "New Date", 101, "Updated", "donvalino", "a", 1, "Updated");
        
        $offersAfterUpdate = $placedOffersController->GetUserlacedOffersByJobIdAndUserId(138, 36);
        
        $this->assertEquals("New Date",$offersAfterUpdate->placementDate);
    }
    
    // Test Get The Lowest Placed Offers Price in a specific job
    public function testGetLowestPlacedOffersByJobId()
    {
        $placedOffersController = new PlacedOffersController();
        
        $lowestBid = $placedOffersController->GetLowestPlacedOffersByJobId(138);
        
        $this->assertNotEquals(0,count($lowestBid));
    }
    
    // Test Get All Placed Offers
    public function testGetAllPlacedOffers()
    {
        $placedOffersController = new PlacedOffersController();
        
        $bids = $placedOffersController->GetAllPlacedOffers();
        
        $this->assertNotEquals(0,count($bids));
    }
    
    
}
