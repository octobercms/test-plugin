# October Test

October Test is a playground plugin that exercises October CMS features in the backend and on the frontend. It is used for manual testing and as reference code.

Most of the plugin follows current conventions and is safe to copy. Some files deliberately use unusual configurations to test edge cases, and these are labelled with a comment that starts with **Testing**. Read the label before copying one of them.

## Installation

Before installing this plugin, change your minimum stability to `dev` with composer.

```bash
composer config minimum-stability dev
```

Install the plugin from GitHub.

```bash
php artisan plugin:install October.Test --from=https://github.com/octobercms/test-plugin
```

The plugin seeds its own test data. To rebuild the tables and the data at any time, refresh the plugin.

```bash
php artisan plugin:refresh October.Test
```

Refreshing is also how the plugin is upgraded, since its migrations are edited in place. An install made before the migrations were restructured records a higher version in the database, so `october:migrate` reports nothing to do until the plugin is refreshed.

To uninstall the plugin.

```bash
php artisan plugin:remove October.Test
```

## Running the Tests

Run the PHPUnit suite from the project root.

```bash
php artisan plugin:test october.test
```

The suite uses an in-memory SQLite database and isolates each test with a transaction, so it does not touch your data.

To fill the posts list with a large number of records, for example to test pagination and performance, use the console command.

```bash
php artisan test:seed-posts --count=5000
```

## Feature Map

The backend pages are found under the **Playground** menu item. Some pages are opened from another page instead of the menu: Cities and Countries from the Locations toolbar, Categories, Channels and Members from the Trees page, Plugins and Themes from the Reviews toolbar, and Orders, Product Categories and Companies from the Products toolbar.

### Backend Pages

Page | Relationships | Also covers
---- | ------------- | -----------
People | Person has one Phone | Relation controller, record finder, proxy fields, form contexts, AJAX handlers, mail sending, file downloads
Posts | Post has many Comments, belongs to many Tags | Three lists in one controller, comment and tag popups that switch the form config, delete with a reason, import and export
Users | User belongs to many Roles | Plain, pivot data and pivot model relations, file uploads, custom file model, a partial field with a control, custom filter widgets
Locations | Location belongs to Country and City | Dependent fields, quick create from a relation field, many attachments loaded in one query
Countries | Country has many Cities, has many Posts through Users, has one Post through Users | Relational repeaters, checkbox lists, translatable attributes, a single default record
Cities | City belongs to Country, has many Locations | Nested relation definitions that manage the cities of the related country, and a nested form inside the country relation popup
Reviews | Review morphs to Post, Plugin or Theme | Change handlers, list tabs, a custom list view path, a custom form widget
Plugins and Themes | Morph many Reviews, morph one Meta | Popup form design and meta fields saved to a related model, both on Plugins
Galleries | Gallery is morphed by many Posts, belongs to many Countries | Pivot sorting, browser validation, rule objects
Trees | Members and Categories are simple trees, Channels are a nested set | List structure reordering, structure permissions, restoring soft deleted records
Pages | Page belongs to Layout and to a parent Page | Sidebar layout, nested forms, translatable attachments, import and export
Products | Product belongs to many Categories and Locations, has many Offers | Validation unique to a site, data tables
Orders | Order has many Order Items | Picking a product to create an order item, data tables in popups
Companies and Product Categories | Company is soft deleted and multisite | Tailor navigation context, UI and icon showcases

### Registration

The plugin registration file `Plugin.php` registers each of these features.

Feature | Files
------- | -----
Dashboard widgets | `reportwidgets/`, `vuecomponents/MyCustomWidget.php`
Dashboard data source | `classes/LocationDataSource.php`
Form widget | `formwidgets/TimeChecker.php`
Filter widgets | `filterwidgets/`
Tailor content field | `contentfields/MyContentField.php`
Validation rules | `classes/UppercaseRule.php`, `classes/BetwixtRule.php`, and `classes/LowercaseRule.php` as a local rule object
Console command | `console/SeedPosts.php`
Scheduled task | `Plugin.php` records an hourly heartbeat in the cache
Event subscriber | `classes/ExtendCoreFeatures.php`
Settings | `models/Setting.php` with translatable values
Mail templates | `views/mail/`
Permissions and navigation | `Plugin.php`

### Frontend

The CMS components are used by the companion test theme.

Component | Covers
--------- | ------
`kitchenSink` | Inspector property types, AJAX handlers and page snippets
`inlineData` | A snippet that renders inline within page content
`vueTester` | Vue component registration on the frontend

### Tailor Blueprints

The `blueprints` directory defines the Blog, Stream and Wiki Tailor sections. After changing a blueprint, run the migration to update its database tables.

```bash
php artisan tailor:migrate
```

## Documentation Coupling

The October CMS documentation prints some files from this plugin. These are listed in [CLAUDE.md](CLAUDE.md), and the documentation should be updated in the same change when they move or change.
