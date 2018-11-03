# Islandora Console

Proof of concept implementation of Islandora CLAW replacement for Islandora 7.x's [Datastream CRUD](https://github.com/SFULibrary/islandora_datastream_crud). See https://github.com/Islandora-CLAW/CLAW/issues/965 for more details.

## Requirements

* [Islandora](https://github.com/Islandora-CLAW/islandora) a.k.a. CLAW

## Installation

1. Clone this repo into your Islandora's `drupal/web/modules/contrib` directory.
1. Enable the module either under the "Admin > Extend" menu or by running `drush en -y islandora_console`.

## Usage

Two commands so far:

* `drupal islandora_console:print_title --nid_file=PATH_TO_FILE`
   * where `PATH_TO_FILE` is the absolute path to a file containing one node ID per line, e.g. `drupal islandora_console:print_title --nid_file=/tmp/node_ids.txt`
   * prints the title of the nodes, which is not that useful, it's just sort of a "hello world" command.
* `drupal islandora_console:get_fedora_uris --nid_file=PATH_TO_FILE`
   * where `PATH_TO_FILE` is the absolute path to a file containing one node ID per line, e.g. `drupal islandora_console:get_fedora_uris --nid_file=/tmp/node_ids.txt`

This will print the node ID and the corresponding Fedora URI for the node, separted by a comma:

```
drupal islandora_console:get_fedora_uris --nid_file=/tmp/nodes.txt
90,http://localhost:8080/fcrepo/rest/b1/8b/f3/be/b18bf3be-9615-47ca-bb4e-6fe4d97da2a6
92,http://localhost:8080/fcrepo/rest/55/40/43/23/55404323-81c5-4096-8210-c57bcab77cf8
93,http://localhost:8080/fcrepo/rest/73/f5/d9/f1/73f5d9f1-fabc-4a01-8b5c-8e764eb9060c
```

For both commands, if a node does not exist, a warning message will appear. If the file specified in `--nid_file` does not exist, a warning message to that effect will appear.

## Current maintainer

* [Mark Jordan](https://github.com/mjordan)

## License

[GPLv2](http://www.gnu.org/licenses/gpl-2.0.txt)


