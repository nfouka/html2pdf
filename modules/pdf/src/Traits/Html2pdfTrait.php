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
trait Html2pdfTrait {
    //put your code here
    
    public function convertHtmlToPdf($content){
            $html2pdf = new \HTML2PDF('P','A4','fr');
            $html2pdf->pdf->SetDisplayMode('fullpage');
           $html2pdf->WriteHTML($content);
           $html2pdf->Output('exemple.pdf');
           ob_clean();
           $html2pdf->Output($_SERVER['DOCUMENT_ROOT'] . "/data/result_.pdf", 'F');
    }
}
