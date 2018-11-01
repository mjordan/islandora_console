# Islandora Console

Some horsing around to do with https://github.com/Islandora-CLAW/CLAW/issues/965.

## Requirements

* [Islandora](https://github.com/Islandora-CLAW/islandora) a.k.a. CLAW

## Installation

1. Clone this repo into your Islandora's `drupal/web/modules/contrib` directory.
1. Enable the module either under the "Admin > Extend" menu or by running `drush en -y islandora_console`.

## Usage

Only one command so far:

* `drupal islandora_console:print_title --nid_file=PATH_TO_FILE`
   * where `PATH_TO_FILE` is the absolute path to a file containing one node ID per line, e.g. `drupal islandora_console:print_title --nid_file=/tmp/node_ids.txt`

This will print the title of each of the nodes identified in the file. If a node does not exist, a warning message will appear. If the file does not exist, a different warning message will appear:

```
vagrant@claw:/var/www/html/drupal$ drupal islandora_console:print_title --nid_file=/tmp/nids.txt
 [OK] Winter Travel in the North, Atlin, B.C.                                                                           
 [OK] Ruskin Power Plant, near Mission City, B.C.                                                                       
vagrant@claw:/var/www/html/drupal$ 
```

This command is a simple example only. We could run an action against the node, such as generate a thumbnail from a service file.

## Current maintainer

* [Mark Jordan](https://github.com/mjordan)

## License

[GPLv2](http://www.gnu.org/licenses/gpl-2.0.txt)


