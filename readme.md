# PyroRoutes 1.1

PyroRoutes is a very simple module for PyroCMS that allows you to create and manage custom routes. It does this by directly editing the routes.php file, so there is no database calls checking for routes when you load up a PyroCMS page.

## Installation

Drop the pyroroutes folder into the addons/shared\_addons/modules or addons/[site-ref]/modules. Activate via the Add-ons section of the PyroCMS back end.

Alternatively, you can upload the upload.zip folder using PyroCMS' module upload function.

Make sure your routes.php permissions are set to 666 so the server can write the file.

## Usage

Create a new route by proving a name, the route key, and the URI to route it to. You can use (:any) and (:num) in your route key to denote a segment containing any string and any number, respectively.

Saving, editing, or deleting a route will sync the routes file. You can also click "Sync Routes" to sync the file again.

## Changelog

*2.0 September 26, 2012*

- Updated for PyroCMS 2.1.x

*1.1 - November 3, 2011*

- Updated for PyroCMS 2.0