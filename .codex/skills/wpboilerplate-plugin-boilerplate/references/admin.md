# Admin area: adding pages and assets

## Namespace & directory

All admin code belongs under `admin/` with namespace `WordPress_Plugin_Boilerplate\Admin`.
Screen classes go under `admin/Partials/` with namespace `WordPress_Plugin_Boilerplate\Admin\Partials`.

## Existing classes

### `Admin\Main` (`admin/Main.php`)

- Receives `$plugin_name` and `$version` in its constructor.
- Reads `*.asset.php` manifests in the constructor (not in the enqueue methods):
  ```php
  $this->js_asset_file  = include WORDPRESS_PLUGIN_BOILERPLATE_PLUGIN_PATH . 'build/js/backend.asset.php';
  $this->css_asset_file = include WORDPRESS_PLUGIN_BOILERPLATE_PLUGIN_PATH . 'build/css/backend.asset.php';
  ```
- `enqueue_styles()` — hooked on `admin_enqueue_scripts`, enqueues `build/css/backend.css`.
- `enqueue_scripts()` — hooked on `admin_enqueue_scripts`, enqueues `build/js/backend.js`.

### `Admin\Partials\Menu` (`admin/Partials/Menu.php`)

- `main_menu()` — hooked on `admin_menu`; calls `add_menu_page()`.
- `about()` — callback for the About admin page.
- `plugin_action_links($links, $file)` — hooked on `plugin_action_links` at priority **1000**;
  checks `WORDPRESS_PLUGIN_BOILERPLATE_PLUGIN_BASENAME` before modifying links.

## How to add a new admin page

1. Create `admin/Partials/MyPage.php`:
   ```php
   namespace WordPress_Plugin_Boilerplate\Admin\Partials;
   class MyPage {
       public function add_menu() { add_submenu_page( ... ); }
       public function render()   { /* output */ }
   }
   ```
2. In `includes/Main.php::define_admin_hooks()`, instantiate and register:
   ```php
   $my_page = new \WordPress_Plugin_Boilerplate\Admin\Partials\MyPage( $this->get_plugin_name(), $this->get_version() );
   $this->loader->add_action( 'admin_menu', $my_page, 'add_menu' );
   ```
3. Run `composer dump-autoload`.

**Never** call `add_action()` directly inside `MyPage::__construct()` or any other constructor.
All hooks must be registered through the Loader.

## How to add new admin assets

Add an entry to `webpack.config.js`, then enqueue it in `Admin\Main` (or a new class) using
the sibling `*.asset.php` manifest. Never hardcode version strings.

- Upstream reference: `https://github.com/WPBoilerplate/wordpress-plugin-boilerplate/blob/main/admin/Main.php`
