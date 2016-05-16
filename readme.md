# Test Plugin

This is a UI test plugin for OctoberCMS. Extract this archive to `/plugins/october/test` and click on **Playground** in the back-end area.

The following sections are explored, tested and demonstrated along with a list of the features used:

### Test 1: People

A Person "Has One" Phone (One to one relationship)

1. Relation Controller
1. Record Finder
1. Proxy Form fields
1. Date pickers
1. Context-based Form fields
1. List search policies `@todo`

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

### Test 4: Countries

A Country "Has Many" Posts "Through" a User (Has many through relationship)

1. Checkbox list
1. Default form field values
1. Field dependency and filtering
1. Repeater fields
1. Tabs empty with no fields

### Test 5: Reviews

Reviews "Morph To" Plugins and Themes as Product (Polymorphic relationships)
Meta "Morph To" Plugins and Themes as Product (Polymorphic relationships)
Plugins and Themes "Morph Many" Reviews
Plugins and Themes "Morph One" Meta

### Test 6: Trees

A Member uses a simple tree (parent-child) structure.

A Category uses a simple tree structure, with sorting.

A Channel uses a nested set tree structure.

### Test 7: Attributes

An Attribute is a single generic model with many relationship types.

1. Posts "Belong To" (Attribute) Status (`general.status`).
1. Countries "Belong To Many" (Attribute) Types (`general.types`).

## Tests that need attention

- An attach relation when required inside a tab does not make the tab active.

- Proxy fields throw a nasty error when the relation is non existant.

- Deleting multiple Comments from a Post (deferred) only deletes one comment.

- Constrained relations should not appear in RecordFinder (Phone:is_active) and Relation Controller lists (Comment:is_visible).

- Record Finder does not incorporate deferred bindings.

- HasOne relations acting as HasMany will break the list completely.

- Pivot model with required field doesn't show the asterisk on the form.

## Incorporating functional tests

- All relation controllers

- Test that input preset API works on fields

- Test that trigger API works on fields
