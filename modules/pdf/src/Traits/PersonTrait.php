<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Drupal\pdf\Traits;

/**
 * Description of newPHPClass
 *
 * @author nadir
 */
Trait PersonTrait {

    public function getInstanceOfClass() {
        print_r($this->getApplication()) ; 
        return 'itw work now !' ; 
    }
}
