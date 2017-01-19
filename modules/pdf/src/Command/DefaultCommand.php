<?php

namespace Drupal\pdf\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command;
use Drupal\Console\Core\Command\Shared\CommandTrait;
use Drupal\Console\Core\Style\DrupalStyle;
use Drupal\Console\Annotations\DrupalCommand;

/**
 * Class DefaultCommand.
 *
 * @package Drupal\pdf
 *
 * @DrupalCommand (
 *     extension="pdf",
 *     extensionType="module"
 * )
 */
class DefaultCommand extends Command {

  use CommandTrait;
  use \Drupal\pdf\Traits\PersonTrait ; 

  /**
   * {@inheritdoc}
   */
  protected function configure() {
      
      
    $this
      ->setName('pdf:default')
      ->setDescription($this->trans('commands.pdf.default.description'));
  }

  /**
   * {@inheritdoc}
   */
  protected function execute(InputInterface $input, OutputInterface $output) {
    $io = new DrupalStyle($input, $output);
    
    $instance = new \Drupal\pdf\d8\Person() ; 
    if($instance instanceof \Drupal\pdf\d8\PersonInterface ) {
        print 'ok' ; 
    }
    
    $this->getInstanceOfClass() ; 

    $io->info($this->trans('commands.pdf.default.messages.success'));
  }
}
