<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Drupal\pdf\Traits;

/**
 *
 * @author nadir
 */
trait SwiftMailerTrait {
    //put your code here
    
     public function sendMailSwiftMail($mail , $region) {
        $transport =  
          \Swift_SmtpTransport::newInstance(\Drupal::service('config.factory')->get('swiftmailer.transport')->get('transport').'.gmail.com', 
                 \Drupal::service('config.factory')->get('swiftmailer.transport')->get('smtp_port') ,  "ssl")
      ->setUsername(\Drupal::service('config.factory')->get('swiftmailer.transport')->get('smtp_username'))
      ->setPassword(\Drupal::service('config.factory')->get('swiftmailer.transport')->get('smtp_password'))
    ;
  
    $mailer = \Swift_Mailer::newInstance($transport);
    $message = \Swift_Message::newInstance('Generteur automatique')
       ->setFrom(array('softrain.evaluaciones@gmail.com' => 'List des medecin par région'))
       ->setEncoder(\Swift_Encoding::get8BitEncoding())
       ->setBody($body, "text/html")
      ->setTo(array($mail=> 'Doctor'))
      ->setBody('<code> VOUS AVEZ GÉNÉRER LES DEMEDIN DE '.$region.' from swiftmailer</code>')
      ->attach(\Swift_Attachment::fromPath('data/result_.pdf')) ;
    
    $mailer->send($message);
    
  }
  
}
