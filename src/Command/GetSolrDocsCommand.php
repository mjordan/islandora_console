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
class GetSolrDocsCommand extends ContainerAwareCommand {

  /**
   * {@inheritdoc}
   */
  protected function configure() {
    $this
      ->setName('islandora_console:get_solr_docs')
      ->setDescription($this->trans('commands.islandora_console.get_solr_doc.description'))
      ->addOption('nid_file', NULL, InputOption::VALUE_REQUIRED, $this->trans('commands.islandora_console.get_solr_doc.options.nid_file'), NULL);

    // @todo: Add options for specifying the Solr base URL and authorization credentials.
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
          $solr_results = $this->query_solr($nid);
          print $solr_results . "\n";
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
   * Queries Solr's REST API for node's Solr document.
   *
   * @param string $nid
   *   The node's Drupal ID.
   *
   * @return string
   *   The raw JSON Solr document for the node.
   */
  protected function query_solr($nid) {
     $solr_url = 'http://localhost:8983/solr/CLAW/select?q=ss_search_api_id:%22entity:node/' . $nid . ':en%22';
     $response = \Drupal::httpClient()->get($solr_url);
     $response_body = (string) $response->getBody();
     return $response_body;
  }
}
