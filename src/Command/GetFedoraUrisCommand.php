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
class GetFedoraUrisCommand extends ContainerAwareCommand {

  /**
   * {@inheritdoc}
   */
  protected function configure() {
    $this
      ->setName('islandora_console:get_fedora_uris')
      ->setDescription($this->trans('commands.islandora_console.print_title.description'))
      ->addOption('nid_file', NULL, InputOption::VALUE_REQUIRED, $this->trans('commands.islandora_console.print_tilte.options.nid_file'), NULL);

    // @todo: Add options for specifying the Gemini base URL and authorization credentials.
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
          $uuid = $node->uuid->value;
          $gemini_results = $this->query_gemini($uuid);
          print $nid . "," . $gemini_results['fedora'] . "\n";
        }
        else {
          $this->getIo()->warning($this->trans('commands.islandora_console.general.messages.cannotfindnode'));
        }
      }
    }
    else {
      $this->getIo()->warning($this->trans('commands.islandora_console.general.messages.cannotfindfile'));
    }
  }

  /**
   * Queries Gemini's REST API for node's the Fedora URI.
   *
   * @param string $uuid
   *   The node's UUID.
   *
   * @return arrray
   *   The results of the request as an associative array with keys 'drupal' and 'fedora'.
   */
  protected function query_gemini($uuid) {
    $url = 'http://localhost:8000/gemini/' . $uuid;
    $response = \Drupal::httpClient()->get($url, ['headers' => array('Authorization' => 'Bearer islandora')]);
    $response_body = (string) $response->getBody();
    $response_body = json_decode($response_body, true);
    return $response_body;
  }
}
