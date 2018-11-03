# Islandora Console

Proof of concept implementation of Islandora CLAW replacement for Islandora 7.x's [Datastream CRUD](https://github.com/SFULibrary/islandora_datastream_crud). See https://github.com/Islandora-CLAW/CLAW/issues/965 for more details.

## Requirements

* [Islandora](https://github.com/Islandora-CLAW/islandora) a.k.a. CLAW

## Installation

1. Clone this repo into your Islandora's `drupal/web/modules/contrib` directory.
1. Enable the module either under the "Admin > Extend" menu or by running `drush en -y islandora_console`.

## Usage

Input for Islandora Console commands is a NID file, which is a simple plain text file containing one node ID per line, e.g.:

```
100
125
315
```

All commands require the `--nid_file` option, which specifies the absolute path to the NID file. If the file specified in `--nid_file` does not exist, a warning message to that effect will appear and the command will quit.

For all commands, if a node specified in the node file does not exist, a warning message will appear and the command will move on to the next node. 

### Commands so far

* `drupal islandora_console:print_title --nid_file=PATH_TO_FILE`
   * where `PATH_TO_FILE` is the absolute path to a file containing one node ID per line, e.g. `drupal islandora_console:print_title --nid_file=/tmp/node_ids.txt`

This command just prints the title of the nodes. It's not that useful, it's just sort of a "hello world" command.

* `drupal islandora_console:get_fedora_uris --nid_file=PATH_TO_FILE`
   * where `PATH_TO_FILE` is the absolute path to a file containing one node ID per line, e.g. `drupal islandora_console:get_fedora_uris --nid_file=/tmp/node_ids.txt`

For each node identified in the NID file, This command will print the node ID and the corresponding Fedora URI for the node, separted by a comma:

```
drupal islandora_console:get_fedora_uris --nid_file=/tmp/nodes.txt
90,http://localhost:8080/fcrepo/rest/b1/8b/f3/be/b18bf3be-9615-47ca-bb4e-6fe4d97da2a6
92,http://localhost:8080/fcrepo/rest/55/40/43/23/55404323-81c5-4096-8210-c57bcab77cf8
93,http://localhost:8080/fcrepo/rest/73/f5/d9/f1/73f5d9f1-fabc-4a01-8b5c-8e764eb9060c
```

* `drupal islandora_console:get_solr_docs --nid_file=/tmp/nodes.txt`
   * where `PATH_TO_FILE` is the absolute path to a file containing one node ID per line, e.g. `drupal islandora_console:get_fedora_uris --nid_file=/tmp/node_ids.txt`

For each node identified in the NID file, this command will print the node's Solr document, e.g.:

```javascript
{
  "response":{"numFound":1,"start":0,"docs":[
      {
        "timestamp":"2018-11-02T21:57:11Z",
        "id":"5r7dfi-default_solr_index-entity:node/93:en",
        "index_id":"default_solr_index",
        "sm_context_tags":["search_api_X2f_index_X3a_default_solr_index",
          "search_api_solr_X2f_site_hash_X3a_5r7dfi",
          "drupal_X2f_langcode_X3a_en"],
        "hash":"5r7dfi",
        "site":"http://localhost:8000/",
        "sm_node_grants":["node_access__all"],
        "sort_node_grants":"node_access__all",
        "ss_author":"admin",
        "sort_author":"admin",
        "ds_changed":"2018-11-02T21:57:11Z",
        "ds_created":"2018-07-24T21:24:01Z",
        "bs_status":true,
        "bs_sticky":false,
        "tm_title":["Citations"],
        "spell":["Citations"],
        "sort_title":"Citations",
        "ss_type":"islandora_object",
        "sort_type":"islandora_object",
        "its_uid":1,
        "ss_uuid":"73f5d9f1-fabc-4a01-8b5c-8e764eb9060c",
        "sort_uuid":"73f5d9f1-fabc-4a01-8b5c-8e764eb9060c",
        "ss_search_api_id":"entity:node/93:en",
        "ss_search_api_datasource":"entity:node",
        "ss_search_api_language":"en",
        "_version_":1616060963501375488}]
  }}
```

## Current maintainer

* [Mark Jordan](https://github.com/mjordan)

## License

[GPLv2](http://www.gnu.org/licenses/gpl-2.0.txt)


