<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TypeTest
 *
 * @author Jake Valino
 */
require ("Controller/TypeController.php");
class TypeTest extends \PHPUnit_Framework_TestCase
{
    // Test Get Types
    public function testGetTypes()
    {
        $typeController = new TypeController();
        
        $types = $typeController->GetTypes();
        
        $this->assertNotEquals(0, count($types));
    }
    
    //Get Type By ID.
    public function testGetTypeByID()
    {
        $typeController = new TypeController();
        
        $type = $typeController->GetTypeByID(10);
        
        $this->assertEquals(10, $type->typeId);
    }
    
    
}
