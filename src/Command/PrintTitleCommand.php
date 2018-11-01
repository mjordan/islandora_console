<?php

namespace Drupal\islandora_console\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Drupal\Console\Core\Command\ContainerAwareCommand;
use Drupal\Console\Annotations\DrupalCommand;

/**
 * Class PrintTitleCommand.
 *
 * @DrupalCommand (
 *     extension="islandora_console",
 *     extensionType="module"
 * )
 */
class PrintTitleCommand extends ContainerAwareCommand {

  /**
   * {@inheritdoc}
   */
  protected function configure() {
    $this
      ->setName('islandora_console:print_title')
      ->setDescription($this->trans('commands.islandora_console.print_title.description'))
      ->addOption('nid_file', NULL, InputOption::VALUE_REQUIRED, $this->trans('commands.islandora_console.print_tilte.options.nid_file'), NULL);
  }

 /**
  * {@inheritdoc}
  */
  protected function initialize(InputInterface $input, OutputInterface $output) {
    parent::initialize($input, $output);
    // $this->getIo()->info('initialize');
  }

 /**
  * {@inheritdoc}
  */
  protected function interact(InputInterface $input, OutputInterface $output) {
    // $this->getIo()->info('interact');
  }

  /**
   * {@inheritdoc}
   */
  protected function execute(InputInterface $input, OutputInterface $output) {
    $nid_file_path = $input->getOption('nid_file');
    if (file_exists($nid_file_path)) {
      $nids = file($nid_file_path, FILE_IGNORE_NEW_LINES);
      foreach ($nids as $nid) {
        if ($node = \Drupal::service('entity_type.manager')->getStorage('node')->load($nid)) {
          $title = $node->getTitle();
          $this->getIo()->success($title);
        }
        else {
          $this->getIo()->warning($this->trans('commands.islandora_console.print_title.messages.cannotfindnode'));
        }
      }
    }
    else {
      $this->getIo()->warning($this->trans('commands.islandora_console.print_title.messages.cannotfindfile'));
    }
  }
}
