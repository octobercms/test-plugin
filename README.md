# Test Plugin

This is a UI test plugin for October CMS.

## Installation Instructions

Run the following to install this plugin:

```bash
php artisan plugin:install October.Test --from=https://github.com/octobercms/test-plugin
```

If you already have this plugin installed and need to update the database schema, run this command:

```bash
php artisan plugin:refresh October.Test
```

To uninstall this plugin:

```bash
php artisan plugin:remove October.Test
```

## Tests

The following sections are explored, tested and demonstrated along with a list of the features used:

### Test 1: People

A Person "Has One" Phone (One to one relationship)

1. Relation Controller
1. Record Finder
1. Proxy Form fields
1. Date pickers
1. Context-based Form fields

### Test 2: Posts

A Post "Has Many" Comments (One to many relationship)

1. Relation Controller
1. Popup-based Form fields
1. Rich Editor
1. Dual Form Controller and List Controller
1. HTML in comments
1. Custom Delete workflow
1. Repeater fields in comments popup

### Test 3: Users

User "Belongs To Many" Roles (Many to many relationship)

1. Relation Controller (Standard, Pivot data, Pivot model)
1. Image Uploaders (Single, Multi, File, Image)
1. Number field
1. No click list column
1. Custom File model
1. Form field partial
1. Tag List in relation mode

### Test 4: Locations

1. City "Has Many" Locations
1. City "Belongs To" Country
1. Location "Belongs To" Country
1. Location "Belongs To" City

#### Countries

A Country "Has Many" Posts "Through" a User (Has many through relationship)

1. Checkbox list
1. Default form field values
1. Field dependency and filtering
1. Repeater fields
1. Tabs empty with no fields

#### Cities

A City "Belongs To" a Country and "Has Many" Locations.

#### Attributes

An Attribute is a single generic model with many relationship types.

1. Posts "Belong To" (Attribute) Status (`general.status`).
1. Countries "Belong To Many" (Attribute) Types (`general.types`).

### Test 5: Reviews

1. Reviews "Morph To" Plugins and Themes as Product (Polymorphic relationships)
1. Meta "Morph To" Plugins and Themes as Product (Polymorphic relationships)
1. Plugins and Themes "Morph Many" Reviews
1. Plugins and Themes "Morph One" Meta
1. Plugins should not create when Meta validation fails.

### Test 6: Galleries

1. Galleries are "Morphed By Many" Posts
1. Posts "Morph To Many" Galleries

### Test 7: Trees

1. A Member uses a simple tree (parent-child) structure.
1. A Category uses a simple tree structure, with sorting.
1. A Channel uses a nested set tree structure.

### Test 8: Pages

1. Page "Belongs To" Layout

### Test 9: Product

1. Product
