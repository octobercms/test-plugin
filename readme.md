# Test Plugin

This is a UI test plugin for OctoberCMS.

The following sections are explored, tested and demonstrated along with a list of the features used:

### Test 1: People

A Person has a Phone (One to one relationship)

1. Relation Controller
1. Record Finder
1. Proxy Form fields

### Test 2: Posts

A Post "Has Many" Comments (One to many relationship)

1. Relation Controller
1. Image Uploader in a Popup
1. Rich Editor in a Popup

### Test 3: Users

User "Has Many" Roles (Many to many relationship)

### Test 4: Countries

A Country "Has Many" Posts "Through" a User (Has many through relationship)

### Test 5: Staff & Orders

Staff and Orders "Morph Many" Photos (Polymorphic relationship)


## Tests that need attention

- When an AJAX error occurs inside a popup, the stripe indicator sticks around.

- An attach relation cannot be made required, even with an image it shows unpopulated.

- An attach relation when required inside a tab does not make the tab active.

- When a relation controller popup has an invalid error, the popup does not reappear.
