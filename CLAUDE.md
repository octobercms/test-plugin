# October Test Plugin

This plugin is a playground that exercises October CMS features, and it is widely read as reference code. Code added here should be safe to copy, unless it is labelled as a deliberate edge case.

## Reference Code and Edge Cases

- A comment starting with **Testing** marks a deliberate edge case, such as an always-true relation condition or a validation rule set at runtime. Do not present a labelled edge case as recommended practice, and label any new one in the same way.
- Unlabelled code should follow the conventions below. When something unlabelled looks odd, fix it or label it.
- The plugin stands alone. It must not reference, depend on or mention other plugins, and `tests/PluginRegistrationTest.php` enforces this.

## Conventions

- **Models** define relations as array properties, validate with the `Validation` trait, and declare `$fillable` only for attributes that are mass assigned. Keep `public $table` as `create:model` emits it, use the `$casts` property, and name enum cases in TitleCase.
- **Migrations** use one anonymous class per table, named `0000NN_create_<table>.php` and listed in `updates/version.yaml`. Use `id()` keys and plain indexed foreign key columns whose type matches the referenced key, with no foreign key constraints or cascades. Multisite tables use the documented `site_id` and `site_root_id` columns. Upgrades are done with `php artisan plugin:refresh October.Test`.
- **Controllers** use behaviors with YAML config files. Views are `.php` files that render forms with `formRenderDesign()`, and extra content goes in the `form:before-form` and `form:after-form` blocks.
- **Partials** for a model field or column live next to the model YAML, named `_field_<name>.php` or `_column_<name>.php`.
- **Buttons** use the `Ui::` helpers with named arguments, and icons use Phosphor classes such as `ph ph-plus`. The exception is rich editor buttons, which take `icon-*` class names because of how the editor renders them.
- **Strings** use the `__()` helper with `lang/en.json`. The PHP files under `lang/en`, `lang/fr` and `lang/fr-ca` test the PHP language loader and the fallback from fr-ca to fr, and `lang/en.json` turns "Happy" and "Sad" into "Happy!" and "Sad!" to test translated option labels.
- **Types** are declared on new methods. Overrides of core hooks keep the core signature.
- **Docblocks** are one sentence that starts with the member name.
- **JavaScript** is a control registered with `oc.registerControl` that binds its events in `connect()`, loaded with `addJs` from the controller. Avoid inline scripts.
- **Deprecated APIs** are not used. The one labelled exception is the `oc.richEditorRegisterButton` block in `assets/js/custom-button.js`, which tests backwards compatibility.

## Tests

- Run the suite with `php artisan plugin:test october.test`.
- Every test class sets `protected $useTransactions = true;` so the database is migrated once per run.
- A fix comes with a test that fails without it.
- `tests/YamlConfigTest.php` parses every YAML file and checks blueprint keys, field types, mixin sources and `titleFrom` references, so a broken YAML file fails the suite.
- Tests are grouped by area:
  - Models: `ModelCrudTest`, `ModelRelationTest`, `ModelValidationTest`, `ModelTraitTest`, `TreeModelTest`, `MultisiteModelTest`, `EnumCastTest` and `TranslationTest`.
  - Controllers: one `<Name>ControllerTest` per controller with custom code, plus `OrderItemTest` for the order item picker and `PageImportTest` for the page import.
  - Forms and lists: `FieldOptionsTest`, `ListColumnsTest` and `DataTableFieldTest`.
  - Widgets and components: `WidgetsTest` and `KitchenSinkTest`.
  - Registration, schema and files: `PluginRegistrationTest`, `DatabaseMigrationTest`, `YamlConfigTest`, `LangFilesTest` and `SeedPostsCommandTest`.

## Coupled Files

The October CMS documentation prints these files or simplified copies of them, so check the documentation in the same change when they move or change.

File | Documentation page
---- | ------------------
`classes/UppercaseRule.php`, `classes/BetwixtRule.php`, `classes/LowercaseRule.php` | `extend/services/validation.md`
`assets/js/custom-button.js` | `element/form/widget-richeditor.md`
`contentfields/MyContentField.php` and its `_field_mycontentfield.php` partial | `extend/tailor-fields.md`
`filterwidgets/Discount.php` | `extend/lists/filter-widgets.md`
`vuecomponents/MyCustomWidget.php` and its `registerDashboards` entry | `extend/dashboards/vue-report-widgets.md`
`models/Location.php`, `models/user/scopes.yaml` | `extend/lists/filters.md`
`models/Role.php` | `element/filter/scope-group.md`
`models/product/columns.yaml`, `models/product/fields.yaml` | `element/form/widget-recordfinder.md`, `element/form/widget-relation.md`

The companion test theme also depends on the `kitchenSink` and `vueTester` components, the `config/repeater_notes.yaml` and `config/repeater_content.yaml` files, and the `october.test::lang.test.component_name` language key, and its README links to the plugin repository.
