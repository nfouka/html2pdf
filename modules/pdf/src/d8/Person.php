<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Person
 *
 * @author nadir
 */


namespace Drupal\pdf\d8 ;

class Person implements PersonInterface {

    
    private $name ; 
    private $adress  ; 
    
    
    public function getResult1($v1) {
        print 'v1' ; 
    }

    public function getResult2($v1) {
         print 'v2' ; 
    }

    public function getResult3($v1) {
         print 'v3' ; 
    }

}
